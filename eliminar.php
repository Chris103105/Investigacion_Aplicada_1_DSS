<?php
session_start();

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$nombre_producto = "";

foreach ($_SESSION["productos"] as $producto) {
    if ($producto["id"] == $id) {
        $nombre_producto = $producto["nombre"];
        break;
    }
}

if (isset($_POST["si"])) {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            unset($_SESSION["productos"][$i]);
            // V1: Función clave para evitar errores de índices
            $_SESSION["productos"] = array_values($_SESSION["productos"]); 
            break;
        }
    }
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Producto</title>
    <style>body { background-color: #b3b7ba; font-family: Arial; padding: 20px; }</style>
</head>
<body>
    <h2>Eliminar Producto</h2>
    
    <?php if ($nombre_producto != "") { ?>
        <div style="border: 2px solid #dc3545; padding: 15px; background-color: #f8d7da; max-width: 400px; border-radius: 5px;">
            <h3 style="color: #721c24; margin-top: 0;">¡Advertencia!</h3>
            <p style="color: #721c24;">Está a punto de eliminar el siguiente producto:</p>
            <ul style="color: #721c24;">
                <li><b>ID:</b> <?php echo htmlspecialchars($id); ?></li>
                <li><b>Nombre:</b> <?php echo htmlspecialchars($nombre_producto); ?></li>
            </ul>
            <p style="color: #721c24;">¿Está completamente seguro?</p>
            <form method="POST">
                <input type="submit" name="si" value="Sí, eliminar" style="background-color: #dc3545; color: white; border: none; padding: 8px; cursor: pointer;">
                <a href="index.php" style="margin-left: 10px;">Cancelar</a>
            </form>
        </div>
    <?php } else { ?>
        <p style="color: red;">El producto no existe o ya fue eliminado.</p>
        <a href="index.php">Volver al inventario</a>
    <?php } ?>
</body>
</html>