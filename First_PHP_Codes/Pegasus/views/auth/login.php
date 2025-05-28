<?php
require_once __DIR__ . '/../../config/config.php';
?>

<!DOCTYPE html>
<html lang="es">

<body>
    <div class="login-container">
        <h1>Iniciar sesión</h1>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error-message" style="color: red; margin-bottom: 1em;">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>login">
            <div class="form-group">
                <label for="email">Email:</label><br />
                <input type="email" id="email" name="email" required autofocus />
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label><br />
                <input type="password" id="password" name="password" required />
            </div>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>

</html>