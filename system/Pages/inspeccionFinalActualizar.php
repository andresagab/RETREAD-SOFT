<?php
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
require_once dirname(__FILE__).'\..\Clases\Embandado.php';
require_once dirname(__FILE__).'\..\Clases\Vulcanizado.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Final.php';
require_once dirname(__FILE__).'\..\Clases\Terminacion.php';
require_once dirname(__FILE__).'\..\Clases\Servicio_Fin.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
$header=false;
switch ($accion){
    case 'preRegistro':
        if (isset($idVulcanizado)){
            $inspeccionFinal=new Inspeccion_Final('idVulcanizado', $idVulcanizado, null, null);
            if ($inspeccionFinal->getId()!=null && $inspeccionFinal->getId()!='') $header=true;
            else {
                $objeto=new Inspeccion_Final(null, null, null, null);
                $objeto->setIdVulcanizado($idVulcanizado);
                $objeto->setIdPuestoTrabajo('null');
                $objeto->setIdEmpleado('null');
                $objeto->setFoto(null);
                $objeto->setObservaciones(null);
                $objeto->setEstado('prs');
                $objeto->setChecked('f');
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                $objeto->grabar();
                $inspeccionFinal=new Inspeccion_Final('idVulcanizado', $idVulcanizado, null, null);
                if ($inspeccionFinal->getId()!=null && $inspeccionFinal->getId()!='') $header=true;
                else {
                    $inspeccionFinal->setIdVulcanizado($idVulcanizado);
                    $idLlanta=$inspeccionFinal->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
                }
            } 
        }
        break;
    case 'Registrar':
        $objeto=new Inspeccion_Final('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdEmpleado($idEmpleado);
        if (isset($_FILES['foto'])){
            if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/InspeccionFinal/")){
                if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/InspeccionFinal/", 0777)) $ok=true;
            }
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $id . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/InspeccionFinal/$namePhoto");
        } else $namePhoto="";
        $objeto->setFoto($namePhoto);
        $objeto->setObservaciones($observaciones);
        $objeto->setEstado("prs");
        $objeto->setChecked('f');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Inspeccion_Final('id', $id, null, null);
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta(), " and idProceso={$objeto->getNextId()} and proceso=9", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        }
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $idLlanta=$objeto->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        //2018-09-21 14:31 REGISTRO TERMINACION
        //if ($checked=='t') {
        $terminacion=new Terminacion(null, null, null, null);
        $terminacion->setIdInspeccionFinal($objeto->getId());
        $terminacion->setIdEmpleado($objeto->getIdEmpleado());
        $terminacion->setFoto("");
        $terminacion->setObservaciones("");
        $terminacion->setEstado("prf");
        $terminacion->setChecked($checked);
        $terminacion->setFechaRegistro(date("Y-m-d H:i:s"));
        $terminacion->grabar();
        //Registro de finalizacion de proceso de rencauche
        $inspeccionFinal=$terminacion->getInspeccionFinal();
        if ($inspeccionFinal->getId()!=null && $inspeccionFinal->getId()!=''){
            $servicioFin=new Servicio_Fin(null, null, null, null);
            $servicioFin->setIdLlanta($idLlanta);
            if ($servicioFin->getIdLlanta()!=null && $servicioFin->getIdLlanta()!=''){
                $servicioFin->setEstado($checked);
                $servicioFin->setObservaciones("");
                $servicioFin->setFechaRegistro(date("Y-m-d H:i:s"));
                $servicioFin->grabar();
            }
        }
        $idLlanta=$terminacion->getInspeccionFinal()->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        //END 2018-09-21 14:31
        //}
        break;
    case 'Eliminar':
        
        break;
}
if ($header) header("Location: principal.php?CON=system/Pages/inspeccionFinalFormulario.php&id={$inspeccionFinal->getId()}");
else header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");