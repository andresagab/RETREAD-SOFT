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
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
require_once dirname(__FILE__).'\..\Clases\Servicio_Fin.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
switch ($accion){
    case 'Registrar':
        $objeto=new Terminacion(null, null, null, null);
        $objeto->setIdInspeccionFinal($idInspeccionFinal);
        $objeto->setIdEmpleado($idEmpleado);
        if (isset($_FILES['foto'])){
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= Terminacion::getNextId(). "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Terminacion/$namePhoto");
        } else $namePhoto="";
        $objeto->setFoto($namePhoto);
        $objeto->setObservaciones($observaciones);
        $objeto->setEstado("prf");
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getInspeccionFinal()->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta(), " and idProceso={$objeto->getNextId()} and proceso=10", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        }
        $objeto->setChecked($checked);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        //Registro de finalizacion de proceso de rencauche
        $inspeccionFinal=$objeto->getInspeccionFinal();
        if ($inspeccionFinal->getId()!=null && $inspeccionFinal->getId()!=''){
            $servicioFin=new Servicio_Fin(null, null, null, null);
            $servicioFin->setIdLlanta($inspeccionFinal->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta());
            if ($servicioFin->getIdLlanta()!=null && $servicioFin->getIdLlanta()!=''){
                $servicioFin->setEstado($checked);
                $servicioFin->setObservaciones("");
                $servicioFin->setFechaRegistro(date("Y-m-d H:i:s"));
                $servicioFin->grabar();
            }
        }
        $idLlanta=$objeto->getInspeccionFinal()->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        //Fin Registro de finalizacion de proceso de rencauche
        break;
}
header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");