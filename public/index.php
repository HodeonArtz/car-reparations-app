<?php 
  namespace Public;
  require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ControllerError;
use App\Controllers\ControllerForm;
use App\Controllers\ControllerUser;
use App\Services\ServiceUser;
use App\Views\ViewAlert;
use App\Views\ViewNav;

  $controllerError = new ControllerError(); 
  $controllerUser = new ControllerUser();

  $controllerUser->resetRole();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer>
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous" defer>
  </script>


  <title>Car workshop</title>
</head>

<body>
  <?php (new ViewNav(indexPath: "#"))->render(); // Should render only once?>
  <main class="container py-4 gap-2">
    <h1>Welcome!</h1>
    <?php 
      try {
        $controllerError->checkErrors(); ?>
    <?php } catch (\Throwable $th) { 
        (new ViewAlert($th->getMessage(), "danger"))->render();
     } ?>
    <form action="../App/Views/ViewDashboard.php" method="GET" class=" row row-cols-lg-auto g-3 align-items-center">
      <input type="hidden" name="form_action" value="<?= ControllerForm::ACTIONS["SELECT_ROLE"] ?>">
      <div class="col-12">
        <label for="userRole" class="form-label">Enter as: </label>
      </div>
      <div class="col-12">
        <select name="user-role" id="userRole" class="form-select">
          <?php // Renders all the available "selectable" roles in the system ?>
          <?php foreach (ServiceUser::AVAILABLE_ROLES as $role) { ?>
          <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Enter</button>
      </div>
    </form>
  </main>
</body>

</html>