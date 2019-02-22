<?php
require_once dirname(__FILE__) . '/../Clases/Solicitud_Eliminar_Llanta.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
//print_r($_POST);die();
switch ($accion){
    case 'Adicionar':
        $objeto=new Solicitud_Eliminar_Llanta(null, null, null, null);
        $objeto->setIdLlanta($idLlanta);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setMotivo($motivo);
        $objeto->setLlantaJSON($llantaJSON);
        $objeto->setEstado('f');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    
    case 'Modificar':
        $objeto=new Solicitud_Eliminar_Llanta('id', $id, null, null);
        $objeto->setIdLlanta($idLlanta);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setMotivo($motivo);
        $objeto->setLlantaJSON($llantaJSON);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->modificar();
        break;
    
    case 'Eliminar':
        $objeto=new Solicitud_Eliminar_Llanta('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/solicitudesEliminarLlanta.php");