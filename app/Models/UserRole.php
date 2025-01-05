<?php

namespace App\Models;

enum UserRole: string
{
  case EMPLOYEE = "Employee";
  case CLIENT = "Client";
}
