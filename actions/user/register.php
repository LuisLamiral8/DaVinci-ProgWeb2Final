<?php
require_once __DIR__ . '/../../class/mysqli.php';
require_once __DIR__ . '/../../class/Usuario.php';
session_start();

function devolverDatosRegistro($nombre, $apellido, $dni, $email) {
    $_SESSION['save_nombre'] = $nombre;
    $_SESSION['save_apellido'] = $apellido;
    $_SESSION['save_dni'] = $dni;
    $_SESSION['save_email'] = $email;
}

function validarCampos($nombre, $apellido, $dni, $email, $password, $password2) {
	$errores = [];
	if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
	if ($apellido === '') $errores[] = 'El apellido es obligatorio.';
	if ($dni === '' || !preg_match('/^\d{7,8}$/', $dni)) $errores[] = 'El DNI es obligatorio y debe tener 7 u 8 dígitos.';
	if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'El email es obligatorio y debe ser válido.';
	if ($password === '') $errores[] = 'La contraseña es obligatoria.';
	if ($password !== $password2) $errores[] = 'Las contraseñas no coinciden.';
	return $errores;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: ../../index.php?page=home');
	exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$dni = trim($_POST['dni'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

$errores = validarCampos($nombre, $apellido, $dni, $email, $password, $password2);
if (!empty($errores)) {
	$_SESSION['register_error'] = implode('<br>', $errores);
	devolverDatosRegistro($nombre, $apellido, $dni, $email);
	header('Location: ../../index.php?page=registrarse');
	exit;
}


try {
	$nuevoUsuario = new Usuario($nombre, $apellido, $dni, $email, $password, Usuario::ROL_USUARIO);
	$ddbb = new MySQLDB();
	$conexion = $ddbb->getConnection();
	$resultado = $nuevoUsuario->save($conexion);
	if ($resultado === true) {
		$_SESSION['register_success'] = '¡Registro exitoso! Ya puedes iniciar sesión.';
		header('Location: ../../index.php?page=registrarse');
		exit;
	} elseif ($resultado === 'duplicate') {
		$_SESSION['register_error'] = 'El email o DNI ya están registrados.';
		devolverDatosRegistro($nombre, $apellido, $dni, $email);
		header('Location: ../../index.php?page=registrarse');
		exit;
	} else {
		$_SESSION['register_error'] = 'Error al registrar. Intenta nuevamente.';
		header('Location: ../../index.php?page=registrarse');
		exit;
	}
} catch (Exception $e) {
	$_SESSION['register_error'] = 'Error de conexión: ' . $e->getMessage();
	header('Location: ../../index.php?page=registrarse');
	exit;
}
