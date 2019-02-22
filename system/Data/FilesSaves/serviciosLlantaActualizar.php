<?php
require_once dirname(__FILE__) . '/../Clases/Servicio.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
//print_r($_POST);die();
if (isset($urgente)) $urgente='t';
else $urgente='f';
switch ($accion){
    case 'Adicionar':
        $objeto=new Servicio(null, null, null, null);
        $objeto->setIdLlanta($idLlanta);
        $objeto->setIdVendedor($idVendedor);
        $objeto->setOs($os);
        $objeto->setIdDisenoSolicitado($idDisenoSolicitado);
        $objeto->setIdDisenoFinal($idDisenoFinal);
        $objeto->setUrgente($urgente);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaEntrega($fechaEntrega);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        $servicio=new Servicio('idLlanta', $idLlanta, null, null);
        $ruta='procesoServicio.php&idServicio='.$servicio->getId();
        break;
    
    case 'Modificar':
        $objeto=new Servicio('id', $id, null, null);
        $objeto->setIdLlanta($idLlanta);
        $objeto->setIdVendedor($idVendedor);
        $objeto->setOs($os);
        $objeto->setIdDisenoSolicitado($idDisenoSolicitado);
        $objeto->setIdDisenoFinal($idDisenoFinal);
        $objeto->setUrgente($urgente);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaEntrega($fechaEntrega);
        $objeto->modificar();
        break;
    
    case 'Eliminar':
        $objeto=new Servicio('id', $id, null, null);
        $objeto->eliminar();
        break;
}
//header("Location: principal.php?CON=system/Pages/serviciosLlanta.php&idLlanta=$idLlanta");
//header("Location: principal.php?CON=system/Pages/llantas.php");
header("Location: principal.php?CON=system/Pages/$ruta");