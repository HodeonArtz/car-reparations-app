<?php

namespace App\Models;

enum FormAction: string
{
  case SELECT_ROLE = "select_role";
  case GET_REPARATION = "get_reparation";
  case INSERT_REPARATION = "insert_reparation";
}