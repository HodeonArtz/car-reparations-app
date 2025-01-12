<?php

namespace App\Services;

use App\Models\UserRole;

/**
 * ServiceUser
 * 
 * Service to manage users on the page.
 * 
 * @package App\Services
 * 
 * @method void setRole(UserRole $role) Set & overwrite role to user.
 * @method \App\Models\UserRole|null getRole() Get user's current role.
 * @method void unsetRole() Reset user's role.
 */
class ServiceUser
{

  /**
   * @param \App\Models\UserRole $role User's role to set.
   */
  public function setRole(UserRole $role): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION["role"] = serialize($role);
    session_write_close();
  }

  public function getRole(): UserRole | null
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $role = null;
    if (isset($_SESSION["role"])) $role = unserialize($_SESSION["role"]);
    session_write_close();

    if (!$role || trim($_SESSION["role"]) === "") return null;
    return $role;
  }

  public function unsetRole(): void
  {
    if (!isset($_SESSION["role"])) return;
    session_start();
    unset($_SESSION["role"]);
    session_write_close();
  }
}
