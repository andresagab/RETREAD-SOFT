<?php
require_once dirname(__FILE__).'/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Dimension_Referencia.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
switch ($accion){
    case 'Adicionar':
        $objeto=new Dimension_Referencia(null, null, null, null);
        $objeto->setIdReferenciaTipoLlanta($idReferenciaGravado);
        $objeto->setBase($base);
        $objeto->setProfundidad($profundidad);
        $objeto->setPeso($peso);
        $objeto->setLargo($largo);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        break;
    case 'Modificar':
        $objeto=new Dimension_Referencia('id', $id, null, null);
        $objeto->setIdReferenciaTipoLlanta($idReferenciaGravado);
        $objeto->setBase($base);
        $objeto->setProfundidad($profundidad);
        $objeto->setPeso($peso);
        $objeto->setLargo($largo);
        $objeto->setObservaciones($observaciones);
        $objeto->modificar();
        break;
    case 'Eliminar':
        $objeto=new Dimension_Referencia('id', $id, null, null);
        $objeto->eliminar();
        break;
}
$idReferenciaGravado=$objeto->getIdReferenciaTipoLlanta();
header("Location: principal.php?CON=system/Pages/dimensionesReferencia.php&id=$idReferenciaGravado");
