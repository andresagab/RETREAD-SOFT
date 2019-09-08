<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 29/07/2019
 * Time: 22:30
 */
include_once dirname(__FILE__) . '/../../lib/php/Time.php';
include_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Raspado.php';
require_once dirname(__FILE__) . '/../Clases/Preparacion.php';
if (count($_GET)>0) {
    foreach ($_GET as $item => $val) ${$item} = $val;
}
if (count($_POST)>0) {
    foreach ($_POST as $item => $val) ${$item} = $val;
}
$JSON = array();
$JSON['status'] = false;
$JSON['data'] = [];
$allData = json_decode(Llanta::getLlantasOrdenServicio("ll.id in (select idllanta from inspeccion_inicial where estado='prf' and checked='t' and id in (select idinspeccion from raspado where estado='prf' and checked='t'))", 'order by ll.fecharegistro desc', false));
$sql= "select p.id, p.idempleado, p.idpuestotrabajo, p.idraspado, p.estado, p.checked, p.foto, p.observaciones, p.fecharegistro, p.fechainicioproceso, 
       r.id as idpastprocess, r.fecharegistro as fechafinpastprocces, 
       ll.id as idllanta
        from preparacion as p, raspado as r, inspeccion_inicial as ii, llanta as ll
        where p.idraspado=r.id
        and r.idinspeccion=ii.id
        and ll.id=ii.idllanta order by ll.fecharegistro desc;";
$processData = Conector::ejecutarQuery($sql, null);
$compareData = false;
if (is_array($processData)) {
    if (count($processData)>0) $compareData = true;
}
for ($i=0; $i<count($allData); $i++) {
    $allData[$i]->statusProcess = false;
//    $allData[$i]->procesofoto = '';
    $allData[$i]->procesoStatus = 'spr';
    $allData[$i]->procesoChecked = null;
    $allData[$i]->fechainicioproceso = null;
    $allData[$i]->fechafinpastprocces = null;
    if ($compareData) {
        for ($j=0; $j<count($processData); $j++) {
            if ($allData[$i]->id === $processData[$j]['idllanta']) {
                $allData[$i]->statusProcess = true;
//                $allData[$i]->procesofoto = $processData[$j]['foto'];
                $allData[$i]->procesoStatus = $processData[$j]['estado'];
                $allData[$i]->procesoChecked = $processData[$j]['checked'];
                $allData[$i]->fechainicioproceso = $processData[$j]['fechainicioproceso'];
                $allData[$i]->fechafinpastprocces = $processData[$j]['fechafinpastprocces'];
                //$j = count($processData);
                break;
            }
        }
    }
    $object = new Preparacion(null, null, null, null);
    $object->setEstado($allData[$i]->procesoStatus);
    $object->setChecked($allData[$i]->procesoChecked);
    $allData[$i]->procesoNameStatus = $object->getNombreEstado();
    $allData[$i]->procesoNameChecked = $object->getNombreChecked();
    $allData[$i]->colorStatus = getColorStatusProcess($allData[$i]->fechainicioproceso, $object->getEstado(), 90);
}
$JSON['status'] = true;
$JSON['data'] = $allData;
//$JSON['data'] = sortJSON(false, $allData, 'fechafinpastprocces'); AL ORDENAR LOS REGISTRO SE DEMORA LA CARGA DE LOS DATOS EN UN 60% DE 11 SEGUNDOS PARA MAS DE 5000 DATOS SE PASO A 42 SEGUNDOS
echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
