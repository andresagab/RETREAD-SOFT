<?php
require_once dirname(__FILE__).'/../Clases/Unidad_Medida.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Unidad_Medida(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->setSigla($sigla);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Unidad_Medida('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->setSigla($sigla);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Unidad_Medida('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/unidadesMedida.php");
