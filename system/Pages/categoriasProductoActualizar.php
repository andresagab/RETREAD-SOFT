<?php
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
/*print_r($_FILES);
echo "<br>";
print_r($_POST);
die();*/
switch ($accion){
    case 'Adicionar':
        $objeto=new Categoria_Producto(null, null, null, null);
        $objeto->setIdCategoria("null");
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        //Upload de foto
        if (isset($_FILES['imagen'])){
            $foto=$_FILES['imagen']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= Categoria_Producto::getNextId(). "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['imagen']['tmp_name'], "system/Uploads/Imgs/Categorias/$namePhoto");
        } else $namePhoto="";
        //Fin Upload de foto
        $objeto->setImagen($namePhoto);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Categoria_Producto('id', $id, null, null);
        $objeto->setIdCategoria("null");
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        //Upload de foto
        if (isset($_FILES['imagen'])){
            $foto=$_FILES['imagen']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $id . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['imagen']['tmp_name'], "system/Uploads/Imgs/Categorias/$namePhoto");
        } else $namePhoto="";
        //Fin Upload de foto
        $objeto->setImagen($namePhoto);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Categoria_Producto('id', $id, null, null);
        if (file_exists("system/Uploads/Imgs/Categorias/".$objeto->getImagen())){
            if (unlink("system/Uploads/Imgs/Categorias/".rtrim($objeto->getImagen()))) echo "Archivo eliminado";
            else "Error al eliminar el archivo";
        }
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/categoriasProducto.php");