<?php

namespace App\Views;

require __DIR__ . '\\..\\..\\vendor\\autoload.php';

use App\Controllers\ControllerError;
use App\Controllers\ControllerForm;
use App\Controllers\ControllerReparation;
use App\Controllers\ControllerUser;
use App\Models\FormAction;
use App\Models\UserRole;
use App\Services\ServiceUser;
use App\Views\ViewReparation;

$controllerError = new ControllerError();
$controllerUser = new ControllerUser();
$controllerForm = new ControllerForm();
$controllerReparation = new ControllerReparation();

/**
 * @var ViewAlert[]
 */
$errorAlerts = [];

// ---- Handle user roles
$handleSetRole = function (): void {
  global $controllerUser;
  global $controllerError;

  try {
    $controllerUser->validateRole();
    $controllerUser->setRole();
  } catch (\Throwable $error) {
    $controllerError->redirectErrorTo("../../public/index.php", $error);
  }
};

$controllerForm->handleForm(
  action: FormAction::SELECT_ROLE,
  functionHandler: $handleSetRole
);
// ----------------------------

// ---- Get and view reparation
$foundReparation = null;
$showReparation = false;

$handleGetReparation = function (): void {
  global $controllerReparation;
  global $foundReparation;
  global $showReparation;
  global $errorAlerts;

  try {
    $foundReparation = $controllerReparation->getReparation();
    $showReparation = true;
  } catch (\Throwable $th) {
    array_push(
      $errorAlerts,
      new ViewAlert($th->getMessage(), "danger")
    );
  }
};

$controllerForm->handleForm(
  action: FormAction::GET_REPARATION,
  functionHandler: $handleGetReparation
);
// ----------------------------

// ---- Insert reparation
$insertedReparationId = 0;
$showInsertSuccessMessage = false;

$handleInsertReparation = function (): void {
  global $controllerReparation;
  global $insertedReparationId;
  global $showInsertSuccessMessage;
  global $errorAlerts;

  try {
    $insertedReparationId = $controllerReparation->insertReparation();
    $showInsertSuccessMessage = true;
  } catch (\Throwable $th) {
    array_push(
      $errorAlerts,
      new ViewAlert($th->getMessage(), "danger")
    );
  }
};

$controllerForm->handleForm(
  action: FormAction::INSERT_REPARATION,
  functionHandler: $handleInsertReparation
);
// ----------------------------


$controllerUser->restrictPageToVisitors();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $controllerUser->getCurrentRole()?->value ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer>
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous" defer>
  </script>

</head>

<body>

  <?php (new ViewNav())->render(); // Should render only once
  ?>

  <main class="container py-4 d-flex flex-column gap-2">
    <h1 class="mb-3">
      <?= $controllerUser->getCurrentRole()?->value ?>'s dashboard
    </h1>
    <?php
    foreach ($errorAlerts as $errorAlert) {
      $errorAlert->render();
    }
    ?>
    <section class="d-flex flex-column gap-3" id="search_form">
      <div class="form">
        <h2>Search for a car reparation</h2>
        <form action="./ViewDashboard.php#search_form" method="post"
          class=" row row-cols-lg-auto g-3 align-items-center">
          <input type="hidden" name="form_action" value="<?= FormAction::GET_REPARATION->value ?>">
          <label for="reparationSearchId" class="form-label">Reparation ID: </label>
          <div class="col-12">
            <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="reparationId"
              id="reparationSearchId" required min="0" max="2147483647" placeholder="Enter ID number">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
      </div>
      <div class="result">
        <?php
        if ($showReparation && $foundReparation) (new ViewReparation(reparation: $foundReparation))->render();

        if ($showReparation && !$foundReparation) (new ViewAlert("No reparation was found.", "danger"))->render();
        ?>
      </div>
    </section>
    <?php if ($controllerUser->getCurrentRole() === UserRole::EMPLOYEE) { ?>
      <hr>
      <section class="d-flex flex-column gap-3" id="register-form">
        <!-- TODO: preview image upload -->
        <div class="form col-md-6 col-12">
          <h2>Register a reparation</h2>
          <form action="./ViewDashboard.php#register-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="form_action" value="<?= FormAction::INSERT_REPARATION->value ?>">
            <div class="mb-3">
              <label for="vehicle_image_upload" class="form-label">Reparation photo</label>
              <input class="form-control" type="file" name="vehicle_image_upload" id="vehicle_image_upload" required>
            </div>
            <div class="mb-3">
              <label for="add_workshop_name" class="form-label">Workshop name</label>
              <input type="text" required maxlength="12" class="form-control" name="add_workshop_name"
                id="add_workshop_name" placeholder="Enter workshop's name">
            </div>
            <div class="mb-3">
              <label for="add_license_plate" class="form-label">License name</label>
              <input type="text" required maxlength="8" class="form-control" name="add_license_plate"
                id="add_license_plate" placeholder="Example: 1234-ABC">
            </div>
            <button type="submit" class="btn btn-primary">Register reparation</button>
          </form>
        </div>
        <div class="result">
          <?php
          if ($showInsertSuccessMessage) (new ViewAlert(
            "Reparation succesfully registered. Reparation ID: " . $insertedReparationId,
            "success"
          ))->render();
          ?>
        </div>
      </section>
    <?php } ?>
  </main>
</body>

</html>