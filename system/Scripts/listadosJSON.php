<?php
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Clases/Opcion.php';
require_once dirname(__FILE__) . '/../Clases/Persona.php';
require_once dirname(__FILE__) . '/../Clases/Contacto_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Rol.php';
require_once dirname(__FILE__) . '/../Clases/Usuario.php';
require_once dirname(__FILE__) . '/../Clases/Usuario_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Vehiculo.php';
require_once dirname(__FILE__) . '/../Clases/Soat.php';
require_once dirname(__FILE__) . '/../Clases/Revision_Tecnomecanica.php';
require_once dirname(__FILE__) . '/../Clases/Gravado_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Referencia.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Detalle_Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Vehiculo.php';
require_once dirname(__FILE__) . '/../Clases/Presentacion_Producto.php';
require_once dirname(__FILE__) . '/../Clases/Categoria_Producto.php';
require_once dirname(__FILE__) . '/../Clases/Unidad_Medida.php';
require_once dirname(__FILE__) . '/../Clases/Puc.php';
require_once dirname(__FILE__) . '/../Clases/Tercero.php';
require_once dirname(__FILE__) . '/../Clases/Producto.php';
require_once dirname(__FILE__) . '/../Clases/Solicitud_Eliminar_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Novedad_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Insumo_Terminacion.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso_Detalle.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/Raspado.php';
require_once dirname(__FILE__) . '/../Clases/Preparacion.php';
require_once dirname(__FILE__) . '/../Clases/Reparacion.php';
require_once dirname(__FILE__) . '/../Clases/Cementado.php';
require_once dirname(__FILE__) . '/../Clases/Relleno.php';
require_once dirname(__FILE__) . '/../Clases/Corte_Banda.php';
require_once dirname(__FILE__) . '/../Clases/Embandado.php';
require_once dirname(__FILE__) . '/../Clases/Vulcanizado.php';
require_once dirname(__FILE__) . '/../Clases/Posicion_Camara.php';
require_once dirname(__FILE__) . '/../Clases/Servicio_Fin.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/RLlanta_Detalle.php';
require_once dirname(__FILE__) . '/../Clases/Salida_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Registro_Banda.php';
require_once dirname(__FILE__) . '/../Clases/Bitacora.php';
if (isset($_GET['P'])) $P=$_GET['P'];
else $P='';
if (isset($_GET['BD'])) $BD=$_GET['BD'];
else $BD='';
switch ($_GET['metodo']) {
	case 'serviciosLlantaJSON':
            echo Servicio::getObjetosJSON("idLlanta={$_GET['idLlanta']}", null);
            break;
	case 'presentacionesProductoJSON':
            echo Presentacion_Producto::getObjetosJSON(null, null);
            break;
	case 'unidadesMedidaJSON':
            echo Unidad_Medida::getObjetosJSON(null, null);
            break;
	case 'marcasVehiculoJSON':
            echo Marca_Vehiculo::getObjetosJSON(null, null);
            break;
	case 'dimensionesLlantaJSON':
            echo Dimension_Llanta::getObjetosJSON(null, null);
            break;
	case 'gravadosLlantaJSON':
            echo Gravado_Llanta::getObjetosJSON(null, null);
            break;
	case 'referenciasTipoLlantaJSON':
            echo Referencia_Tipo_Llanta::getObjetosJSON("idTipoLlanta={$_GET['idTipoLlanta']}", 'order by fecharegistro desc');
            break;
    case 'referenciasTipoLlantaJSONSQL':
        if (isset($_GET['filter'])) $filter = $_GET['filter'];
        else $filter = null;
        if (isset($_GET['extras'])) $extras = $_GET['extras'];
        else $extras = true;
        echo Referencia_Tipo_Llanta::getDataJsonSQL($_GET['idTipoLlanta'], $filter, $extras);
        break;
	case 'dimensionesReferenciaJSON':
            echo Dimension_Referencia::getObjetosJSON("idReferenciaTipoLlanta={$_GET['idReferencia']}", 'order by fecharegistro desc');
            break;
	case 'rechazosJSON':
            echo Rechazo::getObjetosJSON(null, null);
            break;
	case 'kardexJSON':
            echo Producto::getObjetosJSON(null, null);
            break;
	case 'getContactosPersonaJSON':
            echo Contacto_Persona::getObjetosJSON("identificacionPersona='{$_GET['identificacionPersona']}'", null);
            break;
	case 'vehiculosJSON':
            $objeto=new Cliente('id', $_GET['idCliente'], null, null);
            echo Vehiculo::getObjetosJSON("identificacion='{$objeto->getIdentificacion()}'", "order by id asc");
            break;
	case 'soatsJSON':
            $objeto=new Vehiculo('id', $_GET['idVehiculo'], null, null);
            echo Soat::getObjetosJSON("idVehiculo='{$objeto->getId()}'", "order by id asc");
            break;
	case 'revisionesTecnomecanicasJSON':
            $objeto=new Vehiculo('id', $_GET['idVehiculo'], null, null);
            echo Revision_Tecnomecanica::getObjetosJSON("idVehiculo='{$objeto->getId()}'", "order by id asc");
            break;
	case 'tiposLlantaJSON':
            echo Tipo_Llanta::getObjetosJSON(null, "order by id asc");
            break;
	case 'llantasJSON':
            echo Llanta::getObjetosJSON(null, "order by id asc");
            break;
	case 'solicitudesEliminarLlantaJSON':
            echo Solicitud_Eliminar_Llanta::getObjetosJSON(null, "order by id asc");
            break;
	case 'getPuestosTrabajosJSON':
            echo Puesto_Trabajo::getObjetosJSON(null, "order by id asc");
            break;
	case 'getCategoriasProductosJSON':
            echo Categoria_Producto::getObjetosJSON(null, "order by id asc");
            break;
	case 'getProductosCategoriaJSON':
            //echo Producto::getObjetosJSON("idCategoria={$_GET['idCategoria']}", "order by id asc");
            //echo Producto::getDataJSON("idCategoria={$_GET['idCategoria']}", "order by id asc");
            echo Producto::getDataSQLJSON(null, "and idCategoria={$_GET['idCategoria']}", "order by pr.id asc");
            break;
	case 'getInsumosPuestoTrabajoJSON':
            //echo Insumo_Puesto_Trabajo::getObjetosJSON("idPuestoTrabajo={$_GET['idPT']}", "order by id asc");
        $sql="select pc.id as idPuc, pc.codigo as codPuc, pc.nombre nombreProducto,
              pr.id as idProducto, pr.foto, pr.stock,
              ip.id as idInsumoPT, ip.cantidad as cantidadInsumoPT, ip.estado as estadoInsumoPT, per.nombres || ' ' || per.apellidos as nombresEmpleado, per.identificacion as identificacionEmpleado
            from insumo_puestotrabajo ip, producto pr, puc pc, usuario u, usuario_persona up, persona per, empleado e
            where ip.idpuestotrabajo={$_GET['idPT']}  
            and pr.id=idinsumo
            and pc.codigo=pr.codpuc
            and u.usuario=ip.usuario
            and up.idusuario=u.id
            and per.identificacion=up.identificacion
            and e.identificacion=per.identificacion 
            order by ip.estado desc";
            //order by ip.id, ip.estado asc";
        echo Insumo_Puesto_Trabajo::getDataJSON(2, null, null, null, null, $sql, true);
            break;
	case 'getInsumosPuestoTrabajo':
	    echo Insumo_Puesto_Trabajo::getObjetosJSON("idPuestoTrabajo={$_GET['idPT']} and id not in (select idInsumoPt from insumo_terminacion)", "order by id asc");
        //echo Insumo_Puesto_Trabajo::getInsumosPuestoTrabajoSQLJSON($_GET['idPT']);
        //echo Puesto_Trabajo::getInsumosPtJSON($_GET['idPT']);
            break;
	case 'getInsumosProcesoJSON':
            /*if (isset($_GET['idPT']) && isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])){
                echo Insumo_Puesto_Trabajo::getObjetosJSON("idPuestoTrabajo={$_GET['idPT']} and fechaRegistro between '{$_GET['fechaInicio']}' and ''", "order by id asc");
            } else*/ echo '[]';
            break;
	case 'getTiposServicioJSON':
            echo Tipo_Servicio::getObjetosJSON(null, null);
            break;
	case 'serviciosJSON':
	    $sql="select s.id as idOs, s.numerofactura, s.os, s.estado estadoOs, s.fecharegistro as fecharegistroos, s.fecharecoleccion as fecharecoleccionos, 
              c.id as idCliente, c.identificacion as identificacionCliente, c.razonsocial, c.nit, 
              pc.nombres as nombresCliente, pc.apellidos as apellidosCliente, pc.email as emailCliente, pc.direccion as direccionCliente, pc.celular as celularCliente, pc.fechanacimiento as clienteFechaNacimiento, 
              e.id as idEmpleado, e.identificacion as identificacionEmpleado,  
              pe.nombres as nombresEmpleado, pe.apellidos as apellidosEmpleado, pe.email as emailEmpleado, pe.direccion as direccionEmpleado, pe.celular as celularEmpleado, pe.fechanacimiento as empleadoFechaNacimiento, 
              r.id as idRol, r.nombre as nombreRol, r.estado as estadoRol
              from servicio as s, cliente as c, persona as pc, empleado as e, persona as pe, rol as r 
              where c.id=s.idcliente 
              and pc.identificacion=c.identificacion 
              and e.id=s.idvendedor 
              and pe.identificacion=e.identificacion
              and r.id=e.idcargo
              order by s.fecharecoleccion desc";
	    echo Servicio::getDataJSON(false, $sql, null, null, null, null);
        //echo Servicio::getObjetosJSON(null, "order by fechaRegistro desc");
        //echo Servicio::getListaPersonalizadaJSON(null, "order by s.fechaRegistro desc");
        break;
    case 'serviciosRecientes':
        foreach ($_GET as $key => $val) ${$key} = $val;
        if (!isset($filter)) $filter = "order by s.fecharecoleccion desc";
        $sql="select s.id as idOs, s.numerofactura, s.os, s.estado estadoOs, s.fecharegistro as fecharegistroos, s.fecharecoleccion as fecharecoleccionos, 
              c.id as idCliente, c.identificacion as identificacionCliente, c.razonsocial, c.nit, 
              pc.nombres as nombresCliente, pc.apellidos as apellidosCliente, pc.email as emailCliente, pc.direccion as direccionCliente, pc.celular as celularCliente, pc.fechanacimiento as clienteFechaNacimiento, 
              e.id as idEmpleado, e.identificacion as identificacionEmpleado,  
              pe.nombres as nombresEmpleado, pe.apellidos as apellidosEmpleado, pe.email as emailEmpleado, pe.direccion as direccionEmpleado, pe.celular as celularEmpleado, pe.fechanacimiento as empleadoFechaNacimiento, 
              r.id as idRol, r.nombre as nombreRol, r.estado as estadoRol
              from servicio as s, cliente as c, persona as pc, empleado as e, persona as pe, rol as r 
              where c.id=s.idcliente 
              and pc.identificacion=c.identificacion 
              and e.id=s.idvendedor 
              and pe.identificacion=e.identificacion
              and r.id=e.idcargo
              $filter";
        echo Servicio::getDataJSON(false, $sql, null, null, null, null);
        break;
    case 'getCountDataOS':
        echo Servicio::getCountData();
        break;
	case 'getLlantasOrdenServicio':
            //echo Llanta::getLlantasInformeBodegaSQL("ll.idServicio={$_GET['idServicio']}", null);
            //echo Llanta::getObjetosJSON("idServicio={$_GET['idServicio']}", 'order by consecutivo asc');
            echo Llanta::getLlantasOrdenServicio("ll.idServicio={$_GET['idServicio']}", 'order by ll.consecutivo asc', true);
            break;
	case 'getLlantasOSImprimir':
            //echo Llanta::getLlantasInformeBodegaSQL("ll.idServicio={$_GET['idServicio']}", null);
            echo Llanta::getLlantasInformeBodega("idServicio={$_GET['idServicio']}", null);
            //echo Llanta::getObjetosJSON("idServicio={$_GET['idServicio']}", null);
            break;
	case 'getPosicionesCamrasVulcanizado':
            //echo Posicion_Camara::getObjetosJSON("idVulcanizado={$_GET['idVulcanizado']}", null);
            echo Posicion_Camara::getObjetosJSONSimple("idVulcanizado={$_GET['idVulcanizado']}", "order by posicion asc");
            break;
	case 'getNovedadesPuestoTrabajoJSON':
            echo Novedad_Puesto_Trabajo::getObjetosJSON("idPuestoTrabajo={$_GET['idPT']}", 'order by fechaRegistro desc');
            break;
	case 'getLlantasInformeBodega':
            echo Llanta::getLlantasInformeBodegaSQL($_GET['filtro'], $_GET['orden']);
            //echo Llanta::getLlantasInformeBodega($_GET['filtro'], $_GET['orden']);
            //echo Llanta::getObjetosJSON($_GET['filtro'], $_GET['orden']);
            //echo Llanta::getObjetosJSON($_GET['filtro'], $_GET['orden']);
            break;
	case 'getTotalInformeBodega':
            echo Llanta::getTotalFacturado($_GET['filtro'], $_GET['orden']);
            break;
	case 'getCountOSInformeBodega':
            echo Llanta::getCountOS($_GET['filtro'], $_GET['orden']);
            break;
	case 'getUsosInsumoProceso':
	    //print_r($_GET);
            if (isset($_GET['idProceso']) && isset($_GET['proceso'])){
                if ($_GET['idProceso']!=null && $_GET['proceso']!=null){
                    $usoInsumoProceso=new Uso_Insumo_Proceso('idProceso', $_GET['idProceso'], " and proceso={$_GET['proceso']}", null);
                    //print_r($usoInsumoProceso);
	                //die();
                    if ($usoInsumoProceso->getId()!=null && $usoInsumoProceso->getId()!='') echo Uso_Insumo_Proceso_Detalle::getObjetosJSON ("idUsoInsumoProceso={$usoInsumoProceso->getId()}", null);
                    else echo '[]';
                } else echo '[]';
            } else echo '[]';
            break;
	case 'getLlantasOSInformeRencauche':
            if (isset($_GET['os'])){
                if ($_GET['os']!=null){
                    echo Servicio::getLlantasOSInformeRencauche($_GET['os']);
                } else echo '[]';
            } else echo '[]';
            break;
    case 'getRegistrosBandasJSON':
        //echo Registro_Banda::getDataJSON(1, null, null, null, 'order by fechaRegistro desc', null, true);
        echo Corte_Banda::getDataJSON("select cb.id, cb.idpreparacion, cb.idrelleno, cb.idempleado, cb.estado, cb.empates, cb.foto, cb.observaciones, cb.fecharegistro, p.checked as chkPreparacion,  
          p.estado as estadoPreparacion, p.observaciones as observacionesPreparacion, 
          r.anchobanda, r.largobanda, r.cinturon, r.cinturoncantidad, r.profundidad, r.radio, r.estado as estadoRaspado, r.observaciones as raspadoObservaciones, r.checked as chkRaspado,  
          ii.numerorencauche, ii.estado as estadoInspeccionInicial, ii.checked as chkii, ii.observaciones as observacionesInspeccionInicial, 
          ll.rp, ll.serie, ll.urgente, ll.id as idLlanta, ll.observaciones as observacionesLlanta, 
          mll.nombre as nombreMarca, gll.nombre as nombreGravado, dll.dimension, 
          os.id as idOs, os.os, os.estado as estadoOs, os.observaciones as observacionesOs, 
          rsoli.referencia as referenciaSolicitada, 
          rorig.referencia as referenciaOriginal, 
          tipllorg.nombre as tipoLlantaOriginal, 
          tipllsol.nombre as tipoLlantaSolicitada   
          from corte_banda as cb, preparacion as p, raspado as r, inspeccion_inicial as ii, llanta as ll, servicio as os, gravado_llanta as gll, marca_llanta as mll, dimension_llanta as dll, referencia_tipo_llanta as rsoli, referencia_tipo_llanta as rorig, tipo_llanta as tipllorg, tipo_llanta as tipllsol    
          where p.id=cb.idpreparacion 
          and r.id=p.idraspado 
          and ii.id=r.idinspeccion 
          and ll.id=ii.idllanta 
          and gll.id=ll.idgravado 
          and mll.id=ll.idmarca 
          and dll.id=ll.iddimension
          and rsoli.id=ll.idreferenciasolicitada 
          and rorig.id=ll.idreferenciaoriginal 
          and tipllorg.id=rorig.idtipollanta 
          and tipllsol.id=rsoli.idtipollanta 
          and os.id=ll.idservicio order by cb.fecharegistro desc");
        break;
    case 'getBitacorasJSON':
        echo Bitacora::getDataJSON(1, null, null, null, 'order by fecharegistro desc', null, true);
        break;

    case 'getDataInformeInsumosJSON':
        header("Access-control-Allow-Origin: *");
        header("Access-control-Allow-Methods: GET, POST");
        header("Access-control-Allow-Headers: X-Requested-with");
        header("Content-type: text/html; charset=utf-8");
        $postdata= file_get_contents("php://input");
        $filters= json_decode($postdata);
        if (isset($_GET['order'])) $order=$_GET['order'];
        else $order='';
        echo Producto::getSQLJSON(null, $filters, $order, true);
        break;

    case 'getEmpleadosJSON':
        $sql="select per.identificacion, per.nombres || ' ' || per.apellidos as nombrescompletos from persona as per, empleado as e where e.identificacion=per.identificacion";
        echo Empleado::getDataJSON(2, null, null, null, null, $sql, false);
        break;
    case 'getSimpleUsosInsumosProcesoJSON':
        if (isset($_GET['idProceso']) && isset($_GET['proceso'])) {
            $sql="select uip.id as idusoinsumoproceso, uip.idempleado as idempleadousoinsumoproceso, uip.idproceso as idprocesousoinsumoproceso, 
                    uipd.id as id, uipd.cantidad, uipd.terminado, uipd.usado, uipd.fecharegistro as fecharegistrousoinsumoprocesodetalle, 
                    ipt.id as idinsumopuestotrabajo, ipt.cantidad as cantidadinsumopuestotrabajo, ipt.estado as estadoinsumopestotrabajo, ipt.usuario as usuarioinsumopuestotrabajo, ipt.idpuestotrabajo as idpuestotrabajoInsumo, 
                    pc.nombre as nombrepuc, 
                    e.id as idempleadousoinsumoprocesodetalle, e.identificacion as identificacionempleadousoinsumoprocesodetalle 
                from uso_insumo_proceso as uip, uso_insumo_proceso_detalle as uipd, insumo_puestotrabajo as ipt, empleado as e, producto as pro, puc as pc 
                where uip.idproceso={$_GET['idProceso']} 
                and uip.proceso={$_GET['proceso']} 
                and uipd.idusoinsumoproceso=uip.id
                and ipt.id=uipd.idinsumopt 
                and pro.id=ipt.idinsumo 
                and pc.codigo=pro.codpuc
                and e.id=uipd.idempleado;";
            //echo $sql;
            echo Uso_Insumo_Proceso_Detalle::getDataJSON(2, null, null, null, null, $sql, false);
        } else header('Location: principal.php?CON=system/pages/unknowData.php');
        break;
    case 'getSimpleInsumosPuestoTrabajoJSON':
        if (isset($_GET['idPuestoTrabajo']) && isset($_GET['extras'])) {
            echo Insumo_Puesto_Trabajo::getInsumosPuestoTrabajoSQLJSON($_GET['idPuestoTrabajo'], $_GET['extras']);
        } else header('Location: principal.php?CON=system/pages/unknowData.php');
        //echo Insumo_Puesto_Trabajo::getObjetosJSON("idPuestoTrabajo={$_GET['idPT']} and id not in (select idInsumoPt from insumo_terminacion)", "order by id asc");
        break;

	default:
            echo "[{'data': 'null'}]";
            break;
}
?>