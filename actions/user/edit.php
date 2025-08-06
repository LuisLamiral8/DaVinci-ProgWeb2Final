<?php
require_once __DIR__ . '/../../class/mysqli.php';
require_once __DIR__ . '/../../class/Usuario.php';
session_start();

function verificarExistenciaEmailDniNuevo($conexion, $email, $dni, $id) {
    $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE (email = ? OR dni = ?) AND id != ? LIMIT 1");
    $consulta->bind_param("ssi", $email, $dni, $id);
    $consulta->execute();
    $consulta->store_result();
    $existe = $consulta->num_rows > 0;
    $consulta->close();
    return $existe;
}

if (!isset($_SESSION['id'])) {
	header('Location: ../../index.php?page=home');
	exit;
}

$id = intval($_SESSION['id']);
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$dni = trim($_POST['dni'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

$errores = [];
if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
if ($apellido === '') $errores[] = 'El apellido es obligatorio.';
if ($dni === '' || !preg_match('/^\d{7,8}$/', $dni)) $errores[] = 'El DNI es obligatorio y debe tener 7 u 8 dígitos.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'El email es obligatorio y debe ser válido.';
if ($password !== '' && $password !== $password2) $errores[] = 'Las contraseñas no coinciden.';

if (!empty($errores)) {
	$_SESSION['perfil_error'] = implode('<br>', $errores);
	header('Location: ../../index.php?page=gestionar-mi-perfil');
	exit;
}

$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();

if (verificarExistenciaEmailDniNuevo($conexion, $email, $dni, $id)) {
	$_SESSION['perfil_error'] = 'El email o DNI ya están registrados por otro usuario.';
	header('Location: ../../index.php?page=gestionar-mi-perfil');
	exit;
}

$resultado = Usuario::updateById($conexion, $id, $nombre, $apellido, $dni, $email, $password);

if ($resultado) {
	$_SESSION['perfil_success'] = '¡Perfil actualizado correctamente!';
	$_SESSION['nombre'] = $nombre;
	$_SESSION['email'] = $email;
} else {
	$_SESSION['perfil_error'] = 'Error al actualizar el perfil.';
}

header('Location: ../../index.php?page=gestionar-mi-perfil');
exit;
