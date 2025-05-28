<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/config.php';

class AuthController
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function showLoginForm()
  {
    // Mostrar vista login.php
    require __DIR__ . '/../views/auth/login.php';
  }

  public function login()
  {
    // Procesar login POST
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
      $_SESSION['error'] = "Email y contraseña son obligatorios.";
      header('Location: ' . BASE_URL . 'login');
      exit;
    }

    $usuario = new Usuario($this->pdo);
    $user = $usuario->findByEmail($email);

    if ($user && $user->verifyPassword($password)) {
      // Guardar datos de usuario en sesión
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_rol'] = $user->rol;
      $_SESSION['user_nombre'] = $user->nombre;

      header('Location: ' . BASE_URL . 'dashboard');
      exit;
    } else {
      $_SESSION['error'] = "Credenciales inválidas.";
      header('Location: ' . BASE_URL . 'login');
      exit;
    }
  }

  public function logout()
  {
    session_unset();
    session_destroy();
    header('Location: ' . BASE_URL . 'login');
    exit;
  }
}
