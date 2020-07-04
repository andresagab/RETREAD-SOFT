<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 4/03/2019
 * Time: 09:14
 */

header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST");
header("Access-control-Allow-Headers: X-Requested-with");
header("Content-type: text/html; charset=utf-8");

include_once dirname(__FILE__) . '/../../lib/php/Time.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';

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
    $allData = json_decode(Llanta::getLlantasOrdenServicio(null, 'order by ll.fecharegistro desc limit 100', false));
}
//Cargamos todos los registros de inspección inicial
$processData = Inspeccion_Inicial::getListaEnObjetos(null, null);

//Configuramos todos los registros generados en las consultas
if (count($allData)>0 && count($processData)>0) {
    for ($i=0; $i<count($allData); $i++) {
        $allData[$i]->statusInspeccionInicial = false;
        $allData[$i]->procesofoto = '';
        $allData[$i]->procesoStatus = 'spr';
        $allData[$i]->procesoChecked = null;
        for ($j=0; $j<count($processData); $j++) {
            //Validamos si la llanta cargada ya tiene un registro en inspección inicial
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
