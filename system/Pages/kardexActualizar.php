<?php
require_once dirname(__FILE__).'/../Clases/Producto.php';
require_once dirname(__FILE__).'/../Clases/Presentacion_Producto.php';
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Tercero.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        //print_r($_POST);die();
        $objeto=new Producto(null, null, null, null);
        $puc=new Puc(null, null, null, null);
        $codigo= Puc::getMaxId()+1;
        $puc->setCodigo($codigo);
        $puc->setNombre($nombre);
        $puc->setDescripcion($descripcion);
        $puc->setNivel("null");
        $puc->setFechaRegistro(date("Y-m-d H:i:s"));
        $puc->grabar();
        $puc=new Puc('codigo', "'$codigo'", null, null);
        
        $objeto->setCodPuc($puc->getCodigo());
        $objeto->setIdPresentacion($idPresentacion);
        $objeto->setIdUnidadMedida($idUnidadMedida);
        $objeto->setIdProvedor($idProvedor);
        $objeto->setStock($stock);
        $objeto->setStockMinimo($stockMinimo);
        $objeto->setStockMaximo($stockMaximo);
        $objeto->setFoto('null');
        $objeto->setTipo('0');
        $objeto->setCosto(0);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Producto('id', $id, null, null);
        $puc=$objeto->getPuc();
        //print_r($puc);die();
        //$puc->setCodigo($puc->getCodigo());
        $puc->setNombre($nombre);
        $puc->setDescripcion($descripcion);
        $puc->setNivel("null");
        $puc->modificar();
        
        //$objeto->setCodPuc($puc->getCodigo());
        $objeto->setIdPresentacion($idPresentacion);
        $objeto->setIdUnidadMedida($idUnidadMedida);
        $objeto->setIdProvedor($idProvedor);
        $objeto->setStock($stock);
        $objeto->setStockMinimo($stockMinimo);
        $objeto->setStockMaximo($stockMaximo);
        $objeto->setFoto('null');
        $objeto->setTipo(0);
        $objeto->setCosto(0);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Producto('id', $id, null, null);
        $puc=$objeto->getPuc();
        $objeto->eliminar();
        $puc->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/kardex.php");