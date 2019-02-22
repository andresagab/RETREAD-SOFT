<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
require_once dirname(__FILE__).'/../Clases/Presentacion_Producto.php';
require_once dirname(__FILE__).'/../Clases/Unidad_Medida.php';
require_once dirname(__FILE__).'/../Clases/Tercero.php';
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
/*print_r($_POST);
echo "<br>";
print_r($_FILES);
die();*/
switch ($accion){
    case 'Adicionar':
        //Validacciones de variables
        if ($idPresentacion=="#") $idPresentacion='null';
        if ($idUnidadMedida=="#") $idUnidadMedida='null';
        if ($idProvedor=="#") $idProvedor='null';
        if ($grupo==null) $grupo='null';
        if ($peso==null) $peso='null';
        //Fin Validacciones de variables
        //
        $objeto=new Producto(null, null, null, null);
        $puc=new Puc(null, null, null, null);
        $codigo= Puc::getMaxId()+1;
        //Registro para la tabla PUC}
        $puc->setCodigo($codigo);
        $puc->setNombre($nombre);
        $puc->setDescripcion($descripcion);
        $puc->setNivel("null");
        $puc->setFechaRegistro(date("Y-m-d H:i:s"));
        $puc->grabar();
        //Fin Registro para la tabla PUC
        $puc=new Puc('codigo', "'$codigo'", null, null);
        //
        //Upload de foto
        if (isset($_FILES['foto'])){
            if ($_FILES['foto']['tmp_name']!=null){
                $foto=$_FILES['foto']['name'];
                $cutExt= substr($foto, strpos($foto, "."));
                $namePhoto= Producto::getNextId(). "_" . date("Y-m-d") . $cutExt;
                move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Productos/$namePhoto");
            } else $namePhoto="";
        } else $namePhoto="";
        //Fin Upload de foto
        //
        //Registro de datos para el producto
        $objeto->setCodPuc($puc->getCodigo());
        $objeto->setIdPresentacion($idPresentacion);
        $objeto->setIdUnidadMedida($idUnidadMedida);
        $objeto->setIdProvedor($idProvedor);
        $objeto->setGrupo($grupo);
        $objeto->setStock($stock);
        $objeto->setStockMinimo($stockMinimo);
        $objeto->setStockMaximo($stockMaximo);
        $objeto->setPeso($peso);
        $objeto->setFoto($namePhoto);
        $objeto->setCosto($costo);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->setIdCategoria($idCategoria);
        $objeto->grabar();
        //Fin Registro de datos para el producto
        break;
    case 'Modificar':
        if ($idPresentacion=="#") $idPresentacion='null';
        if ($idUnidadMedida=="#") $idUnidadMedida='null';
        if ($idProvedor=="#") $idProvedor='null';
        if ($grupo==null) $grupo='null';
        if ($peso==null) $peso='null';
        //Fin Validacciones de variables
        //
        $objeto=new Producto('id', $id, null, null);
        $puc=$objeto->getPuc();
        //Registro para la tabla PUC}
        $puc->setNombre($nombre);
        $puc->setDescripcion($descripcion);
        $puc->setNivel('null');
        $puc->modificar();
        //Fin Registro para la tabla PUC
        //
        //Upload de foto
        if ($objeto->getFoto()!=null || $objeto->getFoto()!=''){
            if (file_exists("system/Uploads/Imgs/Productos/".rtrim($objeto->getFoto()))){
                if (isset($_FILES['foto'])){
                    if ($_FILES['foto']['tmp_name']!=null){
                        $foto=$_FILES['foto']['name'];
                        $cutExt= substr($foto, strpos($foto, "."));
                        $namePhoto= $objeto->getFoto();
                        move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Productos/$namePhoto");
                    } else $namePhoto= $objeto->getFoto();
                } else $namePhoto= $objeto->getFoto();
            } else $namePhoto= $objeto->getFoto();
        } else {
            if (isset($_FILES['foto'])){
                if ($_FILES['foto']['tmp_name']!=null){
                    $foto=$_FILES['foto']['name'];
                    $cutExt= substr($foto, strpos($foto, "."));
                    $namePhoto= $objeto->getId() . "_" . date("Y-m-d") . $cutExt;
                    move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Productos/$namePhoto");
                } else $namePhoto= $objeto->getFoto();
            } else $namePhoto= $objeto->getFoto();
        }
        //Fin Upload de foto
        //
        //Registro de datos para el producto
        $objeto->setIdPresentacion($idPresentacion);
        $objeto->setIdUnidadMedida($idUnidadMedida);
        $objeto->setIdProvedor($idProvedor);
        $objeto->setGrupo($grupo);
        $objeto->setStock($stock);
        $objeto->setStockMinimo($stockMinimo);
        $objeto->setStockMaximo($stockMaximo);
        $objeto->setPeso($peso);
        $objeto->setFoto($namePhoto);
        $objeto->setCosto($costo);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Producto('id', $id, null, null);
        $puc=$objeto->getPuc();//Elimar puc
        if ($objeto->getFoto()!=null || $objeto->getFoto()!=''){
            if (unlink("system/Uploads/Imgs/Productos/".rtrim($objeto->getFoto()))) $fileDelete=true;
            else $fileDelete=false;
        } else $fileDelete=true;
        $objeto->eliminar();
        $puc->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/productosCategoria.php&idCategoria=$idCategoria");