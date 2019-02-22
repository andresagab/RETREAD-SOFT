<?php
require_once dirname(__FILE__).'/../Clases/Rechazo.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Rechazo(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Rechazo('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setObservaciones($observaciones);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Rechazo('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/rechazos.php");
