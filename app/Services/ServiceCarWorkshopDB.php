<?php

namespace App\Services;

use App\Exceptions\DatabaseException;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
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
    $log = new Logger("Car Workshop DB");
    $log->pushHandler(new StreamHandler("../../logs/car-workshop-db.log", Level::Info));
  
    try {
      $mysqli = new mysqli(
        $this->database_config["host"],
        $this->database_config["user"],
        $this->database_config["password"],
        $this->database_config["db_name"],
        $this->database_config["port"],
      );
      $log->info("A connection to the database has been established.");
    } catch (\Throwable $th) {
      $log->error("An error has ocurred with the database connection: " . $th->getMessage());
      throw new DatabaseException(
        "There has been an error connecting with the database server."
      );
    }
    return $mysqli; 
  }
}