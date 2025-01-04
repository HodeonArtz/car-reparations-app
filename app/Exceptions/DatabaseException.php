<?php

namespace App\Exceptions;

use Exception;

class DatabaseException extends Exception
{
  public function __construct(
    string $message = "There has been an error related to the database."
  ) {
    $this->message = $message;
  }
}
