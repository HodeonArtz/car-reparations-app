<?php

namespace App\Views;

/**
 * ViewBaseInterface
 * 
 * @package App\Views
 * 
 * Interface for HTML components.
 * @method void render() Render the HTML component.
 */
interface ViewBaseInterface
{
  public function render(): void;
}
