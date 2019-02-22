<?php
require_once dirname(__FILE__).'/../Clases/Gravado_Llanta.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Gravado_Llanta(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Gravado_Llanta('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Gravado_Llanta('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/gravadosLlanta.php");
