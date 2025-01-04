<?php

namespace App\Views;

/**
 * Interface for HTML components
 */
interface ViewBaseInterface
{
  /**
   * Renders the HTML component
   * @return void
   */
  public function render() : void;

}