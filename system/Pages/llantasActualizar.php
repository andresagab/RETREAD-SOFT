<?php
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Gravado_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if (isset($urgente)) $urgente='t';
else $urgente='f';
switch ($accion){
    case 'Modificar':
        $objeto=new Llanta('id', $id, null, null);
        //if ($idTipo=="#") $idTipo="null";
        if ($idMarca=="#") $idMarca="null";
        if ($idGravado=="#") $idGravado="null";
        if ($idReferenciaOriginal=="#") $idReferenciaOriginal="null";
        if ($idReferenciaSolicitada=="#") $idReferenciaSolicitada="null";
        if ($idDimension=="#") $idDimension="null";
        $objeto->setIdMarca($idMarca);
        $objeto->setIdGravado($idGravado);
        $objeto->setSerie($serie);
        $objeto->setIdReferenciaOriginal($idReferenciaOriginal);
        $objeto->setIdReferenciaSolicitada($idReferenciaSolicitada);
        $objeto->setIdDimension($idDimension);
        $objeto->setUrgente($urgente);
        $objeto->setObservaciones($observaciones);
        $objeto->modificar();
        
        break;
    case 'Eliminar':
        $objeto=new Llanta('id', $id, null, null);
        $objeto->eliminar();
        break;
}
header("Location: principal.php?CON=system/Pages/ordenesServicioFormulario.php&id={$objeto->getIdServicio()}");