<?php
// index.php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
$pdo = new PDO('mysql:host=localhost;dbname=pegasusmedical', 'root', '');
// Iniciar sesión sólo si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Obtener la ruta solicitada
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Quitar BASE_URL al principio si existe para rutas relativas
if (strpos($path, BASE_URL) === 0) {
    $path = substr($path, strlen(BASE_URL));
}

// Normalizar ruta (sin barras iniciales ni finales)
$path = trim($path, '/');

// Rutas públicas: login y logout
if ($path === 'login') {
    require_once __DIR__ . '/controllers/AuthController.php';
    $pdo = new PDO('mysql:host=localhost;dbname=pegasusmedical', 'root', '');
    $authController = new AuthController($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->login();
    } else {
        $authController->showLoginForm();
    }
    exit;
}

if ($path === 'logout') {
    require __DIR__ . '/controllers/AuthController.php';
    $authController = new AuthController($pdo);
    $authController->logout();
    exit;
}

// Rutas protegidas, requieren sesión activa
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login');
    exit;
}

// Pasar la ruta al router principal
$pathForRouter = $path;
require __DIR__ . '/routes/web.php';
