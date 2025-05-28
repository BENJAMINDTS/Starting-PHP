<?php

require_once __DIR__ . '/../config/database.php';

class Lectura
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM lecturas ORDER BY fecha DESC");
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM lecturas WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($id_producto, $id_botiquin, $cantidad_leida, $fecha)
  {
    $stmt = $this->db->prepare("INSERT INTO lecturas (id_producto, id_botiquin, cantidad_leida, fecha) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$id_producto, $id_botiquin, $cantidad_leida, $fecha]);
  }

  public function update($id, $id_producto, $id_botiquin, $cantidad_leida, $fecha)
  {
    $stmt = $this->db->prepare("UPDATE lecturas SET id_producto = ?, id_botiquin = ?, cantidad_leida = ?, fecha = ? WHERE id = ?");
    return $stmt->execute([$id_producto, $id_botiquin, $cantidad_leida, $fecha, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM lecturas WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function getByBotiquin($id_botiquin)
  {
    $stmt = $this->db->prepare("SELECT * FROM lecturas WHERE id_botiquin = ? ORDER BY fecha DESC");
    $stmt->execute([$id_botiquin]);
    return $stmt->fetchAll();
  }

  public function getByProducto($id_producto)
  {
    $stmt = $this->db->prepare("SELECT * FROM lecturas WHERE id_producto = ? ORDER BY fecha DESC");
    $stmt->execute([$id_producto]);
    return $stmt->fetchAll();
  }

  public function getByDateRange($startDate, $endDate)
  {
    $stmt = $this->db->prepare("SELECT * FROM lecturas WHERE fecha BETWEEN ? AND ? ORDER BY fecha DESC");
    $stmt->execute([$startDate, $endDate]);
    return $stmt->fetchAll();
  }
}
