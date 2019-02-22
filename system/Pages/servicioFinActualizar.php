<?php
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio_Fin.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'FinalizarXRechazo':
        $llanta=new Llanta('id', $id, null, null);
        if ($llanta->getId()!=null && $llanta->getId()!=''){
            $objeto=new Servicio_Fin(null, null, null, null);
            $objeto->setIdLlanta($id);
            $objeto->setEstado('f');
            $objeto->setObservaciones('');
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->grabar();
        }
        break;
}
header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$id");