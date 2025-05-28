<?php
// config/config.php

// Ruta base del sistema (ajústala según tu entorno)
define('BASE_URL', '/Pegasus/');

// Nombre de la aplicación
const APP_NAME = 'PEGASUS MEDICAL';

// Zona horaria por defecto
date_default_timezone_set('Europe/Madrid');

// Control de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Duración de la sesión
session_start([
  'cookie_lifetime' => 86400,
  'read_and_close'  => false,
]);

// Roles disponibles (para validación)
define('ROLES', [
  'Administrador',          // Acceso total
  'Gestor_General',
  'Gestor_de_Hospital',
  'Gestor_de_Planta',
  'Usuario_de_Botiquín'
]);

// Ruta al directorio de etiquetas generadas
define('ETIQUETAS_DIR', __DIR__ . '/../public/etiquetas/');
