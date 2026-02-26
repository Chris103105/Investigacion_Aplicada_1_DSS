<?php
// Arrancamos la sesion temporal ya que no estamos usando una base de datos real
session_start();

// Si es la primera vez que el usuario entra y la matriz "productos" no existe la inicializamos como un arreglo vacío para que el código no nos tire errores más adelante.
if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = array();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Inventario</title>
   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="container py-5">
    <div class="mb-4">
        <br><br><br><br>
        <h2 class="fw-bold" style="color: #ffffff;">Inventario General</h2>
    </div>

    <div class="card dashboard-card">
        
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-medium"><i class="bi bi-list-stars me-2"></i>Listado de Productos</h4>
            </div>
            
            <a href="agregar.php" class="btn btn-add-custom d-flex align-items-center">
                <i class="bi bi-plus-circle-fill me-2 fs-5"></i> Nuevo Producto
            </a>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    
                    <thead>
                        <tr>
                            <th class="ps-4"><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-box-seam me-1"></i>Producto</th>
                            <th><i class="bi bi-tag me-1"></i>Categoría</th>
                            <th><i class="bi bi-card-text me-1"></i>Descripción</th> <th><i class="bi bi-currency-dollar me-1"></i>Precio</th>
                            <th class="text-center"><i class="bi bi-layers me-1"></i>Stock</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                    // Verificamos si hay al menos un producto guardado en la sesión
                    if (count($_SESSION["productos"]) > 0) {
                        
                        // Si hay productos, recorremos la matriz uno por uno
                        foreach ($_SESSION["productos"] as $producto) {
                            echo "<tr>";
                            
                            // Imprimimos el ID 
                            echo "<td class='ps-4 fw-bold text-secondary'>#".$producto["id"]."</td>";
                            
                            // Mostramos el nombre resaltado
                            echo "<td><span class='producto-nombre'>".$producto["nombre"]."</span></td>";
                            
                            // Categoria y Descripcion con estilos de etiquetas grises  para mantener la UI limpia
                            echo "<td><span class='badge bg-light text-dark border'>".$producto["categoria"]."</span></td>";
                            echo "<td><span class='badge bg-light text-dark border'>".$producto["descripcion"]."</span></td>";

                            // Forzamos a que el precio siempre muestre 2 decimales 
                            echo "<td class='fw-bold text-primary'>$".number_format((float)$producto["precio"], 2)."</td>";
                            
                            // Logica visual del Stock Si hay inventario (> 0), la clase CSS lo pinta de verde. Si es 0, lo pinta de rojo.
                            $badgeClass = $producto["stock"] > 0 ? "badge-stock-ok" : "badge-stock-low";
                            $iconStock = $producto["stock"] > 0 ? "bi-check-circle-fill" : "bi-x-circle-fill";
                            echo "<td class='text-center'><span class='$badgeClass'><i class='bi $iconStock me-1'></i>".$producto["stock"]."</span></td>";
                            
                            // Botones de accion (Editar, Eliminar, Vender) apuntando a sus respectivos archivos y enviando el ID por metodo GET
                            echo "<td class='text-center'>
                                    <a href='editar.php?id=".$producto["id"]."' class='btn-action-soft btn-edit' title='Editar'><i class='bi bi-pencil-square'></i></a>
                                    <a href='eliminar.php?id=".$producto["id"]."' class='btn-action-soft btn-delete' title='Eliminar'><i class='bi bi-trash3'></i></a>
                                    <a href='vender.php?id=".$producto["id"]."' class='btn-sell-gradient ms-2'><i class='bi bi-cart-check me-1'></i> Vender</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        
                        // Si el arreglo está vacío mostramos un mansaje de que esta vacia y un botón para agregar el primer producto.
                    
                        echo "<tr><td colspan='7' class='text-center text-muted py-5'>
                                <i class='bi bi-inbox fs-1 d-block mb-3' style='opacity:0.3'></i>
                                No hay productos registrados en el inventario.<br>
                                <a href='agregar.php' class='btn btn-link text-decoration-none mt-2'>Comienza agregando uno</a>
                              </td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>