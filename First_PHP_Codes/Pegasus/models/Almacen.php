<?php

require_once __DIR__ . '/../config/database.php';

class Almacen
{
  private $db;
  private $tiposValidos = ['General', 'Almacenillo'];

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM almacenes");
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM almacenes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }

  public function create($id_planta, $tipo)
  {
    if (!$this->isTipoValido($tipo)) {
      throw new InvalidArgumentException("Tipo de almacén inválido.");
    }

    $stmt = $this->db->prepare("INSERT INTO almacenes (id_planta, tipo) VALUES (?, ?)");
    return $stmt->execute([$id_planta, $tipo]);
  }

  public function update($id, $id_planta, $tipo)
  {
    if (!$this->isTipoValido($tipo)) {
      throw new InvalidArgumentException("Tipo de almacén inválido.");
    }

    $stmt = $this->db->prepare("UPDATE almacenes SET id_planta = ?, tipo = ? WHERE id = ?");
    return $stmt->execute([$id_planta, $tipo, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM almacenes WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function getByPlanta($id_planta)
  {
    $stmt = $this->db->prepare("SELECT * FROM almacenes WHERE id_planta = ?");
    $stmt->execute([$id_planta]);
    return $stmt->fetchAll();
  }

  private function isTipoValido($tipo)
  {
    return in_array($tipo, $this->tiposValidos);
  }
}
