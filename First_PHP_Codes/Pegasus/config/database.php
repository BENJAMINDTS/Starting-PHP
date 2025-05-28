<?php

class Database
{
  private static $instance = null;
  private $pdo;

  private function __construct()
  {
    try {
      $host = 'localhost';
      $dbname = 'pegasusmedical';
      $user = 'root';
      $pass = '';
      $charset = 'utf8mb4';

      $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
      $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
      ];

      $this->pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
      die("Error de conexión a la base de datos: " . $e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = (new self())->pdo;
    }

    return self::$instance;
  }
}
