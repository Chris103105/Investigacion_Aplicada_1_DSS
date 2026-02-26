<?php
session_start();

// Validar que el ID venga en la URL con un if tradicional
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = "";
}

$error = "";
$mensaje = "";
$posicion = -1;
$nombre_producto = "";
$stock_actual = 0;
$precio_producto = 0;

// Buscar el producto con un foreach simple
if ($id != "") {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            $posicion = $i;
            $nombre_producto = $producto["nombre"];
            $stock_actual = $producto["stock"];
            $precio_producto = $producto["precio"];
        }
    }
}

// Logica del boton vender
if (isset($_POST["vender"])) {
    $cantidad = $_POST["cantidad"];

    if ($posicion == -1) {
        $error = "Error: El producto no existe.";
    } else if (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) {
        $error = "La cantidad debe ser un número mayor a cero.";
    } else if ($cantidad > $stock_actual) {
        $error = "No hay suficiente stock. Solo quedan: " . $stock_actual;
    } else {
        // Restar el stock en la sesion
        $_SESSION["productos"][$posicion]["stock"] -= $cantidad;
        
        // Calcular el total
        $total_pagar = $cantidad * $precio_producto;
        
        $mensaje = "Venta exitosa de <strong>" . htmlspecialchars($nombre_producto) . "</strong>.<br>";
        $mensaje .= "Total a pagar: <strong>$" . number_format($total_pagar, 2) . "</strong>";
        
        // Actualizamos la variable para que el HTML muestre el nuevo stock
        $stock_actual = $_SESSION["productos"][$posicion]["stock"];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
         <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="mb-4 text-center">
                <h5 style="color: #ffffff;">Panel de Administración</h5>
                <h2 class="fw-bold" style="color: #ffffff;">Punto de Venta</h2>
            </div>

            <div class="card dashboard-card">
                <div class="card-header-custom text-center">
                    <h4 class="mb-0 fw-medium"><i class="bi bi-cart-check-fill me-2"></i>Procesar Venta</h4>
                </div>
                
                <div class="card-body p-4">
                    
                    <?php if ($error != ""): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($mensaje != ""): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                            <div><?php echo $mensaje; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($posicion != -1): ?>
                        
                        <div class="p-3 mb-4 rounded" style="background-color: rgba(248, 249, 250, 0.8); border: 1px solid #e9ecef;">
                            <h5 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="bi bi-box-seam me-2"></i><?php echo htmlspecialchars($nombre_producto); ?>
                            </h5>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted fw-semibold">Precio Unitario:</span>
                                <span class="fw-bold fs-5" style="color: #2c3e50;">$<?php echo number_format($precio_producto, 2); ?></span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-semibold">Stock Disponible:</span>
                                <?php 
                                    $badgeClass = $stock_actual > 0 ? "badge-stock-ok" : "badge-stock-low";
                                    $iconStock = $stock_actual > 0 ? "bi-check-circle-fill" : "bi-x-circle-fill";
                                ?>
                                <span class="<?php echo $badgeClass; ?> px-3 py-1 fs-6">
                                    <i class="bi <?php echo $iconStock; ?> me-1"></i><?php echo $stock_actual; ?>
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="">
                            <div class="mb-4">
                                <label class="form-label">Cantidad a vender</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-123"></i></span>
                                    <input type="number" name="cantidad" class="form-control border-start-0" placeholder="Ej. 2" required <?php echo $stock_actual <= 0 ? 'disabled' : ''; ?>>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="vender" class="btn btn-sell-gradient py-2 fw-bold" style="font-size: 1.1rem;" <?php echo $stock_actual <= 0 ? 'disabled' : ''; ?>>
                                    <i class="bi bi-cash-coin me-2"></i> Cobrar Venta
                                </button>
                                <a href="index.php" class="btn btn-light border py-2 text-muted fw-medium mt-2">
                                    <i class="bi bi-arrow-left me-2"></i> Volver al Inventario
                                </a>
                            </div>
                        </form>

                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-search d-block fs-1 text-muted mb-3" style="opacity: 0.5;"></i>
                            <h5 class="text-danger">El producto no fue encontrado</h5>
                            <p class="text-muted">Es posible que el ID sea incorrecto o el producto haya sido eliminado.</p>
                            <a href="index.php" class="btn btn-outline-secondary mt-3"><i class="bi bi-arrow-left me-2"></i>Regresar</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>