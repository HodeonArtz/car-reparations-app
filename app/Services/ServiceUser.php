<?php

namespace App\Services;

use App\Exceptions\InvalidRoleException;

class ServiceUser
{
  const AVAILABLE_ROLES = ["employee","client"];

  public function validateRole(string $role): bool {
    $formattedRole = strtolower(trim($role));
    return in_array($formattedRole,self::AVAILABLE_ROLES);
  }
  
  public function setRole(string $role ) : void {
    $formattedRole = strtolower(trim($role));

    if(!$this->validateRole($formattedRole))
      throw new InvalidRoleException();
    
    session_start();
    $_SESSION["role"] = $formattedRole;
    session_write_close();
  }

  public function getRole(): string | bool {
    session_start();
    $role = null;
    if(isset($_SESSION["role"])) $role = $_SESSION["role"];
    session_write_close();

    if(!$role || trim($_SESSION["role"]) === "") return false;
    return $_SESSION["role"];
    
  }

  public function unsetRole() : void {
    if(!isset($_SESSION["role"])) return;
    session_start();
    unset($_SESSION["role"]);
    session_write_close();
  }
}