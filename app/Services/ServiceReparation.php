<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Models\Reparation;
use App\Services\ServiceCarWorkshopDB;
use DateTime;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Ramsey\Uuid\Uuid;

class ServiceReparation
{
  private const OUTPUT_IMAGE_PATH = "../../resources/images/reparations/output-imgs/";
  /**
   * @return array{maxImgBytesSize: int, validMimeFormats:string[]}
   */
  private array $IMG_CONFIG;
  private ServiceCarWorkshopDB $serviceDatabase;
  private ServiceUser $serviceUser;

  public function __construct() {
    $this->serviceDatabase = new ServiceCarWorkshopDB();
    $this->serviceUser = new ServiceUser();
    $this->IMG_CONFIG = json_decode(file_get_contents("../../cfg/img_config.json"),true);
  }
  public function maskReparation(Reparation $reparation): void{

    $maskedPrefix = "masked-";

    if(!file_exists(self::OUTPUT_IMAGE_PATH.$maskedPrefix. $reparation->getVehicleImageFilename())){
      $imageManager = new ImageManager(new Driver());

      $vehicleImage = $imageManager->read(
        self::OUTPUT_IMAGE_PATH. $reparation->getVehicleImageFilename()
      );
      $vehicleImage->scale(height:300)->blur(75);
      $vehicleImage->toWebp()->save(
        self::OUTPUT_IMAGE_PATH.$maskedPrefix. $reparation->getVehicleImageFilename()
      );
    }

    $reparation->setVehicleImageFilename($maskedPrefix . $reparation->getVehicleImageFilename());

    $reparation->setLicensePlate(
      license_plate: substr(
            string: $reparation->getLicensePlate(),
            offset: 0,
            length: 1
          )."***-***"
      );
  }
  public function getReparation(int $reparationId) : Reparation | null{
    $log = new Logger("Car Workshop DB");
    $log->pushHandler(new StreamHandler("../../logs/car-workshop-db.log", Level::Info));
    $mysqli = $this->serviceDatabase->connectDatabase();
    
    try {
      $reparationSentence = $mysqli->prepare("SELECT * FROM reparations WHERE id = ?");
      $reparationSentence->bind_param("i", $reparationId);
      $reparationSentence->execute();
  
      $result = $reparationSentence->get_result();
      $log->info("SELECT reparation");

      if($result->num_rows === 0)
        return null;
  
      $response = $result->fetch_assoc();
  
      $register_date = DateTime::createFromFormat("Y-m-d", $response["register_date"]);
  
      $foundReparation = new Reparation(
        id: $response["id"], 
        uuid: Uuid::fromString($response["uuid"]),
        workshop_name: $response["workshop_name"], 
        register_date: $register_date, 
        license_plate: $response["license_plate"],
        vehicle_image_filename: $response["vehicle_image_filename"]
      );
    } catch (\Throwable $th) {
      $log->warning("There has been an error selecting a reparation: ". $th->getMessage());
    }

    if($this->serviceUser->getRole() === ServiceUser::AVAILABLE_ROLES["CLIENT"]){
      $this->maskReparation($foundReparation);
    }

    return $foundReparation;
  }

  /**
   * 
   * @param array{type:string,size:int,tmp_name:string} $imageFile
   * @param string $workshopName
   * @param string $licensePlate
   * @return int|null
   */
  public function insertReparation(
    array $imageFile,
    string $workshopName,
    string $licensePlate
  ): int {
    if(!in_array(
      $imageFile['type'],
      $this->IMG_CONFIG['validMimeFormats']
      ))
      throw new FileException(
        "The image must be of type: " . 
        implode(", ",$this->IMG_CONFIG['validMimeFormats']) .
        "."
      );
    
    if($imageFile['size'] > $this->IMG_CONFIG['maxImgBytesSize'])
      throw new FileException("This image exceeds the size limit (6MB).");

    $mysqli = $this->serviceDatabase->connectDatabase();
    $insertSentence = $mysqli->prepare(query: 
      "INSERT INTO reparations 
        (uuid,workshop_name,license_plate,vehicle_image_filename)
      VALUES 
          (?,?,?,?);
      "
    );

    $random_uuid = Uuid::uuid4()->toString();

    $imageManager = new ImageManager(new Driver());
    $vehicleImage = $imageManager->read($imageFile['tmp_name']);
    $vehicleImage->scale(height:300)->text(
      $licensePlate . " " . $random_uuid,
      12,
      12,
      function (FontFactory $font): void {
        $font->file("../../resources/fonts/segoe-ui.ttf");
        $font->size(24);
        $font->color("ffffff");
        $font->stroke("000000", 2);
        $font->align("left");
        $font->valign("top");
        $font->angle(0);
      }
    );
    $vehicleImageOutFilename = $random_uuid . ".webp";

    $vehicleImage->toWebp()->save(self::OUTPUT_IMAGE_PATH . $vehicleImageOutFilename);

    $insertSentence->bind_param(
      "ssss",
      $random_uuid,
      $workshopName,
      $licensePlate,
      $vehicleImageOutFilename
    );

    $insertSentence->execute();

    return $mysqli->insert_id;
  }
}