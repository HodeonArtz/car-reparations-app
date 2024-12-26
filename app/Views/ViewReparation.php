<?php 
  namespace App\Views;

use App\Models\Reparation;

  class ViewReparation implements ViewBaseInterface
  { 

    
    /**
     * Summary of render
     * @param mixed $f
     * @return void
     */
    public function render(Reparation $reparation = null): void {
      if($reparation){
      ?>
<div class="card" style="width: 18rem;">
  <img src="../../resources/images/reparations/output-imgs/<?= $reparation->getVehicleImageFilename() ?>"
    class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?= $reparation->getId() ?></h5>

  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <b>UUID: </b><?= $reparation->getUUIDString() ?>
    </li>
    <li class="list-group-item">
      <b>Workshop: </b><?= $reparation->getWorkshopName() ?>
    </li>
    <li class="list-group-item">
      <b>Date: </b><?= $reparation->getFormattedRegisterDate() ?>
    </li>
    <li class="list-group-item">
      <b>License Plate: </b><?= $reparation->getLicensePlate() ?>
    </li>
  </ul>

</div>
<?php 
      }
    }
  }
  
?>