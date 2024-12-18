<?php

namespace App\Views;

use App\Controllers\ControllerUser;

/**
 * Creates an instance of a navigation component
 */
class ViewNav implements ViewBaseInterface
{
  private $controllerUser;  

  public function __construct() {
    $this->controllerUser = new ControllerUser();
  }

  /**
   * Renders the naviagtion component 
   * @param string $indexPath Sets the path to the index.php page
   * @return void
   */
  public function render(string $indexPath = "../../public/"):void{
    ?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= $indexPath ?>">Car Workshop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= $indexPath ?>">Home</a>
        </li>
      </ul>


      <h5 class="navbar-text">
        <?= $this->controllerUser->getFormattedRole()?>
      </h5>
    </div>
  </div>
</nav>
<?php
  }
}