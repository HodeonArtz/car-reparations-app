<?php

namespace App\Controllers;

use Throwable;

class ControllerError
{
  public function redirectErrorTo(string $URL, Throwable $error): void
  {
    session_start();
    $_SESSION["error"] = [
      "type" => $error::class,
      "message" => $error->getMessage()
    ];
    session_write_close();

    header("Location: $URL");
    exit();
  }

  public function checkErrors(): void
  {
    session_start();
    if (isset($_SESSION["error"])) {
      $exceptionClass = $_SESSION["error"]["type"];
      $exceptionMessage = $_SESSION["error"]["message"];
      unset($_SESSION["error"]);
      session_write_close();
      throw new $exceptionClass($exceptionMessage);
    }
    session_write_close();
  }
}
