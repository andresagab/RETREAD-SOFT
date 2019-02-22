<?php
require_once dirname(__FILE__).'/../Clases/Rechazo_Inspeccion_Inicial.php';
require_once dirname(__FILE__).'/../Clases/RII_Detalles.php';
require_once dirname(__FILE__).'/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__).'/../Clases/Rechazo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/RLlanta_Detalle.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
//print_r($_POST);die();
switch ($accion){
    case 'Registrar':
        $objeto=new Inspeccion_Inicial(null, null, null, null);
        $objeto->setIdLlanta($idLlanta);
        $objeto->setIdEmpleado($idEmpleado);
        $objeto->setNumeroRencauche($numeroRencauche);
        $objeto->setObservaciones($observaciones);
        $objeto->setFoto(null);
        $objeto->setChecked('f');
        $objeto->setEstado('prs');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $objeto->grabar();
        //die();
        break;
    case 'Finalizar':
        $objeto=new Inspeccion_Inicial('id', $id, null, null);
        //Upload de foto
        if (isset($_FILES['foto'])){
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto="{$objeto->getId()}_". date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Inspeccion_Inicial/$namePhoto");
        } else $namePhoto="";
        //Fin Upload de foto
        $objeto->setChecked($checked);
        if ($checked=='t'){//Si la inspeccion inicial fue aprobada se debe eliminar cualquier registro de rechazo, para asi suprimir todos los registros residuales que se hayan hecho por error
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getIdLlanta(), " and idProceso={$objeto->getId()} and proceso=0", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
        }
        $objeto->setFoto($namePhoto);
        $objeto->setEstado('prf');
        $objeto->finalizar($observaciones);
        $idLlanta=$objeto->getIdLlanta();
        break;
    case 'Eliminar':
        break;
}
header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");