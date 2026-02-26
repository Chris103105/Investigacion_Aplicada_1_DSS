<?php
session_start();
if (!isset($_SESSION["productos"])) { $_SESSION["productos"] = array(); }

$error = "";
if (isset($_POST["guardar"])) {
    $id = $_POST["id"];
    // ... (recepción de variables) ...

    // Su aporte principal: Las validaciones
    if (empty($id) || empty($nombre) || empty($precio) || empty($stock)) {
        $error = "Por favor, no deje campos vacíos.";
    } else if (!is_numeric($precio) || !is_numeric($stock)) {
        $error = "El precio y el stock deben ser números válidos.";
    } else if ($precio < 0 || $stock < 0) {
        $error = "No se permiten valores numéricos negativos.";
    } else {
        // Lógica de ID repetido y array_push...
        // ... (resto del código de agregar.php) ...
    }
}
?>
