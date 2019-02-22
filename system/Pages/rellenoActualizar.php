<?php
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
$header=false;
switch ($accion){
    case 'preRegistro':
        if (isset($idCementado)){
            $relleno=new Relleno('idCementado', $idCementado, null, null);
            if ($relleno->getId()!=null && $relleno->getId()!='') $header=true;
            else {
                $objeto=new Relleno(null, null, null, null);
                $objeto->setIdCementado($idCementado);
                $objeto->setIdPuestoTrabajo('null');
                $objeto->setIdEmpleado('null');
                $objeto->setEmpates('null');
                $objeto->setFoto(null);
                $objeto->setObservaciones(null);
                $objeto->setEstado('prs');
                $objeto->setChecked('f');
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                $objeto->grabar();
                $relleno=new Relleno('idCementado', $idCementado, null, null);
                if ($relleno->getId()!=null && $relleno->getId()!='') $header=true;
                else $idLlanta=$relleno->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
            }
        }
        break;
    case 'Registrar':
        $objeto=new Relleno('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setEmpates("null");
        if (isset($_FILES['foto'])){
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $objeto->getId() . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Relleno/$namePhoto");
        } else $namePhoto="";
        $objeto->setFoto($namePhoto);
        $objeto->setObservaciones($observaciones);
        $objeto->setChecked('f');
        $objeto->setEstado('prs');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Relleno('id', $id, null, null);
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta(), " and idProceso={$objeto->getId()} and proceso=5", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
            if (isset($idPreparacion)){
                $CB=new Corte_Banda("idPreparacion", $idPreparacion, null, null);
                if ($CB->getId()!=null){
                    $CB->setIdRelleno($objeto->getId());
                    $CB->addIdRelleno();
                }
            }
        }
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $idLlanta=$objeto->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        break;
    case 'Eliminar':
        
        break;
}
//die();
if ($header) header("Location: principal.php?CON=system/Pages/rellenoFormulario.php&id={$relleno->getId()}");
else header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");