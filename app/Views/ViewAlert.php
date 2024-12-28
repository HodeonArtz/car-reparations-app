<?php

namespace App\Views;

/**
 * Creates an instance of a navigation component
 */
class ViewAlert implements ViewBaseInterface
{
  private string $message;
  private string $type;

  public function __construct(string $message = "Alert!", string $type = "primary") {
    $this->message = $message;
    $this->type = $type;
  }

  /**
   * Renders the naviagtion component 
   * @param string $indexPath Sets the path to the index.php page
   * @return void
   */
  public function render():void{
    ?>
<div class="alert alert-<?= $this->type ?> alert-dismissible fade show" role="alert">
  <?= $this->message ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
  }
}