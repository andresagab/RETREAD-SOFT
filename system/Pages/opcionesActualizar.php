<?php
require_once dirname(__FILE__).'/../Clases/Opcion.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Opcion(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->setRuta($ruta);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabarOpcion();
        break;
    case 'Modificar':
        $objeto=new Opcion('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->setRuta($ruta);
        $objeto->modificarOpcion();
        break;
    case 'Eliminar':
        $objeto=new Opcion('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/opciones.php");
?>
