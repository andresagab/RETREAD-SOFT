<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 4/03/2019
 * Time: 09:14
 */
include_once dirname(__FILE__) . '/../../lib/php/Time.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';
if (count($_GET)>0) {
    foreach ($_GET as $item => $val) ${$item} = $val;
}
if (count($_POST)>0) {
    foreach ($_POST as $item => $val) ${$item} = $val;
}
$JSON = array();
$JSON['status'] = false;
$JSON['data'] = [];
$allData = json_decode(Llanta::getLlantasOrdenServicio(null, 'order by ll.fecharegistro desc', false));
$processData = Inspeccion_Inicial::getListaEnObjetos(null, null);

if (count($allData)>0 && count($processData)>0) {
    for ($i=0; $i<count($allData); $i++) {
        $allData[$i]->statusInspeccionInicial = false;
        $allData[$i]->procesofoto = '';
        $allData[$i]->procesoStatus = 'spr';
        $allData[$i]->procesoChecked = null;
        for ($j=0; $j<count($processData); $j++) {
            if ($allData[$i]->id===$processData[$j]->getIdLlanta()) {
                $allData[$i]->statusInspeccionInicial = true;
                $allData[$i]->procesofoto = $processData[$j]->getFoto();
                $allData[$i]->procesoStatus = $processData[$j]->getEstado();
                $allData[$i]->procesoNameStatus = $processData[$j]->getNombreEstado();
                $allData[$i]->procesoChecked = $processData[$j]->getChecked();
                $allData[$i]->procesoNameChecked = $processData[$j]->getNombreChecked();
                $j = count($processData);
            }
        }
        $object = new Inspeccion_Inicial(null, null, null, null);
        $object->setEstado($allData[$i]->procesoStatus);
        $object->setChecked($allData[$i]->procesoChecked);
        $allData[$i]->procesoNameStatus = $object->getNombreEstado();
        $allData[$i]->procesoNameChecked = $object->getNombreChecked();
        $allData[$i]->colorStatus = $object->getColorStatus($allData[$i]->fechainicioproceso);
    }
    $JSON['status'] = true;
    $JSON['data'] = $allData;
}
echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
