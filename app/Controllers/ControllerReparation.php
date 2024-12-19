<?php
namespace App\Controllers;

use App\Models\Reparation;
use App\Services\ServiceReparation;
use App\Services\ServiceUser;



class ControllerReparation
{
  private ServiceUser $serviceUser;
  private ServiceReparation $serviceReparation;


  public function __construct() {
    $this->serviceUser = new ServiceUser(); 
    $this->serviceReparation = new ServiceReparation();
  }
  public function getReparation():  null | Reparation {
    $reparation_id = $_POST["reparationId"];
    return $this->serviceReparation->getReparation($reparation_id);
  }
}