<?php
require_once dirname(__FILE__).'/../Clases/Llanta.php';
require_once dirname(__FILE__).'/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__).'/../Clases/Rechazo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/RLlanta_Detalle.php';
require_once dirname(__FILE__).'/../Clases/Servicio_Fin.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
$ok = false;
//print_r($_POST);
//print_r($_FILES);die();
switch ($accion){
    case 'initProcess':
        if (isset($id)) {
            $llanta = new Llanta('id', $id, null, null);
            $llanta->setFechaInicioProceso(date('Y-m-d H:i:s'));
            $llanta->updateFechaInicioProceso();
            $objeto=new Inspeccion_Inicial(null, null, null, null);
            $objeto->setIdLlanta($llanta->getId());
            $objeto->setIdEmpleado('null');
            $objeto->setNumeroRencauche(0);
            $objeto->setObservaciones(null);
            $objeto->setFoto(null);
            $objeto->setChecked('f');
            $objeto->setEstado('prs');
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->grabar();
            $ok = true;
        }
        break;
    case 'Registrar':
        if (isset($id)) {
            $objeto = new Inspeccion_Inicial('id', $id, null, null);
            $objeto->setIdLlanta($idLlanta);
            $objeto->setIdEmpleado($idEmpleado);
            $objeto->setNumeroRencauche($numeroRencauche);
            $objeto->setObservaciones($observaciones);
            if (isset($_FILES['foto'])){
                if (!is_dir(dirname(__FILE__) . '/../Uploads/Imgs/Inspeccion_Inicial/')) {
                    if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/Inspeccion_Inicial/", 0777)) echo 'ok';
                }
                $foto = $_FILES['foto']['name'];
                $cutExt = substr($foto, strpos($foto, "."));
                $namePhoto = "{$objeto->getId()}_". date("Y-m-d") . $cutExt;
                if (file_exists(dirname(__FILE__) . "/../Uploads/Imgs/Inspeccion_Inicial/{$namePhoto}")) {
                    try {
                        unlink(dirname(__FILE__) . "/../Uploads/Imgs/Inspeccion_Inicial/{$namePhoto}");
                    } catch (Exception $e) {echo $e->getMessage();}
                }
                move_uploaded_file($_FILES['foto']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/Inspeccion_Inicial/$namePhoto");
            } else $namePhoto="";
            $objeto->setFoto($namePhoto);
            $objeto->setChecked($checked);
            if ($checked==='t'){//Si la inspeccion inicial fue aprobada se debe eliminar cualquier registro de rechazo, para asi suprimir todos los registros residuales que se hayan hecho por error
                $rechazoLlanta = new Rechazo_Llanta('idLlanta', $objeto->getIdLlanta(), " and idProceso={$objeto->getId()} and proceso=0", null);
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
            $objeto->setEstado('prf');
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->finalizar();
            $id = $objeto->getIdLlanta();
            $ok = true;
        }
        break;
}
if ($ok) header("Location: principal.php?CON=system/Pages/inspeccionInicialFormulario.php&id=$id");
else header("Location: principal.php?CON=system/Pages/unknowData.php");
//header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");