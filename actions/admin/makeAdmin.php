<?php
require_once __DIR__ . '/../../class/mysqli.php';
require_once __DIR__ . '/../../class/Usuario.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== Usuario::ROL_ADMIN) {
	header('Location: ../../index.php?page=home');
	exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
if ($id <= 0) {
	header('Location: ../../index.php?page=gestionar-usuarios');
	exit;
}

if (isset($_SESSION['id']) && $id === intval($_SESSION['id'])) {
	$_SESSION['admin_msg'] = 'Ya sos administrador.';
	header('Location: ../../index.php?page=gestionar-usuarios');
	exit;
}

$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();
$resultado = Usuario::setRol($conexion, $id, Usuario::ROL_ADMIN);

if ($resultado === true) {
	$_SESSION['admin_msg'] = 'Se ejecutó la operación correctamente.';
} else {
	$_SESSION['admin_msg'] = 'No se pudo cambiar el rol.';
}

header('Location: ../../index.php?page=gestionar-usuarios');
exit;
