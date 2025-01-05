<?php

namespace App\Controllers;

use App\Models\UserRole;
use App\Services\ServiceUser;

class ControllerUser
{
  private ServiceUser $serviceUser;
  public function __construct()
  {
    $this->serviceUser = new ServiceUser();
  }
  public function validateRole(): void
  {
    if (
      !$this->serviceUser->getRole() &&
      !UserRole::tryFrom($_GET["user-role"])
    ) {

      header("Location: ../../public/index.php");
      exit;
    }
  }

  public function getCurrentRole(): UserRole
  {
    return $this->serviceUser->getRole();
  }
  public function setRole(): void
  {
    // if(isset($_GET["user-role"]))
    $this->serviceUser->setRole(UserRole::tryFrom($_GET["user-role"]));
  }

  public function resetRole(): void
  {
    $this->serviceUser->unsetRole();
  }

  public function restrictPageToVisitors(): void
  {
    if (!$this->serviceUser->getRole()) {
      header("Location: ../../public/index.php");
      exit;
    }
  }
}
