<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
require_once __DIR__ . '/../class/mysqli.php';
require_once __DIR__ . '/../class/Novedad.php';
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'ADMINISTRADOR') {
	header('Location: index.php?page=home');
	exit;
}
$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$novedad = null;
if ($id > 0) {
	$consulta = $conexion->prepare("SELECT id, descripcion, orden FROM novedades WHERE id = ? LIMIT 1");
	$consulta->bind_param("i", $id);
	$consulta->execute();
	$result = $consulta->get_result();
	$novedad = $result->fetch_assoc();
	$consulta->close();
}
if (!$novedad) {
	echo '<div class="container my-5"><div class="alert alert-danger">Novedad no encontrada.</div></div>';
	exit;
}
?>
<link rel="stylesheet" href="styles/global.css">
<link rel="stylesheet" href="styles/home.css">
<div class="container my-5">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card custom_border p-4 shadow-sm">
				<h1 class="mb-4 text-center section-title section-title_novedades" style="color: #fff;">Editar Novedad</h1>
				<form method="POST" action="actions/admin/editNews.php">
					<input type="hidden" name="id" value="<?= $novedad['id'] ?>">
					<div class="mb-3">
						<label for="descripcion" class="form-label">Descripción</label>
						<input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($novedad['descripcion']) ?>" required>
					</div>
					<div class="mb-3">
						<label for="orden" class="form-label">Orden</label>
						<input type="number" class="form-control" id="orden" name="orden" value="<?= htmlspecialchars($novedad['orden']) ?>" min="1" required>
					</div>
					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-primary">Guardar cambios</button>
						<a href="index.php?page=gestionar-datos" class="btn btn-secondary">Cancelar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>