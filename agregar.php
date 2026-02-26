<?php
 //lo primero es arrancar la sesión para poder guardar o leer datos
session_start();

// Si por alguna razón la matriz no existe  la creamos
if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = array();
}

// Variable para guardar y mostrar mensajes de error al usuario
$error = "";

// Solo ejecutamos este bloque si el usuario le dio clic al botón con el name="guardar"
if (isset($_POST["guardar"])) {

    // Recibimos todos los datos que el usuario escribio en el formulario
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $categoria = $_POST["categoria"];

   
    // Esto es vital para que no nos metan basura en el inventario.

    // 1. Que no haya campos en blanco
    if (empty($id) || empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($categoria)) {
        $error = "Por favor, no deje campos vacíos.";
    }
    // 2. Que el precio y stock sean obligatoriamente numeros
    else if (!is_numeric($precio) || !is_numeric($stock)) {
        $error = "El precio y el stock deben ser números válidos.";
    }
    // 3. Que no haya precios ni inventarios en negativo 
    else if ($precio < 0 || $stock < 0) {
        $error = "No se permiten valores numéricos negativos.";
    }
    else {
        // 4. Validar que el ID sea unico. 
        // Recorremos todo el inventario buscando si alguien ya uso ese ID.
        foreach ($_SESSION["productos"] as $producto) {
            if ($producto["id"] == $id) {
                $error = "El ID ingresado ya existe en el inventario.";
                // Si encontramos uno igual, ya no hace falta seguir buscando
                break; 
            }
        }

        // Si despues de pasar  los filtros, la variable $error sigue vacía, significa que todo esta perfecto
        if ($error == "") {
            
            // Armamos un nuevo arreglo asociativo con los datos limpios
            $nuevo = array(
                "id" => $id,
                "nombre" => $nombre,
                "descripcion" => $descripcion,
                "precio" => $precio,
                "stock" => $stock,
                "categoria" => $categoria
            );

            // Metemos este nuevo arreglo al final de nuestra matriz principal de la sesión
            array_push($_SESSION["productos"], $nuevo);

            // Redirigimos al usuario a la tabla principal para que vea su producto agregado
            header("Location: index.php");
            // Usamos exit() siempre después de un header para que el script no siga corriendo en segundo plano
            exit(); 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto</title> 
    
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
                <h2 class="fw-bold" style="color: #ffffff;">Registro de Producto</h2>
            </div>

            <div class="card dashboard-card">
                
                <div class="card-header-custom text-center">
                    <h4 class="mb-0 fw-medium"><i class="bi bi-box-seam me-2"></i>Detalles del Producto</h4>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    <?php if ($error != ""): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID del Producto</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="id" class="form-control border-start-0" placeholder="Ej. 12004" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Categoría</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-tags"></i></span>
                                    <input type="text" name="categoria" class="form-control border-start-0" placeholder="Ej. Tecnología" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-fonts"></i></span>
                                <input type="text" name="nombre" class="form-control border-start-0" placeholder="Ej. Teclado Mecánico RGB" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0"><i class="bi bi-card-text"></i></span>
                                <input type="text" name="descripcion" class="form-control border-start-0" placeholder="Breve detalle del artículo..." required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Precio ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-currency-dollar"></i></span>
                                    <input type="text" name="precio" class="form-control border-start-0" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Stock Inicial</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0"><i class="bi bi-boxes"></i></span>
                                    <input type="text" name="stock" class="form-control border-start-0" placeholder="Cantidad" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="guardar" class="btn btn-sell-gradient py-2 fw-bold" style="font-size: 1.1rem;">
                                <i class="bi bi-save me-2"></i> Guardar Producto
                            </button>
                            
                            <a href="index.php" class="btn btn-light border py-2 text-muted fw-medium mt-2 transition">
                                <i class="bi bi-arrow-left me-2"></i> Cancelar y Volver
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>