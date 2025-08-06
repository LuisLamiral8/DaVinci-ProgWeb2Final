<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$errores = $_SESSION['save_errors'] ?? [];
$save_status = $_SESSION['save_status'] ?? '';
$save_type = $_SESSION['save_type'] ?? 'info';
$motivo = $_SESSION['save_motivo'] ?? '';
$nombre = $_SESSION['save_nombre'] ?? '';
$email = $_SESSION['save_email'] ?? '';
$telefono = $_SESSION['save_telefono'] ?? '';
$comentario = $_SESSION['save_comentario'] ?? '';

unset(
	$_SESSION['save_errors'],
	$_SESSION['save_status'],
	$_SESSION['save_motivo'],
	$_SESSION['save_nombre'],
	$_SESSION['save_email'],
	$_SESSION['save_telefono'],
	$_SESSION['save_comentario']
);

?>
<div class="container my-5">
	<?php if (!empty($errores)): ?>
		<div class='alert alert-danger'>
			<ul class="mb-0">
				<?php foreach ($errores as $error): ?>
					<li><?= htmlspecialchars($error) ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php elseif ($save_status): ?>
		<div class='alert alert-<?= htmlspecialchars($save_type) ?>'><?= htmlspecialchars($save_status) ?></div>
	<?php endif; ?>

	<h1 class="mb-4">Contacto</h1>
	<form class="row g-3" method="POST" action="actions/contact_save.php">
		<div class="col-md-6">
			<label for="motivo" class="form-label">Motivo *</label>
			<select id="motivo" class="form-select" name="motivo" required="">
				<option value="" <?= $motivo === '' ? 'selected' : '' ?> disabled>Seleccione un motivo</option>
				<option <?= $motivo === 'Consultar sobre algún producto de la tienda' ? 'selected' : '' ?>>Consultar sobre algún producto de la tienda</option>
				<option <?= $motivo === 'Consulta sobre un pedido realizado' ? 'selected' : '' ?>>Consulta sobre un pedido realizado</option>
				<option <?= $motivo === 'Problema con un producto recibido' ? 'selected' : '' ?>>Problema con un producto recibido</option>
				<option <?= $motivo === 'Consulta sobre envíos y entregas' ? 'selected' : '' ?>>Consulta sobre envíos y entregas</option>
				<option <?= $motivo === 'Consulta sobre métodos de pago' ? 'selected' : '' ?>>Consulta sobre métodos de pago</option>
				<option <?= $motivo === 'Sugerencias o comentarios' ? 'selected' : '' ?>>Sugerencias o comentarios</option>
				<option <?= $motivo === 'Otro' ? 'selected' : '' ?>>Otro</option>
			</select>
		</div>
		<div class="col-md-6">
			<label for="nombre" class="form-label">Nombre *</label>
			<input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label for="email" class="form-label">Correo electrónico *</label>
			<input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label for="telefono" class="form-label">Número de teléfono *</label>
			<input type="tel" class="form-control" id="telefono" name="telefono" required value="<?= htmlspecialchars($telefono ?? '') ?>">
		</div>
		<div class="col-12">
			<label for="comentario" class="form-label">Escriba aquí su comentario o consulta *</label>
			<textarea class="form-control" id="comentario" name="comentario" rows="3" required><?= htmlspecialchars($comentario ?? '') ?></textarea>
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" id="robot" required>
				<label class="form-check-label" for="robot">
					I'm not a robot *
				</label>
			</div>
		</div>
		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" id="politica" required>
				<label class="form-check-label" for="politica">
					He leído y acepto la Política de Privacidad *
				</label>
			</div>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-dark">Enviar</button>
		</div>
	</form>
	<div class="row mt-5">
		<div class="col-md-6">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3332.2403195934126!2d-68.3313042242727!3d-34.61434916923415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x967999b3b13c6887%3A0x9f5355e85b3f1595!2sMangaland!5e0!3m2!1ses!2sar!4v1689281973787!5m2!1ses!2sar" width="100%" height="300" style="border: 0" allowfullscreen="" loading="lazy">
			</iframe>
		</div>
		<div class="col-md-6">
			<h5>Teléfono de contacto</h5>
			<p>0261 666-608</p>
			<p>Atención de Lunes a Viernes de 9 a 14hs y de 17:30 a 20hs</p>
			<h5>E-mail</h5>
			<p>info@mangaland.com</p>
			<a href="mailto:info@mangaland.com" class="btn btn-dark" target="_blank">Enviar mail</a>
			<h5 class="mt-3">Chat</h5>
			<p>Asistencia 24/7, chatea con nuestro asistente virtual</p>
			<a href="https://api.whatsapp.com/send?phone=540261666608" class="btn btn-dark" target="_blank">Iniciar chat</a>
		</div>
	</div>
</div>