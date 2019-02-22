<?php
require_once dirname(__FILE__).'/../Clases/Tipo_Servicio.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Tipo_Servicio(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Tipo_Servicio('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setObservaciones($observaciones);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Tipo_Servicio('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/tiposServicio.php");
