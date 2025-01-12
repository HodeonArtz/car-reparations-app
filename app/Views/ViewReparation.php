<?php

namespace App\Views;

use App\Models\Reparation;

/**
 * ViewReparation
 * 
 * Creates an instance of a Bootstrap card component for displaying data of a
 * {@see \App\Models\Reparation} instance.
 * 
 * @package App\Views
 * 
 * @implements ViewBaseInterface
 * 
 * @property \App\Models\Reparation $reparation Reparation instance that will be 
 * displayed with its attributes.
 * @method void render() Renders the card component.
 */
class ViewReparation implements ViewBaseInterface
{
  private Reparation $reparation;

  /**
   * @param \App\Models\Reparation $reparation Reparation instance that will be displayed
   * with its attributes.
   */
  public function __construct(Reparation $reparation)
  {
    $this->reparation = $reparation;
  }

  /**
   * Render the Bootstrap card with the Reparation attributes as data
   * @return void
   */
  public function render(): void
  {

?>
    <div class="card" style="width: 18rem;">
      <img src="data:image/jpeg;base64,<?= base64_encode($this->reparation->getVehicleImage()) ?>" class="card-img-top"
        alt="...">
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