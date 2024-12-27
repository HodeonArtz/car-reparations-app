<?php
namespace App\Views;
require __DIR__ . '\\..\\..\\vendor\\autoload.php';

use App\Controllers\ControllerForm;
use App\Controllers\ControllerReparation;
use App\Controllers\ControllerUser;
use App\Views\ViewReparation;


$controllerForm = new ControllerForm();
$controllerUser = new ControllerUser();
$controllerReparation = new ControllerReparation();


$handleSetRole = function () : void {
  global $controllerUser;
  
  $controllerUser->validateRole();
  $controllerUser->setRole();
};

$controllerForm->handleForm(
  action: ControllerForm::ACTIONS["SELECT_ROLE"], 
  functionHandler: $handleSetRole
);


$foundReparation = null;
$showReparation = false;

$handleGetReparation = function () : void {
  global $controllerReparation;
  global $foundReparation;
  global $showReparation;

  $foundReparation = $controllerReparation->getReparation();
  $showReparation = true;
};

$controllerForm->handleForm(
  action: ControllerForm::ACTIONS["GET_REPARATION"], 
  functionHandler: $handleGetReparation
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=  $controllerUser->getFormattedRole() ?></title>
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

  <?php (new ViewNav())->render(); // Should render only once?>

  <main class="container py-4 d-flex flex-column gap-2">
    <h1 class="mb-3">
      <?= $controllerUser->getFormattedRole()?>'s dashboard
    </h1>
    <section class="d-flex flex-column gap-3" id="search_form">
      <div class="form">
        <h2>Search for a car reparation</h2>
        <form action="./ViewDashboard.php#search_form" method="post"
          class=" row row-cols-lg-auto g-3 align-items-center">
          <input type="hidden" name="form_action" value="<?= ControllerForm::ACTIONS["GET_REPARATION"] ?>">
          <label for="reparationSearchId" class="form-label">Reparation ID: </label>
          <div class="col-12">
            <input type="number" name="reparationId" id="reparationSearchId" required min="0"
              placeholder="Enter ID number">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
      </div>
      <div class="result">
        <?php if($showReparation && $foundReparation) { ?>
        <?= (new ViewReparation(reparation: $foundReparation))->render() ?>
        <?php
          }
          ?>

        <?php if($showReparation && !$foundReparation) { ?>
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
          <div>
            No reparation was found.
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
          }
          ?>
      </div>
    </section>
    <hr>
    <section class="d-flex flex-column gap-3" id="register-form">
      <!-- TODO: preview image upload -->
      <div class="form col-md-6 col-12">
        <h2>Register a reparation</h2>
        <form action="./ViewDashboard.php#register-form">
          <div class="mb-3">
            <label for="upload_vehicle_image" class="form-label">Reparation photo</label>
            <input class="form-control" type="file" id="vehicle_image_upload" required>
          </div>
          <div class="mb-3">
            <label for="add_workshop_name" class="form-label">Workshop name</label>
            <input type="text" required maxlength="12" class="form-control" id="add_workshop_name"
              placeholder="Enter workshop's name">
          </div>
          <div class="mb-3">
            <label for="add_license_plate" class="form-label">Workshop name</label>
            <input type="text" required maxlength="7" class="form-control" id="add_license_plate"
              placeholder="Example: 1234-ABC">
          </div>
          <button type="submit" class="btn btn-primary">Register reparation</button>
        </form>
      </div>
    </section>
  </main>
</body>

</html>