<?php
header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST");
header("Access-control-Allow-Headers: X-Requested-with");
header("Content-type: text/html; charset=utf-8");
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Usuario.php';
require_once dirname(__FILE__) . '/../Clases/Usuario_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Persona.php';
require_once dirname(__FILE__) . '/../Clases/Telefono_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Rol.php';
require_once dirname(__FILE__) . '/../Clases/Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Preparacion.php';
require_once dirname(__FILE__) . '/../Clases/Corte_Banda.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso_Detalle.php';
date_default_timezone_set("America/Bogota");
//SD: Solicitud desconocida
//IR: Invalid request -> Solicitud invalida
//ID: Incomplete data -> Datos incompletos
//SDE:SAVE DATA ERROR -> Error al guardar los datos
//OK: DATOS GUARDADOS EXITOSAMENTE
if (isset($_GET['method'])) $method = $_GET['method'];
else if (isset($_POST['method'])) $method = $_POST['method'];
else $method = null;

switch ($method) {
        case 'updateCorteBanda':
            foreach ($_POST as $key => $value) ${$key}=$value;
            foreach ($_GET as $key => $value) ${$key}=$value;
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            if (isset($chkEmpates)) {
                if ($chkEmpates==1){
                    if (isset($empates) && isset($idProceso)) {
                        $object = new Corte_Banda('id', $idProceso, null, null);
                        if ($object->getId()!=null) {
                            if ($empates!=$object->getEmpates()) {
                                if ($observaciones!=null) $object->setObservaciones($observaciones);
                                $object->setEmpates($empates);
                                if ($object->updateOnlyEmpatesObs()) echo 'OK';
                                else echo 'SDE';
                            } else echo 'OK';
                        } else echo 'ID';
                    } else echo 'ID';
                } else {
                    $finalResponse = 'SDE';
                    if (isset($idProceso) && isset($proceso)) {
                        $objects = Uso_Insumo_Proceso_Detalle::getListaEnObjetos("idusoinsumoproceso in (select id from uso_insumo_proceso where idproceso=$idProceso and proceso=$proceso)", "order by fecharegistro asc");
                        if (count($objects)>=2) {
                            for ($i=0; $i<count($objects)-1; $i++) $objects[$i]->eliminar();
                            $finalResponse = 'OK';
                        } else $finalResponse = 'OK';
                        $corteBanda = new Corte_Banda('id', $idProceso, null, null);
                        if ($corteBanda->getId()!=null) {
                            if (isset($_FILES['file'])){
                                if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/")){
                                    if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/", 0777)) $ok = true;
                                }
                                if (file_exists(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/{$corteBanda->getFoto()}")) {
                                    try {
                                        unlink(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/{$corteBanda->getFoto()}");
                                    } catch (Exception $e) {echo $e->getMessage();}
                                }
                                move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/{$corteBanda->getFoto()}");
                            } else $finalResponse = "ID";
                            $corteBanda->setEmpates($empates);
                            $corteBanda->setObservaciones($observaciones);
                            if ($corteBanda->updateOnlyEmpatesObs()) $finalResponse = 'OK';
                            else $finalResponse = 'SDE';
                        } else $finalResponse = "ID";
                    } else $finalResponse = 'ID';
                    echo $finalResponse;
                }
            } else echo 'ID';
            break;
    default: echo 'SD';break;
}