<?php
// ... (búsqueda del producto) ...

if (isset($_POST["vender"])) {
    $cantidad = $_POST["cantidad"];

    if ($cantidad > $stock_actual) {
        $error = "No hay suficiente stock. Solo quedan: " . $stock_actual;
    } else {
        // Su aporte principal: Matemáticas de la sesión
        $_SESSION["productos"][$posicion]["stock"] -= $cantidad;
        $total_pagar = $cantidad * $precio_producto;
        
        $mensaje = "Venta exitosa. Total a pagar: $" . number_format($total_pagar, 2);
        $stock_actual = $_SESSION["productos"][$posicion]["stock"];
    }
}
?>
