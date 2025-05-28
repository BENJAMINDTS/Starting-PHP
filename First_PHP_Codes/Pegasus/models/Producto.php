<?php

require_once __DIR__ . '/../config/database.php';

class Producto
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM productos");
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($codigo, $descripcion)
  {
    $stmt = $this->db->prepare("INSERT INTO productos (codigo, descripcion) VALUES (?, ?)");
    return $stmt->execute([$codigo, $descripcion]);
  }

  public function update($id, $codigo, $descripcion)
  {
    $stmt = $this->db->prepare("UPDATE productos SET codigo = ?, descripcion = ? WHERE id = ?");
    return $stmt->execute([$codigo, $descripcion, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function getByCodigo($codigo)
  {
    $stmt = $this->db->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->execute([$codigo]);
    return $stmt->fetch();
  }

  //Contar el número de productos
  public function countAll()
  {
    $stmt = $this->db->query("SELECT COUNT(*) as total FROM productos");
    return $stmt->fetchColumn();
  }
}
