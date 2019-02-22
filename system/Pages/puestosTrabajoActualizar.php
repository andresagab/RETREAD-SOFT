<?php
require_once dirname(__FILE__).'/../Clases/Puesto_Trabajo.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Puesto_Trabajo(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setProceso($proceso);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Puesto_Trabajo('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setProceso($proceso);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Puesto_Trabajo('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/puestosTrabajo.php");
