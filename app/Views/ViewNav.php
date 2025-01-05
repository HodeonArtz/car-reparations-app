<?php

namespace App\Views;

use App\Controllers\ControllerUser;

/**
 * Creates an instance of a navigation component
 */
class ViewNav implements ViewBaseInterface
{
  private $controllerUser;
  private string $indexPath;
  public function __construct(string $indexPath = "../../public/")
  {
    $this->controllerUser = new ControllerUser();
    $this->indexPath = $indexPath;
  }

  /**
   * Renders the naviagtion component 
   * @param string $indexPath Sets the path to the index.php page
   * @return void
   */
  public function render(): void
  { ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?= $this->indexPath ?>">Car Workshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-lg-flex flex-column flex-lg-row align-items-lg-center align-items-start"
          id="navbarSupportedContent">
          <h5 class="navbar-text order-lg-1">
            <?= $this->controllerUser->getCurrentRole()?->value ?>
          </h5>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="<?= $this->indexPath ?>">Home</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<?php
  }
}
