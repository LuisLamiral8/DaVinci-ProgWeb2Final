<?php
require_once __DIR__ . '/../../class/mysqli.php';
require_once __DIR__ . '/../../class/Usuario.php';
session_start();

function devolverEmailLogin($email, $mantener, $redirectPage) {
    if ($mantener) {
        $_SESSION['save_email'] = $email;
    } else {
        unset($_SESSION['save_email']);
    }
    header('Location: ../../index.php?page=' . $redirectPage);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: ../../index.php?page=iniciar-sesion');
	exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
	$_SESSION['login_error'] = 'Email y contraseña son obligatorios.';
	devolverEmailLogin($email, true, 'iniciar-sesion');
}

try {
	$ddbb = new MySQLDB();
	$conexion = $ddbb->getConnection();
	$resultado = Usuario::login($email, $password, $conexion);
	if (is_array($resultado)) {
		// Login correcto
		$_SESSION['id'] = $resultado['id'];
		$_SESSION['nombre'] = $resultado['nombre'];
		$_SESSION['email'] = $resultado['email'];
		$_SESSION['rol'] = $resultado['rol'];
		devolverEmailLogin($email, false, 'dashboard');
	} elseif ($resultado === 'wrong_password') {
		$_SESSION['login_error'] = 'Contraseña incorrecta.';
		devolverEmailLogin($email, true, 'iniciar-sesion');
	} else {
		$_SESSION['login_error'] = 'No existe una cuenta con ese email.';
		devolverEmailLogin($email, true, 'iniciar-sesion');
	}
} catch (Exception $e) {
	$_SESSION['login_error'] = 'Error de conexión: ' . $e->getMessage();
	devolverEmailLogin($email, true, 'iniciar-sesion');
}
