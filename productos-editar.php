<?php
require_once './autoload.php';

$id = $_GET['id'];

$producto = ProductoRepository::obtener($id);

$categorias = CategoriaRepository::listar();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <?php require_once './includes/resources.php';?>
    </head>
    <body>
        
        <?php require_once './includes/header.php';?>

        <div class="container-fluid main">
            
            <div class="page-header">
                <h1>Registro de Producto</h1>
            </div>
            
            <form action="productos-actualizar.php" method="POST" enctype="multipart/form-data">
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Formulario de edición</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="categorias_id">Categoría</label>
                            <select name="categorias_id" id="categorias_id" class="form-control" required="">
                                <option value="" selected="" disabled="">Seleccione una categoría</option>
                                <?php foreach($categorias as $categoria){ ?>
                                <option value="<?=$categoria->id?>" <?=($categoria->id==$producto->categorias_id)?'selected':''?>><?=$categoria->nombre?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="<?=$producto->nombre?>" class="form-control" required="" maxlength="100" placeholder="Ingrese el nombre">
                        </div>
                        
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" id="precio" name="precio" value="<?=$producto->precio?>" class="form-control" placeholder="Ingrese el precio">
                        </div>
                        
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock" value="<?=$producto->stock?>" class="form-control" min="0" max="1000" placeholder="Ingrese el nombre">
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control ckeditor"><?=$producto->descripcion?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input type="file" id="imagen" name="imagen" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <img src="productos-imagen.php?id=<?=$producto->id?>" alt="" style="height: 64px" class="img-thumbnail">
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="estado" <?=($producto->estado==1)?'checked':''?> data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-onstyle="success" data-offstyle="danger" value="1">
                            </label>
                        </div>
                        
                        <input type="hidden" name="id" value="<?=$producto->id?>"/>
                        
                    </div>
                    <div class="panel-footer">
                        <input type="submit" class="btn btn-primary" value="Actualizar"/>
                        <a href="productos-listar.php" class="btn btn-default">Regresar</a>
                    </div>
                </div>
                
            </form>
            
        </div>
        
        <?php require_once './includes/footer.php';?>
        
    </body>
</html>
