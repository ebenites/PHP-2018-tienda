<?php
require_once './autoload.php';

// validaciones
if(!isset($_POST['categorias_id']) || '' === $_POST['categorias_id'])
    die('Categoría inválida');

if(!isset($_POST['nombre']) || strlen($_POST['nombre']) <= 3)
    die('Modelo debe ser mayor a 3 caracteres');

if($_FILES['imagen']['error']==0 && $_FILES['imagen']['size'] > 1048576)
        die('Archivo demasiado grande ( > 1MiB)');

$id = $_POST['id'];
$categorias_id = $_POST['categorias_id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$descripcion = $_POST['descripcion'];
$estado = $_POST['estado'];

$producto = new Producto();
$producto->id = $id;
$producto->categorias_id = $categorias_id;
$producto->nombre = $nombre;
$producto->precio = $precio;
$producto->stock = $stock;
$producto->descripcion = $descripcion;
$producto->estado = $estado;

if($_FILES['imagen']['error']==0){
    
    $productoAnterior = ProductoRepository::obtener($id);
    $filename = Constantes::RUTA_IMAGENES . $productoAnterior->imagen_nombre; 
    if(file_exists($filename)){
        unlink($filename);
    }
    
    $filename = md5($_FILES['imagen']['name'] . microtime()) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    
    $producto->imagen_nombre = $filename;
    $producto->imagen_tipo  = $_FILES['imagen']['type'];
    $producto->imagen_tamanio = $_FILES['imagen']['size'];
    
    if(!file_exists(Constantes::RUTA_IMAGENES) ){
        mkdir(Constantes::RUTA_IMAGENES, '0777', true);
    }
    
    $destino = Constantes::RUTA_IMAGENES . $filename;
    
    move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
    
}

ProductoRepository::actualizar($producto);

Flash::success('Registro actualizado satisfactoriamente');

if(empty(error_get_last() ))
    header('location: productos-listar.php');