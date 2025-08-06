<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
$register_error = $_SESSION['register_error'] ?? '';
$register_success = $_SESSION['register_success'] ?? '';
unset($_SESSION['register_error'], $_SESSION['register_success']);
?>
<link rel="stylesheet" href="styles/global.css">
<link rel="stylesheet" href="styles/home.css">
<div class="container my-5">
	<?php if ($register_error): ?>
		<div class="alert alert-danger"> <?= htmlspecialchars($register_error) ?> </div>
	<?php elseif ($register_success): ?>
		<div class="alert alert-success"> <?= htmlspecialchars($register_success) ?> </div>
	<?php endif; ?>
	<div class="row justify-content-center">
		<div class="col-md-7 col-lg-6">
			<div class="card custom_border p-4 shadow-sm">
				<h1 class="mb-4 text-center section-title section-title_novedades" style="color: #fff;">Registrarse</h1>
				<form method="POST" action="actions/user/register.php">
					<div class="row">
						<div class="mb-3 col-md-6">
							<label for="nombre" class="form-label">Nombre *</label>
							<input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? $_SESSION['save_nombre'] ?? '') ?>">
						</div>
						<div class="mb-3 col-md-6">
							<label for="apellido" class="form-label">Apellido *</label>
							<input type="text" class="form-control" id="apellido" name="apellido" required value="<?= htmlspecialchars($_POST['apellido'] ?? $_SESSION['save_apellido'] ?? '') ?>">
						</div>
					</div>
					<div class="mb-3">
						<label for="dni" class="form-label">DNI *</label>
						<input type="text" class="form-control" id="dni" name="dni" required pattern="\d{8}" maxlength="8" value="<?= htmlspecialchars($_POST['dni'] ?? $_SESSION['save_dni'] ?? '') ?>">
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">Email *</label>
						<input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? $_SESSION['save_email'] ?? '') ?>">
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Contraseña *</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<div class="mb-3">
						<label for="password2" class="form-label">Repetir Contraseña *</label>
						<input type="password" class="form-control" id="password2" name="password2" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Registrarse</button>
				</form>
				<div class="mt-3 text-center">
					<span>¿Ya tienes cuenta?</span>
					<a href="index.php?page=iniciar-sesion">Iniciar sesión</a>
				</div>
			</div>
		</div>
	</div>
</div>