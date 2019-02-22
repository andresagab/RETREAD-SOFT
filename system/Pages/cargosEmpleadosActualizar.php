<?php
require_once dirname(__FILE__).'/../Clases/Cargo_Empleado.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Cargo_Empleado(null, null, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Cargo_Empleado('id', $id, null, null);
        $objeto->setNombre($nombre);
        $objeto->setDescripcion($descripcion);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Cargo_Empleado('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/cargosEmpleado.php");
?>
