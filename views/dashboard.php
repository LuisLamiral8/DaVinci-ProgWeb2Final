<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$nombre = $_SESSION['nombre'] ?? 'Usuario';
$rol = $_SESSION['rol'] ?? 'usuario';
$fecha = date('d/m/Y H:i');
?>
<link rel="stylesheet" href="styles/global.css">
<link rel="stylesheet" href="styles/home.css">
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card custom_border p-4 shadow-sm">
        <h1 class="mb-4 text-center section-title section-title_novedades" style="color: #fff;">Dashboard</h1>
        <div class="mb-4 text-center">
          <h2>¡Bienvenido/a, <?= htmlspecialchars($nombre) ?>!</h2>
          <p class="lead mb-1">Rol: <strong><?= htmlspecialchars($rol) ?></strong></p>
          <p class="mb-3">Fecha y hora actual: <?= $fecha ?></p>
          <p>Gracias por ser parte de Manga Land. ¡Explora y disfruta de tus mangas favoritos!</p>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="p-3 bg-light rounded shadow-sm h-100">
              <h5 class="mb-2">Últimas novedades</h5>
              <ul class="mb-0">
                <li>¡Nuevo manga agregado a la tienda!</li>
                <li>Promociones activas este mes.</li>
                <li>Revisa tus compras recientes.</li>
              </ul>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 bg-light rounded shadow-sm h-100">
              <h5 class="mb-2">Accesos rápidos</h5>
              <ul class="mb-0">
                <li><a href="index.php?page=home">Ir a la tienda</a></li>
                <li><a href="index.php?page=contact">Contacto</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>