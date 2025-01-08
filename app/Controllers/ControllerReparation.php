<?php

namespace App\Controllers;

use App\Models\Reparation;
use App\Services\ServiceReparation;

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
  private ServiceReparation $serviceReparation;
  public function __construct()
  {
    $this->serviceReparation = new ServiceReparation();
  }
  public function getReparation(): null | Reparation
  {
    $reparation_id = +$_POST["reparationId"]; // Parse parameter to integer
    return $this->serviceReparation->getReparation($reparation_id);
  }
  public function insertReparation(): int
  {
    return $this->serviceReparation->insertReparation(
      imageFile: $_FILES["vehicle_image_upload"],
      workshopName: $_POST["add_workshop_name"],
      licensePlate: $_POST["add_license_plate"]
    );
  }
}
