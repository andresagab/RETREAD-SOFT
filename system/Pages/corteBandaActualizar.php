<?php
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
foreach ($_POST as $key => $value) ${$key}=$value;
foreach ($_GET as $key => $value) ${$key}=$value;
if(isset($checked)) $checked='t';
else $checked='f';
$header=false;
switch ($accion){
    case 'preRegistro':
        if (isset($idRelleno)){
            $corteBanda=new Corte_Banda('idRelleno', $idRelleno, null, null);
            if ($corteBanda->getId()!=null && $corteBanda->getId()!='') $header=true;
            else {
                $objeto=new Corte_Banda(null, null, null, null);
                $objeto->setIdRelleno($idRelleno);
                $objeto->setIdPuestoTrabajo('null');
                $objeto->setIdEmpleado('null');
                $objeto->setFoto(null);
                $objeto->setObservaciones(null);
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                $objeto->grabar();
                $corteBanda=new Corte_Banda('idRelleno', $idRelleno, null, null);
                if ($corteBanda->getId()!=null && $corteBanda->getId()!='') $header=true;
                else $idLlanta=$corteBanda->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
            }
        }
        break;
    case 'Registrar':
        $objeto=new Corte_Banda('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdEmpleado($idEmpleado);
        if (isset($_FILES['foto'])){
            if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/")){
                if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/", 0777)) $ok=true;
            }
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $id . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/$namePhoto");
        } else $namePhoto="";
        $objeto->setFoto($namePhoto);
        $objeto->setObservaciones($observaciones);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Corte_Banda('id', $id, null, null);
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $idLlanta=$objeto->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        break;
    case 'Eliminar':
        
        break;
}
if ($header) header("Location: principal.php?CON=system/Pages/corteBandaFormulario.php&id={$corteBanda->getId()}");
else header("Location: principal.php?CON=system/Pages/procesoServicio.php&id=$idLlanta");