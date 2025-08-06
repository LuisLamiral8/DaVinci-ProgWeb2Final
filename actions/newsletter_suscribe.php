<?php
session_start();
require_once __DIR__ . '/../class/mysqli.php';
require_once __DIR__ . '/../class/Newsletter.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: ../index.php?page=home');
	exit;
}

$_SESSION['newsletter_status'] = '';
$_SESSION['newsletter_errors'] = [];
$_SESSION['newsletter_type'] = 'info';
$email = trim($_POST['email'] ?? '');
if ($email === '') {
	$_SESSION['newsletter_errors'][] = 'El correo electrónico es obligatorio.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$_SESSION['newsletter_errors'][] = 'El correo electrónico no es válido.';
}

if (!empty($_SESSION['newsletter_errors'])) {
	$_SESSION['newsletter_status'] = "Ocurrió un error al suscribirse:";
	header('Location: ../index.php?page=home');
	exit;
}
try {
	$emailAGuardar = new Newsletter($email);
	$ddbb = new MySQLDB();
	$conexion = $ddbb->getConnection();

	$resultado = $emailAGuardar->save($conexion);
	if ($resultado === true) {
		$_SESSION['newsletter_status'] = "¡Te suscribiste correctamente!";
		$_SESSION['newsletter_type'] = 'success';
	} elseif ($resultado === 'duplicate') {
		$_SESSION['newsletter_status'] = "Este email ya está suscripto.";
		$_SESSION['newsletter_type'] = 'info';
	} else {
		$_SESSION['newsletter_status'] = "Error al suscribirse. Intenta nuevamente.";
		$_SESSION['newsletter_type'] = 'danger';
	}
	$conexion->close();
} catch (Exception $e) {
	$_SESSION['newsletter_status'] = "No se pudo conectar a la base de datos. Intente más tarde.";
	$_SESSION['newsletter_type'] = 'danger';
}
header('Location: ../index.php?page=registrarse');
exit;
