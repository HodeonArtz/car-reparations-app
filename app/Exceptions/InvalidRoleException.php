<?php

namespace App\Exceptions;

class InvalidRoleException extends \Exception
{
  protected int $code = 400;

  public function __construct(string $message = "User role is invalid")  {
    $this->message = $message;
  }
}