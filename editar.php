<?php
session_start();

if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = array();
}

// Recibir el ID de la URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = "";
}

$posicion = -1;

// EL APORTE DE LA V1: Uso de foreach para evitar errores de índices vacíos
if ($id != "") {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            $posicion = $i;
            break;
        }
    }
}


?>