<?php
session_start();
require_once __DIR__ . '/../../class/Usuario.php';
Usuario::logout();
header('Location: ../../index.php?page=home');
exit;
