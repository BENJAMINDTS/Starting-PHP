<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Crear Usuario</h1>

<?php if (isset($error)): ?>
  <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="<?= BASE_URL ?>usuarios/create" method="POST">
  <div class="form-group">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" required>
  </div>
  <br>

  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
  </div>
  <br>

  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
  </div>
  <br>

  <div class="form-group">
    <label for="rol">Rol:</label>
    <select name="rol" id="rol" required>
      <option value="">-- Seleccione un rol --</option>
      <option value="Administrador">Administrador</option>
      <option value="Gestor_General">Gestor General</option>
      <option value="Gestor_de_Hospital">Gestor de Hospital</option>
      <option value="Gestor_de_Planta">Gestor de Planta</option>
      <option value="Usuario_de_Botiquín">Usuario de Botiquín</option>
    </select>
  </div>
  <br>

  <div class="form-group" id="grupo-hospital" style="display:none;">
    <label for="id_hospital">Hospitales:</label>
    <select name="id_hospital[]" id="id_hospital" multiple size="5">
      <?php foreach ($hospitales as $hospital): ?>
        <option value="<?= $hospital['id'] ?>"><?= htmlspecialchars($hospital['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <br>

  <div class="form-group" id="grupo-planta" style="display:none;">
    <label for="id_planta">Plantas:</label>
    <select name="id_planta[]" id="id_planta" multiple size="5">
      <?php foreach ($plantas as $planta): ?>
        <option value="<?= $planta['id'] ?>"><?= htmlspecialchars($planta['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <br>

  <div class="form-group" id="grupo-botiquin" style="display:none;">
    <label for="id_botiquin">Botiquines:</label>
    <select name="id_botiquin[]" id="id_botiquin" multiple size="5">
      <?php foreach ($botiquines as $botiquin): ?>
        <option value="<?= $botiquin['id'] ?>"><?= htmlspecialchars($botiquin['nombre']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <br>

  <button type="submit">Guardar</button>
  <a href="<?= BASE_URL ?>usuarios">Cancelar</a>
</form>

<script>
  const rolSelect = document.getElementById('rol');
  const grupoHospital = document.getElementById('grupo-hospital');
  const grupoPlanta = document.getElementById('grupo-planta');
  const grupoBotiquin = document.getElementById('grupo-botiquin');

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
