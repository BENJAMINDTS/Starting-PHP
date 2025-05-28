<?php
require_once __DIR__ . '/../models/Relacion.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Hospital.php';
require_once __DIR__ . '/../models/Planta.php';
require_once __DIR__ . '/../models/Botiquin.php';
require_once __DIR__ . '/../models/Almacen.php';

class RelacionController
{
  private $relacionModel;
  private $usuarioModel;
  private $hospitalModel;
  private $plantaModel;
  private $botiquinModel;
  private $almacenModel;

  public function __construct(PDO $pdo)
  {

    $this->relacionModel = new Relacion();
    $this->usuarioModel = new Usuario($pdo);
    $this->hospitalModel = new Hospital();
    $this->plantaModel = new Planta();
    $this->botiquinModel = new Botiquin();
    $this->almacenModel = new Almacen();
  }

  // Mostrar formulario para editar relaciones de un usuario
  public function edit(int $usuario_id)
  {
    $usuario = $this->usuarioModel->findById($usuario_id);
    if (!$usuario) {
      // manejar error, usuario no existe
      header('Location: ' . BASE_URL . 'usuarios');
      exit;
    }

    // Obtener todas las relaciones actuales del usuario
    $relaciones = $this->relacionModel->obtenerRelacionesUsuario($usuario_id);

    // Obtener listas completas de entidades para mostrar en selects
    $hospitales = $this->hospitalModel->getAll();
    $plantas = $this->plantaModel->getAll();
    $botiquines = $this->botiquinModel->getAll();
    $almacenes = $this->almacenModel->getAll();

    // Organizar IDs asociados por tipo entidad para marcar selects
    $asociados = [
      'hospital' => [],
      'planta' => [],
      'botiquin' => [],
      'almacen' => []
    ];
    foreach ($relaciones as $rel) {
      $tipo = $rel['tipo_entidad'];
      $asociados[$tipo][] = $rel['entidad_id'];
    }

    require_once __DIR__ . '/../views/relaciones/edit.php';
  }

  // Guardar las relaciones actualizadas del usuario
  public function update(int $usuario_id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Recoger datos enviados, puede venir como arrays de IDs por tipo entidad
      $relaciones = [];

      if (!empty($_POST['hospital'])) {
        foreach ($_POST['hospital'] as $idHospital) {
          $relaciones[] = ['entidad_id' => (int)$idHospital, 'tipo_entidad' => 'hospital'];
        }
      }

      if (!empty($_POST['planta'])) {
        foreach ($_POST['planta'] as $idPlanta) {
          $relaciones[] = ['entidad_id' => (int)$idPlanta, 'tipo_entidad' => 'planta'];
        }
      }

      if (!empty($_POST['botiquin'])) {
        foreach ($_POST['botiquin'] as $idBotiquin) {
          $relaciones[] = ['entidad_id' => (int)$idBotiquin, 'tipo_entidad' => 'botiquin'];
        }
      }

      if (!empty($_POST['almacen'])) {
        foreach ($_POST['almacen'] as $idAlmacen) {
          $relaciones[] = ['entidad_id' => (int)$idAlmacen, 'tipo_entidad' => 'almacen'];
        }
      }

      try {
        $this->relacionModel->actualizarRelacionesUsuario($usuario_id, $relaciones);
        header('Location: ' . BASE_URL . 'usuarios/edit/' . $usuario_id . '?success=1');
        exit;
      } catch (Exception $e) {
        $error = "Error al actualizar relaciones: " . $e->getMessage();
        // Recargar el formulario con error
        $this->edit($usuario_id);
      }
    } else {
      // No es POST, redirigir
      header('Location: ' . BASE_URL . 'usuarios');
      exit;
    }
  }
    // Mostrar relaciones hospitalarias
  public function mostrarHospitales()
  {
    $usuarios = $this->usuarioModel->getAll();
    $hospitales = $this->hospitalModel->getAll();
    $relaciones = $this->relacionModel->obtenerRelaciones('hospital');
    require_once __DIR__ . '/../views/relaciones/usuario_hospital.php';
  }

  public function asociarHospital(array $data)
  {
    $this->relacionModel->crearRelacion((int)$data['usuario_id'], (int)$data['entidad_id'], 'hospital');
    header('Location: ' . BASE_URL . 'relaciones/hospital');
    exit;
  }

  public function eliminarHospital(int $id)
  {
    $this->relacionModel->eliminarRelacion($id);
    header('Location: ' . BASE_URL . 'relaciones/hospital');
    exit;
  }

  // Mostrar relaciones de plantas
  public function mostrarPlantas()
  {
    $usuarios = $this->usuarioModel->getAll();
    $plantas = $this->plantaModel->getAll();
    $relaciones = $this->relacionModel->obtenerRelaciones('planta');
    require_once __DIR__ . '/../views/relaciones/usuario_planta.php';
  }

  public function asociarPlanta(array $data)
  {
    $this->relacionModel->crearRelacion((int)$data['usuario_id'], (int)$data['entidad_id'], 'planta');
    header('Location: ' . BASE_URL . 'relaciones/planta');
    exit;
  }

  public function eliminarPlanta(int $id)
  {
    $this->relacionModel->eliminarRelacion($id);
    header('Location: ' . BASE_URL . 'relaciones/planta');
    exit;
  }

  // Mostrar relaciones de almacenes
  public function mostrarAlmacenes()
  {
    $usuarios = $this->usuarioModel->getAll();
    $almacenes = $this->almacenModel->getAll();
    $relaciones = $this->relacionModel->obtenerRelaciones('almacen');
    require_once __DIR__ . '/../views/relaciones/usuario_almacen.php';
  }

  public function asociarAlmacen(array $data)
  {
    $this->relacionModel->crearRelacion((int)$data['usuario_id'], (int)$data['entidad_id'], 'almacen');
    header('Location: ' . BASE_URL . 'relaciones/almacen');
    exit;
  }

  public function eliminarAlmacen(int $id)
  {
    $this->relacionModel->eliminarRelacion($id);
    header('Location: ' . BASE_URL . 'relaciones/almacen');
    exit;
  }

  // Mostrar relaciones de botiquines
  public function mostrarBotiquines()
  {
    $usuarios = $this->usuarioModel->getAll();
    $botiquines = $this->botiquinModel->getAll();
    $relaciones = $this->relacionModel->obtenerRelaciones('botiquin');
    require_once __DIR__ . '/../views/relaciones/usuario_botiquin.php';
  }

  public function asociarBotiquin(array $data)
  {
    $this->relacionModel->crearRelacion((int)$data['usuario_id'], (int)$data['entidad_id'], 'botiquin');
    header('Location: ' . BASE_URL . 'relaciones/botiquin');
    exit;
  }

  public function eliminarBotiquin(int $id)
  {
    $this->relacionModel->eliminarRelacion($id);
    header('Location: ' . BASE_URL . 'relaciones/botiquin');
    exit;
  }

}
