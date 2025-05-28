<?php

require_once __DIR__ . '/../config/database.php';
class Relacion
{
    private $db;

    public function __construct()
    {
        // Asumiendo que tienes una clase Database que devuelve conexión PDO
        $this->db = Database::getInstance();
    }

    /**
     * Obtener todas las relaciones de un usuario,
     * devuelve array con ['entidad_id', 'tipo_entidad']
     */
    public function obtenerRelacionesUsuario(int $usuario_id): array
    {
        $sql = "SELECT entidad_id, tipo_entidad FROM relaciones WHERE usuario_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza las relaciones del usuario eliminando las viejas y agregando las nuevas.
     * $relaciones es un array de arrays con ['entidad_id' => int, 'tipo_entidad' => string]
     */
    public function actualizarRelacionesUsuario(int $usuario_id, array $relaciones): void
    {
        $this->db->beginTransaction();

        try {
            // Eliminar relaciones previas
            $sqlDelete = "DELETE FROM relaciones WHERE usuario_id = ?";
            $stmtDelete = $this->db->prepare($sqlDelete);
            $stmtDelete->execute([$usuario_id]);

            // Insertar nuevas relaciones
            $sqlInsert = "INSERT INTO relaciones (usuario_id, entidad_id, tipo_entidad) VALUES (?, ?, ?)";
            $stmtInsert = $this->db->prepare($sqlInsert);

            foreach ($relaciones as $relacion) {
                $stmtInsert->execute([
                    $usuario_id,
                    $relacion['entidad_id'],
                    $relacion['tipo_entidad']
                ]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e; // O manejar el error según tu lógica
        }
    }
        /**
     * Crear una relación individual
     */
    public function crearRelacion(int $usuario_id, int $entidad_id, string $tipo_entidad): void
    {
        $sql = "INSERT INTO relaciones (usuario_id, entidad_id, tipo_entidad) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id, $entidad_id, $tipo_entidad]);
    }

    /**
     * Eliminar una relación por ID
     */
    public function eliminarRelacion(int $id): void
    {
        $sql = "DELETE FROM relaciones WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    /**
     * Obtener todas las relaciones de un tipo específico (hospital, planta, etc.)
     */
    public function obtenerRelaciones(string $tipo_entidad): array
    {
        $sql = "SELECT r.id, r.usuario_id, u.nombre AS nombre_usuario, r.entidad_id, e.nombre AS nombre_entidad
                FROM relaciones r
                JOIN usuarios u ON r.usuario_id = u.id
                JOIN " . $this->tablaEntidad($tipo_entidad) . " e ON r.entidad_id = e.id
                WHERE r.tipo_entidad = ?
                ORDER BY u.nombre, e.nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tipo_entidad]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mapear tipo_entidad a su tabla correspondiente
     */
    private function tablaEntidad(string $tipo): string
    {
        $mapa = [
            'hospital' => 'hospitales',
            'planta' => 'plantas',
            'almacen' => 'almacenes',
            'botiquin' => 'botiquines'
        ];

        if (!isset($mapa[$tipo])) {
            throw new InvalidArgumentException("Tipo de entidad no válido: $tipo");
        }

        return $mapa[$tipo];
    }
    
}
