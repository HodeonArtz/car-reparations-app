<?php

namespace App\Exceptions;

use Exception;

class FileException extends Exception
{
  public function __construct(string $message = "The file is invalid.")
  {
    $this->message = $message;
  }
}
