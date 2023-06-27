<?php
require_once 'model.php';

class Controlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new Modelo();
    }

    public function inicio() {
        // Mostrar la vista de la página inicial
        include 'view.php';
    }

    public function redireccionar() {
        // Lógica para redireccionar a otra página
        header("Location: otra_pagina.php");
        exit();
    }
}

// Aquí se manejarían las solicitudes del usuario y se ejecutarían las acciones correspondientes
$controlador = new Controlador();

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
} else {
    $accion = 'inicio';
}

switch ($accion) {
    case 'inicio':
        $controlador->inicio();
        break;
    case 'redireccionar':
        $controlador->redireccionar();
        break;
    default:
        echo "Acción no válida";
        break;
}
?>
