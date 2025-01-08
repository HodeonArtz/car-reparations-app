<?php

namespace App\Views;

use App\Controllers\ControllerUser;

/**
 * ViewNav
 * 
 * Creates an instance of a Bootstrap navigation component.
 * 
 * @package App\Views
 * 
 * @implements ViewBaseInterface
 * 
 * @property ControllerUser $controllerUser Controller for displaying the current user
 * role.
 * @property string $indexPath Relative path to the /public/index.php page.
 * @method void render() Render the navigation component.
 */
class ViewNav implements ViewBaseInterface
{
  private ControllerUser $controllerUser;
  private string $indexPath;

  /**
   * @param string $indexPath Relative path to the /public/index.php page.
   */
  public function __construct(string $indexPath = "../../public/")
  {
    $this->controllerUser = new ControllerUser();
    $this->indexPath = $indexPath;
  }
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
