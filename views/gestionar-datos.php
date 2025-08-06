<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
require_once __DIR__ . '/../class/mysqli.php';
require_once __DIR__ . '/../class/Usuario.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== Usuario::ROL_ADMIN) {
	header('Location: index.php?page=home');
	exit;
}
$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();
$usuarios = Usuario::getAll($conexion);
?>
<link rel="stylesheet" href="styles/global.css">
<link rel="stylesheet" href="styles/home.css">
<style>
	.botonHacerAdmin:hover {
		background-color: rgb(180, 140, 17) !important;
		color: white;
	}
</style>
<?php if (!empty($_SESSION['admin_msg'])): ?>
	<div class="container my-4">
		<div class="alert alert-info alert-dismissible fade show" role="alert">
			<?= htmlspecialchars($_SESSION['admin_msg']) ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<?php unset($_SESSION['admin_msg']); ?>
	</div>
<?php endif; ?>
<div class="container my-5">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card custom_border p-4 shadow-sm">
				<h1 class="mb-4 text-center section-title section-title_ofertas" style="color: #fff;">Gestionar Usuarios</h1>
				<table class="table table-striped table-hover align-middle">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Email</th>
							<th>Rol</th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($usuarios as $usuario): ?>
							<tr>
								<td><?= htmlspecialchars($usuario['id']) ?></td>
								<td><?= htmlspecialchars($usuario['nombre']) ?></td>
								<td><?= htmlspecialchars($usuario['apellido']) ?></td>
								<td><?= htmlspecialchars($usuario['email']) ?></td>
								<td>
									<?php if ($usuario['rol'] === Usuario::ROL_ADMIN): ?>
										<span class="badge bg-danger">ADMINISTRADOR</span>
									<?php else: ?>
										<span class="badge bg-primary">USUARIO</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<?php if ($usuario['rol'] === Usuario::ROL_ADMIN): ?>
										<form method="POST" action="actions/admin/makeUser.php" style="display:inline;">
											<input type="hidden" name="id" value="<?= $usuario['id'] ?>">
											<button type="submit" class="btn btn-sm btn-secondary">Hacer usuario</button>
										</form>
									<?php else: ?>
										<form method="POST" action="actions/admin/makeAdmin.php" style="display:inline;">
											<input type="hidden" name="id" value="<?= $usuario['id'] ?>">
											<button type="submit" class="btn btn-sm btn-warning botonHacerAdmin">Hacer administrador</button>
										</form>
									<?php endif; ?>
									<form method="POST" action="actions/admin/deleteUser.php" style="display:inline;">
										<input type="hidden" name="id" value="<?= $usuario['id'] ?>">
										<button type="submit" class="btn btn-sm btn-danger">Borrar</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<!-- Sección de administración de novedades -->
			<div class="card custom_border p-4 shadow-sm mt-5">
				<h2 class="mb-4 text-center section-title section-title_novedades" style="color: #fff;">Gestionar Novedades</h2>
				<?php
				require_once __DIR__ . '/../class/Novedad.php';
				$novedades = Novedad::getAll($conexion);
				?>
				<table class="table table-striped table-hover align-middle">
					<thead>
						<tr>
							<th>ID</th>
							<th>Orden</th>
							<th>Descripción</th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($novedades as $novedad): ?>
							<tr>
								<td><?= htmlspecialchars($novedad->id) ?></td>
								<td><?= htmlspecialchars($novedad->orden) ?></td>
								<td><?= htmlspecialchars($novedad->descripcion) ?></td>
								<td class="text-center">
									<a href="index.php?page=gestionar-novedad&id=<?= $novedad->id ?>" class="btn btn-sm btn-primary">Editar</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>