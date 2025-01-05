<?php

namespace App\Models;

use DateTime;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

class Reparation
{
  private int $id;
  private UuidInterface $uuid;
  private string $workshop_name;
  private DateTime $register_date;
  private string $license_plate;
  private string $vehicle_image_filename;

  public function __construct(
    int $id,
    UuidInterface $uuid,
    string $workshop_name,
    DateTime $register_date,
    string $license_plate,
    string $vehicle_image_filename
  ) {
    $this->id = $id;
    $this->workshop_name = $workshop_name;
    $this->register_date = $register_date;
    $this->license_plate = $license_plate;
    $this->uuid = $uuid;
    $this->vehicle_image_filename = $vehicle_image_filename;
  }

  public function getId(): int
  {
    return $this->id;
  }
  public function getUUID(): UuidInterface
  {
    return $this->uuid;
  }
  public function getUUIDString(): string
  {
    return $this->uuid->toString();
  }
  public function getWorkshopName(): string
  {
    return $this->workshop_name;
  }
  public function getRegisterDate(): DateTime
  {
    return $this->register_date;
  }
  public function getFormattedRegisterDate(): string
  {
    return $this->register_date->format("d/m/Y");
  }

  public function setLicensePlate(string $license_plate): void
  {
    $this->license_plate = $license_plate;
  }
  public function getLicensePlate(): string
  {
    return $this->license_plate;
  }
  public function setVehicleImageFilename(string $vehicle_image_filename): void
  {
    $this->vehicle_image_filename = $vehicle_image_filename;
  }
  public function getVehicleImageFilename(): string
  {
    return $this->vehicle_image_filename;
  }
}
