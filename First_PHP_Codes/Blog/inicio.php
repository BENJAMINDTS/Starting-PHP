<?php
session_start();
$logueado = isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
$rol = $_SESSION['rol'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Blog Personal</title>
  <link rel="stylesheet" href="CSS/inicio.css">
</head>

<body>

  <header>
    <h1>Bienvenido a Mi Blog</h1>
    <p>Reflexiones, ideas y más</p>
  </header>

  <nav>
    <div class="nav-links">
      <a href="inicio.php">Inicio</a>
      <a href="AboutMe.html">Sobre mí</a>
      <a href="#">Contacto</a>
      <?php if ($logueado && $rol === 'administrador'): ?>
        <a href="administrador/list.php">Administrar</a>
      <?php endif; ?>
      <?php if ($logueado && $rol === 'editor'): ?>
        <a href="editor/crear_entrada.php">Modo editor</a>
      <?php endif; ?>
    </div>
    <div class="auth-links">
      <?php if (!$logueado): ?>
        <a href="Registro.html">Registrarse</a>
        <a href="Login.html">Iniciar sesión</a>
      <?php else: ?>
        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="php/logout.php">Cerrar sesión</a>
      <?php endif; ?>
    </div>
  </nav>

  <div class="anuncio" id="miAnuncio" style="display: none;">
    <button class="cerrar-btn" onclick="cerrarAnuncio()">×</button>
    <h3>¡Mira mis proyectos!</h3>
    <p>Visita mi GitHub para ver en qué estoy trabajando.</p>
    <a href="https://github.com/BENJAMINDTS" target="_blank">Ir a GitHub</a>
  </div>

  <div class="container">
    <?php
    $directorio = __DIR__ . "/Entradas/";
    $archivos = glob("{$directorio}*.html");

    foreach ($archivos as $archivo) {
      $contenido = file_get_contents($archivo);

      preg_match("/<h1>(.*?)<\\/h1>/", $contenido, $tituloMatch);
      $titulo = $tituloMatch[1] ?? "Sin título";

      preg_match("/<p><em>(.*?)<\\/em><\\/p>/", $contenido, $fechaMatch);
      $fecha = $fechaMatch[0] ?? "<p><em>Fecha desconocida</em></p>";

      preg_match('/<img\\s+src=["\'](.*?)["\']/', $contenido, $imagenMatch);
      $imagen = $imagenMatch[1] ?? "img/default.jpg";
      if (str_starts_with($imagen, '../')) {
        $imagen = substr($imagen, 3);
      }



      preg_match('/<!-- RESUMEN:\s*(.*?)\s*-->/', $contenido, $resumenMatch);
      $resumen = $resumenMatch[1] ?? "";





      $nombreArchivo = basename($archivo);

      echo "
        <a class='post' data-url='Entradas/$nombreArchivo'>
            <img src='$imagen' alt='Imagen de la entrada'>
            <div class='post-content'>
                <h2>$titulo</h2>
                $fecha
                <p>$resumen</p>
            </div>
        </a>";
    }
    ?>
  </div>

  <footer>
    <p>&copy; 2025 Mi Blog Personal. Todos los derechos reservados.</p>
  </footer>

  <script>
    const logueado = <?php echo json_encode($logueado); ?>;

    document.querySelectorAll('.post').forEach(post => {
      post.addEventListener('click', function(e) {
        if (!logueado) {
          e.preventDefault();
          alert("Debes iniciar sesión para acceder a esta entrada.");
        } else {
          const destino = this.getAttribute('data-url');
          window.location.href = destino;
        }
      });
    });

    function cerrarAnuncio() {
      document.getElementById("miAnuncio").style.display = "none";
      sessionStorage.setItem("anuncioCerrado", "true");
    }

    window.onload = function() {
      if (!sessionStorage.getItem("anuncioCerrado")) {
        const anuncio = document.getElementById("miAnuncio");
        anuncio.style.display = "block";

        setTimeout(() => {
          cerrarAnuncio();
        }, 10000);
      }
    };
  </script>

</body>

</html>