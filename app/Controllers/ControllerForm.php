<?php

namespace App\Controllers;

use App\Models\FormAction;

class ControllerForm
{
  public function handleForm(FormAction $action, callable $functionHandler): void
  {
    // handle when $action is not in self::ACTIONS array.
    if (
      !isset($_REQUEST["form_action"]) ||
      FormAction::tryFrom($_REQUEST["form_action"]) !== $action
    ) {
      return;
    }

    $functionHandler($_REQUEST);
  }
}
