<?php
require_once dirname(__FILE__).'/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Marca_Llanta.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Referencia_Tipo_Llanta(null, null, null, null);
        $objeto->setIdTipoLlanta($idGravadoLlanta);
        $objeto->setIdMarcaLlanta($idMarcaLlanta);
        $objeto->setReferencia($referencia);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Referencia_Tipo_Llanta('id', $id, null, null);
        $objeto->setIdTipoLlanta($idGravadoLlanta);
        $objeto->setIdMarcaLlanta($idMarcaLlanta);
        $objeto->setReferencia($referencia);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Referencia_Tipo_Llanta('id', $id, null, null);
        $objeto->eliminar();
        break;
}
$idGravadoLlanta=$objeto->getIdTipoLlanta();
header("Location: principal.php?CON=system/Pages/referenciasGravado.php&id=$idGravadoLlanta");
