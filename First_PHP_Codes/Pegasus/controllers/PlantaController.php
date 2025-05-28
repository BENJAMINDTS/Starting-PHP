<?php

require_once 'models/Planta.php';
require_once 'models/Hospital.php';

class PlantaController
{
  private $plantaModel;
  private $hospitalModel;

  public function __construct()
  {
    $this->plantaModel = new Planta();
    $this->hospitalModel = new Hospital();
  }

  // Mostrar todas las plantas
  public function index()
  {
    $plantas = $this->plantaModel->getAll();
    require 'views/plantas/index.php';
  }

  // Formulario de creación
  public function create()
  {
    $hospitales = $this->hospitalModel->getAll();
    require 'views/plantas/create.php';
  }

  // Guardar nueva planta
  public function store()
  {
    $nombre = $_POST['nombre'] ?? null;
    $id_hospital = $_POST['id_hospital'] ?? null;

    if (empty($nombre) || empty($id_hospital)) {
      $error = "Todos los campos son obligatorios.";
      $hospitales = $this->hospitalModel->getAll();
      require 'views/plantas/create.php';
      return;
    }

    $this->plantaModel->create($nombre, $id_hospital);
    header("Location: " . BASE_URL . "plantas");
    exit;
  }

  // Formulario de edición
  public function edit($id)
  {
    $planta = $this->plantaModel->getById($id);
    $hospitales = $this->hospitalModel->getAll();

    if (!$planta) {
      $error = "Planta no encontrada.";
      require 'views/error/404.php';
      return;
    }

    require 'views/plantas/edit.php';
  }

  // Actualizar planta
  public function update($id)
  {
    $nombre = $_POST['nombre'] ?? null;
    $id_hospital = $_POST['id_hospital'] ?? null;

    if (empty($nombre) || empty($id_hospital)) {
      $error = "Todos los campos son obligatorios.";
      $planta = $this->plantaModel->getById($id);
      $hospitales = $this->hospitalModel->getAll();
      require 'views/plantas/edit.php';
      return;
    }

    $this->plantaModel->update($id, $nombre, $id_hospital);
    header("Location: " . BASE_URL . "plantas");
    exit;
  }

  // Eliminar planta
  public function delete($id)
  {
    $this->plantaModel->delete($id);
    header("Location: " . BASE_URL . "plantas");
    exit;
  }
  public function show($id)
  {
    $planta = $this->plantaModel->getById($id);

    if (!$planta) {
      $error = "Planta no encontrada.";
      require 'views/error/404.php';
      return;
    }

    // Obtener también el nombre del hospital para mostrar, si quieres
    $hospital = $this->hospitalModel->getById($planta['id_hospital']);

    require 'views/plantas/show.php';
  }
}
