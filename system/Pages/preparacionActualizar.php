<?php
/*
 * Descripción modificada el 06/08/2019: Ahora este archivo se encarga de:
 * - Inicializar el proceso de preparación
 * - Reiniciar el proceso de preparación
 * - Culminar el registro del proceso de preparacíon
 * Al final del archivo se lleva a cabo un redireccionamiento a la pagina de Falta de datos o el respectivo Formulario
 * de registro.
 */
/*RESOURCES*/
include_once dirname(__FILE__) . '\..\..\lib\php\functions.system.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\RLlanta_Detalle.php';
require_once dirname(__FILE__).'\..\Clases\Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__).'\..\Clases\Uso_Insumo_Proceso_Detalle.php';
require_once dirname(__FILE__).'/../Clases/Servicio_Fin.php';
/*END RESOURCES*/
foreach ($_POST as $key => $value) ${$key} = $value;
foreach ($_GET as $key => $value) ${$key} = $value;
if(isset($checked)) $checked = 't';
else $checked = 'f';
$ok = false;
//print_r($_GET);die();
/*EJECUCIÓN*/
switch ($accion){
    case 'initProcces':
        if (isset($idLlanta) && isset($idPastProcces)) {
            $objeto = new Preparacion(null, null, null, null);
            $objeto->setIdRaspado($idPastProcces);
//            $objeto->setIdEmpleado('null');
//            $objeto->setFoto(null);
//            $objeto->setObservaciones(null);
            $objeto->setEstado('prs');
            $objeto->setChecked('f');
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->setFechaInicioProceso(date("Y-m-d H:i:s"));
            $objeto->grabar();
            $ok = true;
        }
        break;
    case 'resetProcces':
        if (isset($id) && isset($idPastProcces)) {
            $objeto = new Preparacion('id', $id, null, 'limit 1');
            $objeto->setIdRaspado($idPastProcces);
            $objeto->setIdEmpleado('null');
            $objeto->setFoto(null);
            $objeto->setObservaciones(null);
            $objeto->setEstado('prs');
            $objeto->setChecked('f');
            $objeto->modificar();
            $ok = true;
        }
        break;
    case 'Registrar':
        if (isset($id)) {
            $objeto = new Preparacion('id', $id, null, null);
            $objeto->setIdEmpleado($idEmpleado);
            if (!isset($idPuestoTrabajo)) $idPuestoTrabajo = getIdPuestoTrabajoProceso($objeto->getId(), 2);
            $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
            $objeto->setFoto(uploadFile($_FILES, 'foto', '/../../system/Uploads/Imgs/Preparacion/', $objeto->getId()));
            $objeto->setObservaciones($observaciones);
            $objeto->setEstado('prf');
            $objeto->setChecked($checked);
            if (!isset($idLlanta)) $idLlanta = $objeto->getRaspado()->getInspeccion()->getIdLlanta();
            validarRechazoProceso($idLlanta, $objeto->getId(), 2, $checked);
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->finalizar();
            $ok = true;
        }
        break;
    /*case 'preRegistro':
        if (isset($idRaspado)){
            $raspado=new Raspado('id', $idRaspado, null, null);
            $preparacion=new Preparacion('idRaspado', $idRaspado, null, null);
            if ($preparacion->getId()!=null && $preparacion->getId()!='') $header=true;
            else {
                $objeto=new Preparacion(null, null, null, null);
                $objeto->setIdRaspado($idRaspado);
                $objeto->setIdPuestoTrabajo('null');
                $objeto->setIdEmpleado('null');
                $objeto->setFoto(null);
                $objeto->setObservaciones(null);
                $objeto->setEstado('prs');
                $objeto->setChecked('f');
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                $objeto->grabar();
                $preparacion=new Preparacion('idRaspado', $idRaspado, null, null);
                if ($preparacion->getId()!=null && $preparacion->getId()!='') $header=true;
                else $idLlanta=$raspado->getInspeccion()->getIdLlanta();
            }
        }
        break;
    case 'Registrar':
        $objeto=new Preparacion('id', $id, null, null);
        $objeto->setIdPuestoTrabajo($idPuestoTrabajo);
        $objeto->setIdEmpleado($idEmpleado);
        if (isset($_FILES['foto'])){
            $foto=$_FILES['foto']['name'];
            $cutExt= substr($foto, strpos($foto, "."));
            $namePhoto= $objeto->getId() . "_" . date("Y-m-d") . $cutExt;
            move_uploaded_file($_FILES['foto']['tmp_name'], "system/Uploads/Imgs/Preparacion/$namePhoto");
        } else $namePhoto="";
        $objeto->setFoto($namePhoto);
        $objeto->setObservaciones($observaciones);
        $objeto->setChecked('f');
        $objeto->setEstado('prs');
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        $idLlanta=$objeto->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->continuarRegistro();
        break;
    case 'Finalizar':
        $objeto=new Preparacion('id', $id, null, null);
        if ($checked=='t'){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getRaspado()->getInspeccion()->getLlanta()->getId(), " and idProceso={$objeto->getId()} and proceso=2", null);
            if ($rechazoLlanta->getId()!='' && $rechazoLlanta->getId()!=null){
                $rechazoLlanta->eliminarDetalles();
                $rechazoLlanta->eliminar();
            }
            $registroBanda=new Corte_Banda(null, null, null, null);
            $registroBanda->setIdPreparacion($objeto->getId());
            $registroBanda->setIdRelleno('null');
            $registroBanda->setIdPuestoTrabajo('null');
            $registroBanda->setIdEmpleado('null');
            $registroBanda->setEstado('f');
            $registroBanda->setEmpates('null');
            $registroBanda->setFoto(null);
            $registroBanda->setObservaciones('');
            $registroBanda->setFechaRegistro(date('Y-m-d H:i:s'));
            $registroBanda->grabar();
        }
        $objeto->setChecked($checked);
        $objeto->setEstado('prf');
        $idLlanta=$objeto->getRaspado()->getInspeccion()->getIdLlanta();
        $objeto->finalizar($observaciones);
        break;
    case 'Eliminar':
        
        break;*/
}
/*END EJECUCIÓN*/
/*REDIRECCIONAMIENTO*/
if ($ok) header("Location: principal.php?CON=system/Pages/preparacionFormularioNew.php&id={$idLlanta}");
else header("Location: principal.php?CON=system/Pages/unknowData.php");
/*END REDIRECCIONAMIENTO*/