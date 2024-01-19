<?php
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($cinturon)) {
    $cinturon='t';
} else {
    $cinturon='f';
    $cinturonCantidad=0;
}
if(isset($checked)) $checked='t';
else $checked='f';
$header=false;
switch ($accion){
    case 'preRegistro':
        if (isset($idInspeccion)){
            $inspeccion=new Inspeccion_Inicial('id', $idInspeccion, null, null);
            $raspado=new Raspado('idInspeccion', $idInspeccion, null, null);
            if ($raspado->getId()!=null && $raspado->getId()!='') $header=true;
            else {
                $objeto=new Raspado(null, null, null, null);
                $objeto->setIdInspeccion($idInspeccion);
                $objeto->setIdEmpleado('null');
                $objeto->setIdPuestoTrabajo('null');
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
                $objeto->grabar();
                $raspado=new Raspado('idInspeccion', $idInspeccion, null, null);
                if ($raspado->getId()!=null && $raspado->getId()!='') $header=true;
                else $idLlanta=$inspeccion->getIdLlanta();
            }
        }
        break;
    case 'Registrar':
        $objeto=new Raspado('id', $id, null, null);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setAnchoBanda($anchoBanda);
        $objeto->setLargoBanda($largoBanda);
        $objeto->setCinturon($cinturon);
        $objeto->setCinturonCantidad($cinturonCantidad);
        $objeto->setProfundidad($profundidad);
        $objeto->setRadio($radio);
        if (isset($_FILES['foto'])){
            if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/Raspado/")){
                if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/Raspado/", 0777)) $ok=true;
            }
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $id . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/Raspado/$namePhoto");
        } else $namePhoto="";
        //Fin Upload de foto
        $objeto->setFoto($namePhoto);
        $objeto->setObservaciones($observaciones);
        $objeto->setChecked('t');
        $objeto->setEstado('prs');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Raspado('id', $id, null, null);
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getInspeccion()->getLlanta()->getId(), " and idProceso={$objeto->getId()} and proceso=1", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        }
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $idLlanta=$objeto->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        break;
    case 'Eliminar':
        
        break;
}
if ($header) header("Location: principal.php?CON=system/Pages/new_raspadoFormulario.php&id={$raspado->getId()}");
else header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");