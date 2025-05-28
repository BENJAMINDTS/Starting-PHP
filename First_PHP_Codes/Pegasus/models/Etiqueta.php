<?php
require_once __DIR__ . '/Database.php';

class Reposicion
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM reposiciones ORDER BY fecha DESC");
    return $stmt->fetchAll();
  }

  public function getAllWithProduct()
  {
    $stmt = $this->db->query(
      "SELECT r.*, p.nombre AS producto_nombre, p.descripcion AS producto_descripcion
            FROM reposiciones r
            JOIN productos p ON r.id_producto = p.id
            ORDER BY r.fecha DESC"
    );
    return $stmt->fetchAll();
  }

  public function findById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM reposiciones WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($data)
  {
    $stmt = $this->db->prepare("INSERT INTO reposiciones (id_producto, origen, destino, cantidad, fecha) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
      $data['id_producto'],
      $data['origen'],
      $data['destino'],
      $data['cantidad'],
      $data['fecha']
    ]);
  }

  public function update($id, $data)
  {
    $stmt = $this->db->prepare("UPDATE reposiciones SET id_producto = ?, origen = ?, destino = ?, cantidad = ?, fecha = ? WHERE id = ?");
    return $stmt->execute([
      $data['id_producto'],
      $data['origen'],
      $data['destino'],
      $data['cantidad'],
      $data['fecha'],
      $id
    ]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM reposiciones WHERE id = ?");
    return $stmt->execute([$id]);
  }
}
