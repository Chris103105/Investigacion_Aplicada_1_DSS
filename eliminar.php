<?php

if (isset($_POST["si"])) {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            unset($_SESSION["productos"][$i]); // Borra el dato
            
            // La función clave de su código:
            $_SESSION["productos"] = array_values($_SESSION["productos"]); 
            break; 
        }
    }
    header("Location: index.php");
    exit();
}
?>
