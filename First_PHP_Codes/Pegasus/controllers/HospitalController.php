<?php
require_once __DIR__ . '/../models/Hospital.php';

class HospitalController
{
  private $hospitalModel;

  public function __construct()
  {
    $this->hospitalModel = new Hospital();
  }

  // Mostrar lista de hospitales
  public function index()
  {
    $hospitales = $this->hospitalModel->getAll();
    require __DIR__ . '/../views/hospitales/index.php';
  }

  // Mostrar formulario para crear un hospital
  public function create()
  {
    require __DIR__ . '/../views/hospitales/create.php';
  }

  // Guardar nuevo hospital
  public function store($data)
  {
    $nombre = trim($data['nombre']);

    if ($nombre === '') {
      $error = "El nombre no puede estar vacío.";
      require __DIR__ . '/../views/hospitales/create.php';
      return;
    }

    if ($this->hospitalModel->create($nombre)) {
      header('Location: ' . BASE_URL . 'hospitales');
      exit;
    } else {
      $error = "Error al crear hospital.";
      require __DIR__ . '/../views/hospitales/create.php';
    }
  }

  // Mostrar formulario para editar hospital
  public function edit($id)
  {
    $hospital = $this->hospitalModel->getById($id);
    if (!$hospital) {
      header("HTTP/1.0 404 Not Found");
      echo "Hospital no encontrado.";
      exit;
    }
    require __DIR__ . '/../views/hospitales/edit.php';
  }

  // Actualizar hospital existente
  public function update($id, $data)
  {
    $nombre = trim($data['nombre']);

    if ($nombre === '') {
      $error = "El nombre no puede estar vacío.";
      $hospital = $this->hospitalModel->getById($id);
      require __DIR__ . '/../views/hospitales/edit.php';
      return;
    }

    if ($this->hospitalModel->update($id, $nombre)) {
      header('Location: ' . BASE_URL . 'hospitales');
      exit;
    } else {
      $error = "Error al actualizar hospital.";
      $hospital = $this->hospitalModel->getById($id);
      require __DIR__ . '/../views/hospitales/edit.php';
    }
  }

  // Eliminar hospital
  public function delete($id)
  {
    if ($this->hospitalModel->delete($id)) {
      header('Location: ' . BASE_URL . 'hospitales');
      exit;
    } else {
      echo "Error al eliminar hospital.";
    }
  }
}
