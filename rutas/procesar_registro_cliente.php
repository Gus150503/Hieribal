<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../controlador/ControladorCliente.php';

$controlador = new ControladorCliente();
$controlador->registrar();
