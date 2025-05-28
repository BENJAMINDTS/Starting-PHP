<?php

require_once __DIR__ . '/../config/database.php';

class Pacto
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM pactos");
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM pactos WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($id_producto, $id_botiquin, $cantidad_pactada)
  {
    $stmt = $this->db->prepare("INSERT INTO pactos (id_producto, id_botiquin, cantidad_pactada) VALUES (?, ?, ?)");
    return $stmt->execute([$id_producto, $id_botiquin, $cantidad_pactada]);
  }

  public function update($id, $id_producto, $id_botiquin, $cantidad_pactada)
  {
    $stmt = $this->db->prepare("UPDATE pactos SET id_producto = ?, id_botiquin = ?, cantidad_pactada = ? WHERE id = ?");
    return $stmt->execute([$id_producto, $id_botiquin, $cantidad_pactada, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM pactos WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function getByBotiquin($id_botiquin)
  {
    $stmt = $this->db->prepare("SELECT * FROM pactos WHERE id_botiquin = ?");
    $stmt->execute([$id_botiquin]);
    return $stmt->fetchAll();
  }

  public function getByProducto($id_producto)
  {
    $stmt = $this->db->prepare("SELECT * FROM pactos WHERE id_producto = ?");
    $stmt->execute([$id_producto]);
    return $stmt->fetchAll();
  }
}
