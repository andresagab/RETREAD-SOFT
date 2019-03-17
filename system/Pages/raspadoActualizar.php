<?php
include_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
require_once dirname(__FILE__).'\..\Clases\Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__).'\..\Clases\Uso_Insumo_Proceso_Detalle.php';
require_once dirname(__FILE__).'/../Clases/Servicio_Fin.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($cinturon)) {
    $cinturon = 't';
} else {
    $cinturon = 'f';
    $cinturonCantidad = 0;
}
if(isset($checked)) $checked = 't';
else $checked = 'f';
$ok = false;
//print_r($_GET);
//print_r($_POST);
//print_r($_FILES);
//die();
switch ($accion){
    case 'initProcess':
        if (isset($idLlanta) && isset($idPastProcess)) {
            $objeto = new Raspado(null, null, null, null);
            $objeto->setIdInspeccion($idPastProcess);
            $objeto->setIdEmpleado('null');
            $objeto->setAnchoBanda(0);
            $objeto->setLargoBanda(0);
            $objeto->setCinturon('f');
            $objeto->setCinturonCantidad(0);
            $objeto->setProfundidad('null');
            $objeto->setRadio('null');
            $objeto->setEstado('prs');
            $objeto->setChecked('f');
            $objeto->setFoto(null);
            $objeto->setObservaciones(null);
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->setFechaInicioProceso(date("Y-m-d H:i:s"));
            $objeto->grabar();
            $ok = true;
        }
        break;
    case 'Registrar':
        $objeto = new Raspado('id', $id, null, null);
        $objeto->setIdEmpleado($idEmpleado);
        if (!isset($idPuestoTrabajo)) $idPuestoTrabajo = getIdPuestoTrabajoProceso($objeto->getId(), 1);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setAnchoBanda($anchoBanda);
        $objeto->setLargoBanda($largoBanda);
        $objeto->setCinturon($cinturon);
        $objeto->setCinturonCantidad($cinturonCantidad);
        $objeto->setProfundidad($profundidad);
        $objeto->setRadio($radio);
        $objeto->setEstado('prf');
        $objeto->setChecked($checked);
        if (!isset($idLlanta)) $idLlanta = $objeto->getInspeccion()->getIdLlanta();
        if ($idLlanta!=null) {
            if ($checked==='t'){//Si el proceso fue aprobado se debe eliminar cualquier registro de rechazo, para asi suprimir todos los registros residuales que se hayan hecho por error
                $rechazoLlanta = new Rechazo_Llanta('idLlanta', $idLlanta, " and idProceso={$objeto->getId()} and proceso=1", null);
                if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                    $rechazoLlanta->eliminarDetalles();
                    $rechazoLlanta->eliminar();
                }
            } else {
                $llanta = new Llanta('id', $idLlanta, null, null);
                if ($llanta->getId()!=null && $llanta->getId()!=''){
                    $servicioFin = new Servicio_Fin(null, null, null, null);
                    $servicioFin->setIdLlanta($llanta->getId());
                    $servicioFin->setEstado('f');
                    $servicioFin->setObservaciones('');
                    $servicioFin->setFechaRegistro(date("Y-m-d H:i:s"));
                    $servicioFin->grabar();
                }
            }
        }
        $objeto->setFoto(uploadFile($_FILES, '/../../system/Uploads/Imgs/Raspado/', $objeto->getId()));
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->finalizar();
        $ok = true;
        break;
}
if ($ok) header("Location: principal.php?CON=system/Pages/raspadoFormulario.php&id=$idLlanta");
else header("Location: principal.php?CON=system/Pages/unknowData.php");