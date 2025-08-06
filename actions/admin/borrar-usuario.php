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
	$_SESSION['admin_msg'] = 'No puedes borrar tu propio usuario.';
	header('Location: ../../index.php?page=gestionar-usuarios');
	exit;
}

$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();
$resultado = Usuario::deleteById($conexion, $id);

if ($resultado === true) {
	$_SESSION['admin_msg'] = 'Usuario borrado correctamente.';
} else {
	$_SESSION['admin_msg'] = 'No se pudo borrar el usuario.';
}

header('Location: ../../index.php?page=gestionar-usuarios');
exit;
