<?php

namespace App\Services;

use App\Exceptions\FileException;
use App\Models\Reparation;
use App\Models\UserRole;
use App\Services\ServiceCarWorkshopDB;
use DateTime;
use finfo;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Ramsey\Uuid\Uuid;

/**
 * ServiceReparation
 * 
 * Service to fetch {@see App\Models\Reparation}'s
 * 
 * @package App\Services
 * 
 * @property array $IMG_CONFIG Contains a configuration list of constraints for uploading
 * images.
 * 
 * @method void maskReparation(Reparation $reparation) 
 * Mask or "censor" sensitive data from a reparation. These data are the image and 
 * license plate.
 * 
 * @method Reparation getReparation(int $reparationId)
 * Fetch a reparation from database.
 * 
 * @method int insertReparation(Reparation $reparation).
 * Insert a new reparation into the database and returns its generated ID (primary key).
 */
class ServiceReparation
{

  /**
   * @return array{maxImgBytesSize: int, validMimeFormats:string[]}
   */
  private array $IMG_CONFIG;
  private ServiceCarWorkshopDB $serviceDatabase;

  public function __construct()
  {
    $this->serviceDatabase = new ServiceCarWorkshopDB();
    $this->IMG_CONFIG = json_decode(file_get_contents("../../cfg/img_config.json"), true);
  }

  /**
   * @param \App\Models\Reparation $reparation Reparation to be masked.
   */
  public function maskReparation(Reparation $reparation): void
  {

    $reparation->setLicensePlate(
      license_plate: substr(
        string: $reparation->getLicensePlate(),
        offset: 0,
        length: 1
      ) . "***-***"
    );

    $reparation->setUUID(null);

    // Masks the image.
    $imageManager = new ImageManager(new Driver());

    $vehicleImage = $imageManager->read(
      $reparation->getVehicleImage()
    );
    $vehicleImage->scale(width: 450)->blur(75);


    $reparation->setVehicleImage(
      $vehicleImage->toWebp()->toString()
    );
  }

  /**
   * @param int $reparationId Reparation ID to fetch.
   */
  public function getReparation(int $reparationId, UserRole $userRole): Reparation | null
  {
    $log = new Logger("Car_Workshop_SELECT");
    $log->pushHandler(new StreamHandler("../../logs/app_workshop.log", Level::Info));
    $mysqli = $this->serviceDatabase->connectDatabase();

    try {
      $reparationSentence = $mysqli->prepare("SELECT * FROM reparations WHERE id = ?");
      $reparationSentence->bind_param("i", $reparationId);
      $reparationSentence->execute();

      $result = $reparationSentence->get_result();
      $log->info("SELECT reparation, ID: $reparationId");

      if ($result->num_rows === 0)
        return null;

      $response = $result->fetch_assoc();

      $register_date = DateTime::createFromFormat("Y-m-d", $response["register_date"]);

      $foundReparation = new Reparation(
        id: $response["id"],
        uuid: Uuid::fromString($response["uuid"]),
        workshop_name: $response["workshop_name"],
        register_date: $register_date,
        license_plate: $response["license_plate"],
        vehicle_image: $response["vehicle_image"]
      );
    } catch (\Throwable $th) {
      $log->warning("There has been an error selecting a reparation: " . $th->getMessage());
      throw $th;
    }

    if ($userRole === UserRole::CLIENT) {
      $this->maskReparation($foundReparation);
    }
    $mysqli->close();
    return $foundReparation;
  }

  public function insertReparation(
    Reparation $reparation
  ): int {
    // Throw exception if the file doesn't have a valid image format.
    $imageType = // Get MIME type from binary string using finfo.
      (new finfo(FILEINFO_MIME_TYPE))->buffer($reparation->getVehicleImage());
    if (!in_array(
      $imageType,
      $this->IMG_CONFIG['validMimeFormats']
    ))
      throw new FileException(
        "The image must be of type: " .
          implode(", ", $this->IMG_CONFIG['validMimeFormats']) .
          "."
      );

    // Throw exception if file exceeds size limit.
    $maxImgMbSize = +$this->IMG_CONFIG['maxImgBytesSize'] / 1000000; // Bytes to MB
    $imageSize = strlen($reparation->getVehicleImage()); // File size in bytes
    if ($imageSize > $this->IMG_CONFIG['maxImgBytesSize'])
      throw new FileException("This image exceeds the size limit ({$maxImgMbSize}MB).");

    // Database connection
    $mysqli = $this->serviceDatabase->connectDatabase();

    try {
      $log = new Logger("Car_Workshop_INSERT");
      $log->pushHandler(new StreamHandler("../../logs/app_workshop.log", Level::Info));

      // Ramsey (random UUID generation).
      $random_uuid = Uuid::uuid4()->toString();

      // Intervention (setup image and insert text).
      $imageManager = new ImageManager(new Driver());
      $vehicleImage = $imageManager->read($reparation->getVehicleImage());
      $vehicleImage->scale(width: 1000)->text(
        $random_uuid . "\n" . $reparation->getLicensePlate(),
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

      // Formatted register reparation date.
      $formattedRegisterDate = $reparation->getRegisterDate()->format('Y-m-d');

      // Inserted image as binary.
      $vehicleImageBinary = $vehicleImage->toWebp()->toString();

      // Insert parameter bind and execution.
      $insertQuery = "INSERT INTO reparations 
            (uuid,workshop_name,license_plate,vehicle_image,register_date)
          VALUES 
              (?,?,?,?,?);
          ";
      $mysqli->execute_query(
        $insertQuery,
        [
          $random_uuid,
          $reparation->getWorkshopName(),
          $reparation->getLicensePlate(),
          $vehicleImageBinary,
          $formattedRegisterDate
        ]
      );


      $log->info("INSERT reparation, ID: " . $mysqli->insert_id);
    } catch (\Throwable $th) {
      $log->error("There has been an error inserting a reparation: " . $th->getMessage());
      throw $th;
    }

    $result_id = $mysqli->insert_id;
    $mysqli->close();

    return $result_id;
  }
}
