<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */

/**
 * Descripcion de la clase Insumo_Puesto_Trabajo:
 *
 * Define las propiedades id, cantidad, estado, fechaRegistro las cuales permite identificar las marcas de llanta que se manejaran en el sistema de informacion.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Insumo_Puesto_Trabajo {
    //Propiedades
    private $id;
    private $idPuestoTrabajo;
    private $idInsumo;//Hace referencia al campo id de la tabla producto.
    private $usuario;//Hace referencia al campo usuario de la tabla usuario.
    private $cantidad;
    private $estado;
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
                $sql="select id, idPuestoTrabajo, idInsumo, usuario, cantidad, estado, fechaRegistro from {$P}insumo_puestotrabajo where $campo=$valor $filtro $orden";
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
    	$this->idPuestoTrabajo=$arreglo['idpuestotrabajo'];
    	$this->idInsumo=$arreglo['idinsumo'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdPuestoTrabajo() {
        return $this->idPuestoTrabajo;
    }

    function getIdInsumo() {
        return $this->idInsumo;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getPuestoTrabajo() {
        if ($this->idPuestoTrabajo!=null) return new Puesto_Trabajo ('id', $this->idPuestoTrabajo, null, null);
        else return new Puesto_Trabajo (null, null, null, null);
    }
    
    function getInsumo() {
        if ($this->idInsumo!=null) return new Producto ('id', $this->idInsumo, null, null);
        else return new Producto (null, null, null, null);
    }
    
    function getObjetoUsuario() {
        if ($this->usuario!=null) return new Usuario ('usuario', "'$this->usuario'", null, null);
        else return new Usuario (null, null, null, null);
    }

    function getNombreEstado() {
        //print_r($this);
        if ($this->estado) return 'Disponible';
        else return 'Terminado';
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setIdPuestoTrabajo($idPuestoTrabajo) {
        $this->idPuestoTrabajo = $idPuestoTrabajo;
    }

    function setIdInsumo($idInsumo) {
        $this->idInsumo = $idInsumo;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}insumo_puestotrabajo (idPuestoTrabajo, idInsumo, usuario, cantidad, estado, fechaRegistro) values ($this->idPuestoTrabajo, $this->idInsumo, '$this->usuario', $this->cantidad, '$this->estado', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}insumo_puestotrabajo set idPuestoTrabajo=$this->idPuestoTrabajo, idInsumo=$this->idInsumo, usuario='$this->usuario', cantidad=$this->cantidad, estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}insumo_puestotrabajo where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function updateCantidad() {
        $P='';
        if ($this->id!=null) {
            $sql="update {$P}insumo_puestotrabajo set cantidad=$this->cantidad where id=$this->id";
            Conector::ejecutarQuery($sql, null);
        }
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idPuestoTrabajo, idInsumo, usuario, cantidad, estado, fechaRegistro from {$P}insumo_puestotrabajo $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Insumo_Puesto_Trabajo::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Insumo_Puesto_Trabajo($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Insumo_Puesto_Trabajo::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getInsumo()->getPuc()->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null || $valor!='') $objeto=new Insumo_Puesto_Trabajo($campo, $valor, $filtro, $orden);
        else $objeto=new Insumo_Puesto_Trabajo (null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
        $arreglo['idInsumo']=$objeto->getIdInsumo();
        $arreglo['usuario']=$objeto->getUsuario();
        $arreglo['cantidad']= $objeto->getCantidad();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
        $arreglo['insumo']= json_decode(Producto::getObjetoJSON('id', $objeto->getIdInsumo(), null, null));
        $arreglo['objetoUsuario']= json_decode(Usuario::getObjetoJSON('usuario', "'{$objeto->getUsuario()}'", null, null));
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['chk']=false;
        $arreglo['btnActions']=$objeto->getStatusButtons();
        $arreglo['remainingStock']=$objeto->getRemainingStock();
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Insumo_Puesto_Trabajo::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idPuestoTrabajo']=$objeto->getIdPuestoTrabajo();
            $arreglo['idInsumo']=$objeto->getIdInsumo();
            //$arreglo['usuario']=$objeto->getUsuario();
            $arreglo['cantidad']= $objeto->getCantidad();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            //$arreglo['puestoTrabajo']= json_decode(Puesto_Trabajo::getObjetoJSON('id', $objeto->getIdPuestoTrabajo(), null, null));
            $arreglo['insumo']= json_decode(Producto::getObjetoJSON('id', $objeto->getIdInsumo(), null, null));
            //$arreglo['objetoUsuario']= json_decode(Usuario::getObjetoJSON('usuario', "'{$objeto->getUsuario()}'", null, null));
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            if ($objeto->getTerminado()){
                $color='#d29d9d';
                $hideBtnTerminar='hide';
            } else {
                $color='';
                $hideBtnTerminar='';
            }
            $arreglo['terminado']=$objeto->getTerminado();
            $arreglo['colorFila']=$color;
            $arreglo['btnModalTerminar']=$hideBtnTerminar;
            $arreglo['btnEnviarTerminar']=$hideBtnTerminar;
            $arreglo['btnUsar']=$objeto->getUsado();
            //--$arreglo['btnUsar']=$objeto->getTerminado();
            $arreglo['btnTerminar']=$objeto->getUsado();
            $arreglo['chk']=false;
            $arreglo['btnActions']=$objeto->getStatusButtons();
            $arreglo['remainingStock']=$objeto->getRemainingStock();
            array_push($JSON, $arreglo);
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
    
    public function getTerminado() {
        $valido=false;
        if ($this->id!=null || $this->id!=''){
            $objeto=new Insumo_Terminacion('idInsumoPT', $this->id, null, null);
            if ($objeto->getId()!=null || $objeto->getId()!='') $valido=true;
        }
        return $valido;
    }
    
    public function getUsado() {
        /*
         * Con esta funcion se determina si el insumo del puesto de trabajo fue
         * o esta siendo usado:
         * 
         * False=No ha sido utilizado aun.
         * True=Ya fue utilizado.
         * 
         */
        $valid = false;
        if ($this->id!=null && $this->id!=''){
            $sql = "select idinsumopt from uso_insumo_proceso_detalle where idinsumopt=$this->id limit 1";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                if (count($result)>0) {
                    if ($result[0][0]!=null && $result[0][0]==$this->id) $valid = true;
                }
            }
        }
        return $valid;
    }

    public function getStatusButtons(){
        /*
         * Con angular js, aplicaremos el valor retornado en la directiva ng-show para mostrar u ocultar los botones de
         * accion para un registro determinado
         */
        $valid=true;
        if ($this->id!=null){
            $sql="select idInsumoPT from uso_insumo_proceso_detalle where idinsumopt=$this->id";
            //echo $sql;
            $res=Conector::ejecutarQuery($sql, null);
            if ($res!=null){
                if ($res[0][0]!=null) $valid=false;
            }
        }
        return $valid;
    }

    public function getRemainingStock(){
        $remaining = $this->cantidad;
        if ($this->id!=null){
            $sql = "select sum(cantidad) from uso_insumo_proceso_detalle where idinsumopt=$this->id";
            if (is_array($result = Conector::ejecutarQuery($sql, null))){
                if (count($result)>0) {
                    if ($result[0][0]!=null) $remaining -= $result[0][0];
                }
            }
        }
        return $remaining;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extra){
        /*
         * $type=0 => se interpreta que el cliente esta solicitando solo
         * un objeto de esta clase en formato JSON para ello se tienen encuenta
         * todos los parametros a exepcion de la variable $sql.
         *
         * $type=1 => se interpreta que el cliente esta solicitando todos
         * los objetos de esta clase en formato JSON, para ello se tienen encuenta
         * los parametros $filter y $order.
         *
         * $type=2 => se interprete que el cliente esta solicitando todos los datos y valores de una cadena sql en
         * formato JSON
         */
        $JSON=array();
        switch ($type){
            case 0:
                if ($value!=null && $field!=null) $object=new Insumo_Puesto_Trabajo($field, $value, $filter, $order);
                else $object=new Insumo_Puesto_Trabajo(null, null, $filter, $order);
                $JSON=array();
                foreach ($object as $key => $value) $JSON["$key"]=$value;
                break;
            case 1:
                $data= Insumo_Puesto_Trabajo::getListObjects($filter, $order);
                for ($i = 0; $i < count($data); $i++) {
                    $object = $data[$i];
                    $array = array();
                    foreach ($object as $key => $value) $array["$key"] = $value;
                    array_push($JSON, $array);
                }
                break;
            case 2:
                if ($sql!=null) $r=Conector::ejecutarQuery($sql, null);
                else $r=array();
                for ($i=0; $i<count($r); $i++){
                    $array=array();
                    foreach ($r[$i] as $key => $val) {
                        $array["$key"] = $val;
                        ${$key}=$val;
                    }
                    if ($extra){
                        $object=new Insumo_Puesto_Trabajo(null, null, null, null);
                        @$object->setId($idinsumopt);
                        @$object->setCantidad($cantidadinsumopt);
                        @$object->setEstado($estadoinsumopt);
                        //$array['btnActions']=$object->getStatusButtons();
                        $array['remainingStock']=$object->getRemainingStock();
                        $array['nombreEstado']=$object->getNombreEstado();
                        $array['foto']=getFoto(dirname(__FILE__ . "/../Uploads/Imgs/Producto/$foto}"));
                        $terminado=$object->getTerminado();
                        if ($terminado){
                            $color='#d29d9d';
                            $hideBtnTerminar='hide';
                        } else {
                            $color='';
                            $hideBtnTerminar='';
                        }
                        $array['terminado']=$terminado;
                        $array['colorFila']=$color;
                        $object=new Producto(null, null, null, null);
                        @$object->setId($idproducto);
                        if ($object->getFoto()==null || $object->getFoto()=='') $array['notImage']=true;
                        $array['foto']=$object->getFoto();
                    }
                    array_push($JSON, $array);
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getInsumosPuestoTrabajoSQLJSON($idPuestoTrabajo, $extras) {
        $JSON = array();
        if ($idPuestoTrabajo!=null) {
            $sql = "select ipt.id as id, ipt.idinsumo as idinsumo, ipt.idpuestotrabajo, ipt.cantidad as cantidadpuestotrabajo, ipt.estado as estadopuestotrabajo,
                   pr.id as idproducto, pr.stock, pc.nombre as nombrePuc, pr.foto, um.nombre as nombreUnidadMedida, pp.nombre as nombrePresentacion, percli.nombres || ' ' || percli.apellidos as nombresEmpresa, cl.razonsocial
            from insumo_puestotrabajo as ipt, producto as pr, puc as pc, tercero as ter, puc as pcter, cliente as cl, persona as percli, unidad_medida as um, presentacion_producto as pp
            where ipt.idpuestotrabajo=$idPuestoTrabajo 
            and pr.id=ipt.idinsumo
            and pc.codigo=pr.codpuc
            and ter.id=pr.idprovedor
            and pcter.codigo=ter.codpuc
            and cl.id=ter.idcliente
            and percli.identificacion=cl.identificacion
            and um.id=pr.idunidadmedida
            and pp.id=pr.idpresentacion
            and ipt.id not in (select idinsumopt from insumo_terminacion) order by ipt.id desc";
            if (is_array($result = Conector::ejecutarQuery($sql, null))) {
                for ($i=0; $i<count($result);$i++) {
                    $data = array();
                    foreach ($result[$i] as $key => $val) {
                        ${$key} = $val;
                        $data["$key"] = $val;
                    }
                    $object = new Insumo_Puesto_Trabajo(null, null, null, null);
                    $object->setId(@$id);
                    $object->setEstado(@$estadopuestotrabajo);
                    $object->setCantidad(@$cantidadpuestotrabajo);
                    $data["nombreEstado"] = $object->getNombreEstado();
                    $data["btnUsar"] = $object->getUsado();
                    if ($foto!=null ) @$data["notImage"] = false;
                    else @$data["notImage"] = true;
                    if ($extras) {
                        $data["remainingStock"] = $object->getRemainingStock();
                    }
                    array_push($JSON, $data);
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
}