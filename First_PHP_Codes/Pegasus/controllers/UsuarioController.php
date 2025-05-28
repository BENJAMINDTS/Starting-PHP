<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  // Mostrar listado de usuarios con asociaciones
  public function index()
  {
    $usuarios = $this->listarUsuariosConRelaciones();
    require __DIR__ . '/../views/usuarios/index.php';
  }

  // Mostrar formulario de creación
  public function create()
  {
    $hospitales = $this->pdo->query("SELECT id, nombre FROM hospitales ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
    $plantas = $this->pdo->query("SELECT id, nombre FROM plantas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
    $botiquines = $this->pdo->query("SELECT id, nombre FROM botiquines ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

    // Variables para mantener valores en formulario si se recarga con error
    $nombre = $email = $rol = '';
    $hospitalesSeleccionados = $plantasSeleccionadas = $botiquinesSeleccionados = [];

    require __DIR__ . '/../views/usuarios/create.php';
  }

  // Guardar nuevo usuario (POST)
  public function store($data)
  {
    try {
      $usuario = $this->crearUsuario($data);
      $this->actualizarAsociaciones($usuario, $data);

      header('Location: ' . BASE_URL . 'usuarios');
      exit;
    } catch (Exception $e) {
      $error = $e->getMessage();

      $hospitales = $this->pdo->query("SELECT id, nombre FROM hospitales ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
      $plantas = $this->pdo->query("SELECT id, nombre FROM plantas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
      $botiquines = $this->pdo->query("SELECT id, nombre FROM botiquines ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

      // Mantener datos ingresados para mostrar en el formulario
      $nombre = $data['nombre'] ?? '';
      $email = $data['email'] ?? '';
      $rol = $data['rol'] ?? '';
      $hospitalesSeleccionados = $data['id_hospital'] ?? [];
      $plantasSeleccionadas = $data['id_planta'] ?? [];
      $botiquinesSeleccionados = $data['id_botiquin'] ?? [];

      require __DIR__ . '/../views/usuarios/create.php';
    }
  }

  // Mostrar formulario edición
  public function edit($id)
  {
    $usuario = (new Usuario($this->pdo))->findById($id);
    if (!$usuario) {
      http_response_code(404);
      require __DIR__ . '/../views/error/404.php';
      exit;
    }

    $hospitales = $this->pdo->query("SELECT id, nombre FROM hospitales ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
    $plantas = $this->pdo->query("SELECT id, nombre FROM plantas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
    $botiquines = $this->pdo->query("SELECT id, nombre FROM botiquines ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

    $hospitalesSeleccionados = array_map(fn($h) => $h['id'], $usuario->getHospitales());
    $plantasSeleccionadas = array_map(fn($p) => $p['id'], $usuario->getPlantas());
    $botiquinesSeleccionados = array_map(fn($b) => $b['id'], $usuario->getBotiquines());

    require __DIR__ . '/../views/usuarios/edit.php';
  }

  // Actualizar usuario (POST)
  public function update($id, $data)
  {
    try {
      $usuario = $this->editarUsuario($id, $data);
      $this->actualizarAsociaciones($usuario, $data);

      header('Location: ' . BASE_URL . 'usuarios');
      exit;
    } catch (Exception $e) {
      $error = $e->getMessage();
      $usuario = (new Usuario($this->pdo))->findById($id);

      $hospitales = $this->pdo->query("SELECT id, nombre FROM hospitales ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
      $plantas = $this->pdo->query("SELECT id, nombre FROM plantas ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);
      $botiquines = $this->pdo->query("SELECT id, nombre FROM botiquines ORDER BY nombre ASC")->fetchAll(PDO::FETCH_ASSOC);

      $hospitalesSeleccionados = array_map(fn($h) => $h['id'], $usuario->getHospitales());
      $plantasSeleccionadas = array_map(fn($p) => $p['id'], $usuario->getPlantas());
      $botiquinesSeleccionados = array_map(fn($b) => $b['id'], $usuario->getBotiquines());

      require __DIR__ . '/../views/usuarios/edit.php';
    }
  }

  // Borrar usuario
  public function delete($id)
  {
    try {
      $this->borrarUsuario($id);
      header('Location: ' . BASE_URL . 'usuarios');
      exit;
    } catch (Exception $e) {
      $error = $e->getMessage();
      require __DIR__ . '/../views/error/500.php';
    }
  }

  // --- Métodos privados ---

  private function crearUsuario($data)
  {
    if (empty($data['nombre']) || empty($data['email']) || empty($data['password']) || empty($data['rol'])) {
      throw new Exception("Datos incompletos para crear usuario.");
    }

    if (!Usuario::isValidRole($data['rol'])) {
      throw new Exception("Rol inválido.");
    }

    $usuario = new Usuario($this->pdo);
    $usuario->nombre = $data['nombre'];
    $usuario->email = $data['email'];
    $usuario->setPassword($data['password']);
    $usuario->rol = $data['rol'];

    $usuario->create();

    return $usuario->findByEmail($usuario->email);
  }

  private function editarUsuario($id, $data)
  {
    $usuario = new Usuario($this->pdo);
    $user = $usuario->findById($id);
    if (!$user) {
      throw new Exception("Usuario no encontrado.");
    }

    if (isset($data['rol']) && !Usuario::isValidRole($data['rol'])) {
      throw new Exception("Rol inválido.");
    }

    $user->nombre = $data['nombre'] ?? $user->nombre;
    $user->email = $data['email'] ?? $user->email;
    $user->rol = $data['rol'] ?? $user->rol;

    $user->update();

    return $user;
  }

  private function borrarUsuario($id)
  {
    $usuario = new Usuario($this->pdo);
    $user = $usuario->findById($id);
    if (!$user) {
      throw new Exception("Usuario no encontrado.");
    }
    return $user->delete();
  }

  private function listarUsuariosConRelaciones()
  {
    $sql = "SELECT * FROM usuarios ORDER BY nombre ASC";
    $stmt = $this->pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as &$usuario) {
      $usuario['hospitales'] = $this->obtenerHospitalesPorUsuario($usuario['id']);
      $usuario['plantas'] = $this->obtenerPlantasPorUsuario($usuario['id']);
      $usuario['botiquines'] = $this->obtenerBotiquinesPorUsuario($usuario['id']);
    }

    return $usuarios;
  }

  private function obtenerHospitalesPorUsuario($idUsuario)
  {
    $stmt = $this->pdo->prepare("SELECT h.id, h.nombre FROM hospitales h
                                 JOIN hospital_usuario hu ON h.id = hu.id_hospital
                                 WHERE hu.id_usuario = :id_usuario");
    $stmt->execute([':id_usuario' => $idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function obtenerPlantasPorUsuario($idUsuario)
  {
    $stmt = $this->pdo->prepare("SELECT p.id, p.nombre FROM plantas p
                                 JOIN planta_usuario pu ON p.id = pu.id_planta
                                 WHERE pu.id_usuario = :id_usuario");
    $stmt->execute([':id_usuario' => $idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function obtenerBotiquinesPorUsuario($idUsuario)
  {
    $stmt = $this->pdo->prepare("SELECT b.id, b.nombre FROM botiquines b
                                 JOIN botiquin_usuario bu ON b.id = bu.id_botiquin
                                 WHERE bu.id_usuario = :id_usuario");
    $stmt->execute([':id_usuario' => $idUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function actualizarAsociaciones(Usuario $usuario, array $data)
  {
    $this->eliminarTodasAsociaciones($usuario);

    if (!empty($data['id_hospital'])) {
      $ids = is_array($data['id_hospital']) ? $data['id_hospital'] : [$data['id_hospital']];
      foreach ($ids as $idHospital) {
        $usuario->addHospital($idHospital);
      }
    }

    if (!empty($data['id_planta'])) {
      $ids = is_array($data['id_planta']) ? $data['id_planta'] : [$data['id_planta']];
      foreach ($ids as $idPlanta) {
        $usuario->addPlanta($idPlanta);
      }
    }

    if (!empty($data['id_botiquin'])) {
      $ids = is_array($data['id_botiquin']) ? $data['id_botiquin'] : [$data['id_botiquin']];
      foreach ($ids as $idBotiquin) {
        $usuario->addBotiquin($idBotiquin);
      }
    }
  }

  private function eliminarTodasAsociaciones(Usuario $usuario)
  {
    $usuario->removeAllHospitales();
    $usuario->removeAllPlantas();
    $usuario->removeAllBotiquines();
  }
}
