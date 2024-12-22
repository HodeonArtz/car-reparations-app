<?php

namespace App\Services;

use App\Models\Reparation;
use App\Services\ServiceCarWorkshopDB;
use DateTime;
use Ramsey\Uuid\Uuid;

class ServiceReparation
{
  private ServiceCarWorkshopDB $serviceDatabase;
  private ServiceUser $serviceUser;

  public function __construct() {
    $this->serviceDatabase = new ServiceCarWorkshopDB();
    $this->serviceUser = new ServiceUser();
  }
  public function maskReparation(Reparation $reparation): void{
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
      license_plate: $response["license_plate"]
    );
  

    if($this->serviceUser->getRole() === "client"){
      $this->maskReparation($foundReparation);
    }

    return $foundReparation;
  }
}