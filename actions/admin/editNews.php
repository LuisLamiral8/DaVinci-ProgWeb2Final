<?php
require_once __DIR__ . '/../../class/mysqli.php';
require_once __DIR__ . '/../../class/Novedad.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'ADMINISTRADOR') {
    header('Location: ../../index.php?page=home');
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$descripcion = trim($_POST['descripcion'] ?? '');
$orden = isset($_POST['orden']) ? intval($_POST['orden']) : 1;

$errores = [];
if ($id <= 0) $errores[] = 'ID inválido.';
if ($descripcion === '') $errores[] = 'La descripción es obligatoria.';
if ($orden < 1) $errores[] = 'El orden debe ser mayor o igual a 1.';

if (!empty($errores)) {
    $_SESSION['novedad_error'] = implode('<br>', $errores);
    header('Location: ../../index.php?page=gestionar-novedad&id=' . $id);
    exit;
}

$ddbb = new MySQLDB();
$conexion = $ddbb->getConnection();
$resultado = Novedad::updateById($conexion, $id, $descripcion, $orden);

if ($resultado) {
    $_SESSION['admin_msg'] = 'Novedad actualizada correctamente.';
    header('Location: ../../index.php?page=gestionar-datos');
    exit;
} else {
    $_SESSION['admin_msg'] = 'Error al actualizar la novedad.';
    header('Location: ../../index.php?page=gestionar-novedad&id=' . $id);
    exit;
}
