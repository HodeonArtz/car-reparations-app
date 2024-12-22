<?php

namespace App\Exceptions;
use Exception;

 class InvalidRoleException extends Exception
{

  public function __construct(string $message = "User role is invalid")  {
    $this->message = $message;
  }
}