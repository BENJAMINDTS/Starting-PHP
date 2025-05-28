<?php
// routes/web.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/HospitalController.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../controllers/PlantaController.php';
require_once __DIR__ . '/../controllers/AlmacenController.php';
require_once __DIR__ . '/../controllers/BotiquinController.php';
require_once __DIR__ . '/../controllers/RelacionController.php'; // NUEVO

$pdo = new PDO('mysql:host=localhost;dbname=pegasusmedical', 'root', '');

$dashboardController = new DashboardController();
$hospitalController = new HospitalController();
$usuarioController = new UsuarioController($pdo);
$plantaController = new PlantaController();
$almacenController = new AlmacenController();
$botiquinController = new BotiquinController();
$relacionController = new RelacionController($pdo); // NUEVO

$route = isset($pathForRouter) ? $pathForRouter : '';

// Rutas
switch ($route) {
  case '':
  case 'dashboard':
    $dashboardController->index();
    break;

  // Hospitales
  case 'hospitales':
    $hospitalController->index();
    break;

  case 'hospitales/create':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $hospitalController->store($_POST);
    } else {
      $hospitalController->create();
    }
    break;

  // Usuarios
  case 'usuarios':
    $usuarioController->index();
    break;

  case 'usuarios/create':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuarioController->store($_POST);
    } else {
      $usuarioController->create();
    }
    break;

  // Plantas
  case 'plantas':
    $plantaController->index();
    break;

  case 'plantas/create':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $plantaController->store();
    } else {
      $plantaController->create();
    }
    break;

  // Almacenes
  case 'almacenes':
    $almacenController->index();
    break;

  case 'almacenes/create':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $almacenController->store();
    } else {
      $almacenController->create();
    }
    break;

  // Botiquines
  case 'botiquines':
    $botiquinController->index();
    break;

  case 'botiquines/create':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $botiquinController->store();
    } else {
      $botiquinController->create();
    }
    break;

  // RELACIONES (NUEVO)
  case 'relaciones/hospital':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $relacionController->asociarHospital($_POST);
    } else {
      $relacionController->mostrarHospitales();
    }
    break;

  case 'relaciones/planta':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $relacionController->asociarPlanta($_POST);
    } else {
      $relacionController->mostrarPlantas();
    }
    break;

  case 'relaciones/almacen':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $relacionController->asociarAlmacen($_POST);
    } else {
      $relacionController->mostrarAlmacenes();
    }
    break;

  case 'relaciones/botiquin':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $relacionController->asociarBotiquin($_POST);
    } else {
      $relacionController->mostrarBotiquines();
    }
    break;

  default:
    // Hospitales edit/delete
    if (preg_match('#^hospitales/edit/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hospitalController->update($id, $_POST);
      } else {
        $hospitalController->edit($id);
      }
      break;
    }

    if (preg_match('#^hospitales/delete/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      $hospitalController->delete($id);
      break;
    }

    // Usuarios edit/delete
    if (preg_match('#^usuarios/edit/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuarioController->update($id, $_POST);
      } else {
        $usuarioController->edit($id);
      }
      break;
    }

    if (preg_match('#^usuarios/delete/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      $usuarioController->delete($id);
      break;
    }

    // Plantas edit/delete/show
    if (preg_match('#^plantas/edit/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $plantaController->update($id);
      } else {
        $plantaController->edit($id);
      }
      break;
    }

    if (preg_match('#^plantas/delete/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      $plantaController->delete($id);
      break;
    }

    if (preg_match('#^plantas/show/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      $plantaController->show($id);
      break;
    }

    // Almacenes edit/delete
    if (preg_match('#^almacenes/edit/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $almacenController->update($id);
      } else {
        $almacenController->edit($id);
      }
      break;
    }

    if (preg_match('#^almacenes/delete/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      $almacenController->delete($id);
      break;
    }

    // Botiquines edit/delete
    if (preg_match('#^botiquines/edit/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $botiquinController->update($id);
      } else {
        $botiquinController->edit($id);
      }
      break;
    }

    if (preg_match('#^botiquines/delete/(\d+)$#', $route, $matches)) {
      $id = (int)$matches[1];
      $botiquinController->delete($id);
      break;
    }

    // RELACIONES delete (NUEVO)
    if (preg_match('#^relaciones/hospital/delete/(\d+)$#', $route, $matches)) {
      $relacionController->eliminarHospital((int)$matches[1]);
      break;
    }

    if (preg_match('#^relaciones/planta/delete/(\d+)$#', $route, $matches)) {
      $relacionController->eliminarPlanta((int)$matches[1]);
      break;
    }

    if (preg_match('#^relaciones/almacen/delete/(\d+)$#', $route, $matches)) {
      $relacionController->eliminarAlmacen((int)$matches[1]);
      break;
    }

    if (preg_match('#^relaciones/botiquin/delete/(\d+)$#', $route, $matches)) {
      $relacionController->eliminarBotiquin((int)$matches[1]);
      break;
    }

    // 404
    http_response_code(404);
    require __DIR__ . '/../views/error/404.php';
    break;
}
