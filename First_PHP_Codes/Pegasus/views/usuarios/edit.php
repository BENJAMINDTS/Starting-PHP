<?php
require_once __DIR__ . '/../../config/config.php';


echo '<pre>';
print_r($usuario);
print_r($hospitalesAsociados ?? 'hospitalesAsociados no definido');
print_r($plantasAsociadas ?? 'plantasAsociadas no definido');
print_r($botiquinesAsociados ?? 'botiquinesAsociados no definido');
echo '</pre>';

// Extraer IDs de asociaciones para facilitar comparación
$hospitales_ids = [];
if (!empty($hospitalesAsociados)) {
    foreach ($hospitalesAsociados as $h) {
        $hospitales_ids[] = $h['id'];
    }
}
$plantas_ids = [];
if (!empty($plantasAsociadas)) {
    foreach ($plantasAsociadas as $p) {
        $plantas_ids[] = $p['id'];
    }
}
$botiquines_ids = [];
if (!empty($botiquinesAsociados)) {
    foreach ($botiquinesAsociados as $b) {
        $botiquines_ids[] = $b['id'];
    }
}
?>

<h1>Editar Usuario</h1>

<?php if (isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<!-- El método debe ser POST y la acción ir a update -->
<form action="<?= BASE_URL ?>usuarios/update/<?= $usuario->id ?>" method="POST">

    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario->nombre) ?>" required>
        <br><br>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario->email) ?>" required>
        <br><br>
    </div>

    <div>
        <label for="rol">Rol:</label>
        <select name="rol" id="rol" required>
            <option value="">-- Seleccione un rol --</option>
            <option value="Administrador" <?= $usuario->rol === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
            <option value="Gestor_General" <?= $usuario->rol === 'Gestor_General' ? 'selected' : '' ?>>Gestor General</option>
            <option value="Gestor_de_Hospital" <?= $usuario->rol === 'Gestor_de_Hospital' ? 'selected' : '' ?>>Gestor de Hospital</option>
            <option value="Gestor_de_Planta" <?= $usuario->rol === 'Gestor_de_Planta' ? 'selected' : '' ?>>Gestor de Planta</option>
            <option value="Usuario_de_Botiquín" <?= $usuario->rol === 'Usuario_de_Botiquín' ? 'selected' : '' ?>>Usuario de Botiquín</option>
        </select>
        <br><br>
    </div>

    <div id="grupo_hospital" style="display:none;">
        <label for="id_hospital">Hospitales:</label>
        <select name="id_hospital[]" id="id_hospital" multiple size="5">
            <?php foreach ($hospitales as $hospital): ?>
                <option value="<?= $hospital['id'] ?>"
                    <?= in_array($hospital['id'], $hospitales_ids) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($hospital['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
    </div>

    <div id="grupo_planta" style="display:none;">
        <label for="id_planta">Plantas:</label>
        <select name="id_planta[]" id="id_planta" multiple size="5">
            <?php foreach ($plantas as $planta): ?>
                <option value="<?= $planta['id'] ?>"
                    <?= in_array($planta['id'], $plantas_ids) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($planta['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
    </div>

    <div id="grupo_botiquin" style="display:none;">
        <label for="id_botiquin">Botiquines:</label>
        <select name="id_botiquin[]" id="id_botiquin" multiple size="5">
            <?php foreach ($botiquines as $botiquin): ?>
                <option value="<?= $botiquin['id'] ?>"
                    <?= in_array($botiquin['id'], $botiquines_ids) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($botiquin['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
    </div>

    <button type="submit">Actualizar</button>
    <a href="<?= BASE_URL ?>usuarios">Cancelar</a>
</form>

<script>
    const rolSelect = document.getElementById('rol');
    const grupoHospital = document.getElementById('grupo_hospital');
    const grupoPlanta = document.getElementById('grupo_planta');
    const grupoBotiquin = document.getElementById('grupo_botiquin');

    function actualizarVisibilidadCampos() {
        const rol = rolSelect.value;

        grupoHospital.style.display = 'none';
        grupoPlanta.style.display = 'none';
        grupoBotiquin.style.display = 'none';

        if (rol === 'Gestor_de_Hospital') {
            grupoHospital.style.display = '';
        } else if (rol === 'Gestor_de_Planta') {
            grupoHospital.style.display = '';
            grupoPlanta.style.display = '';
        } else if (rol === 'Usuario_de_Botiquín') {
            grupoHospital.style.display = '';
            grupoPlanta.style.display = '';
            grupoBotiquin.style.display = '';
        }
    }

    rolSelect.addEventListener('change', actualizarVisibilidadCampos);
    window.addEventListener('DOMContentLoaded', actualizarVisibilidadCampos);
</script>
