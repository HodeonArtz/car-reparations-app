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
  action: ControllerForm::ACTIONS["SELECT_ROLE"], 
  functionHandler: $handleSetRole
);
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

  <main class="container py-4 gap-2">
    <h1>
      <?= $controllerUser->getFormattedRole()?>
    </h1>
    <section>
      <h2>Search for a car reparation</h2>
      <form action="./ViewDashboard.php" method="post" class=" row row-cols-lg-auto g-3 align-items-center">
        <input type="hidden" name="form_action" value="<?= ControllerForm::ACTIONS["GET_REPARATION"] ?>">
        <label for="reparationSearchId" class="form-label">Reparation ID: </label>
        </div>
        <div class="col-12">
          <input type="number" name="reparationId" id="reparationSearchId">
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </form>
      <?php if($showReparation && $foundReparation) { ?>
      <h3><?= (new ViewReparation())->render(reparation: $foundReparation) ?></h3>
      <?php
      }
      ?>

      <?php if($showReparation && !$foundReparation) { ?>
      <h3>No reparation was found.</h3>
      <?php
      }
      ?>


    </section>
  </main>
</body>

</html>