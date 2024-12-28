<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use mysqli;

class ServiceCarWorkshopDB
{
  /**
   * Summary of database_config
   * @var array{host:string, user:string, password:string, db_name:string,port:int}|bool
   */
  private array | bool $database_config;

  public function __construct() {
    $this->database_config = parse_ini_file("../../cfg/db_config.ini");
  }
  public function connectDatabase(): mysqli {
    $mysqli = new mysqli(
      $this->database_config["host"],
      $this->database_config["user"],
      $this->database_config["password"],
      $this->database_config["db_name"],
      $this->database_config["port"],
    );

    if($mysqli->connect_errno)
      throw new DatabaseException(
        "There has been an error connecting with car_workshop database."
      );
    
    return $mysqli; 
  }
}