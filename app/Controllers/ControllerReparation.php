<?php

namespace App\Controllers;

use App\Models\Reparation;
use App\Services\ServiceReparation;

class ControllerReparation
{
  private ServiceReparation $serviceReparation;
  public function __construct()
  {
    $this->serviceReparation = new ServiceReparation();
  }
  public function getReparation(): null | Reparation
  {
    $reparation_id = +$_POST["reparationId"];
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
