<?php

namespace App\Controllers;

use App\Models\UserRole;
use App\Services\ServiceUser;

/**
 * ControllerUser
 * 
 * Controller for handling users in the page.
 * 
 * @package App\Controllers
 * 
 * @method void validateRole() 
 * Redirect user to the index.php page if the submitted role is not a
 * {@see App\Models\UserRole} enum value (meaning if its not valid role).
 * 
 * @method UserRole getCurrentRole()
 * Specify the current role of the user. If the user has no role is considered visitor 
 * and returns a {@see null} role.
 * 
 * @method void setRole() 
 * Set role specified in a GET request.
 * 
 * @method void resetRole()
 * Clear user's role and is converted into a visitor user ({@see null} role)
 * 
 * @method void restrictPageToVisitors()
 * Redirect user to index.php if the user has no role.
 */
class ControllerUser
{
  private ServiceUser $serviceUser;
  public function __construct()
  {
    $this->serviceUser = new ServiceUser();
  }

  /**
   * @see App\Models\UserRole
   * @return void
   */
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

  /**
   * @see App\Models\UserRole
   * @return \App\Models\UserRole|null
   */
  public function getCurrentRole(): UserRole | null
  {
    return $this->serviceUser->getRole();
  }

  /**
   * @see App\Models\UserRole
   * @return void
   */
  public function setRole(): void
  {
    // if(isset($_GET["user-role"]))
    $this->serviceUser->setRole(UserRole::tryFrom($_GET["user-role"]));
  }

  /**
   * @return void
   */
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
