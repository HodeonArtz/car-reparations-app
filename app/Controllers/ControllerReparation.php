<?php

namespace App\Controllers;

use App\Models\Reparation;
use App\Services\ServiceReparation;
use App\Services\ServiceUser;
use DateTime;

/**
 * ControllerReparation
 * 
 * Controller for managing reparations.
 * 
 * @package App\Controllers
 * 
 * @method null|Reparation getReparation()
 * Return a {@see App\Models\Reparation} by finding a reparation by its ID (requested
 * with the POST method). Returns {@see null} if no reparation was found.
 * 
 * @method int insertReparation() 
 * Register a new reparation with the parameters from a POST request as the reparation
 * data.
 * 
 */
class ControllerReparation
{
  private ServiceUser $serviceUser;
  private ServiceReparation $serviceReparation;
  public function __construct()
  {
    $this->serviceReparation = new ServiceReparation();
    $this->serviceUser = new ServiceUser();
  }
  public function getReparation(): null | Reparation
  {
    $reparation_id = +$_POST["reparationId"]; // Parse parameter to integer
    return $this->serviceReparation->getReparation($reparation_id, $this->serviceUser->getRole());
  }
  public function insertReparation(): int
  {
    $registerDate = new DateTime($_POST["add_register_date"]);
    return $this->serviceReparation->insertReparation(
      reparation: new Reparation(
        id: 0,
        uuid: null,
        vehicle_image: file_get_contents($_FILES["vehicle_image_upload"]["tmp_name"]),
        workshop_name: $_POST["add_workshop_name"],
        license_plate: $_POST["add_license_plate"],
        register_date: $registerDate
      )
    );
  }
}
