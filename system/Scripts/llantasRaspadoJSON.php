<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 4/03/2019
 * Time: 09:14
 */
include_once dirname(__FILE__) . '/../../lib/php/Time.php';
include_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
//require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/Raspado.php';
if (count($_GET)>0) {
    foreach ($_GET as $item => $val) ${$item} = $val;
}
if (count($_POST)>0) {
    foreach ($_POST as $item => $val) ${$item} = $val;
}
$JSON = array();
$JSON['status'] = false;
$JSON['data'] = [];
//$allData = json_decode(Llanta::getLlantasOrdenServicio(null, 'order by ll.fecharegistro desc', false));
$allData = json_decode(Llanta::getLlantasOrdenServicio("ll.id in (select idllanta from inspeccion_inicial where estado='prf' and checked='t')", 'order by ll.fecharegistro desc', false));
//$processData = json_decode(Llanta::getLlantasOrdenServicio(null, 'order by ll.fecharegistro desc', false));
$sql= "select r.id, r.idempleado, r.idpuestotrabajo, r.anchobanda, r.largobanda, r.cinturon, r.cinturoncantidad, r.profundidad, r.radio, r.estado, r.checked, r.foto, r.observaciones, r.fecharegistro, r.fechainicioproceso, 
        ii.id as idpastprocess, ll.id as idllanta
        from raspado as r, inspeccion_inicial as ii, llanta as ll
        where r.idinspeccion=ii.id
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
    if ($compareData) {
        for ($j=0; $j<count($processData); $j++) {
            if ($allData[$i]->id===$processData[$j]['idllanta']) {
                $allData[$i]->statusProcess = true;
//                $allData[$i]->procesofoto = $processData[$j]['foto'];
                $allData[$i]->procesoStatus = $processData[$j]['estado'];
                $allData[$i]->procesoChecked = $processData[$j]['checked'];
                $allData[$i]->fechainicioproceso = $processData[$j]['fechainicioproceso'];
                $j = count($processData);
            }
        }
    }
    $object = new Raspado(null, null, null, null);
    $object->setEstado($allData[$i]->procesoStatus);
    $object->setChecked($allData[$i]->procesoChecked);
    $allData[$i]->procesoNameStatus = $object->getNombreEstado();
    $allData[$i]->procesoNameChecked = $object->getNombreChecked();
    $allData[$i]->colorStatus = getColorStatusProcess($allData[$i]->fechainicioproceso, $object->getEstado(), 480);
}
$JSON['status'] = true;
$JSON['data'] = $allData;
echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
