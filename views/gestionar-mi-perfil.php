<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
require_once __DIR__ . '/../class/mysqli.php';
require_once __DIR__ . '/../class/Usuario.php';
if (!isset($_SESSION['id'])) {
	header('Location: index.php?page=home');
	exit;
}
$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();
$id = intval($_SESSION['id']);
$usuario = Usuario::getById($conexion, $id);
$nombre = $usuario['nombre'];
$apellido = $usuario['apellido'];
$dni = $usuario['dni'];
$email = $usuario['email'];
?>
<link rel="stylesheet" href="styles/global.css">
<link rel="stylesheet" href="styles/home.css">
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card custom_border p-4 shadow-sm">
        <h1 class="mb-4 text-center section-title section-title_novedades" style="color: #fff;">Editar mi perfil</h1>
        <?php if (!empty($_SESSION['perfil_error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['perfil_error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['perfil_error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['perfil_success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['perfil_success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['perfil_success']); ?>
        <?php endif; ?>
        <form method="POST" action="actions/user/edit.php">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
          </div>
          <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" required>
          </div>
          <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="<?= htmlspecialchars($dni) ?>" required pattern="\d{7,8}">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Dejar vacío para no cambiar">
          </div>
          <div class="mb-3">
            <label for="password2" class="form-label">Repetir nueva contraseña</label>
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Dejar vacío para no cambiar">
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <a href="index.php?page=dashboard" class="btn btn-secondary">Volver</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
