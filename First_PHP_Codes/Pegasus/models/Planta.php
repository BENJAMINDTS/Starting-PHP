<?php

require_once __DIR__ . '/../config/database.php';

class Planta
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $sql = "SELECT p.*, h.nombre AS hospital_nombre
                FROM plantas p
                INNER JOIN hospitales h ON p.id_hospital = h.id
                ORDER BY p.id DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM plantas WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($nombre, $id_hospital)
  {
    $stmt = $this->db->prepare("INSERT INTO plantas (nombre, id_hospital) VALUES (?, ?)");
    return $stmt->execute([$nombre, $id_hospital]);
  }

  public function update($id, $nombre, $id_hospital)
  {
    $stmt = $this->db->prepare("UPDATE plantas SET nombre = ?, id_hospital = ? WHERE id = ?");
    return $stmt->execute([$nombre, $id_hospital, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM plantas WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function getByHospital($id_hospital)
  {
    $stmt = $this->db->prepare("SELECT * FROM plantas WHERE id_hospital = ?");
    $stmt->execute([$id_hospital]);
    return $stmt->fetchAll();
  }

  //Contar el número de plantass
  public function countAll()
  {
    $stmt = $this->db->query("SELECT COUNT(*) as total FROM plantas");
    return $stmt->fetchColumn();
  }
}
