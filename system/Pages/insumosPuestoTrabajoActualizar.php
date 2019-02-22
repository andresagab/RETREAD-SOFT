<?php
require_once dirname(__FILE__).'/../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
require_once dirname(__FILE__).'/../Clases/Insumo_Puesto_Trabajo.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
//print_r($_POST);
//echo "<br>";
//print_r($_FILES);
//die();
switch ($accion){
    case 'Adicionar':
        //Validaciones de variables
        if ($idInsumo=="#") $idInsumo='null';
        //Fin Validaciones de variables
        $objeto=new Insumo_Puesto_Trabajo(null, null, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdInsumo($idInsumo);
        $objeto->setUsuario($usuario);
        $objeto->setCantidad($cantidad);
        $objeto->setEstado('t');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        //Validaciones de variables
        if ($idInsumo=="#") $idInsumo='null';
        //Fin Validaciones de variables
        $objeto=new Insumo_Puesto_Trabajo('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdInsumo($idInsumo);
        $objeto->setUsuario($usuario);
        $objeto->setCantidad($cantidad);
        $objeto->setEstado('t');
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Insumo_Puesto_Trabajo('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/insumosPuestoTrabajo.php&idPT=$idPT");
