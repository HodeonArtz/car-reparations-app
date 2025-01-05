<?php

namespace App\Services;

use App\Exceptions\InvalidRoleException;
use App\Models\UserRole;

class ServiceUser
{
  /* public const AVAILABLE_ROLES = [
    "EMPLOYEE" => "employee",
    "CLIENT" => "client"
  ];

  public function validateRole(string $role): bool
  {
    $formattedRole = strtolower(trim($role));
    return in_array($formattedRole, self::AVAILABLE_ROLES);
  } */

  public function setRole(UserRole $role): void
  {
    session_start();
    $_SESSION["role"] = serialize($role);
    session_write_close();
  }

  public function getRole(): UserRole | null
  {
    session_start();
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
