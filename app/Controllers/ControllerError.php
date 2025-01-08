<?php

namespace App\Controllers;

use Throwable;

/**
 * ControllerError
 * 
 * Controller for managing exceptions between multiple pages and allows to display them
 * as errors.
 * 
 * @package App\Controllers
 * 
 * @method void redirectErrorTo(string $URL, Throwable $error) Throw caught exception to
 * another page as a redirect.
 * @method void checkErrors() Listen for exceptions thrown with 
 * {@see ControllerError::redirectErrorTo()} that come from other pages and throws them.
 */
class ControllerError
{
  /**
   * @param string $URL Path to the page to redirect exception.
   * @param \Throwable $error Caught exception to rethrow.
   * @return void
   */
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
