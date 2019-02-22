<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Soat.php';
require_once dirname(__FILE__).'/../Clases/Soat.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Soat(null, null, null, null);
        $objeto->setIdVehiculo($idVehiculo);
        $objeto->setFechaInicioVigencia($fechaInicioVigencia);
        $objeto->setFechaFinVigencia($fechaFinVigencia);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Soat('id', $id, null, null);
        $objeto->setFechaInicioVigencia($fechaInicioVigencia);
        $objeto->setFechaFinVigencia($fechaFinVigencia);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Soat('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/soatsVehiculo.php&id=$idVehiculo&idCliente=$idCliente");
