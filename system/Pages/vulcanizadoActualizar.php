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
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
$header=FALSE;
switch ($accion){
    case 'preRegistro':
        if (isset($idEmbandado)){
            $vulcanizado=new Vulcanizado('idEmbandado', $idEmbandado, null, null);
            if ($vulcanizado->getId()!=null && $vulcanizado->getId()!='') $header=true;
            else {
                $objeto=new Vulcanizado(null, null, null, null);
                $objeto->setIdEmbandado($idEmbandado);
                $objeto->setIdPuestoTrabajo('null');
                $objeto->setIdEmpleado('null');
                $objeto->setIdEnvelope('null');
                $objeto->setMetodo(0);
                $objeto->setIdTubo('null');
                $objeto->setIdNeumatico('null');
                $objeto->setFoto(null);
                $objeto->setObservaciones(null);
                $objeto->setEstado('prs');
                $objeto->setChecked('f');
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                $objeto->grabar();
                $vulcanizado=new Vulcanizado('idEmbandado', $idEmbandado, null, null);
                if ($vulcanizado->getId()!=null && $vulcanizado->getId()!='') $header=true;
                else {
                    $vulcanizado->setIdEmbandado($idEmbandado);
                    $idLlanta=$vulcanizado->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
                }
            } 
        }
        break;
    case 'Registrar':
        $objeto=new Vulcanizado('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setMetodo($metodo);
        if (isset($_FILES['foto'])){
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $objeto->getId() . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Vulcanizado/$namePhoto");
        } else $namePhoto="";
        $objeto->setIdEnvelope("null");
        $objeto->setIdTubo("null");
        $objeto->setIdNeumatico("null");
        $objeto->setFoto($namePhoto);
        $objeto->setEstado("prs");
        $objeto->setChecked("f");
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->setFechaFinalizacion("null");
        $idLlanta=$objeto->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Vulcanizado('id', $id, null, null);
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta(), " and idProceso={$objeto->getId()} and proceso=8", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        }
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $objeto->setFechaFinalizacion(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        break;
    case 'Eliminar':
        
        break;
}
if ($header) header("Location: principal.php?CON=system/Pages/vulcanizadoFormulario.php&id={$vulcanizado->getId()}");
else header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");