<?php 
  namespace App\Views;

use App\Models\Reparation;

  class ViewReparation implements ViewBaseInterface
  { 
    private Reparation $reparation;

    public function __construct(Reparation $reparation) {
      $this->reparation = $reparation;
    }
    
    /**
     * Summary of render
     * @param mixed $f
     * @return void
     */
    public function render(): void {
      ?>
<div class="card" style="width: 18rem;">
  <a href="../../resources/images/reparations/output-imgs/<?= $this->reparation->getVehicleImageFilename() ?>">
    <img src="../../resources/images/reparations/output-imgs/<?= $this->reparation->getVehicleImageFilename() ?>"
      class="card-img-top" alt="...">
  </a>
  <div class="card-body">
    <h5 class="card-title"><?= $this->reparation->getId() ?></h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <b>UUID: </b><?= $this->reparation->getUUIDString() ?>
    </li>
    <li class="list-group-item">
      <b>Workshop: </b><?= $this->reparation->getWorkshopName() ?>
    </li>
    <li class="list-group-item">
      <b>Date: </b><?= $this->reparation->getFormattedRegisterDate() ?>
    </li>
    <li class="list-group-item">
      <b>License Plate: </b><?= $this->reparation->getLicensePlate() ?>
    </li>
  </ul>
</div>
<?php 
    }
  }
  
?>