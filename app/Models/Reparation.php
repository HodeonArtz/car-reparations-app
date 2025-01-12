<?php

namespace App\Models;

use DateTime;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Ramsey\Uuid\UuidInterface;

/**
 * Reparation
 * 
 * @package App\Models
 * 
 * Creates an instance of a car reparation.
 * 
 * @property int $id Unique ID number of the reparation.
 * @property UuidInterface | null $uuid UUID that the reparation holds.
 * @property DateTime $register_date Date where the reparation was registered.
 * @property string $license_plate License plate of the car.
 * @property string $vehicle_image BLOB of the car image (binary webp file).
 * 
 * @method string getFormattedRegisterDate() Return the registered date with format 
 * `"d/m/Y"`.
 */
class Reparation
{
  private int $id;
  private UuidInterface | null $uuid;
  private string $workshop_name;
  private DateTime $register_date;
  private string $license_plate;
  private string $vehicle_image;

  public function __construct(
    int $id,
    UuidInterface | null $uuid,
    string $workshop_name,
    DateTime $register_date,
    string $license_plate,
    string $vehicle_image
  ) {
    $this->id = $id;
    $this->workshop_name = $workshop_name;
    $this->register_date = $register_date;
    $this->license_plate = $license_plate;
    $this->uuid = $uuid;
    $this->vehicle_image = $vehicle_image;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setUUID(UuidInterface | null $uuid): void
  {
    $this->uuid = $uuid;
  }
  public function getUUID(): UuidInterface | null
  {
    return $this->uuid;
  }
  public function getUUIDString(): string
  {
    // If reparation has no UUID (probably meaning that it has been masked) show this
    // string of asterisks.
    if ($this->uuid === null)
      return "********-****-****-****-************";

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
  public function setVehicleImage(string $vehicle_image_filename): void
  {
    $this->vehicle_image = $vehicle_image_filename;
  }
  public function getVehicleImage(): string
  {
    return $this->vehicle_image;
  }
}
