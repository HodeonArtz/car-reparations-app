<?php

namespace App\Models;

use DateTime;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

class Reparation
{
  private int $id;
  // TODO: Implement later
   private UuidInterface $uuid;
  private string $workshop_name;
  private DateTime $register_date;
  private string $license_plate;
  // TODO: Implement later
  // private int $vehicle_image;

  public function __construct(
    int $id,
    UuidInterface $uuid,
    string $workshop_name,
    DateTime $register_date,
    string $license_plate
  ){
    $this->id = $id;
    $this->workshop_name = $workshop_name;
    $this->register_date = $register_date;
    $this->license_plate = $license_plate;
    $this->uuid = $uuid;
  }


  public function setId(int $id) : void {
    $this->id = $id;
  }
  public function getId() : int {
    return $this->id;
  }

  public function setUUID(UuidInterface $uuid) : void {
    $this->uuid = $uuid;
  }

  public function getUUID() : UuidInterface {
    return $this->uuid;
  }
  public function getUUIDString() : string {
    return $this->uuid->toString();
  }

  public function setWorkshopName(string $workshop_name): void {
    $this->workshop_name = $workshop_name;
  }
  public function getWorkshopName() : string {
    return $this->workshop_name;
  }

  public function setRegisterDate(DateTime $register_date) : void {
    $this->register_date = $register_date;
  }
  public function getRegisterDate(): DateTime {
    return $this->register_date;
  }
  public function getFormattedRegisterDate(): string{
    return $this->register_date->format("d/m/Y");
  }

  public function setLicensePlate(string $license_plate) : void {
    $this->license_plate = $license_plate;
  }
  public function getLicensePlate(): string {
    return $this->license_plate;
  }
}