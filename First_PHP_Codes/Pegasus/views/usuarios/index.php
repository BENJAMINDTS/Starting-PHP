<?php
require_once __DIR__ . '/../../config/config.php';

?>
<h1>Listado de Usuarios</h1>

<a href="<?= BASE_URL ?>usuarios/create">Crear nuevo usuario</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Hospitales</th>
            <th>Plantas</th>
            <th>Botiquines</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= htmlspecialchars($usuario['rol']) ?></td>
            <td>
                <?php
                if (!empty($usuario['hospitales'])) {
                    // Mostrar nombres separados por coma
                    echo htmlspecialchars(implode(', ', array_column($usuario['hospitales'], 'nombre')));
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
            <td>
                <?php
                if (!empty($usuario['plantas'])) {
                    echo htmlspecialchars(implode(', ', array_column($usuario['plantas'], 'nombre')));
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
            <td>
                <?php
                if (!empty($usuario['botiquines'])) {
                    echo htmlspecialchars(implode(', ', array_column($usuario['botiquines'], 'nombre')));
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
            <td>
                <a href="<?= BASE_URL ?>usuarios/edit/<?= $usuario['id'] ?>">Editar</a> |
                <a href="<?= BASE_URL ?>usuarios/delete/<?= $usuario['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a> |
                <a href="<?= BASE_URL ?>usuarios/perfil/<?= $usuario['id'] ?>">Perfil</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
