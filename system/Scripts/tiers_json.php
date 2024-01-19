<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 11/01/2024
 */

header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST");
header("Access-control-Allow-Headers: X-Requested-with");
header("Content-type: text/html; charset=utf-8");

include_once dirname(__FILE__) . '/../../lib/php/Time.php';
include_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Raspado.php';

if (count($_GET)>0) foreach ($_GET as $item => $val) ${$item} = $val;
if (count($_POST)>0) foreach ($_POST as $item => $val) ${$item} = $val;

$JSON = array();
$JSON['status'] = false;
$JSON['data'] = [];

//Cargamos los datos enviado por AJAX
$postdata= file_get_contents("php://input");
$request= json_decode($postdata);

//Validamos una posible petición de busqueda -> DirectSearh && valueSearch
if (isset($request->directSearch) && isset($request->valueSearch)) {
    //Validamos que los campos de $reques sean validos, posteriormente ejecutamos la busqueda por medio del método correspondiente, el parametro enviado es el rp o el número de orden buscado
    if ($request->directSearch && $request->valueSearch != null) $allData = json_decode(Llanta::getDirectSearch($request->valueSearch, false));
} else {
    //Por pedido del cliente se limito la carga de datos, ahora solo se listan los ultimos 100 registros existentes en la base de datos a partir de la fecha de generación de la consulta (fecha actual)
    $allData = json_decode(Llanta::getLlantasOrdenServicio("ll.id in (select idllanta from inspeccion_inicial where estado='prf' and checked='t')", 'order by ll.fecharegistro desc limit 100', false));
}

# custom SQL to load data of retread process
$sql= "select r.id, r.idinspeccion, r.idempleado, r.idpuestotrabajo, r.anchobanda, r.largobanda, r.cinturon, r.cinturoncantidad, r.profundidad, r.radio, r.estado, r.checked, r.foto, r.observaciones, r.fecharegistro, ll.fechainicioproceso, 
        ii.id as idpastprocess, ll.id as idllanta
        from raspado as r, inspeccion_inicial as ii, llanta as ll
        where r.idinspeccion=ii.id
        and ll.id=ii.idllanta order by ll.fecharegistro desc;";
# load data from db
$processData = Conector::ejecutarQuery($sql, null);

# load tiers id from previous process
$sql = "select idllanta, id as id_previous_process from inspeccion_inicial as ii where estado = 'prf' and checked is true;";
# load data from db
$previously_processed_tires = Conector::ejecutarQuery($sql, null);
# define compare data as false
$compareData = false;
# if  processData is an array
if (is_array($processData)) {
    # if processData have data, then set compare data as true
    if (count($processData)>0) $compareData = true;
}

# loop of tires loaded in $allData
for ($i=0; $i<count($allData); $i++) {
    $allData[$i]->statusProcess = false;
//    $allData[$i]->procesofoto = '';
    $allData[$i]->procesoStatus = 'spr';
    $allData[$i]->procesoChecked = null;
    $allData[$i]->fechainicioproceso = null;

    # define processed as false
    # $allData[$i]->processed = false;
    $allData[$i]->id_previous_process = null;

    if ($compareData) {
        for ($j=0; $j<count($processData); $j++) {
            if ($allData[$i]->id===$processData[$j]['idllanta']) {
                $allData[$i]->statusProcess = true;
//                $allData[$i]->procesofoto = $processData[$j]['foto'];
                $allData[$i]->procesoStatus = $processData[$j]['estado'];
                $allData[$i]->procesoChecked = $processData[$j]['checked'];
                $allData[$i]->fechainicioproceso = $processData[$j]['fechainicioproceso'];
                $allData[$i]->id_previous_process = $processData[$j]['idinspeccion'];
                break;
            }
        }
    }

    
    # if tier haven't id of previous process
    if (!$allData[$i]->id_previous_process)
    {
        # use loop to search tier id in previous processed tiers
        foreach($previously_processed_tires as $tier)
        {
            # if the proccess tier is equal to current loop tier
            if ($tier['idllanta'] === $allData[$i]->id)
            {
                # set id_previous_process
                $allData[$i]->id_previous_process = $tier['id_previous_process'];
                break;
            }
        }
    }
    # define current process object
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