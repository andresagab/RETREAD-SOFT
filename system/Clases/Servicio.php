<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Servicio:
 *
 * Define las propiedades id, idCliente, observaciones, os, fechaRegistro las cuales permite identificar el servicio de una llanta.
 *
 * El atributo idCliente ayudara a relacionar una llanta ya registrada con un nuevo servicio de rencauche.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Servicio {
    //Propiedades
    private $id;
    private $idCliente;
    private $idVendedor;
    private $os;
    private $numeroFactura;
    private $observaciones;
    private $estado;
    private $fechaRecoleccion;
    private $fechaRegistro;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='panam';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, idCliente, idVendedor, os, numeroFactura, observaciones, estado, fecharecoleccion, fechaRegistro from {$P}servicio where $campo=$valor $filtro $orden";
                $resultado=Conector::ejecutarQuery($sql, null);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $key => $value) $this->$key=$value;
                    $this->cargarAtributos($resultado[0]);
                }
            }
    	} else return null;
    }
    //Fin constructor

    private function cargarAtributos($arreglo){
    	$this->idCliente=$arreglo['idcliente'];
    	$this->idVendedor=$arreglo['idvendedor'];
    	$this->numeroFactura=$arreglo['numerofactura'];
    	$this->fechaRecoleccion=$arreglo['fecharecoleccion'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }

    function getId() {
        return $this->id;
    }

    function getIdCliente() {
        return $this->idCliente;
    }

    function getIdVendedor() {
        return $this->idVendedor;
    }

    function getOs() {
        return $this->os;
    }
    
    function getNumeroFactura() {
        return $this->numeroFactura;
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!='' && $this->observaciones!='---') return $this->observaciones;
        else return 'Sin observaciones';
    }
    
    function getEstado() {
        return $this->estado;
    }
    
    function getNombreEstado() {
        switch (strtolower($this->estado)) {
            case 'c':
                return 'Cerrada';
                break;
            case 'a':
                return 'Anulada';
                break;
            case 'o':
                //Open -> Abierta
                return 'Abierta';
                break;
            default:
                return 'Desconocido';
                break;
        }
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getCliente() {
        if ($this->idCliente!=null) return new Cliente ('id', $this->idCliente, null, null);
        else return new Cliente (null, null, null, null);
    }
    
    function getVendedor() {
        if ($this->idVendedor!=null) return new Empleado ('id', $this->idVendedor, null, null);
        else return new Empleado (null, null, null, null);
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setIdVendedor($idVendedor) {
        $this->idVendedor = $idVendedor;
    }

    function setOs($os) {
        $this->os = $os;
    }

    function setNumeroFactura($numeroFactura) {
        $this->numeroFactura = $numeroFactura;
    }
    
    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
    
    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    /**
     * @return mixed
     */
    public function getFechaRecoleccion()
    {
        return $this->fechaRecoleccion;
    }

    /**
     * @param mixed $fechaRecoleccion
     */
    public function setFechaRecoleccion($fechaRecoleccion)
    {
        $this->fechaRecoleccion = $fechaRecoleccion;
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}servicio (idCliente, idVendedor, os, numeroFactura, observaciones, fechaRecoleccion, fechaRegistro, estado) values ($this->idCliente, $this->idVendedor, '$this->os', '$this->numeroFactura', '$this->observaciones', '$this->fechaRecoleccion', '$this->fechaRegistro', 'o')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function modificar() {
        $P='';
        $sql="update {$P}servicio set idCliente=$this->idCliente, idVendedor=$this->idVendedor, os='$this->os', numeroFactura='$this->numeroFactura', observaciones='$this->observaciones', fechaRecoleccion='$this->fechaRecoleccion' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function cerrarOS() {
        $P='';
        $sql="update {$P}servicio set estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}servicio where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idCliente, idVendedor, os, numeroFactura, observaciones, estado, fecharecoleccion, fechaRegistro from {$P}servicio $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Servicio::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Servicio($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Servicio($campo, $valor, $filtro, $orden);
        else $objeto=new Servicio(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idCliente']=$objeto->getIdCliente();
        $arreglo['idVendedor']=$objeto->getIdVendedor();
        $arreglo['os']=$objeto->getOs();
        $arreglo['numeroFactura']=$objeto->getNumeroFactura();
        $arreglo['observaciones']= rtrim($objeto->getObservaciones());
        $arreglo['estado']= $objeto->getEstado();
        $arreglo['nombreEstado']= $objeto->getNombreEstado();
        /*if ($objeto->getEstado()==null && $objeto->getId()!=null && $objeto->getEstadoRencauchesOS()) $arreglo['btnCerrarOS']=false;
        else $arreglo['btnCerrarOS']=true;*/
        $arreglo['btnCerrarOS']=$objeto->getBtnCerrarOS();
        $arreglo['btnAcciones']=$objeto->getBtnAcciones();
        if ($objeto->getEstado()!=null) {
            $arreglo['alertaCerrada']=true;
            $arreglo['colorAlertaCerrada']=$objeto->getColorAlertaCerrada();
            $arreglo['mjsCerrada']=$objeto->getMjsOSCerrada();
        } else {
            $arreglo['alertaCerrada']=false;
            $arreglo['colorAlertaCerrada']=$objeto->getColorAlertaCerrada();
            $arreglo['mjsCerrada']=$objeto->getMjsOSCerrada();
        }
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['fechaRecoleccion']=$objeto->getFechaRecoleccion();
        $arreglo['cliente']= json_decode(Cliente::getObjetoJSON('id', $objeto->getIdCliente(), null, null));
        $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdVendedor(), null, null));
        $arreglo['colorEstado']=$objeto->getColorEstado();
        $arreglo['colorLetraEstado']=$objeto->getColorLetraEstado($arreglo['colorEstado']);
        $arreglo['numeroLlantas']=$objeto->getNumeroLlantas();
        $arreglo['btnEliminar']=$objeto->getBtnEliminar($arreglo['numeroLlantas']);
        $arreglo['campoNFactura']=$objeto->getCampoNFactura();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Servicio::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idCliente']=$objeto->getIdCliente();
            $arreglo['idVendedor']=$objeto->getIdVendedor();
            $arreglo['os']=$objeto->getOs();
            $arreglo['numeroFactura']=$objeto->getNumeroFactura();
            $arreglo['observaciones']= rtrim($objeto->getObservaciones());
            $arreglo['estado']= $objeto->getEstado();
            $arreglo['nombreEstado']= $objeto->getNombreEstado();
            /*if ($objeto->getEstado()==null && $objeto->getId()!=null && $objeto->getEstadoRencauchesOS()) $arreglo['btnCerrarOS']=false;
            else $arreglo['btnCerrarOS']=true;*/
            $arreglo['btnCerrarOS']=$objeto->getBtnCerrarOS();
            $arreglo['btnAcciones']=$objeto->getBtnAcciones();
            if ($objeto->getEstado()!=null) {
                $arreglo['alertaCerrada']=true;
                $arreglo['colorAlertaCerrada']=$objeto->getColorAlertaCerrada();
                $arreglo['mjsCerrada']=$objeto->getMjsOSCerrada();
            } else {
                $arreglo['alertaCerrada']=false;
                $arreglo['colorAlertaCerrada']=$objeto->getColorAlertaCerrada();
                $arreglo['mjsCerrada']=$objeto->getMjsOSCerrada();
            }
            $arreglo['fechaRecoleccion']=$objeto->getFechaRecoleccion();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['cliente']= json_decode(Cliente::getObjetoJSON('id', $objeto->getIdCliente(), null, null));
            $arreglo['empleado']= json_decode(Empleado::getObjetoJSON('id', $objeto->getIdVendedor(), null, null));
            $arreglo['colorEstado']=$objeto->getColorEstado();
            $arreglo['colorLetraEstado']=$objeto->getColorLetraEstado($arreglo['colorEstado']);
            $arreglo['numeroLlantas']=$objeto->getNumeroLlantas();
            $arreglo['btnEliminar']=$objeto->getBtnEliminar($arreglo['numeroLlantas']);
            $arreglo['campoNFactura']=$objeto->getCampoNFactura();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getListaPersonalizadaJSON($filtro, $orden) {
        if ($filtro!=null) $filtro=" and $filtro";
        $sql="select s.id, s.os, s.numerofactura, pe.nombres || ' ' || pe.apellidos as vendedor, e.id as idVendedor, e.identificacion as identificacionVendedor, c.id as idCliente, pc.nombres || ' ' || pc.apellidos as cliente, c.identificacion as identificacionCliente, s.fecharegistro as fechaRegistroOs, s.fecharecoleccion as fechaRecoleccion,  
            from servicio as s, cliente as c, empleado as e, persona as pe, persona as pc
            where e.id=s.idvendedor
            and pe.identificacion=e.identificacion
            and c.id=s.idcliente
            and pc.identificacion=c.identificacion $filtro $orden";
        $r=Conector::ejecutarQuery($sql, null);
        $JSON=array();
        if ($r!=null){
            $array=array();
            if (count($r)>0){
                for ($i = 0; $i < count($r); $i++) {
                    foreach ($r[$i] as $key => $value) ${$key}=$value;
                    $objeto=new Servicio(null, null, null, null);
                    $objeto->setId($id);
                    $array['id']=$id;
                    $array['os']=$os;
                    $array['numeroFactura']=$numerofactura;
                    $array['vendedor']=$vendedor;
                    $array['idVendedor']=$idvendedor;
                    $array['identificacionVendedor']=$identificacionvendedor;
                    $array['idCliente']=$idcliente;
                    $array['cliente']=$cliente;
                    $array['identificacionCliente']=$identificacioncliente;
                    $array['fechaRegistro']=$fecharegistroos;
                    $array['fechaRecoleccion']=$fecharecoleccion;
                    $array['colorEstado']=$objeto->getColorEstado();
                    $array['numeroLlantas']=$objeto->getNumeroLlantas();
                    $array['btnEliminar']=$objeto->getBtnEliminar($array['numeroLlantas']);
                    array_push($JSON, $array);
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getTiempoTranscurrido($timeStar) {
        date_default_timezone_set("America/Bogota");
        $timepoInicial=new DateTime($timeStar, null);
        $timepoActual=new DateTime(date("Y-m-d H:i:s"), null);
        $diff=date_diff($timepoInicial, $timepoActual, null);
        foreach ($diff as $key => $value) ${$key}=$value;
        $diferencia="$y-$m-$d $h:$i:$s";
        return $diferencia;
    }
    
    public static function getNextNumeroFactura() {
        global $P, $BD;
        $sql="select numeroFactura as numero from servicio order by numerofactura desc";
        $r= Conector::ejecutarQuery($sql, null);
        if ($r!=null){
            if ($r[0]['numero']!=null) return $r[0]['numero']+1;
            else 1;
        } else return 1;
    }
    
    public function getTiposServicio() {
        $datosTipoServicio= Tipo_Servicio::getListaEnObjetos(null, null);
        if ($this->id!=null && $this->id!='') $datosDetalleServicio= Detalle_Servicio::getListaEnObjetos("idServicio=$this->id", null);
        else $datosDetalleServicio=null;
        $JSON=array();
        for ($i = 0; $i < count($datosTipoServicio); $i++) {
            $tipoServicio=$datosTipoServicio[$i];
            $arreglo=array();
            $arreglo['id']=$tipoServicio->getId();
            $arreglo['nombre']=$tipoServicio->getNombre();
            $arreglo['observaciones']=$tipoServicio->getObservaciones();
            $arreglo['fechaRegistro']=$tipoServicio->getFechaRegistro();
            if (count($datosDetalleServicio)>0){
                for ($j = 0; $j < count($datosDetalleServicio); $j++) {
                    $detalleServicio=$datosDetalleServicio[$j];
                    if ($detalleServicio->getIdTipoServicio()==$tipoServicio->getId()){
                        $arreglo['checked']=true;
                        $j= count($datosDetalleServicio);
                    } else $arreglo['checked']=false;
                }
            } else $arreglo['checked']=false;
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function getColorEstado() {
        $color='';
        if ($this->id!=null && $this->id!=''){
            if ($this->estado==null || $this->estado=='o') {
                $datosLlantas= Llanta::getListaEnObjetos("idServicio=$this->id", null);
                if (count($datosLlantas)>0){
                    $llantasOK=true;
                    for ($i = 0; $i < count($datosLlantas); $i++) {
                        $llanta=$datosLlantas[$i];
                        if (!$llanta->getFinRencaucheXProceso()) {
                            $llantasOK=false;
                            $i= count($datosLlantas);
                        }
                    }
                    if ($llantasOK) $color='#b1de96';
                    else $color='#f5e38a';
                } else $color='#de756d';
            } elseif ($this->estado=='c') {
                $color='#61abe2';
            } elseif ($this->estado=='a') $color='#313030';
        }
        return $color;
    }

    public function getColorEstado2() {
        $color = '';
        if ($this->id!=null && $this->id!=''){

            if ($this->estado==null || $this->estado=='o') {

                $sql = "select id from llanta where idservicio=$this->id";
                $r = Conector::ejecutarQuery($sql, null);

                if (count($r)>0) {

                    $llantasOK = true;
                    for ($i = 0; $i < count($r); $i++) {

                        $sql="select id from servicio_fin where idllanta={$r[$i][0]}";
                        $res = Conector::ejecutarQuery($sql, null);
                        if ($res==null) {
                            $i = count($r);
                            $llantasOK = false;
                        }

                    }

                    if ($llantasOK) $color = '#b1de96';
                    else $color = '#f5e38a';

                } else $color = '#de756d';

            } elseif ($this->estado=='c') {
                $color='#61abe2';
            } elseif ($this->estado=='a') $color='#313030';
        }
        return $color;
    }
    
    public function getLlantas() {
        if ($this->id!=null && $this->id!=''){
            return Llanta::getListaEnObjetos("idServicio=$this->id", null);
        } else return null;
    }
    
    public function getBtnEliminar($cantidadLlantas) {
        if ($this->id!=null && $this->id!=''){
            //if (count($this->getLlantas())>0) return false;
            //if ($this->getNumeroLlantas()>0) return false;
            if ($cantidadLlantas>0) return false;
            else return true;
        } else return false;
    }
    
    public function getNumeroLlantas() {
        global $P, $BD;
        $valor=0;
        if ($this->id!=null && $this->id!=''){
            $sql="select count(id) as total from {$P}llanta where idServicio=$this->id";
            $r= Conector::ejecutarQuery($sql, null);
            if ($r!=null){
                if ($r[0]['total']!=null) $valor=$r[0]['total'];
            }
        }
        return $valor;
    }
    
    public function getEstadoRencauchesOS() {
        /*
         * TRUE: Todas las llantas registradas han finalizado el proceso de rencauche.
         * ELSE: Hay llantas con proceso de rencacuche sin terminar
         */
        $valido=true;
        $datosLlantas= Llanta::getListaEnObjetos("idServicio=$this->id", null);
        for ($i = 0; $i < count($datosLlantas); $i++) {
            if (!$datosLlantas[$i]->getFinRencaucheXProceso()) {
                $valido=false;
                $i= count($datosLlantas);
            }
        }
        return $valido;
    }
    
    public function getColorAlertaCerrada() {
        if ($this->id!=null){
            if ($this->estado=='c') return 'success';
            elseif ($this->estado=='a') return 'danger';
            else return 'info';
        } else return 'default';
    }
    
    public function getMjsOSCerrada() {
        if ($this->id!=null){
            if ($this->estado=='c') return 'cerrada';
            elseif ($this->estado=='a') return 'anulada';
            else return 'abierta';
        } else return '';
    }
    
    public function getColorLetraEstado($colorPrimario) {
        /*
         * '': color claro
         * #313030: color oscuro
         * 
         * Con la informacion anterior se puede retornar el color de letra de 
         * acuerdo al color primario (Color de fondo)
         * 
         */
        if ($colorPrimario=='#313030') return '#fffcfc';
        else return '#000';
    }
    
    public function getBtnCerrarOS() {
        /*
         * TRUE: se permite mediante la opcion ng-hide ocultar el boton de cier-
         * re para la orden de servicio.
         * 
         * FALSE: se permite mediante la opcion ng-hide mostrar el boton de cie-
         * rre para la orden de servicio
         */
        $valid=true;
        if ($this->estado=='o' || $this->estado==''){
            $sql = "select id from llanta where idservicio={$this->id}";
            $llantas = Conector::ejecutarQuery($sql, null);
            $pendientes = false;
            for ($i=0; $i<count($llantas); $i++){
                $sql = "select id from inspeccion_inicial where idllanta={$llantas[$i][0]}";
                $idInspeccionInicial = Conector::ejecutarQuery($sql, null);
                if (count($idInspeccionInicial)>0) {
                    if ($idInspeccionInicial[0][0]!=null) {
                        $sql = "select id from servicio_fin where idllanta={$llantas[$i][0]}";
                        $idServicioFin = Conector::ejecutarQuery($sql, null);
                        if (count($idServicioFin)<=0) {
                            $pendientes = true;
                            $i = count($llantas);
                        }
                    }
                }
            }
            //if ($this->id!=null && $this->getEstadoRencauchesOS()) $valid=false;
            if ($this->id!=null && !$pendientes) $valid=false;
        }
        return $valid;
        /*
        if ($this->estado==null){
            if ($this->estado || !$this->estado) {
                if ($this->id!=null && $this->getEstadoRencauchesOS()) return true;
                else return false;
            } else return true;
        } else {
            if ($this->estado || !$this->estado) return true;
            else {
                if ($this->id!=null && $this->getEstadoRencauchesOS()) return true;
                else return false;
            }
        }
         */
    }
    
    public function getBtnAcciones() {
        /*
         * TRUE: los botones se ocultan con ng-hide (La orden de servicio ya fue cerrada).
         * FALSE: los botones no se ocultan con ng-hide (La orden de servicio no ha sido cerrada).
         * 
         */
        $valido=false;
        if ($this->estado!='o' && $this->estado!=null) $valido=true;
        return $valido;
    }
    
    public function getCampoNFactura(){
        /*
         * Esta funcion permite mostrar u ocultar el campo numero de factura de 
         * acuerdo al estado de la orden de servicio. si el estado de la os es
         * 'o' el campo se oculta en caso contrario se muestra.
         */
        if ($this->estado!='o' && $this->estado!=null) return true;
        else return false;
    }
    
    public static function getLlantasOSInformeRencauche($os) {
        $JSON=array();
        if ($os!=null){
            $sql="select s.id as idOs, s.numerofactura, s.os, ll.id as idLlanta, ll.rp, ll.serie from servicio as s, llanta as ll where ll.idservicio=s.id and os='$os' order by ll.idServicio";
            $r= Conector::ejecutarQuery($sql, null);
            if ($r!=null){
                if ($r[0]!=null || count($r)>0){
                    for ($i = 0; $i < count($r); $i++) {
                        foreach ($r[$i] as $key => $value) ${$key}=$value;
                        $arreglo=array();
                        $arreglo['idOs']=$idos;
                        $arreglo['numeroFactura']=$numerofactura;
                        $arreglo['os']=$os;
                        $arreglo['idLlanta']=$idllanta;
                        $arreglo['rp']=$rp;
                        $arreglo['serie']=$serie;
                        array_push($JSON, $arreglo);
                    }
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getDataJSON($type, $sql, $field, $value, $filter, $order){
        /*
         * TYPE= TRUE => SE RETORNA UN OBJETO JSON APARTIR DEL $field y $value
         * TYPE= FALSE => SE RETORNA UN OBJETO JSON DEL $filter y el $order
         */
        $JSON=array();
        if ($sql!=null) {
            $result=Conector::ejecutarQuery($sql, null);
            for ($i=0; $i<count($result); $i++){
                $array=array();
                foreach ($result[$i] as $key => $val){
                    $array["$key"]=$val;
                    ${$key}=$val;
                }
                $object=new Servicio(null, null, null, null);
                @$object->setId($idos);
                @$object->setIdCliente($idcliente);
                @$object->setIdVendedor($idempleado);
                @$object->setOs($os);
                @$object->setNumeroFactura($numerofactura);
                @$object->setObservaciones($observaciones);
                @$object->setEstado($estadoos);
                @$object->setFechaRegistro($fecharegistroos);
                @$object->setFechaRecoleccion($fecharecoleccionos);
                @$array['nombreEstado']= $object->getNombreEstado();
                //@$array['btnCerrarOS']=$object->getBtnCerrarOS();
                //@$array['btnAcciones']=$object->getBtnAcciones();
                /*if ($object->getEstado()!=null) {
                    $array['alertaCerrada']=true;
                    $array['colorAlertaCerrada']=$object->getColorAlertaCerrada();
                    $array['mjsCerrada']=$object->getMjsOSCerrada();
                } else {
                    $array['alertaCerrada']=false;
                    $array['colorAlertaCerrada']=$object->getColorAlertaCerrada();
                    $array['mjsCerrada']=$object->getMjsOSCerrada();
                }*/
                $array['fechaRegistro']=$object->getFechaRegistro();
                $array['colorEstado']=$object->getColorEstado2();
                $array['colorLetraEstado']=$object->getColorLetraEstado($array['colorEstado']);
                $array['numeroLlantas']=$object->getNumeroLlantas();
                $array['btnEliminar']=$object->getBtnEliminar($array['numeroLlantas']);
                //$array['campoNFactura']=$object->getCampoNFactura();
                @$array['nombresCompletosEmpleado']=$nombresempleado . " " . $apellidosempleado;
                if ($razonsocial!=NULL && $razonsocial!='') @$array['nombreEmpresa']= $razonsocial;
                else @$array['nombreEmpresa']=$nombrescliente . " " . $apellidoscliente;
                //Ingresado desde 2018-09-16 02:14
                $array['llantasRps']=json_decode($object->getRps(true));
                //End Ingresado desde 2018-09-16 02:14
                array_push($JSON, $array);
            }
        } else {
            if ($type){
                if ($val!=null) $object=new Servicio($field, $value, $filter, $order);
                else $object=new Servicio(null, null, $filter, $order);
                $array=array();
                foreach ($object as $key => $val) {
                    $array["$key"]=$val;
                }
                $object=new Servicio(null, null, null, null);
                @$array['btnCerrarOS']=$object->getBtnCerrarOS();
                @$array['btnAcciones']=$object->getBtnAcciones();
                @$object->setId($id);
                @$object->setIdCliente($idcliente);
                @$object->setIdVendedor($idempleado);
                @$object->setOs($os);
                @$object->setNumeroFactura($numerofactura);
                @$object->setObservaciones($observaciones);
                @$object->setEstado($estadoos);
                $JSON=$array;
            } else {
                $data=Servicio::getListaEnObjetos($filter, $order);
                for ($i=0; $i<count($data); $i++){
                    $object=$data[$i];
                    $array=array();
                    foreach ($object as $key => $val) {
                        $array["$key"]=$val;
                        ${$key}=$val;
                    }
                    array_push($JSON, $array);
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getNumerosFacturas($filter, $order){
        $sql="select numeroFactura from servicio $filter $order";
        $res=Conector::ejecutarQuery($sql, null);
        $JSON=array();
        //foreach ($res as $key => $val) $JSON[]=$val;
        for ($i=0; $i<count($res); $i++) $JSON[]=$res[$i][0];
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getNumerosOS($filter, $order){
        $sql="select os from servicio $filter $order";
        $res=Conector::ejecutarQuery($sql, null);
        $JSON=array();
        //foreach ($res as $key => $val) $JSON[]=$val;
        for ($i=0; $i<count($res); $i++) $JSON[]=$res[$i][0];
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public function getRps($json) {
       $data=array();
       if ($this->id!=null) {
           $sql="select rp from llanta where idservicio=$this->id";
           $result=Conector::ejecutarQuery($sql, null);
           for ($i=0; $i<count($result); $i++) {
               //$array=array();
               //$array['rp']=$result[$i]['rp'];
               $data[$i]=$result[$i]['rp'];
               //array_push($data, $array);
           }
       }
       if ($json) return json_encode($data, JSON_UNESCAPED_UNICODE);
       else return $data;
    }

    public static function getCountData() {
        $sql = "select count(id) from servicio";
        $r = Conector::ejecutarQuery($sql, null);
        if ($r!=null) {
            if ($r[0][0]!=null) return $r[0][0];
            else return 0;
        } else return 0;
    }

}
