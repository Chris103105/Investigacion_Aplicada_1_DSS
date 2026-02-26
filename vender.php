<?php
session_start();

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$error = ""; 
$mensaje = ""; 
$posicion = -1; 
$nombre_producto = ""; 
$stock_actual = 0; 
$precio_producto = 0;

if ($id != "") {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            $posicion = $i;
            $nombre_producto = $producto["nombre"];
            $stock_actual = $producto["stock"];
            $precio_producto = $producto["precio"];
            break;
        }
    }
}

if (isset($_POST["vender"]) && $posicion != -1) {
    $cantidad = $_POST["cantidad"];
    
    if (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) {
        $error = "La cantidad debe ser un número mayor a cero.";
    } else if ($cantidad > $stock_actual) {
        $error = "No hay suficiente stock. Solo quedan: " . $stock_actual;
    } else {
        // V1: Resta matemática en la matriz
        $_SESSION["productos"][$posicion]["stock"] -= $cantidad;
        $total_pagar = $cantidad * $precio_producto;
        
        $mensaje = "Venta exitosa de " . htmlspecialchars($nombre_producto) . ".<br>";
        $mensaje .= "Total a pagar: $" . number_format($total_pagar, 2);
        
        $stock_actual = $_SESSION["productos"][$posicion]["stock"];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Vender Producto</title>
    <style>body { background-color: #b3b7ba; font-family: Arial; padding: 20px; }</style>
</head>
<body>
    <h2>Vender Producto</h2>
    
    <?php if ($error != "") echo "<p style='color:red;'>".$error."</p>"; ?>
    
    <?php if ($mensaje != "") { ?>
        <p style='color:green;'><b><?php echo $mensaje; ?></b></p>
        <a href="index.php">Realizar otra operación</a>
        
    <?php } else if ($posicion != -1) { ?>
        
        <p><b>Producto:</b> <?php echo htmlspecialchars($nombre_producto); ?></p>
        <p><b>Precio:</b> $<?php echo htmlspecialchars($precio_producto); ?></p>
        <p><b>Stock disponible:</b> <?php echo $stock_actual; ?></p>

        <form method="POST">
            Cantidad a vender: 
            <input type="text" name="cantidad" <?php if($stock_actual <= 0) echo "disabled"; ?>><br><br>
            <input type="submit" name="vender" value="Cobrar Venta" <?php if($stock_actual <= 0) echo "disabled"; ?>>
            <a href="index.php" style="margin-left: 10px;">Cancelar</a>
        </form>
        
    <?php } else { ?>
        <p style="color:red;">No se encontró el producto.</p>
        <a href="index.php">Volver a la lista</a>
    <?php } ?>
</body>
</html>
