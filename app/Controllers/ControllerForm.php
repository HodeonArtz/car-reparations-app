<?php

namespace App\Controllers;

use App\Models\FormAction;

/**
 * ControllerForm
 * 
 * Controller for handling multiple request from HTML forms.
 * 
 * @package App\Controllers
 * 
 * @method void handleForm(FormAction $action, callable $functionHandler)
 * Execute a function handler only when the chosen form is submitted.
 * This method acts as a hook.
 * 
 * @see App\Models\FormAction
 */
class ControllerForm
{
  /**
   * @param callable $functionHandler Function handler to be executed.
   * @param \App\Models\FormAction $action Form that the function belongs to.
   * @return void
   */
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
