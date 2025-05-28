<?php

require_once __DIR__ . '/../config/database.php';

class Botiquin
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM botiquines");
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM botiquines WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($nombre, $id_planta)
  {
    $stmt = $this->db->prepare("INSERT INTO botiquines (nombre, id_planta) VALUES (?, ?)");
    return $stmt->execute([$nombre, $id_planta]);
  }

  public function update($id, $nombre, $id_planta)
  {
    $stmt = $this->db->prepare("UPDATE botiquines SET nombre = ?, id_planta = ? WHERE id = ?");
    return $stmt->execute([$nombre, $id_planta, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM botiquines WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function getByPlanta($id_planta)
  {
    $stmt = $this->db->prepare("SELECT * FROM botiquines WHERE id_planta = ?");
    $stmt->execute([$id_planta]);
    return $stmt->fetchAll();
  }
  public function getByNombreYPlanta($nombre, $id_planta)
  {
    $stmt = $this->db->prepare("SELECT * FROM botiquines WHERE nombre = ? AND id_planta = ?");
    $stmt->execute([$nombre, $id_planta]);
    return $stmt->fetch();
  }
}
