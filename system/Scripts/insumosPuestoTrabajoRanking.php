<?php
/*
 * Created by PhpStorm.
 * User: Andres Angulo
 * Date: 07/26/2019
 * Time: 16:19
 *
 * ESTE ARCHIVO SE ENCARGA DE CARGAR TODOS LOS INSUMOS DISPONIBLES EN UN DETERMINADO PUESTO DE TRABAJO PARA LUEGO
 * ORDENARLOS DE ACUERDO AL MAS O MENOS USADO, POR ULTIMO SE GENERA UN OBJETO JSON CON TODOS LOS DATOS OBTENIDOS.
 *
 * NOTA: ESTE ARCHIVO SOLO ACEPTA PETICIONES VIA 'GET'
 *
 * */
/*RESOURCES*/
include_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso_Detalle.php';
/*END RESOURCES*/
/*
 * COMPROBAMOS LOS VALORES ALMACENADOS EN '$_GET'
 * TRUE = CONTINUA EL PROCESO
 * FALSE = SE REDIRECCIONA A PÁGINA 'unknowData.php'
*/
$validData = validResourcesVal($_GET);
if ($validData){
    /*DECLARACIÓN DE VARIABLES GLOBALES*/
    foreach ($_GET as $item => $val) ${$item} = $val;
    if (!isset($extras)) $extras = false;
    if (!isset($typeSort)) $typeSort = 3;
    if (!isset($numberProcess)) {
        $typeSort = 3;
        $numberProcess = null;
    }
    if (!isset($asc)) $asc = false;
    $JSON = array();
    /*END DECLARACIÓN DE VARIABLES GLOBALES*/
    if (isset($idPuestoTrabajo)){
        /*
         * CARGAMOS TODOS LOS REGISTROS DEL PUESTO DE TRABAJO
         * CARGAMOS TODOS LOS USOS DE CADA INSUMO DEPENDIENDO DEL ORDEN DESEADO
         * */
        $insumosPuestoTrabajo = json_decode(Insumo_Puesto_Trabajo::getInsumosPuestoTrabajoSQLJSON($idPuestoTrabajo, $extras));
        $element = array();
        for ($i = 0; $i < count($insumosPuestoTrabajo); $i++){
            $object = new Insumo_Puesto_Trabajo(null, null, null, null);
            $object->setId($insumosPuestoTrabajo[$i]->id);
            $object->setIdInsumo($insumosPuestoTrabajo[$i]->idinsumo);
            foreach ($insumosPuestoTrabajo[$i] as $item => $val) {
                $element["$item"] = $val;
            }
            $element["totalUsages"] = $object->getNumberUsages($typeSort, $numberProcess);
            array_push($JSON, $element);
        }
        $JSON = sortArray($asc, $JSON, "totalUsages");
    } else $validData = false;
}
if (!$validData) header('Location: principal.php?CON=system/pages/unknowData.php');
echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
?>