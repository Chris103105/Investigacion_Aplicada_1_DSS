<?php

session_start();

// Validamos que el arreglo exista
if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = array();
}

// Atrapamos el ID del producto que queremos editar este ID viene en la URL 
// Usamos isset para evitar que PHP tire un error si alguien entra sin poner un ID en la URL.
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = "";
}

// Inicializamos la variable $posicion en -1. 
// Si después de buscar el producto esta variable sigue valiendo -1, significa que no existe.
$posicion = -1;
$error = "";


// Si tenemos un ID válido, empezamos a buscar en el inventario.
if ($id != "") {
    // Usamos 'foreach' con índice ($i) en lugar de un 'for' tradicional. 
    // Esto es vital porque si eliminamos productos antes, los índices numéricos se desordenan.
    // El foreach nos garantiza encontrar la posición real en la memoria de la sesión.
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            $posicion = $i; // ¡Lo encontramos! Guardamos en qué cajón (índice) está guardado.
            break; // Como ya lo encontramos, detenemos el ciclo para no gastar recursos a lo loco.
        }
    }
}


// Solo entramos aquí si el usuario apretó el botón de "Actualizar" y si el producto realmente existe.
if (isset($_POST["actualizar"]) && $posicion != -1) {

    // Recibimos los datos del formulario.
    // Usamos trim() para quitar los espacios en blanco accidentales que el usuario pudo dejar al inicio o al final.
    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $categoria = trim($_POST["categoria"]);

    // Reciclamos las mismas validaciones de seguridad que usamos al agregar.
    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($categoria)) {
        $error = "Por favor, no deje campos vacíos.";
    } else if (!is_numeric($precio) || !is_numeric($stock)) {
        $error = "El precio y el stock deben ser números válidos.";
    } else if ($precio < 0 || $stock < 0) {
        $error = "No se permiten valores numéricos negativos.";
    } else {
        // Si todo está perfecto, usamos la $posicion que encontramos arriba 
        // para sobreescribir ÚNICAMENTE los datos de este producto en específico.
        // Ojo: ¡No actualizamos el ID! Ese se queda intacto para no romper las relaciones.
        $_SESSION["productos"][$posicion]["nombre"] = $nombre;
        $_SESSION["productos"][$posicion]["descripcion"] = $descripcion;
        $_SESSION["productos"][$posicion]["precio"] = $precio;
        $_SESSION["productos"][$posicion]["stock"] = $stock;
        $_SESSION["productos"][$posicion]["categoria"] = $categoria;

        // Mandamos al usuario de regreso al listado principal.
        header("Location: index.php");
        exit(); // Detenemos la ejecución aquí por seguridad.
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title> 
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="mb-4 text-center">
                <h5 style="color: #ffffff;">Panel de Administración</h5>
                <h2 class="fw-bold" style="color: #ffffff;">Actualizar Producto</h2>
            </div>

            <div class="card dashboard-card">
                <div class="card-header-custom text-center">
                    <h4 class="mb-0 fw-medium"><i class="bi bi-pencil-square me-2"></i>Edición de Datos</h4>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    <?php if ($error != ""): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($posicion != -1): ?>
                        
                        <form method="POST" action="">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ID del Producto (No editable)</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-light"><i class="bi bi-hash"></i></span>
                                        
                                        <input type="text" name="id" class="form-control border-start-0 bg-light text-muted" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["id"]); ?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Categoría</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-tags"></i></span>
                                        <input type="text" name="categoria" class="form-control border-start-0" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["categoria"]); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nombre del Producto</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-fonts"></i></span>
                                    <input type="text" name="nombre" class="form-control border-start-0" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["nombre"]); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-card-text"></i></span>
                                    <input type="text" name="descripcion" class="form-control border-start-0" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["descripcion"]); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Precio ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-currency-dollar"></i></span>
                                        <input type="text" name="precio" class="form-control border-start-0" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["precio"]); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Stock Actual</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0"><i class="bi bi-boxes"></i></span>
                                        <input type="text" name="stock" class="form-control border-start-0" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["stock"]); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="actualizar" class="btn btn-warning py-2 fw-bold" style="font-size: 1.1rem; color: #856404; background-color: #ffda6a; border: none;">
                                    <i class="bi bi-arrow-repeat me-2"></i> Guardar Cambios
                                </button>
                                <a href="index.php" class="btn btn-light border py-2 text-muted fw-medium mt-2">
                                    <i class="bi bi-arrow-left me-2"></i> Cancelar
                                </a>
                            </div>

                        </form>

                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-search d-block fs-1 text-muted mb-3" style="opacity: 0.5;"></i>
                            <h5 class="text-danger">Producto no encontrado</h5>
                            <p class="text-muted">El producto que intentas editar no existe.</p>
                            <a href="index.php" class="btn btn-outline-secondary mt-3"><i class="bi bi-arrow-left me-2"></i>Regresar al inicio</a>
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