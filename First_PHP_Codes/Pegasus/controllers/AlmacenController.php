<?php
// controllers/AlmacenController.php

require_once __DIR__ . '/../models/Almacen.php';
require_once __DIR__ . '/../models/Planta.php';
require_once __DIR__ . '/../models/Hospital.php';

class AlmacenController
{
  private $almacenModel;
  private $plantaModel;
  private $hospitalModel;

  public function __construct()
  {
    $this->almacenModel = new Almacen();
    $this->plantaModel = new Planta();
    $this->hospitalModel = new Hospital();
  }

  public function index()
  {
    $almacenes = $this->almacenModel->getAll();
    require __DIR__ . '/../views/almacenes/index.php';
  }

  public function create()
  {
    $plantas = $this->plantaModel->getAll();
    require __DIR__ . '/../views/almacenes/create.php';
  }

  public function store()
  {
    $id_planta = $_POST['id_planta'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if (!$id_planta || !$tipo) {
      $_SESSION['error'] = "Todos los campos son obligatorios.";
      header("Location: " . BASE_URL . "almacenes/create");
      exit;
    }

    // Verificar existencia de otro almacén del mismo tipo en la planta
    $almacenesEnPlanta = $this->almacenModel->getByPlanta($id_planta);
    foreach ($almacenesEnPlanta as $almacen) {
      if ($almacen['tipo'] === $tipo) {
        $_SESSION['error'] = "La planta ya tiene un almacén de tipo '$tipo'.";
        header("Location: " . BASE_URL . "almacenes/create");
        exit;
      }
    }

    // Si es tipo General, validar que el hospital no tenga ya un almacén general
    if ($tipo === 'General') {
      $planta = $this->plantaModel->getById($id_planta);
      if (!$planta) {
        $_SESSION['error'] = "Planta no válida.";
        header("Location: " . BASE_URL . "almacenes/create");
        exit;
      }

      $hospitalId = $planta['id_hospital'];
      $almacenes = $this->almacenModel->getAll();
      foreach ($almacenes as $almacen) {
        if (
          $almacen['tipo'] === 'General' &&
          $this->plantaModel->getById($almacen['id_planta'])['id_hospital'] === $hospitalId
        ) {
          $_SESSION['error'] = "Este hospital ya tiene un almacén general.";
          header("Location: " . BASE_URL . "almacenes/create");
          exit;
        }
      }
    }

    $this->almacenModel->create($id_planta, $tipo);
    header("Location: " . BASE_URL . "almacenes");
  }

  public function edit($id)
  {
    $almacen = $this->almacenModel->getById($id);
    $plantas = $this->plantaModel->getAll();
    if (!$almacen) {
      http_response_code(404);
      require __DIR__ . '/../views/error/404.php';
      return;
    }
    require __DIR__ . '/../views/almacenes/edit.php';
  }

  public function update($id)
  {
    $id_planta = $_POST['id_planta'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if (!$id_planta || !$tipo) {
      $_SESSION['error'] = "Todos los campos son obligatorios.";
      header("Location: " . BASE_URL . "almacenes/edit/$id");
      exit;
    }

    // Lógica similar al store, pero evitar compararse con sí mismo
    $almacenesEnPlanta = $this->almacenModel->getByPlanta($id_planta);
    foreach ($almacenesEnPlanta as $almacen) {
      if ($almacen['tipo'] === $tipo && $almacen['id'] != $id) {
        $_SESSION['error'] = "La planta ya tiene un almacén de tipo '$tipo'.";
        header("Location: " . BASE_URL . "almacenes/edit/$id");
        exit;
      }
    }

    if ($tipo === 'General') {
      $planta = $this->plantaModel->getById($id_planta);
      $hospitalId = $planta['id_hospital'];
      $almacenes = $this->almacenModel->getAll();
      foreach ($almacenes as $almacen) {
        if (
          $almacen['tipo'] === 'General' &&
          $almacen['id'] != $id &&
          $this->plantaModel->getById($almacen['id_planta'])['id_hospital'] === $hospitalId
        ) {
          $_SESSION['error'] = "Este hospital ya tiene un almacén general.";
          header("Location: " . BASE_URL . "almacenes/edit/$id");
          exit;
        }
      }
    }

    $this->almacenModel->update($id, $id_planta, $tipo);
    header("Location: " . BASE_URL . "almacenes");
  }

  public function delete($id)
  {
    $this->almacenModel->delete($id);
    header("Location: " . BASE_URL . "almacenes");
  }
}
