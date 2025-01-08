<?php

namespace App\Views;

/**
 * ViewAlert
 * 
 * Creates an instance of a Boostrap alert component.
 * 
 * @package App\Views
 * 
 * @implements ViewBaseInterface
 * 
 * @property string $message Message that the alert will display.
 * @property string $type Type of alert that the alert can be 
 * (danger, success, warning, etc.).
 * 
 * @method void render() Render the alert component.
 */
class ViewAlert implements ViewBaseInterface
{
  private string $message;
  private string $type;

  public function __construct(string $message = "Alert!", string $type = "primary")
  {
    $this->message = $message;
    $this->type = $type;
  }

  public function render(): void
  {
?>
    <div class="alert alert-<?= $this->type ?> alert-dismissible fade show" role="alert">
      <?= $this->message ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
  }
}
