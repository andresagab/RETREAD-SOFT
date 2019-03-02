<?php
header("Access-control-Allow-Origin: *");
header("Access-control-Allow-Methods: GET, POST");
header("Access-control-Allow-Headers: X-Requested-with");
header("Content-type: text/html; charset=utf-8");
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Usuario.php';
require_once dirname(__FILE__) . '/../Clases/Usuario_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Persona.php';
require_once dirname(__FILE__) . '/../Clases/Telefono_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Rol.php';
require_once dirname(__FILE__) . '/../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Gravado_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/RLlanta_Detalle.php';
require_once dirname(__FILE__) . '/../Clases/Solicitud_Eliminar_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo_Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/RII_Detalles.php';
require_once dirname(__FILE__) . '/../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Insumo_Terminacion.php';
require_once dirname(__FILE__) . '/../Clases/Novedad_Puesto_Trabajo.php';
require_once dirname(__FILE__) . '/../Clases/Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Detalle_Servicio.php';
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
require_once dirname(__FILE__) . '/../Clases/Posicion_Camara.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso.php';
require_once dirname(__FILE__) . '/../Clases/Uso_Insumo_Proceso_Detalle.php';
require_once dirname(__FILE__) . '/../Clases/Salida_Llanta.php';
date_default_timezone_set("America/Bogota");
switch ($_GET['metodo']) {
	case 'registrarRechazos':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            $inspeccionInicial=new Inspeccion_Inicial('id', $_GET['idInspeccion'], null, null);
            //Grabar Rechazo_Inspeccion_Inicial
            //print_r($_GET);
                //Eliminacion de registro antiguos
                $RII=new Rechazo_Inspeccion_Inicial('idInspeccionInicial', $inspeccionInicial->getId(), null, null);
                if ($RII->getId()!=NULL){
                    $RII->eliminar();//Por condicion de llave foranea se eleminan todos los registros de RII_Detalles, Replantear si sebe cambiar por una cadena sql
                }
                //Fin Eliminacion de registro antiguos
            $objeto=new Rechazo_Inspeccion_Inicial(null, null, null, null);
            $objeto->setIdInspeccionInicial($inspeccionInicial->getId());
            $objeto->setObservaciones($_GET['observaciones']);
            $objeto->setFechaRegistro(date('Y-m-d H:i:s'));
            $objeto->grabar();
            //Fin Grabar Rechazo_Inspeccion_Inicial
            //Grabar rii_detalles
            $RII=new Rechazo_Inspeccion_Inicial('idInspeccionInicial', $inspeccionInicial->getId(), null, null);
            $sql="select registrarrechazos({$RII->getId()}, '{$_GET['rechazos']}')";
            $result= Conector::ejecutarQuery($sql, null);
            //Fin Grabar rii_detalles
            //print_r($result);
            echo '{"response": "ok"}';
        break;
	case 'registrarRechazosLlanta':
            
            /*
             * En esta seccion se lleva acabo el registro de los rechazos de un 
             * proceso para una llanta, como resultado se retorna una String, la
             * cual sirve para identificar el tipo de resultado generado durante
             * el procesp:
             * 
             * ID: Incomplete Data -> Datos incompletos
             * FEX: Failed to execute -> Fallo al ejecutar
             * NR: Not registred -> No registrado
             * OK: Success -> Datos ejecutados correctamente
             * 
             */
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            //print_r($request);die();
            if (isset($request->idProceso) && isset($request->idLlanta) && isset($_GET['rechazos'])){
                $rechazoLlanta=new Rechazo_Llanta('idLlanta', $request->idLlanta, " and proceso=$request->proceso and idProceso=$request->idProceso", null);
                if ($rechazoLlanta->getId()!=null && $rechazoLlanta->getId()!=''){
                    $rechazoLlanta->eliminarDetalles();
                    $rechazoLlanta->eliminar();
                }
                $rechazoLlanta=new Rechazo_Llanta(null, null, null, null);
                $rechazoLlanta->setIdLlanta($request->idLlanta);
                $rechazoLlanta->setProceso($request->proceso);
                $rechazoLlanta->setIdProceso($request->idProceso);
                $rechazoLlanta->setObservaciones($request->observaciones);
                $rechazoLlanta->setFechaRegistro(date("Y-m-d H:i:s"));
                if ($rechazoLlanta->grabar()){
                    $rechazoLlanta=new Rechazo_Llanta('idLlanta', $request->idLlanta, " and proceso=$request->proceso and idProceso=$request->idProceso", null);
                    if ($rechazoLlanta->getId()!=null && $rechazoLlanta!=''){
                        $sql="select rechazarLlanta({$rechazoLlanta->getId()}, '{$_GET['rechazos']}')";
                        $r= Conector::ejecutarQuery($sql, null);
                        if ($r!=null) echo 'OK';
                        else echo 'FEX';
                    } else 'NR';
                } else echo 'FEX';
            } else echo 'ID';
            
        break;
	case 'grabarSolicitudEliminarLlanta':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            $llantaJSON= Llanta::getObjetoJSON("id", $_GET['idLlanta'], null, null);
            $objeto=new Solicitud_Eliminar_Llanta(null, null, null, null);
            $objeto->setIdLlanta($_GET['idLlanta']);
            $objeto->setIdEmpleado($_GET['idEmpleado']);
            $objeto->setMotivo($_GET['motivo']);
            $objeto->setEstado('f');
            $objeto->setLlantaJSON($llantaJSON);
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            $objeto->grabar();
            echo '{"response": "ok"}';
        break;
	case 'aprobarSolicitudEliminarLlanta':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            $objeto=new Solicitud_Eliminar_Llanta('id', $_GET['id'], null, null);
            $objeto->aprobar();
            echo '{"response": "ok"}';
        break;
	case 'terminarInsumo':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            //Registro de la terminacion para el insumo
            $objeto=new Insumo_Terminacion(null, null, null, null);
            $objeto->setIdInsumoPT($request->idInsumoPT);
            $objeto->setIdEmpleado($request->idEmpleado);
            $objeto->setObservaciones($request->observaciones);
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            //print_r($objeto);
            $objeto->grabar();
            //Fin Registro de la terminacion para el insumo
            echo '{"response": "ok"}';
        break;
	case 'registrarInsumo':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            //print_r($request);
            //Registro del insumo
            $objeto=new Insumo_Puesto_Trabajo(null, null, null, null);
            $objeto->setIdPuestoTrabajo($request->idPuestoTrabajo);
            $objeto->setIdInsumo($request->idInsumo);
            $objeto->setUsuario($request->usuario);
            $objeto->setCantidad($request->cantidad);
            $objeto->setEstado('t');
            $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
            //print_r($objeto);
            $objeto->grabar();
            //Fin Registro del insumo
            echo '{"response": "ok"}';
        break;
	case 'registrarNovedad':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            if (isset($request->idPuestoTrabajo) && isset($request->idEmpleado) && isset($request->novedad)){
                if (validarEmpleado($request->idEmpleado)){
                    $objeto=new Novedad_Puesto_Trabajo(null, null, null, null);
                    $objeto->setIdPuestoTrabajo($request->idPuestoTrabajo);
                    $objeto->setIdEmpleado($request->idEmpleado);
                    $objeto->setNovedad($request->novedad);
                    $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                    if ($objeto->grabar()) echo 'OK';
                    else echo 'SDE';
                } else echo 'ID';
            } else echo 'ID';
        break;

    case 'setCPC':
        if (isset($_GET['valor']) && isset($_GET['id'])){
            if ($_GET['valor']!=null && $_GET['id']!=null) {
                $vulcanizado=new Vulcanizado('id', $_GET['id'], null, null);
                $vulcanizado->setCamarasConfiguracion($_GET['valor']);
                echo $vulcanizado->getMaxPC();
            } else echo 'ID';
        } else echo 'ID';
        break;

    case 'grabarCargoEmpleado':
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            switch ($request->accion) {
                    case 'adicionar':
                            $cargoEmpleado=new Cargo_Empleado(null, null, null, null);
                            $cargoEmpleado->setNombre($request->nombre);
                            $cargoEmpleado->setDescripcion($request->descripcion);
                            $cargoEmpleado->grabar();
                            break;
                    case 'modificar':
                            $cargoEmpleado=new Cargo_Empleado('id', $request->id, null, null);
                            $cargoEmpleado->setNombre($request->nombre);
                            $cargoEmpleado->setDescripcion($request->descripcion);
                            $cargoEmpleado->modificar();
                            break;
                    case 'eliminar':
                            $cargoEmpleado=new Cargo_Empleado('id', $request->id, null, null);
                            $cargoEmpleado->eliminar();
                            break;
                    default:
                            # code...
                            break;
            }
            print_r($request);
        break;
        //OS
        //
    case 'registrarOS':
                $postdata= file_get_contents("php://input");
                $request= json_decode($postdata);
                //print_r($request);die();
                //Registro de la orden de servicio
                $objeto=new Servicio(null, null, null, null);
                $objeto->setIdCliente($request->idCliente);
                $objeto->setIdVendedor($request->idVendedor);
                $objeto->setOs($request->os);
                $objeto->setNumeroFactura($request->numeroFactura);
                //$objeto->setObservaciones($request->observaciones);
                //$objeto->setNumeroFactura(Servicio::getNextNumeroFactura());
                $objeto->setObservaciones("");
                $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
                if (isset($request->fechaRecoleccion)){
                    if ($request->fechaRecoleccion!=null) {
                        $fechaRecoleccion=$request->fechaRecoleccion;
                    }
                    else $fechaRecoleccion=date("Y-m-d");
                } else $fechaRecoleccion=date("Y-m-d");
                $objeto->setFechaRecoleccion($fechaRecoleccion);
                //print_r($objeto);
                if ($objeto->grabar()){
                    $os=new Servicio('os', "'{$request->os}'", null, null);
                    if ($os->getId()!=null && $os->getId()!='') echo Servicio::getObjetoJSON ('id', $os->getId(), null, null);
                    else echo Servicio::getObjetoJSON (null, null, null, null);
                } else echo Servicio::getObjetoJSON (null, null, null, null);
                //Fin Registro de la orden de servicio
                //--------------------------------------------------------------
                //Registro de tipos de servicio para la orden de servicio
                //
                if ($request->tiposServicio!=null && $request->tiposServicio!=''){
                    $detalleServicio=new Detalle_Servicio('idServicio', $os->getId(), null, null);
                    if ($detalleServicio->getId()!=null && $detalleServicio->getId()!='') $detalleServicio->eliminar();
                    $sql="select registrarTiposServicio({$os->getId()}, '$request->tiposServicio')";
                    Conector::ejecutarQuery($sql, null);
                }
                //
                //Fin Registro de tipos de servicio para la orden de servicio
            break;
        //
        //FIN OS
        //----------------------------------------------------------------------
        //LLANTAS OS
        //
    case 'crudLlantasOS':
            //------------------------------------------------------------------
            //Aqui se ejecutaran los procesos de registro, actualizacion y
            //eliminacion de datos, como respuesta se devuelve un String con el 
            //tipo de resultado generado en dicha accion:
            //
            //SD: Solicitud desconocida
            //IR: Invalid request -> Solicitud invalida
            //ID: Incomplete data -> Datos incompletos
            //SDE:SAVE DATA ERROR
            //OK: DATOS GUARDADOS EXITOSAMENTE
            //
            //------------------------------------------------------------------
            foreach ($_GET as $key => $value) ${$key}=$value;
            foreach ($_POST as $key => $value) ${$key}=$value;
            //Carga de data
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            //print_r($request);die();
            //FIN Carga de data
            if (isset($accion)){
                switch ($accion){
                    
                    case 'Adicionar':
                        if (isset($request->idServicio)){
                            if (validarIdServicioLlanta($request->idServicio)){
                                echo registrarLlantaOS($request);
                            } else {
                                echo 'ID';
                                //IR= Incomplete data -> datos incompletos
                            }
                        } else {
                            echo 'ID';
                            //ID= Incomplete data -> datos incompletos
                        }
                        break;

                    case 'Delete':
                        echo deleteLlanta($request);
                        break;

                    case 'addSalida':
                        echo addSalida($request);
                        break;
                        
                    case 'RegistrarAplicacionEntregada':
                        if (isset($request->idLlanta)){
                            echo registrarDisenoEntregadoLlanta($request);
                        } else echo 'ID';
                        break;

                    default :
                        echo 'SD';
                        //SD=Solicitud desconocida -> Undefined request
                        break;
                }
            } else echo 'IR';//IR=Invalid request -> Solicitud invalida
            
            break;
        //
        //FIN LLANTAS OS
        //----------------------------------------------------------------------
        //POSICIONES CAMARA
        //
    case 'crudPosicionCamara':
            //------------------------------------------------------------------
            //Aqui se ejecutaran los procesos de registro, actualizacion y
            //eliminacion de datos, como respuesta se devuelve un String con el 
            //tipo de resultado generado en dicha accion:
            //
            //SD: Solicitud desconocida
            //IR: Invalid request -> Solicitud invalida
            //ID: Incomplete data -> Datos incompletos
            //SDE:SAVE DATA ERROR -> Error al guardar los datos
            //OK: DATOS GUARDADOS EXITOSAMENTE
            //
            //------------------------------------------------------------------
            foreach ($_GET as $key => $value) ${$key}=$value;
            foreach ($_POST as $key => $value) ${$key}=$value;
            if (isset($accion)){
                switch ($accion){
                    
                    case 'Adicionar':
                        if (isset($idVulcanizado)){
                            if (validarIdVulcanizado($idVulcanizado)){
                                echo registrarPosicionCamara($_GET);
                            } else {
                                echo 'ID';
                                //IR= Incomplete data -> datos incompletos
                            }
                        } else {
                            echo 'ID';
                            //ID= Incomplete data -> datos incompletos
                        }
                        break;
                        
                    case 'Modificar':
                        break;
                    
                    case 'Eliminar':
                        //Carga de data
                        $postdata= file_get_contents("php://input");
                        $request= json_decode($postdata);
                        //print_r($request);die();
                        //FIN Carga de data
                        if (isset($request->id)){
                            if ($request->id!=null && $request->id!='') {
                                $objeto=new Posicion_Camara('id', $request->id, null, null);
                                if ($objeto->getId()!=null && $objeto->getId()!='') {
                                    if ($objeto->eliminar()) {
                                        if (file_exists(dirname(__FILE__) . "/../Uploads/Imgs/PC_V-$request->idVulcanizado/$request->foto")){
                                            if (unlink(dirname(__FILE__) - "/../Uploads/Imgs/PC_V-$request->idVulcanizado/$request->foto")) $ok=true;
                                            /*try {
                                                if (rmdir(dirname(__FILE__) . "/../Uploads/Imgs/PC_V-$request->idVulcanizado/$request->foto")) $ok=true;
                                            } catch (Exception $ex) {
                                                
                                            }*/
                                        }
                                        echo 'OK';
                                    }
                                    else echo 'SDE';
                                } else echo 'ID';
                            } else echo 'ID';
                        } else echo 'ID';
                        break;
                    default :
                        echo 'SD';
                        //SD=Solicitud desconocida -> Undefined request
                        break;
                }
            } else echo 'IR';//IR=Invalid request -> Solicitud invalida
            
            break;
        //
        //FIN POSICIONES CAMARAS
        //
        //
        //USOS INSUMOS
        case 'crudUsosInsumos':
            //------------------------------------------------------------------
            //Aqui se ejecutaran los procesos de registro, actualizacion y
            //eliminacion de datos, como respuesta se devuelve un String con el 
            //tipo de resultado generado en dicha accion:
            //
            //SD: Solicitud desconocida
            //IR: Invalid request -> Solicitud invalida
            //ID: Incomplete data -> Datos incompletos
            //SDE:SAVE DATA ERROR -> Error al guardar los datos
            //OK: DATOS GUARDADOS EXITOSAMENTE
            //
            //------------------------------------------------------------------
            foreach ($_GET as $key => $value) ${$key}=$value;
            foreach ($_POST as $key => $value) ${$key}=$value;
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
//            print_r($request);
//            print_r($_POST);
//            print_r($_GET);
//            print_r($_FILES);
//            die();
            if (isset($accion)){
                switch ($accion){
                    
                    case 'Usar':
                        if (isset($request->idEmpleado) && isset($request->idProceso) && isset($request->proceso)){
                            if (validarEmpleado($request->idEmpleado) && validarProceso($request->idProceso, $request->proceso)){
                                echo registrarUsosInsumosProceso($request);
                            } else {
                                echo 'ID';
                            }
                        } else {
                            echo 'ID';
                        }
                        break;
                        
                    case 'Terminar':
                        if (isset($idInsumo) && isset($idEmpleado)){
                            if (validarInsumo($idInsumo) && validarEmpleado($idEmpleado)) echo registrarTerminacionInsumo($_GET, $_FILES);
                            else echo 'ID';
                        } else echo 'ID';
                        break;
                    
                    default :
                        echo 'SD';
                        break;
                }
            } else echo 'IR';
            
            break;
        //FIN USOS INSUMOS
        //CAMBIAR CLAVE
        case 'cambiarClave':
            //------------------------------------------------------------------
            //Aqui se ejecutaran los procesos de actualizacion de contraseña y
            //como respuesta se devuelve un String con el tipo de resultado 
            //generado en dicha accion:
            //
            //SD: Solicitud desconocida
            //IR: Invalid request -> Solicitud invalida
            //ID: Incomplete data -> Datos incompletos
            //SDE:SAVE DATA ERROR -> Error al guardar los datos
            //OK: DATOS GUARDADOS EXITOSAMENTE
            //
            //------------------------------------------------------------------
            foreach ($_GET as $key => $value) ${$key}=$value;
            foreach ($_POST as $key => $value) ${$key}=$value;
            if (isset($id) && isset($claveNueva)){
                if ($id!=null && $claveNueva!=null){
                    $objeto=new Usuario('id', $id, null, null);
                    if ($objeto->getUsuario()!=null){
                        $objeto->setClave($claveNueva);
                        if ($objeto->cambiarClave()) echo 'OK';
                        else echo 'SDE';
                    } else echo 'ID';
                } else echo 'ID';
            } else echo 'ID';
            break;
        //FIN CAMBIAR CLAVE
        //

    case 'addCorteBanda':
        echo addCorteBandaOP();
        break;

    case 'setTiempoInicialPR':
        echo setTiempoInicialPR();
        break;

    case 'actionsNovedadPuestoTrabajo':
        foreach ($_GET as $key => $val) ${$key}=$val;
        foreach ($_POST as $key => $val) ${$key}=$val;
        if (isset($action)){
            $postdata= file_get_contents("php://input");
            $request= json_decode($postdata);
            switch ($action) {
                case 'R':
                    echo revisarNovedad($request);
                    break;
                case 'D':
                    echo deleteNovedadPuestoTrabajo($request);
                    break;
                default: echo 'IR'; break;
            }
        } else echo 'IR';
        break;

    default:
        echo 'SD';
        break;
}

function validarIdVulcanizado($_IdVulcanizado) {
    if ($_IdVulcanizado!=null && $_IdVulcanizado!='') return true;
    else return false;
}

function validarIdServicioLlanta($_IdServicio) {
    if ($_IdServicio!=null && $_IdServicio!='') return true;
    else return false;
}

function parseUrgenteLlantaOS($x) {
    if ($x) return 't';
    else return 'f';
}

function registrarDisenoEntregadoLlanta($json) {
    //--------------------------------------------------------------------------
    //Esta funcion realiza el proceso de registro del dato 
    //'idAplicacionEntregada' para una llanta y retorna un String que identifica
    //el tipo de resultado:
    //
    //SDE:SAVE DATA ERROR
    //OK: DATOS GUARDADOS EXITOSAMENTE
    //
    //--------------------------------------------------------------------------
    $objeto=new Llanta('id', $json->idLlanta, null, null);
    if ($objeto->getId()!=null && $objeto->getId()!=''){
        $objeto->setIdAplicacionEntregada($json->idAplicacionEntregada);
        if ($objeto->updateAplicacionEntregada($json->observaciones)) return 'OK';
        else return 'SDE';
    } else return 'ID';
    //$objeto->grabar();
}

function registrarLlantaOS($json) {
    //--------------------------------------------------------------------------
    //Esta funcion realiza el proceso de registro para una llanta y retorna un
    //String que identifica el tipo de resultado:
    //
    //SDE:SAVE DATA ERROR
    //OK: DATOS GUARDADOS EXITOSAMENTE
    //
    //--------------------------------------------------------------------------
    $idDimension=null;
    if (isset($json->idDimension) && isset($json->dimension)){
        if ($json->idDimension==0 && $json->dimension!=null){
            $dimension=new Dimension_Llanta('dimension', "'$json->dimension'", null, null);
            if ($dimension->getId()!=null) $idDimension=$dimension->getId();
            else {
                $dimension->setDimension($json->dimension);
                $dimension->setDescripcion(null);
                $dimension->setFechaRegistro(date("Y-m-d H:i:s"));
                $dimension->grabar();
                $sql="select max(id) as id from dimension_llanta;";
                $result=Conector::ejecutarQuery($sql, null);
                if ($result!=null){
                    if ($result[0]['id']!=null) $idDimension=$result[0]['id'];
                }
            }
        } else $idDimension=$json->idDimension;
    } else {
        echo 'ID';
        die();
    }
    $objeto=new Llanta(null, null, null, null);
    $objeto->setConsecutivo(Llanta::getNextConsecutivo($json->idServicio));
    $objeto->setIdServicio($json->idServicio);
    $objeto->setIdGravado($json->idGravado);
    $objeto->setIdMarca($json->idMarca);
    $objeto->setIdDimension($idDimension);
    $objeto->setRp($json->rp);
    $objeto->setSerie($json->serie);
    $objeto->setIdReferenciaOriginal($json->idReferenciaTipoDisenoOriginal->id);
    $objeto->setIdReferenciaSolicitada($json->idReferenciaTipoDisenoSolicitado->id);
    //$objeto->setIdAplicacionOriginal($json->idAplicacionOriginal->id);
    //$objeto->setIdAplicacionSolicitada($json->idAplicacionSolicitada->id);
    //$objeto->setIdAplicacionEntregada("null");
    $objeto->setUrgente(parseUrgenteLlantaOS($json->urgente));
    $objeto->setProcesado('f');
    $objeto->setObservaciones($json->observaciones);
    $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
    if ($objeto->grabar()){
        $llanta=new Llanta('serie', $json->serie, null, null);
        if ($llanta->getId()!=null && $llanta->getId()!=''){
            echo 'OK';
        } else {
            echo 'SDE';
        }
    } else {
        echo 'SDE';
        //SDE=Save data error -> Error al guardar el registro
    }
    //$objeto->grabar();
}

function deleteLlanta($json){
    if (isset($json->id)){
        if ($json->id!=null){
            $objeto=new Llanta('id', $json->id, null, null);
            if ($objeto->getRp()!=null) {
                $objeto->eliminar();
                return 'OK';
            } else return 'ID';
        } else return 'ID';
    } else return 'ID';
    die();
}

function addSalida($json){
    if (isset($json->id) && isset($json->valor)){
        if ($json->id!=null){
            $object=new Salida_Llanta(null, null, null, null);
            $object->setIdLlanta($json->id);
            $object->setValor($json->valor);
            $object->setFechaRegistro(date("Y-m-d H:i:s"));
            if ($object->add()) return 'OK';
            else return 'SDE';
        } else return 'ID';
    } else return 'ID';
}

function registrarPosicionCamara($Datos) {
    //--------------------------------------------------------------------------
    //Esta funcion realiza el proceso de registro para una posicion de camara y 
    //retorna un String que identifica el tipo de resultado:
    //
    //SDE:SAVE DATA ERROR -> Error al guardar los datos
    //OK: DATOS GUARDADOS EXITOSAMENTE
    //
    //--------------------------------------------------------------------------
    foreach ($Datos as $key => $value) ${$key}=$value;
    $objeto=new Posicion_Camara(null, null, null, null);
    $objeto->setIdVulcanizado($idVulcanizado);
    $objeto->setIdServicio("null");
    $objeto->setPosicion($posicion);
    if (isset($_FILES['file'])){
        if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/PosicionesCamaras/PC_V-$idVulcanizado/")){
            if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/PosicionesCamaras/PC_V-$idVulcanizado/", 0777)) $ok=true;
        }
        $foto=$_FILES['file']['name'];
        $cutExt= substr($foto, strpos($foto, "."));
        $namePhoto= Posicion_Camara::getNextId() . "_" . date("Y-m-d") . $cutExt;
        move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/PosicionesCamaras/PC_V-$idVulcanizado/$namePhoto");
    } else $namePhoto="";
    $objeto->setFoto($namePhoto);
    $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
    if ($objeto->grabar()){
        $posicionCamara=new Posicion_Camara('idVulcanizado', $idVulcanizado, " and fechaRegistro='{$objeto->getFechaRegistro()}'", null);
        if ($posicionCamara->getId()!=null && $posicionCamara->getId()!=''){
            echo 'OK';
        } else {
            echo 'SDE';
        }
    } else {
        echo 'SDE';
    }
}

//REGISTRO DE USOS DE INSUMOS EN X PROCESO
function validarInsumo($id) {
    $valid=false;
    if ($id!=null && $id!=''){
        $insumo=new Insumo_Puesto_Trabajo('id', $id, null, null);
        if ($insumo->getId()!=null && $insumo->getId()!='') $valid=true;
    }
    return $valid;
}

function validarEmpleado($id) {
    $valid=false;
    if ($id!=null && $id!=''){
        $empleado=new Empleado('id', $id, null, null);
        if ($empleado->getId()!=null && $empleado->getId()!='') $valid=true;
    }
    return $valid;
}

function validarProceso($id, $nProceso) {
    $valid=false;
    if ($id!=null && $id!='' && $nProceso!=null && $nProceso!=''){
        $proceso=new Uso_Insumo_Proceso(null, null, null, null);
        $proceso->setProceso($nProceso);
        $nombreTabla=$proceso->getNombreProceso(true);
        $objeto=new $nombreTabla('id', $id, null, null);
        if ($objeto->getId()!=null && $objeto->getId()!='') $valid=true;
    }
    return $valid;
}

function registrarUsosInsumosProceso($json) {
    //--------------------------------------------------------------------------
    //Esta funcion realiza el proceso de registro para los usos de un insumo
    //y retorna un String que identifica el tipo de resultado:
    //
    //SDE:SAVE DATA ERROR
    //OK: DATOS GUARDADOS EXITOSAMENTE
    //
    //--------------------------------------------------------------------------
    //$result='';
    //$objeto=new Uso_Insumo_Proceso('idProceso', $json->idProceso, " and proceso=$json->proceso and idEmpleado=$json->idEmpleado", null);
    //print_r($json);
    //die();
    $objeto=new Uso_Insumo_Proceso('idProceso', $json->idProceso, " and proceso=$json->proceso", null);
    //print_r($objeto);
    //die();
    if ($objeto->getId()!=null && $objeto->getId()!='') {
        if (isset($json->insumosId)){
            if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->insumosId)) $result='OK';
            else $result='SDE';
        } else {
            if (isset($json->cantidad)){
                if ($json->cantidad!=null){
                    $newUse=new Uso_Insumo_Proceso_Detalle(null, null, null, null);
                    $newUse->setIdUsoInsumoProceso($objeto->getId());
                    $newUse->setIdInsumoPt($json->idInsumo);
                    $newUse->setCantidad($json->cantidad);
                    $newUse->setTerminado('f');
                    $newUse->setUsado('t');
                    $newUse->setIdEmpleado($json->idEmpleado);
                    $newUse->setFechaRegistro(date("Y-m-d H:i:s"));
                    if ($newUse->grabar()) $result="OK";
                    else $result="SDE";
                } else {
                    if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->idInsumo)) $result='OK';
                    else $result='SDE';
                }
            } else {
                if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->idInsumo)) $result = 'OK';
                else $result='SDE';
            }
            //if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->idInsumo)) $result='OK';
        }
    } else {
        $objeto=new Uso_Insumo_Proceso(null, null, null, null);
        $objeto->setIdEmpleado($json->idEmpleado);
        $objeto->setIdProceso($json->idProceso);
        $objeto->setProceso($json->proceso);
        $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
        if ($objeto->grabar()){
            $objeto=new Uso_Insumo_Proceso('idProceso', $json->idProceso, " and proceso=$json->proceso and idEmpleado=$json->idEmpleado", null);
            if ($objeto->getId()!=null && $objeto->getId()!=''){
                if (isset($json->insumosId)){
                    if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->insumosId)) $result='OK';
                    else $result='SDE';
                } else {
                    if (isset($json->cantidad)){
                        if ($json->cantidad!=null){
                            $newUse=new Uso_Insumo_Proceso_Detalle(null, null, null, null);
                            $newUse->setIdUsoInsumoProceso($objeto->getId());
                            $newUse->setIdInsumoPt($json->idInsumo);
                            $newUse->setCantidad($json->cantidad);
                            $newUse->setTerminado('f');
                            $newUse->setUsado('t');
                            $newUse->setIdEmpleado($json->idEmpleado);
                            $newUse->setFechaRegistro(date("Y-m-d H:i:s"));
                            if ($newUse->grabar()) $result="OK";
                            else $result="SDE";
                        } else {
                            if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->idInsumo)) $result='OK';
                            else $result='SDE';
                        }
                    } else {
                        if (Uso_Insumo_Proceso_Detalle::registrarUsos($objeto->getId(), $json->idEmpleado, $json->idInsumo)) $result='OK';
                        else $result='SDE';
                    }
                }
            } else $result='SDE';
        } else $result='SDE';
    }
    return $result;
}
//FIN REGISTRO DE USOS DE INSUMOS EN X PROCESO

//REGISTRO TERMINACION INSUMO
function registrarTerminacionInsumo($Datos, $Archivos) {
    //--------------------------------------------------------------------------
    //Esta funcion realiza el proceso de registro de terminacion para un insumo 
    //y retorna un String que identifica el tipo de resultado:
    //
    //SDE:SAVE DATA ERROR -> Error al guardar los datos
    //OK: DATOS GUARDADOS EXITOSAMENTE
    //
    //--------------------------------------------------------------------------
    //echo Insumo_Terminacion::getNextId();
    //die();
    foreach ($Datos as $key => $value) ${$key}=$value;
    $objeto=new Insumo_Terminacion(null, null, null, null);
    $objeto->setIdInsumoPT($idInsumo);
    $objeto->setIdEmpleado($idEmpleado);
    @$objeto->setObservaciones($observaciones);
    if (isset($_FILES['file'])){
        if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/TerminacionInsumos/")){
            if (mkdir(dirname(__FILE__) . "/../Uploads/Imgs/TerminacionInsumos/", 0777)) $ok=true;
        }
        $foto=$_FILES['file']['name'];
        $cutExt= substr($foto, strpos($foto, "."));
        $namePhoto= Insumo_Terminacion::getNextId() . "_" . date("Y-m-d") . $cutExt;
        move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/TerminacionInsumos/$namePhoto");
    } else $namePhoto="";
    $objeto->setFoto($namePhoto);
    $objeto->setFechaRegistro(date("Y-m-d H:i:s"));
    if ($objeto->grabar()){
        $dato=new Insumo_Terminacion('idInsumoPT', $idInsumo, " and idEmpleado=$idEmpleado", null);
        if ($dato->getId()!=null && $dato->getId()!='') echo 'OK';
        else echo 'SDE';
    } else echo 'SDE';
}
//FIN REGISTRO TERMINACION INSUMO

function addCorteBandaOP(){
    foreach ($_GET as $key => $value) ${$key}=$value;
    foreach ($_POST as $key => $value) ${$key}=$value;
    //$postdata= file_get_contents("php://input");
    //$request= json_decode($postdata);
    if ($_FILES!=null && isset($empates) && isset($idPuestoTrabajo) && isset($id) && isset($idEmpleado)){
        $object=new Corte_Banda('id', $id, null, null);
        if ($object->getIdPreparacion()!=null){
            $object->setIdPuestoTrabajo($idPuestoTrabajo);
            $object->setIdEmpleado($idEmpleado);
            if (isset($_FILES['file'])){
                //if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/PosicionesCamaras/PC_V-$idVulcanizado/")){
                //if (!is_dir(dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/")){
                if (!is_dir("./../Uploads/Imgs/Corte_Banda/")){
                    if (mkdir("./../Uploads/Imgs/Corte_Banda/", 0777)) {/*ok*/}
                }
                $file=$_FILES['file']['name'];
                $ext=substr($file, strpos($file, '.'));
                $fecha=explode($object->getFechaRegistro(), " ");
                $foto=$object->getId() . "_" . $fecha[0] . "_CB" . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'], dirname(__FILE__) . "/../Uploads/Imgs/Corte_Banda/$foto");
            }
            $object->setFoto($foto);
            $object->setEmpates($empates);
            $object->setEstado("t");
            if (isset($observaciones)) $object->setObservaciones($observaciones);
            if ($object->addCorteBanda()) echo 'OK';
            else echo 'SDE';
        } else echo 'ID';
    } else echo 'ID';
}

function setTiempoInicialPR(){
    foreach ($_GET as $key => $value) ${$key}=$value;
    foreach ($_POST as $key => $value) ${$key}=$value;
    if (isset($idLlanta)){
        $llanta=new Llanta('id', $idLlanta, null, null);
        if ($llanta->getRp()!=null){
            $llanta->setFechaInicioProceso(date("Y-m-d H:i:s"));
            if ($llanta->updateFechaInicioProceso()) return 'OK';
            else return 'SDE';
        } else return 'ID';
    } else return 'ID';
}

//Code update 07-09-2018
function revisarNovedad($data) {
    $result='ID';
    if ($data!=null) {
        if ($data->id!=null) {
            $object= new Novedad_Puesto_Trabajo('id', $data->id, null, null);
            if ($object->revisar())  $result='OK';
            else $result='SDE';
        }
    }
    return $result;
}

function deleteNovedadPuestoTrabajo($data) {
    $resul='ID';
    if ($data!=null) {
        if ($data->id!=null) {
            $object= new Novedad_Puesto_Trabajo('id', $data->id, null, null);
            if ($object->eliminar())  $result='OK';
            else $result='SDE';
        }
    }
    return $result;
}
//End code update 07-09-2018

?>