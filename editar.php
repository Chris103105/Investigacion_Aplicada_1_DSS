<?php
session_start();

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$posicion = -1;

// V1: Uso de foreach para evitar errores
if ($id != "") {
    foreach ($_SESSION["productos"] as $i => $producto) {
        if ($producto["id"] == $id) {
            $posicion = $i;
            break;
        }
    }
}

if (isset($_POST["actualizar"]) && $posicion != -1) {
    // V2: Ya no se actualiza el ID para evitar conflictos
    $_SESSION["productos"][$posicion]["nombre"] = trim($_POST["nombre"]);
    $_SESSION["productos"][$posicion]["descripcion"] = trim($_POST["descripcion"]);
    $_SESSION["productos"][$posicion]["precio"] = trim($_POST["precio"]);
    $_SESSION["productos"][$posicion]["stock"] = trim($_POST["stock"]);
    $_SESSION["productos"][$posicion]["categoria"] = trim($_POST["categoria"]);
    
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Producto</title>
    <style>body { background-color: #b3b7ba; font-family: Arial; padding: 20px; }</style>
</head>
<body>
    <h2>Editar Producto</h2>
    
    <?php if ($posicion != -1) { ?>
        <form method="POST">
            ID (No modificable): 
            <input type="text" name="id" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["id"]); ?>" readonly style="background-color: #e9ecef;"><br><br>
            
            Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["nombre"]); ?>"><br><br>
            Descripción: <input type="text" name="descripcion" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["descripcion"]); ?>"><br><br>
            Precio: <input type="text" name="precio" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["precio"]); ?>"><br><br>
            Stock: <input type="text" name="stock" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["stock"]); ?>"><br><br>
            Categoría: <input type="text" name="categoria" value="<?php echo htmlspecialchars($_SESSION["productos"][$posicion]["categoria"]); ?>"><br><br>
            
            <input type="submit" name="actualizar" value="Actualizar Cambios">
            <a href="index.php">Cancelar</a>
        </form>
    <?php } else { ?>
        <p style="color:red;">Producto no encontrado.</p>
        <a href="index.php">Volver</a>
    <?php } ?>
</body>
</html>