<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/config.php';

class Usuario
{
    private $pdo;

    public $id;
    public $nombre;
    public $email;
    protected $password; // Hasheada, ahora protegida
    public $rol;

    const ROLES = [
        'Administrador',
        'Gestor_General',
        'Gestor_de_Hospital',
        'Gestor_de_Planta',
        'Usuario_de_Botiquín'
    ];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Setter para la password que hace el hash internamente
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Getter para el hash de la password (opcional)
    public function getPasswordHash(): string
    {
        return $this->password;
    }

    public function create()
    {
        $sql = "INSERT INTO usuarios (nombre, email, password, rol)
                VALUES (:nombre, :email, :password, :rol)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':password' => $this->password,
            ':rol' => $this->rol
        ]);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->fillProperties($user);
            return $this;
        }
        return null;
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->fillProperties($user);
            return $this;
        }
        return null;
    }

    public function update()
    {
        $sql = "UPDATE usuarios SET
                    nombre = :nombre,
                    email = :email,
                    rol = :rol
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':rol' => $this->rol,
            ':id' => $this->id
        ]);
    }

    public function updatePassword($newPassword)
    {
        $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $this->id
        ]);
    }

    public function delete()
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $this->id]);
    }

    // Aquí está la corrección principal:
    public function verifyPassword($password)
    {
        // Usa el hash ya cargado en $this->password, no hace falta consultar otra vez
        return password_verify($password, $this->password);
    }

    private function fillProperties($data)
    {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->rol = $data['rol'];
    }

    // Validar el rol del usuario
    public static function isValidRole($role)
    {
        return in_array($role, self::ROLES, true);
    }

    // Obtener todos los usuarios
    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM usuarios";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchColumn();
    }

    // Obtener hospitales asociados a este usuario
    public function getHospitales()
    {
        $sql = "SELECT h.* FROM hospitales h
                INNER JOIN hospital_usuario hu ON h.id = hu.id_hospital
                WHERE hu.id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_usuario' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener plantas asociadas a este usuario
    public function getPlantas()
    {
        $sql = "SELECT p.* FROM plantas p
                INNER JOIN planta_usuario pu ON p.id = pu.id_planta
                WHERE pu.id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_usuario' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener almacenes asociados a este usuario
    public function getAlmacenes()
    {
        $sql = "SELECT a.* FROM almacenes a
                INNER JOIN almacen_usuario au ON a.id = au.id_almacen
                WHERE au.id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_usuario' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener botiquines asociados a este usuario
    public function getBotiquines()
    {
        $sql = "SELECT b.* FROM botiquines b
                INNER JOIN botiquin_usuario bu ON b.id = bu.id_botiquin
                WHERE bu.id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_usuario' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Métodos para asignar asociaciones

    public function addHospital($idHospital)
    {
        $sql = "INSERT INTO hospital_usuario (id_usuario, id_hospital) VALUES (:id_usuario, :id_hospital)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_hospital' => $idHospital]);
    }

    public function removeHospital($idHospital)
    {
        $sql = "DELETE FROM hospital_usuario WHERE id_usuario = :id_usuario AND id_hospital = :id_hospital";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_hospital' => $idHospital]);
    }

    public function addPlanta($idPlanta)
    {
        $sql = "INSERT INTO planta_usuario (id_usuario, id_planta) VALUES (:id_usuario, :id_planta)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_planta' => $idPlanta]);
    }

    public function removePlanta($idPlanta)
    {
        $sql = "DELETE FROM planta_usuario WHERE id_usuario = :id_usuario AND id_planta = :id_planta";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_planta' => $idPlanta]);
    }

    public function addAlmacen($idAlmacen)
    {
        $sql = "INSERT INTO almacen_usuario (id_usuario, id_almacen) VALUES (:id_usuario, :id_almacen)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_almacen' => $idAlmacen]);
    }

    public function removeAlmacen($idAlmacen)
    {
        $sql = "DELETE FROM almacen_usuario WHERE id_usuario = :id_usuario AND id_almacen = :id_almacen";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_almacen' => $idAlmacen]);
    }

    public function addBotiquin($idBotiquin)
    {
        $sql = "INSERT INTO botiquin_usuario (id_usuario, id_botiquin) VALUES (:id_usuario, :id_botiquin)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_botiquin' => $idBotiquin]);
    }

    public function removeBotiquin($idBotiquin)
    {
        $sql = "DELETE FROM botiquin_usuario WHERE id_usuario = :id_usuario AND id_botiquin = :id_botiquin";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id, ':id_botiquin' => $idBotiquin]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM usuarios ORDER BY nombre";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function removeAllHospitales()
    {
        $sql = "DELETE FROM hospital_usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id]);
    }

    public function removeAllPlantas()
    {
        $sql = "DELETE FROM planta_usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id]);
    }

    public function removeAllBotiquines()
    {
        $sql = "DELETE FROM botiquin_usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id]);
    }

    public function removeAllAlmacenes()
    {
        $sql = "DELETE FROM almacen_usuario WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id_usuario' => $this->id]);
    }
}
