<?php
require_once __DIR__ . '/../config/database.php';

class Hospital
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getInstance();
  }

  // Obtener todos los hospitales
  public function getAll()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM hospitales ORDER BY nombre ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // Obtener un hospital por ID
  public function getById($id)
  {
    $stmt = $this->pdo->prepare("SELECT * FROM hospitales WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // Crear un nuevo hospital
  public function create($nombre)
  {
    $stmt = $this->pdo->prepare("INSERT INTO hospitales (nombre) VALUES (:nombre)");
    $stmt->bindParam(':nombre', $nombre);
    return $stmt->execute();
  }

  // Actualizar un hospital
  public function update($id, $nombre)
  {
    $stmt = $this->pdo->prepare("UPDATE hospitales SET nombre = :nombre WHERE id = :id");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // Eliminar un hospital
  public function delete($id)
  {
    $stmt = $this->pdo->prepare("DELETE FROM hospitales WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  //Contar hospitales
  public function countAll()
  {
    $stmt = $this->pdo->query("SELECT COUNT(*) FROM hospitales");
    return $stmt->fetchColumn();
  }
}
