<?php

namespace App\Controllers;

class ControllerForm
{
  const ACTIONS = [
    "SELECT_ROLE" => "select_role",
    "GET_REPARATION" => "get_reparation"
  ];

  public function handleForm(string $action,callable $functionHandler) : void {
    // handle when $action is not in self::ACTIONS array.
    if(!isset($_REQUEST["form_action"]) || $_REQUEST["form_action"] !== $action) return;
    $functionHandler($_REQUEST);
  }
}