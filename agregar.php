<?php
session_start();
if (!isset($_SESSION["productos"])) {
    $_SESSION["productos"] = array();
}

$error = "";
// V2: Variables para retener los datos
$id_val = isset($_POST["id"]) ? trim($_POST["id"]) : "";
$nombre_val = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
$desc_val = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
$precio_val = isset($_POST["precio"]) ? trim($_POST["precio"]) : "";
$stock_val = isset($_POST["stock"]) ? trim($_POST["stock"]) : "";
$cat_val = isset($_POST["categoria"]) ? trim($_POST["categoria"]) : "";

if (isset($_POST["guardar"])) {
    if (empty($id_val) || empty($nombre_val) || empty($desc_val) || empty($precio_val) || $stock_val === "" || empty($cat_val)) {
        $error = "No dejar campos vacíos.";
    } else if (!is_numeric($precio_val) || !is_numeric($stock_val)) {
        $error = "Precio y stock deben ser números.";
    } else if ($precio_val < 0 || $stock_val < 0) {
        $error = "No se permiten valores negativos.";
    } else {
        $existe = false;
        foreach ($_SESSION["productos"] as $producto) {
            if ($producto["id"] == $id_val) {
                $existe = true;
                break;
            }
        }
        
        if ($existe) {
            $error = "El ID ya existe.";
        } else {
            $nuevo = array(
                "id" => $id_val, "nombre" => $nombre_val, "descripcion" => $desc_val, 
                "precio" => $precio_val, "stock" => $stock_val, "categoria" => $cat_val
            );
            array_push($_SESSION["productos"], $nuevo);
            header("Location: index.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Producto</title>
    <style>body { background-color: #b3b7ba; font-family: Arial; padding: 20px; }</style>
</head>
<body>
    <h2>Agregar Producto</h2>
    <?php if($error != "") echo "<p style='color:red;'><b>$error</b></p>"; ?>
    
    <form method="POST">
        ID: <input type="text" name="id" value="<?php echo htmlspecialchars($id_val); ?>"><br><br>
        Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre_val); ?>"><br><br>
        Descripción: <input type="text" name="descripcion" value="<?php echo htmlspecialchars($desc_val); ?>"><br><br>
        Precio: <input type="text" name="precio" value="<?php echo htmlspecialchars($precio_val); ?>"><br><br>
        Stock: <input type="text" name="stock" value="<?php echo htmlspecialchars($stock_val); ?>"><br><br>
        Categoría: <input type="text" name="categoria" value="<?php echo htmlspecialchars($cat_val); ?>"><br><br>
        
        <input type="submit" name="guardar" value="Guardar">
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>
