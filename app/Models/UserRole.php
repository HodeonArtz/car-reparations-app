<?php

namespace App\Models;

/**
 * UserRole
 * 
 * @package App\Models
 * 
 * Describes the role for a user.
 */
enum UserRole: string
{
  case EMPLOYEE = "Employee";
  case CLIENT = "Client";
}
