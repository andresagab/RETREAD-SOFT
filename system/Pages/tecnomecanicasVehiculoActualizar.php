<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Vehiculo.php';
require_once dirname(__FILE__).'/../Clases/Revision_Tecnomecanica.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Revision_Tecnomecanica(null, null, null, null);
        $objeto->setIdVehiculo($idVehiculo);
        $objeto->setFechaExpedicion($fechaExpedicion);
        $objeto->setFechaFinVigencia($fechaFinVigencia);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Revision_Tecnomecanica('id', $id, null, null);
        $objeto->setFechaExpedicion($fechaExpedicion);
        $objeto->setFechaFinVigencia($fechaFinVigencia);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Revision_Tecnomecanica('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/tecnomecanicasVehiculo.php&id=$idVehiculo&idCliente=$idCliente");
