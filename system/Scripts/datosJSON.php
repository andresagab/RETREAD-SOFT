<?php
date_default_timezone_set("America/Bogota");
include dirname(__FILE__) . "/../../lib/php/Time.php";
include dirname(__FILE__) . "/../../lib/php/functions.system.php";
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Rol.php';
require_once dirname(__FILE__) . '/../Clases/Usuario.php';
require_once dirname(__FILE__) . '/../Clases/Contacto_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Telefono_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Gravado_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Referencia.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Vehiculo.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo.php';
require_once dirname(__FILE__) . '/../Clases/Vehiculo.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/RLlanta_Detalle.php';
require_once dirname(__FILE__) . '/../Clases/Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Detalle_Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo_Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/RII_Detalles.php';
require_once dirname(__FILE__) . '/../Clases/Solicitud_Eliminar_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Categoria_Producto.php';
require_once dirname(__FILE__) . '/../Clases/Tercero.php';
require_once dirname(__FILE__) . '/../Clases/Unidad_Medida.php';
require_once dirname(__FILE__) . '/../Clases/Presentacion_Producto.php';
require_once dirname(__FILE__) . '/../Clases/Puc.php';
require_once dirname(__FILE__) . '/../Clases/Producto.php';
require_once dirname(__FILE__) . '/../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Novedad_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Raspado.php';
require_once dirname(__FILE__) . '/../Clases/Preparacion.php';
require_once dirname(__FILE__) . '/../Clases/Reparacion.php';
require_once dirname(__FILE__) . '/../Clases/Cementado.php';
require_once dirname(__FILE__) . '/../Clases/Relleno.php';
require_once dirname(__FILE__) . '/../Clases/Corte_Banda.php';
require_once dirname(__FILE__) . '/../Clases/Embandado.php';
require_once dirname(__FILE__) . '/../Clases/Vulcanizado.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Final.php';
require_once dirname(__FILE__) . '/../Clases/Terminacion.php';
require_once dirname(__FILE__) . '/../Clases/Servicio_Fin.php';
require_once dirname(__FILE__) . '/..\Clases\Uso_Insumo_Proceso.php';
require_once dirname(__FILE__) . '/..\Clases\Uso_Insumo_Proceso_Detalle.php';
require_once dirname(__FILE__) . '/..\Clases\Insumo_Terminacion.php';
require_once dirname(__FILE__) . '/..\Clases\Salida_Llanta.php';
global $P, $BD;
if(isset($_GET['P'])) $P=$_GET['P'];
else $P='';
if(isset($_GET['BD'])) $BD=$_GET['BD'];
else $BD='';
switch ($_GET['metodo']) {
    case 'getProximoRP':
        echo Llanta::getProximoRP();
        break;
    case 'getProximoNumeroRencauche':
        echo Inspeccion_Inicial::getProximoNumeroRencauhe();
        break;
    case 'getEmpleadoJSON':
        echo Empleado::getObjetoJSON('id', "'{$_GET['id']}'", null, "order by id desc limit 1");
        break;
    case 'getClienteJSON':
        echo Cliente::getObjetoJSON('id', "'{$_GET['id']}'", null, "order by id desc limit 1");
        break;
    case 'getClientePersonaJSON':
        $objeto=new Vehiculo('id', "'{$_GET['idVehiculo']}'", null, null);
        if ($objeto->getId()!=null) echo Cliente::getObjetoJSON('identificacion', "'{$objeto->getIdentificacion()}'", null, "order by id asc");
        else echo Cliente::getObjetoJSON (null, null, null, null);
        break;
    case 'getVehiculoJSON':
        echo Vehiculo::getObjetoJSON('id', "'{$_GET['id']}'", null, "order by id desc limit 1");
        break;
    case 'getDimensionJSON':
        echo Dimension_Llanta::getDatoJSON('id', $_GET['id'], null, null);
        break;
    case 'getNumeroSolicitudesEliminar':
        echo Solicitud_Eliminar_Llanta::getNumeroSolicitudesPendientes();
        break;
    case 'getTiempoTranscurrido':
        $inspeccionInicial=new Inspeccion_Inicial('id', $_GET['idInspeccion'], null, null);
        echo Servicio::getTiempoTranscurrido($inspeccionInicial->getFechaRegistro());
        break;
    case 'getDiffTiempoInsumoPT':
        $insumoPT=new Insumo_Puesto_Trabajo('id', $_GET['idPuestoTrabajo'], null, null);
        echo Insumo_Puesto_Trabajo::getTiempoTranscurrido($insumoPT->getFechaRegistro());
        break;
    case 'rechazosInspeccionJSON':
        $inspeccionInicial=new Inspeccion_Inicial('id', $_GET['idInspeccion'], null, null);
        echo $inspeccionInicial->getRechazos();
        break;
    case 'getCategoriaProductoJSON':
        if (isset($_GET['id'])){
            if ($_GET['id']!=null) echo Categoria_Producto::getObjetoJSON ('id', $_GET['id'], null, null);
        }
        else {
            $objeto=new Categoria_Producto(null, null, null, null);
            echo json_encode($objeto);
        }
        break;
    case 'getPuestoTrabajoJSON':
        echo Puesto_Trabajo::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getTipoLlantaJSON':
        echo Tipo_Llanta::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getGravadoJSON':
        echo Gravado_Llanta::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getReferenciaJSON':
        echo Referencia_Tipo_Llanta::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getCliente':
        echo Cliente::getObjetoJSON('identificacion', "'{$_GET['identificacion']}'", null, null);
        break;
    case 'getVendedor':
        echo Empleado::getObjetoJSON('identificacion', "'{$_GET['identificacion']}'", null, null);
        break;
    case 'getOS':
        echo Servicio::getObjetoJSON('os', "'{$_GET['os']}'", null, null);
        break;
    case 'getOrdenServicio':
        echo Servicio::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getLlantaSerie':
        $objeto=new Llanta('serie', $_GET['serie'], null, null);
        if ($objeto->getId()!=null && $objeto->getId()!='') echo 'false';
        else echo 'true';
        break;
    case 'getTiposServicioJSON':
        if (isset($_GET['id'])) $objeto=new Servicio('id', $_GET['id'], null, null);
        else $objeto=new Servicio(null, null, null, null);
        echo $objeto->getTiposServicio();
//        if ($objeto->getId()!=null && $objeto->getId()!='') echo 'false';
//        else echo 'true';
        break;
    case 'rechazosProcesoJSON':
        $objeto=new Rechazo_Llanta('idLlanta', $_GET['idLlanta'], " and proceso={$_GET['proceso']}", null);
        echo $objeto->getRechazos();
        break;
    case 'getVulcanizado':
        echo Vulcanizado::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getVulcanizadoSimple':
        echo Vulcanizado::getObjetoJSONSimple('id', $_GET['id'], null, null);
        break;
    case 'getInsumoJSON':
        echo Producto::getObjetoJSON('id', $_GET['id'], null, null);
        break;
    case 'getRaspadoJSON':
        if (isset($_GET['id'])) echo Raspado::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getPreparacionJSON':
        if (isset($_GET['id'])) echo Preparacion::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getReparacionJSON':
        if (isset($_GET['id'])) echo Reparacion::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getCementadoJSON':
        if (isset($_GET['id'])) echo Cementado::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getRellenoJSON':
        if (isset($_GET['id'])) echo Relleno::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getCorteBandaJSON':
        if (isset($_GET['id'])) echo Corte_Banda::getObjetoJSON('id', $_GET['id'], null, null);
        else header('Location: principal.php?CON=system/pages/unknowData.php');
        break;
    case 'getDataCorteBandaJSON':
        if (isset($_GET['id'])) echo Corte_Banda::getData(0, 'id', $_GET['id'], null, null, null, false);
        else header('Location: principal.php?CON=system/pages/unknowData.php');
        break;
    case 'getEmbandadoJSON':
        if (isset($_GET['id'])) echo Embandado::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getVulcanizadoJSON':
        if (isset($_GET['id'])) echo Vulcanizado::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getInspeccionFinalJSON':
        if (isset($_GET['id'])) echo Inspeccion_Final::getObjetoJSON('id', $_GET['id'], null, null);
        else echo '[]';
        break;
    case 'getInfoUsosInsumosJSON':
        if (isset($_GET['idProceso']) && isset($_GET['proceso'])){
            if ($_GET['idProceso']!=null && $_GET['proceso']!=null){
                $objeto=new Uso_Insumo_Proceso('idProceso', $_GET['idProceso'], " and proceso={$_GET['proceso']}", null);
                if ($objeto->getId()!=null) echo $objeto->getInfoUsosInsumos();
                else echo '[]';
            } else echo '[]';
        } else echo '[]';
        break;
    case 'getUsuarioJSON':
        if (isset($_GET['id'])){
            if ($_GET['id']!=null) echo Usuario::getObjetoJSON ('id', $_GET['id'], null, null);
            else echo '[]';
        } else echo '[]';
        break;
    case 'compararClaves':
        //if (md5($_GET['claveActual'])==$_GET['claveSession']) echo 'vaaaa';
        if (isset($_GET['claveActual']) && isset($_GET['claveSession'])){
            if (md5($_GET['claveActual']) == $_GET['claveSession']) echo 'OK';
            else echo 'FALSE';
        } else echo 'ID';
        break;
    case 'getInformeRencauche':
        if (isset($_GET['filtro'])){
            echo Llanta::getInformeRencauche($_GET['filtro'], null);
            //echo Llanta::getObjetoJSON('id', 1, null, null);
        } else echo '[]';
        break;
    case 'getNumeroCortesPendientes':
        echo Corte_Banda::getNumeroCortesPedientes();
        break;
    case 'getNumerosFacturas':
        echo Servicio::getNumerosFacturas(null, "order by numeroFactura asc");
        //echo Servicio::getDataJSON(false, "select numeroFactura from servicio order by numerofactura desc", null, null, null, null);
        break;
    case 'getNumerosOS':
        echo Servicio::getNumerosOS(null, "order by os asc");
        //echo Servicio::getDataJSON(false, "select numeroFactura from servicio order by numerofactura desc", null, null, null, null);
        break;
    case 'getNumberNovedadesPuestoTrabajo':
        echo Novedad_Puesto_Trabajo::getNumberNovedades();
        break;
    case 'getRechazosLlantaJSON':
        echo Rechazo_Llanta::getRechazosLlantaJSON($_GET['idLlanta']);
        break;
    case 'getLlantaJSONSQL':
        if (isset($_GET['id'])) echo Llanta::getLlantasOrdenServicio("ll.id={$_GET['id']}", null, false);
        else header('Location: principal.php?CON=system/pages/unknowData.php');
        break;
    case 'getCorteBandaEditar':
        if (isset($_GET['id'])) echo Corte_Banda::getData(0, 'id', $_GET['id'], null, null, null, false);
        else header('Location: principal.php?CON=system/pages/unknowData.php');
        break;
}