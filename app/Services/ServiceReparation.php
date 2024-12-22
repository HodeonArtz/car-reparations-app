<?php

namespace App\Services;

use App\Models\Reparation;
use App\Services\ServiceCarWorkshopDB;
use DateTime;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Ramsey\Uuid\Uuid;

class ServiceReparation
{
  private const OUTPUT_IMAGE_PATH = "../../resources/images/reparations/output-imgs/";
  private ServiceCarWorkshopDB $serviceDatabase;
  private ServiceUser $serviceUser;

  public function __construct() {
    $this->serviceDatabase = new ServiceCarWorkshopDB();
    $this->serviceUser = new ServiceUser();
  }
  public function maskReparation(Reparation $reparation): void{

    $maskedPrefix = "masked-";

    if(!file_exists(self::OUTPUT_IMAGE_PATH.$maskedPrefix. $reparation->getVehicleImageFilename())){
      $imageManager = new ImageManager(new Driver());
      $vehicleImage = $imageManager->read(self::OUTPUT_IMAGE_PATH. $reparation->getVehicleImageFilename());
      $vehicleImage->blur(200);
      $vehicleImage->toJpeg()->save(self::OUTPUT_IMAGE_PATH.$maskedPrefix. $reparation->getVehicleImageFilename());
    }

    $reparation->setVehicleImageFilename($maskedPrefix . $reparation->getVehicleImageFilename());

    $reparation->setLicensePlate(
      license_plate: substr(
            string: $reparation->getLicensePlate(),
            offset: 0,
            length: 1
          )."**-****"
      );
  }
  public function getReparation(int $reparationId) : Reparation | null{
    $mysqli = $this->serviceDatabase->connectDatabase();
    
    // TODO: get result from select
    $reparationSentence = $mysqli->prepare("SELECT * FROM reparations WHERE id = ?");
    $reparationSentence->bind_param("i", $reparationId);
    $reparationSentence->execute();

    $result = $reparationSentence->get_result();

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
  

    if($this->serviceUser->getRole() === "client"){
      $this->maskReparation($foundReparation);
    }

    return $foundReparation;
  }
}