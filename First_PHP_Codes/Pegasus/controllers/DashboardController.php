<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Hospital.php';
require_once __DIR__ . '/../models/Planta.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Usuario.php';

class DashboardController
{
  public function index()
  {
    // Contar total de hospitales
    $hospitalModel = new Hospital();
    $totalHospitales = $hospitalModel->countAll();

    // Contar total de plantas
    $plantaModel = new Planta();
    $totalPlantas = $plantaModel->countAll();

    // Contar total de productos
    $productoModel = new Producto();
    $totalProductos = $productoModel->countAll();

    // Contar total de usuarios activos (opcional: solo usuarios con estado activo)
    $db = Database::getInstance();
    $usuarioModel = new Usuario($db);
    $totalUsuarios = $usuarioModel->countAll();

    // Puedes pasar los datos a la vista
    require __DIR__ . '/../views/dashboard/index.php';
  }
}
