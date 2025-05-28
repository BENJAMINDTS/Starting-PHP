<?php
// controllers/BotiquinController.php

require_once __DIR__ . '/../models/Botiquin.php';
require_once __DIR__ . '/../models/Planta.php';

class BotiquinController
{
  private $botiquinModel;
  private $plantaModel;

  public function __construct()
  {
    $this->botiquinModel = new Botiquin();
    $this->plantaModel = new Planta();
  }

  public function index()
  {
    $botiquines = $this->botiquinModel->getAll();
    require __DIR__ . '/../views/botiquines/index.php';
  }

  public function create()
  {
    $plantas = $this->plantaModel->getAll();
    require __DIR__ . '/../views/botiquines/create.php';
  }

  public function store()
  {
    $id_planta = $_POST['id_planta'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');

    if (!$id_planta || $nombre === '') {
      $_SESSION['error'] = "Todos los campos son obligatorios.";
      header("Location: " . BASE_URL . "botiquines/create");
      exit;
    }

    $existente = $this->botiquinModel->getByNombreYPlanta($nombre, $id_planta);
    if ($existente) {
      $_SESSION['error'] = "Ya existe un botiquín con ese nombre en esta planta.";
      header("Location: " . BASE_URL . "botiquines/create");
      exit;
    }

    $this->botiquinModel->create($nombre, $id_planta);
    header("Location: " . BASE_URL . "botiquines");
  }

  public function edit($id)
  {
    $botiquin = $this->botiquinModel->getById($id);
    $plantas = $this->plantaModel->getAll();

    if (!$botiquin) {
      http_response_code(404);
      require __DIR__ . '/../views/error/404.php';
      return;
    }

    require __DIR__ . '/../views/botiquines/edit.php';
  }

  public function update($id)
  {
    $id_planta = $_POST['id_planta'] ?? null;
    $nombre = trim($_POST['nombre'] ?? '');

    if (!$id_planta || $nombre === '') {
      $_SESSION['error'] = "Todos los campos son obligatorios.";
      header("Location: " . BASE_URL . "botiquines/edit/$id");
      exit;
    }

    $existente = $this->botiquinModel->getByNombreYPlanta($nombre, $id_planta);
    if ($existente && $existente['id'] != $id) {
      $_SESSION['error'] = "Ya existe un botiquín con ese nombre en esta planta.";
      header("Location: " . BASE_URL . "botiquines/edit/$id");
      exit;
    }

    $this->botiquinModel->update($id, $nombre, $id_planta);
    header("Location: " . BASE_URL . "botiquines");
  }

  public function delete($id)
  {
    $this->botiquinModel->delete($id);
    header("Location: " . BASE_URL . "botiquines");
  }
}
