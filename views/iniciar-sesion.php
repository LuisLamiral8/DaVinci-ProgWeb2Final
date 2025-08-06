<?php
session_start();
$login_error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<link rel="stylesheet" href="styles/global.css">
<link rel="stylesheet" href="styles/home.css">
<div class="container my-5">
	<?php if ($login_error): ?>
		<div class="alert alert-danger"> <?= htmlspecialchars($login_error) ?> </div>
	<?php endif; ?>
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card custom_border p-4 shadow-sm">
				<h1 class="mb-4 text-center section-title section-title_novedades" style="color: #fff;">Iniciar Sesión</h1>
				<form method="POST" action="actions/login.php">
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" class="form-control" id="email" name="email" required autofocus>
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Contraseña</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Ingresar</button>
				</form>
				<div class="mt-3 text-center">
					<span>¿No tienes cuenta?</span>
					<a href="index.php?page=register">Regístrate</a>
				</div>
			</div>
		</div>
	</div>
</div>