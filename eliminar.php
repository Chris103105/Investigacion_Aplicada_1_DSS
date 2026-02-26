<?php
session_start();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = "";
}

$nombre_producto = "";

// Buscar el nombre del producto para mostrarlo
foreach ($_SESSION["productos"] as $producto) {
    if ($producto["id"] == $id) {
        $nombre_producto = $producto["nombre"];
        break; // Detenemos la búsqueda al encontrarlo
    }
}

// Boton si eliminar
if (isset($_POST["si"])) {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            unset($_SESSION["productos"][$i]);
            
            // Reordenar para que el for de otras paginas no falle
            $_SESSION["productos"] = array_values($_SESSION["productos"]); 
            break; 
        }
    }
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    
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
                <h5style="color: #ffffff;">Panel de Administración</h5>
                <h2 class="fw-bold" style="color: #ffffff;">Eliminar Producto</h2>
            </div>

            <div class="card dashboard-card">
                <div class="card-header bg-danger text-white text-center py-3" style="border-bottom: none;">
                    <h4 class="mb-0 fw-medium"><i class="bi bi-exclamation-triangle-fill me-2"></i>Acción Irreversible</h4>
                </div>
                
                <div class="card-body p-4 text-center">
                    
                    <?php if ($nombre_producto != ""): ?>
                        
                        <i class="bi bi-trash3 text-danger d-block mb-3" style="font-size: 4rem; opacity: 0.8;"></i>
                        
                        <h5 class="mb-3 fw-bold">¿Estás completamente seguro?</h5>
                        <p class="text-muted mb-4">
                            Estás a punto de eliminar el producto <br>
                            <strong class="fs-4" style="color: #2c3e50;">"<?php echo htmlspecialchars($nombre_producto); ?>"</strong>.<br>
                            <small class="text-danger mt-2 d-block">Esta acción borrará el producto de la sesión permanentemente.</small>
                        </p>

                        <form method="POST">
                            <div class="d-grid gap-2">
                                <button type="submit" name="si" class="btn btn-danger py-2 fw-bold shadow-sm" style="font-size: 1.1rem;">
                                    <i class="bi bi-trash3-fill me-2"></i> Sí, eliminar definitivamente
                                </button>
                                <a href="index.php" class="btn btn-light border py-2 text-muted fw-medium mt-2">
                                    <i class="bi bi-x-circle me-2"></i> Cancelar y volver
                                </a>
                            </div>
                        </form>

                    <?php else: ?>
                        
                        <i class="bi bi-search d-block fs-1 text-muted mb-3" style="opacity: 0.5;"></i>
                        <h5 class="text-danger fw-bold">Producto no encontrado</h5>
                        <p class="text-muted">El producto ya fue eliminado previamente o el ID es incorrecto.</p>
                        <a href="index.php" class="btn btn-outline-secondary mt-4"><i class="bi bi-arrow-left me-2"></i>Regresar al inventario</a>
                        
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>