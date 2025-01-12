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
    $vehicleImageBase64 = base64_encode($this->reparation->getVehicleImage());
    $vehicleImageSrc = "data:image/jpeg;base64,{$vehicleImageBase64}";
?>
    <div class="card" style="width: 18rem;">
      <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#vehicleImage">
        <img src="<?= $vehicleImageSrc ?>" class="card-img-top" alt="Vehicle Image">
      </button>
      <div class="modal modal-xl fade" id="vehicleImage" tabindex="-1" aria-labelledby="vehicleImage" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content ">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Full size image</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <img src="<?= $vehicleImageSrc ?>" class="w-100 rounded" al t="Vehicle Image">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
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