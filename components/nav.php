<?php
require_once __DIR__ . '/../class/Usuario.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<nav class="navbar navbar-expand-lg">
	<div class="container-fluid">
		<div class="d-flex align-items-center">
			<img
				src="images/mangaland.svg"
				alt="Logo Manga Land"
				class="img-fluid"
				style="max-width: 125px"
				draggable="false" />
		</div>

		<button
			class="navbar-toggler"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbarText"
			aria-controls="navbarText"
			aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a
						class="nav-link active"
						aria-current="page"
						href="index.php?page=home">
						<img
							src="images/icons/icon_books.svg"
							alt="Manga"
							width="25px"
							height="25px"
							style="margin-right: 8px" />
						Inicio
					</a>
				</li>
				<li>
					<a class="nav-link" href="index.php?page=aboutus">
						<img src="images/icons/icon_contact.svg" alt="Sobre Nosotros" width="25px" height="25px" style="margin-right: 8px">
						Sobre Nosotros
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="index.php?page=contact">
						<img
							src="images/icons/icon_faqs.svg"
							alt="Contacto"
							width="25px"
							height="25px"
							style="margin-right: 8px" />
						Contacto
					</a>
				</li>
			</ul>
			<div class="d-flex ms-auto">

				<?php if (isset($_SESSION['nombre'])): ?>
					<span class="nav-link me-2">
						👤 <?= htmlspecialchars($_SESSION['nombre']) ?>
						<?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === Usuario::ROL_ADMIN): ?>
							<span class="badge bg-danger ms-2">ADMINISTRADOR</span>
						<?php endif; ?>
					</span>
					<a href="index.php?page=dashboard" class="nav-link me-2">Dashboard</a>
					<?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === Usuario::ROL_ADMIN): ?>
						<a href="index.php?page=gestionar-usuarios" class="nav-link text-warning me-2">Gestionar Usuarios</a>
					<?php endif; ?>
					<a href="actions/user/logout.php" class="nav-link text-danger">Cerrar sesión</a>
				<?php else: ?>
					<a href="index.php?page=iniciar-sesion" class="nav-link me-2">Iniciar Sesión</a>
					<a href="index.php?page=registrarse" class="nav-link ">Registrarse</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	</div>
</nav>