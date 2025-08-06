<?php
require_once  __DIR__ . "/../class/mysqli.php";
require_once  __DIR__ . "/../class/Contact.php";
session_start();

$motivo = '';
$nombre = '';
$email = '';
$telefono = '';
$comentario = '';
$errores = [];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: ../index.php?page=home');
	exit;
}

$motivo = trim($_POST['motivo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$comentario = trim($_POST['comentario'] ?? '');

if ($motivo === '') $errores[] = 'El motivo es obligatorio.';
if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
if ($email === '') $errores[] = 'El correo electrónico es obligatorio.';
if ($telefono === '') $errores[] = 'El número de teléfono es obligatorio.';
if ($comentario === '') $errores[] = 'El comentario es obligatorio.';

$_SESSION['save_motivo'] = $motivo;
$_SESSION['save_nombre'] = $nombre;
$_SESSION['save_email'] = $email;
$_SESSION['save_telefono'] = $telefono;
$_SESSION['save_comentario'] = $comentario;
$_SESSION['save_errors'] = $errores;

$_SESSION['save_status'] = '';
$_SESSION['save_type'] = 'info';

if (empty($errores)) {
	try {
		$contactoAGuardar = new Contact($motivo, $nombre, $email, $telefono, $comentario);
		$ddbb = new MySQLDB();
		$conexion = $ddbb->getConnection();

		if ($contactoAGuardar->save($conexion)) {
			$_SESSION['save_status'] = "¡Consulta enviada correctamente!";
			$_SESSION['save_type'] = 'success';
		} else {
			$_SESSION['save_status'] = "Error al guardar la consulta.";
			$_SESSION['save_type'] = 'danger';
		}
		$conexion->close();
	} catch (Exception $e) {
		$_SESSION['save_status'] = "No se pudo conectar a la base de datos. Intente más tarde.";
		$_SESSION['save_type'] = 'danger';
	}
}

header("Location: ../index.php?page=contact");
