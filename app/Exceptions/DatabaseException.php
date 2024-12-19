<?php

namespace App\Exceptions;

class DatabaseException extends \Exception
{
  protected int $code = 500;

  public function __construct(
    string $message = "There has been an error related to the database."
    )  {
    $this->message = $message;
  }
}