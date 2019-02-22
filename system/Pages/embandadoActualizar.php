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
        if (isset($idCorteBanda)){
            $embandado=new Embandado('idCorteBanda', $idCorteBanda, null, null);
            if ($embandado->getId()!=null && $embandado->getId()!='') $header=true;
            else {
                $objeto=new Embandado(null, null, null, null);
                $objeto->setIdCorteBanda($idCorteBanda);
                $objeto->setIdPuestoTrabajo('null');
                $objeto->setIdEmpleado('null');
                $objeto->setIdGravado('null');
                $objeto->setAnchoBanda(0);
                $objeto->setLargoBanda(0);
                $objeto->setEmpates('null');
                $objeto->setFoto(null);
                $objeto->setObservaciones(null);
                $objeto->setEstado('prs');
                $objeto->setChecked('f');
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                $objeto->grabar();
                $embandado=new Embandado('idCorteBanda', $idCorteBanda, null, null);
                if ($embandado->getId()!=null && $embandado->getId()!='') $header=true;
                else {
                    $embandado->setIdCorteBanda($idCorteBanda);
                    $idLlanta=$embandado->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
                }
            } 
        }
        break;
    case 'Registrar':
        $objeto=new Embandado('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setIdGravado($objeto->getCorteBanda()->getPreparacion()->getRaspado()->getInspeccion()->getLlanta()->getIdGravado());
        if (isset($_FILES['foto'])){
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $objeto->getId() . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Embandado/$namePhoto");
        } else $namePhoto="";
        $objeto->setAnchoBanda($objeto->getCorteBanda()->getPreparacion()->getRaspado()->getAnchoBanda());
        $objeto->setLargoBanda($objeto->getCorteBanda()->getPreparacion()->getRaspado()->getLargoBanda());
        $empates=$objeto->getCorteBanda()->getEmpates();
        if (strtolower($empates)=='pendiente') $empates=0;
        $objeto->setEmpates($empates);
        $objeto->setFoto($namePhoto);
        $objeto->setEstado("prs");
        $objeto->setChecked("f");
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Embandado('id', $id, null, null);
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta(), " and idProceso={$objeto->getId()} and proceso=7", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        }
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $idLlanta=$objeto->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        break;
    case 'Eliminar':
        
        break;
}
if ($header) header("Location: principal.php?CON=system/Pages/embandadoFormulario.php&id={$embandado->getId()}");
else header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");