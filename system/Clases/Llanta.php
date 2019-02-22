<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 *
 */
 
 /** Descripcion de la clase Llanta:
 *
 * Define las propiedades id, idCliente, idTipo, idMarca, dimension, serie, diseno, rp, observaciones, procesado, fechaRegistro las cuales permite identificar las llantas que se manejaran en el sistema de informacion.
 *
 * El atributo idCliente ayudara a relacionar la llanta con un cliente registrado en el sistema.
 * El atributo idTipo relacionara la llanta con un tipo de llanta ya registrado en el sistema.
 * El atributo idMarca relacionar la llanta con una marca para la misma.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Llanta {
    //Propiedades
    private $id;
    private $consecutivo;
    private $idServicio;
    private $idGravado;
    private $idMarca;
    private $idDimension;
    private $rp;
    private $serie;
    private $idAplicacionOriginal;
    private $idAplicacionSolicitada;
    private $idAplicacionEntregada;
    private $idReferenciaOriginal;
    private $idReferenciaSolicitada;
    private $urgente;
    private $procesado;
    private $observaciones;
    private $fechaRegistro;
    private $fechaInicioProceso;
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
                $sql="select id, consecutivo, idServicio, idGravado, idMarca, iddimension, rp, serie, idAplicacionOriginal, idAplicacionSolicitada, idAplicacionEntregada, idreferenciaoriginal, idreferenciasolicitada, urgente, procesado, observaciones, fechaRegistro, fechainicioproceso from {$P}llanta where $campo=$valor $filtro $orden";
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
    	$this->idServicio=$arreglo['idservicio'];
    	$this->idGravado=$arreglo['idgravado'];
    	$this->idMarca=$arreglo['idmarca'];
    	$this->idDimension=$arreglo['iddimension'];
    	$this->idAplicacionOriginal=$arreglo['idaplicacionoriginal'];
    	$this->idAplicacionSolicitada=$arreglo['idaplicacionsolicitada'];
    	$this->idAplicacionEntregada=$arreglo['idaplicacionentregada'];
    	$this->idReferenciaOriginal=$arreglo['idreferenciaoriginal'];
    	$this->idReferenciaSolicitada=$arreglo['idreferenciasolicitada'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    	$this->fechaInicioProceso=$arreglo['fechainicioproceso'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdServicio() {
        return $this->idServicio;
    }
    
    function getIdGravado() {
        return $this->idGravado;
    }
    
    function getIdMarca() {
        return $this->idMarca;
    }

    function getRp() {
        return $this->rp;
    }

    function getSerie() {
        return $this->serie;
    }

    function getIdAplicacionOriginal() {
        return $this->idAplicacionOriginal;
    }

    function getIdAplicacionSolicitada() {
        return $this->idAplicacionSolicitada;
    }

    function getIdAplicacionEntregada() {
        return $this->idAplicacionEntregada;
    }

    function getUrgente() {
        return $this->urgente;
    }

    function getProcesado() {
        return $this->procesado;
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!='' && $this->observaciones!='-' && $this->observaciones!='---') return $this->observaciones;
        else return 'No se registro observaciones';
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    function setIdGravado($idGravado) {
        $this->idGravado = $idGravado;
    }
    
    function setIdMarca($idMarca) {
        $this->idMarca = $idMarca;
    }

    function setRp($rp) {
        $this->rp = $rp;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function setIdAplicacionOriginal($idAplicacionOriginal) {
        $this->idAplicacionOriginal = $idAplicacionOriginal;
    }

    function setIdAplicacionSolicitada($idAplicacionSolicitada) {
        $this->idAplicacionSolicitada = $idAplicacionSolicitada;
    }

    function setIdAplicacionEntregada($idAplicacionEntregada) {
        $this->idAplicacionEntregada = $idAplicacionEntregada;
    }

    function setUrgente($urgente) {
        $this->urgente = $urgente;
    }

    function setProcesado($procesado) {
        $this->procesado = $procesado;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    /**
     * @return mixed
     */
    public function getIdReferenciaOriginal()
    {
        return $this->idReferenciaOriginal;
    }

    /**
     * @param mixed $idReferenciaOriginal
     */
    public function setIdReferenciaOriginal($idReferenciaOriginal)
    {
        $this->idReferenciaOriginal = $idReferenciaOriginal;
    }

    /**
     * @return mixed
     */
    public function getIdReferenciaSolicitada()
    {
        return $this->idReferenciaSolicitada;
    }

    /**
     * @param mixed $idReferenciaSolicitada
     */
    public function setIdReferenciaSolicitada($idReferenciaSolicitada)
    {
        $this->idReferenciaSolicitada = $idReferenciaSolicitada;
    }

    /**
     * @return mixed
     */
    public function getIdDimension()
    {
        return $this->idDimension;
    }

    /**
     * @param mixed $idDimension
     */
    public function setIdDimension($idDimension)
    {
        $this->idDimension = $idDimension;
    }

    /**
     * @return mixed
     */
    public function getConsecutivo()
    {
        return $this->consecutivo;
    }

    /**
     * @param mixed $consecutivo
     */
    public function setConsecutivo($consecutivo)
    {
        $this->consecutivo = $consecutivo;
    }

    /**
     * @return mixed
     */
    public function getFechaInicioProceso()
    {
        if ($this->fechaInicioProceso!=null) return $this->fechaInicioProceso;
        else return "Sin registrar";
    }

    /**
     * @param mixed $fechaInicioProceso
     */
    public function setFechaInicioProceso($fechaInicioProceso)
    {
        $this->fechaInicioProceso = $fechaInicioProceso;
    }



    function getServicio() {
        if ($this->idServicio!=null) return new Servicio('id', $this->idServicio, null, null);
        else return new Servicio(null, null, null, null);
    }
    
    function getGravado() {
        if ($this->idGravado!=null) return new Gravado_Llanta('id', $this->idGravado, null, null);
        else return new Gravado_Llanta(null, null, null, null);
    }
    
    function getMarca() {
        if ($this->idMarca!=null) return new Marca_Llanta('id', $this->idMarca, null, null);
        else return new Marca_Llanta(null, null, null, null);
    }

    function getDimension() {
        if ($this->idDimension!=null) return new Dimension_Llanta('id', $this->idDimension, null, null);
        else return new Dimension_Llanta(null, null, null, null);
    }

    function getAplicacionOriginal() {
        if ($this->idAplicacionOriginal!=null) return new Dimension_Referencia('id', $this->idAplicacionOriginal, null, null);
        else return new Dimension_Referencia(null, null, null, null);
    }
    
    function getAplicacionSolicitada() {
        if ($this->idAplicacionSolicitada!=null) return new Dimension_Referencia('id', $this->idAplicacionSolicitada, null, null);
        else return new Dimension_Referencia(null, null, null, null);
    }
    
    function getAplicacionEntregada() {
        if ($this->idAplicacionEntregada!=null) return new Dimension_Referencia('id', $this->idAplicacionEntregada, null, null);
        else return new Dimension_Referencia(null, null, null, null);
    }

    function getReferenciaOriginal() {
        if ($this->idReferenciaOriginal!=null) return new Referencia_Tipo_Llanta('id', $this->idReferenciaOriginal, null, null);
        else return new Referencia_Tipo_Llanta(null, null, null, null);
    }

    function getReferenciaSolicitada() {
        if ($this->idReferenciaSolicitada!=null) return new Referencia_Tipo_Llanta('id', $this->idReferenciaSolicitada, null, null);
        else return new Referencia_Tipo_Llanta(null, null, null, null);
    }

    function getNombreProcesado() {
        if ($this->procesado) return 'Procesada';
        else return 'Sin procesar';
    }
    
    function getNombreUrgente() {
        if ($this->urgente) return 'Si';
        else return 'No';
    }

    public function grabar() {
        $P='';
        //$sql="insert into {$P}llanta (idServicio, idGravado, idMarca, serie, idAplicacionOriginal, idAplicacionSolicitada, idAplicacionEntregada, urgente, procesado, observaciones, fechaRegistro) values ($this->idServicio, $this->idGravado, $this->idMarca , $this->serie, $this->idAplicacionOriginal, $this->idAplicacionSolicitada, $this->idAplicacionEntregada, '$this->urgente', '$this->procesado', '$this->observaciones', '$this->fechaRegistro')";
        $sql="insert into {$P}llanta (consecutivo, idServicio, idGravado, idMarca, idDimension, rp, serie, idreferenciaoriginal, idreferenciasolicitada, urgente, procesado, observaciones, fechaRegistro) values ($this->consecutivo, $this->idServicio, $this->idGravado, $this->idMarca, $this->idDimension, $this->rp, $this->serie, $this->idReferenciaOriginal, $this->idReferenciaSolicitada, '$this->urgente', '$this->procesado', '$this->observaciones', '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function updateAplicacionEntregada($observaciones) {
        if ($observaciones!=null && $observaciones!='' && $observaciones!=' ' && $observaciones!='-' && $observaciones!='---') $obs= $this->observaciones . " - " . $observaciones;
        else $obs= $this->observaciones;
        $P='';
        $sql="update {$P}llanta set idAplicacionEntregada=$this->idAplicacionEntregada, observaciones='$obs' where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($r!=null) return true;
        else return false;
    }

    public function updateFechaInicioProceso() {
        if ($this->id!=null){
            $P='';
            $sql="update {$P}llanta set fechainicioproceso='$this->fechaInicioProceso' where id=$this->id";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null) return true;
            else return false;
        } else return false;
    }

    public function modificar() {
        $P='';
        //$sql="update {$P}llanta set idServicio=$this->idServicio, idGravado=$this->idGravado, idMarca=$this->idMarca, serie=$this->serie, idAplicacionOriginal=$this->idAplicacionOriginal, idAplicacionSolicitada=$this->idAplicacionSolicitada, idAplicacionEntregada=$this->idAplicacionEntregada, urgente='$this->urgente', procesado='$this->procesado', observaciones='$this->observaciones' where id=$this->id";
        $sql="update {$P}llanta set idMarca=$this->idMarca, idGravado=$this->idGravado, serie=$this->serie, idReferenciaOriginal=$this->idReferenciaOriginal, idReferenciaSolicitada=$this->idReferenciaSolicitada, idDimension=$this->idDimension, urgente='$this->urgente', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}llanta where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, consecutivo, idServicio, idGravado, idMarca, iddimension, rp, serie, idAplicacionOriginal, idAplicacionSolicitada, idAplicacionEntregada, idreferenciaoriginal, idreferenciasolicitada, urgente, procesado, observaciones, fechaRegistro, fechainicioproceso from {$P}llanta $filtro $orden";
        //$sql="select id, consecutivo, idServicio, idGravado, idMarca, iddimension, rp, serie, idAplicacionOriginal, idAplicacionSolicitada, idAplicacionEntregada, idreferenciaoriginal, idreferenciasolicitada, urgente, procesado, observaciones, fechaRegistro, fechainicioproceso from {$P}llanta $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Llanta::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Llanta($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getDatoJSON($campo, $valor, $filtro, $orden) {
        global $P, $BD;
        if ($campo!=null && $valor!=null){
            $sql="select id, consecutivo, idServicio, idGravado, idMarca, iddimension, rp, serie, idAplicacionOriginal, idAplicacionSolicitada, idAplicacionEntregada, idreferenciaoriginal, idreferenciasolicitada, urgente, procesado, observaciones, fechaRegistro, fechainicioproceso from {$P}llanta where $campo=$valor $filtro $orden";
            $resultado=Conector::ejecutarQuery($sql, null);
            $JSON=array();
            if (count($resultado)>0) {
                array_push($JSON, $resultado);
            }
            return json_encode($JSON, JSON_UNESCAPED_UNICODE);
        } else return "[{'null': 'null'}]";
    }
    
    public static function getDatosJSON($filtro, $orden) {
        global $P, $BD;
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, consecutivo, idServicio, idGravado, idMarca, iddimension, rp, serie, idAplicacionOriginal, idAplicacionSolicitada, idAplicacionEntregada, idreferenciaoriginal, idreferenciasolicitada, urgente, procesado, observaciones, fechaRegistro, fechainicioproceso from {$P}llanta $filtro $orden";
        $resultado=Conector::ejecutarQuery($sql, null);
        $JSON=array();
        if (count($resultado)>0) {
            return json_encode($resultado, JSON_UNESCAPED_UNICODE);
        } else return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Llanta($campo, $valor, $filtro, $orden);
        else $objeto=new Llanta(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['consecutivo']=$objeto->getConsecutivo();
        $arreglo['idServicio']=$objeto->getIdServicio();
        $arreglo['idGravado']=$objeto->getIdGravado();
        $arreglo['idMarca']=$objeto->getIdMarca();
        $arreglo['idDimension']=$objeto->getIdDimension();
        $arreglo['rp']=$objeto->getRp();
        $arreglo['serie']=$objeto->getSerie();
        $arreglo['idAplicacionOriginal']=$objeto->getIdAplicacionOriginal();
        $arreglo['idAplicacionSolicitada']=$objeto->getIdAplicacionSolicitada();
        $arreglo['idAplicacionEntregada']=$objeto->getIdAplicacionEntregada();
        $arreglo['idReferenciaOriginal']=$objeto->getIdReferenciaOriginal();
        $arreglo['idReferenciaSolicitada']=$objeto->getIdReferenciaSolicitada();
        $arreglo['urgente']=$objeto->getUrgente();
        $arreglo['procesado']=$objeto->getProcesado();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['fechaInicioProceso']=$objeto->getFechaInicioProceso();
        $arreglo['nombreProcesado']=$objeto->getNombreProcesado();
        $arreglo['nombreUrgente']=$objeto->getNombreUrgente();
        $arreglo['nombreEstado']=$objeto->getNombreEstadoRencauche();
        if ($objeto->getSolicitudEliminacion()) {
            $color='#d29d9d';
            $btnEnviarSolicitud='hidden disabled';
        }
        else {
            $color='';
            $btnEnviarSolicitud='';
        }
        $arreglo['color']=$color;
        $arreglo['btnEnviarSolicitud']=$btnEnviarSolicitud;
        $marca=$objeto->getMarca();
            $arreglo['nombreMarca']=$marca->getNombre();
            $arreglo['descripcionMarca']=$marca->getDescripcion();
            $arreglo['fechaRegistroMarca']=$marca->getFechaRegistro();
        $arreglo['dimension']=$objeto->getDimension()->getDimension();
        $arreglo['aplicacionOriginal']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionOriginal(), null, null));
        $arreglo['aplicacionSolicitada']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionSolicitada(), null, null));
        $arreglo['aplicacionEntregada']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionEntregada(), null, null));
        $arreglo['referenciaOriginal']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaOriginal(), null, null));
        $arreglo['referenciaSolicitada']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaSolicitada(), null, null));
        $arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
        $arreglo['gravado']= json_decode(Gravado_Llanta::getObjetoJSON('id', $objeto->getIdGravado(), null, null));
        $arreglo['colorUrgente']= $objeto->getColorUrgente();
        $arreglo['colorEstado']= $objeto->getColorEstado();
        $arreglo['colorLetraEstado']= $objeto->getColorLetraEstado($arreglo["colorEstado"]);
        $arreglo['colorIcon']= $objeto->getBackgroudColorIcon($arreglo["colorEstado"]);
        $arreglo['btnRegistrarDisenoEntregado']= $objeto->getBtnRegistrarDisenoEntregado();
        if ($objeto->getEstadoInformeRencauche()==2 || $objeto->getEstadoInformeRencauche()==3) $arreglo['rencauchada_rechazada']= true;
        else $arreglo['rencauchada_rechazada']= false;
        $arreglo['salida']=json_decode(Salida_Llanta::getDataJSON(0, 'idLlanta', $objeto->getId(), null, null, null));
        $arreglo['medidas']=json_decode($objeto->getMedidasProcesadas(true));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Llanta::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['consecutivo']=$objeto->getConsecutivo();
            $arreglo['idServicio']=$objeto->getIdServicio();
            $arreglo['idGravado']=$objeto->getIdGravado();
            $arreglo['idMarca']=$objeto->getIdMarca();
            $arreglo['idDimension']=$objeto->getIdDimension();
            $arreglo['rp']=$objeto->getRp();
            $arreglo['serie']=$objeto->getSerie();
            $arreglo['idAplicacionOriginal']=$objeto->getIdAplicacionOriginal();
            $arreglo['idAplicacionSolicitada']=$objeto->getIdAplicacionSolicitada();
            $arreglo['idAplicacionEntregada']=$objeto->getIdAplicacionEntregada();
            $arreglo['idReferenciaOriginal']=$objeto->getIdReferenciaOriginal();
            $arreglo['idReferenciaSolicitada']=$objeto->getIdReferenciaSolicitada();
            $arreglo['urgente']=$objeto->getUrgente();
            $arreglo['procesado']=$objeto->getProcesado();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['fechaInicioProceso']=$objeto->getFechaInicioProceso();
            $arreglo['nombreProcesado']=$objeto->getNombreProcesado();
            $arreglo['nombreUrgente']=$objeto->getNombreUrgente();
            $arreglo['nombreEstado']=$objeto->getNombreEstadoRencauche();
            if ($objeto->getSolicitudEliminacion()) {
                $color='#d29d9d';
                $btnEnviarSolicitud='hidden disabled';
            }
            else {
                $color='';
                $btnEnviarSolicitud='';
            }
            $arreglo['color']=$color;
            $arreglo['btnEnviarSolicitud']=$btnEnviarSolicitud;
            $marca=$objeto->getMarca();
                $arreglo['nombreMarca']=$marca->getNombre();
                $arreglo['descripcionMarca']=$marca->getDescripcion();
                $arreglo['fechaRegistroMarca']=$marca->getFechaRegistro();
            $arreglo['dimension']=$objeto->getDimension()->getDimension();
            $arreglo['aplicacionOriginal']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionOriginal(), null, null));
            $arreglo['aplicacionSolicitada']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionSolicitada(), null, null));
            $arreglo['aplicacionEntregada']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionEntregada(), null, null));
            $arreglo['referenciaOriginal']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaOriginal(), null, null));
            $arreglo['referenciaSolicitada']= json_decode(Referencia_Tipo_Llanta::getObjetoJSON('id', $objeto->getIdReferenciaSolicitada(), null, null));
            $arreglo['servicio']= json_decode(Servicio::getObjetoJSON('id', $objeto->getIdServicio(), null, null));
            $arreglo['gravado']= json_decode(Gravado_Llanta::getObjetoJSON('id', $objeto->getIdGravado(), null, null));
            $arreglo['colorUrgente']= $objeto->getColorUrgente();
            $arreglo['colorEstado']= $objeto->getColorEstado();
            $arreglo['colorLetraEstado']= $objeto->getColorLetraEstado($arreglo["colorEstado"]);
            $arreglo['colorIcon']= $objeto->getBackgroudColorIcon($arreglo["colorEstado"]);
            $arreglo['btnRegistrarDisenoEntregado']= $objeto->getBtnRegistrarDisenoEntregado();
            $arreglo['salida']=json_decode(Salida_Llanta::getDataJSON(0, 'idLlanta', $objeto->getId(), null, null, null));
            //echo $arreglo['salida']->id;die();
            if ($objeto->getEstadoInformeRencauche()==2 && $arreglo['salida']->id==null || $objeto->getEstadoInformeRencauche()==3 && $arreglo['salida']->id==null) $arreglo['rencauchada_rechazada']= true;
            else $arreglo['rencauchada_rechazada']= false;
            $arreglo['medidas']=json_decode($objeto->getMedidasProcesadas(true));
            //if ($arreglo['salida']->id!=null)
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getProximoRP() {
        $P='';
        $sql="select max(rp)+1 as rp from {$P}llanta";
        $resultado= Conector::ejecutarQuery($sql, null);
        //print_r($resultado);
        if ($resultado[0]['rp']!=null) return $resultado[0]['rp'];
        else return 1;
        //if (count($resultado)>=1) return $resultado[0]['rp'];
        //else return 1;
    }
    
    public function getSolicitudEliminacion() {
        global $P, $BD;
        if ($this->id!=null){
            $sql="select s.id from {$P}solicitud_eliminar_llanta s, {$P}llanta ll where s.idllanta=ll.id and s.estado='f' and ll.id=$this->id";
            //echo $sql;
            $result= Conector::ejecutarQuery($sql, null);
            if (count($result)>0){
                if ($result[0]['id']!=null) return true;
                else return false;
            } else return false;
        } else return false;
    }
    
    public function getFinRencaucheXRechazo(){
        //True = Proceso de rencauche finalizado por rechazo de la llanta
        //Else = Proceso de rencauche sin finalizar (Procesos pendientes)
        if ($this->id!=null && $this->id!=''){
            $rechazoLlanta=new Rechazo_Llanta('idLlanta', $this->id, null, null);
            if ($rechazoLlanta->getId()!=null && $rechazoLlanta->getId()!='') return true;
            else return false;
        } else return false;
    }
    
    public function getFinRencaucheXProceso() {
        //True = Proceso de rencauche finalizado (En la terminacion)
        //False = Proceso de rencauche sin finalizar (Procesos pendientes)
        if ($this->id!=null && $this->id!=''){
            $inspeccionInicial=new Inspeccion_Inicial('idLlanta', $this->id, null, null);
            if ($inspeccionInicial->getId()!=null){
                $servicioFin=new Servicio_Fin('idLlanta', $this->id, null, null);
                if ($servicioFin->getId()!=null && $servicioFin->getId()!='') return true;
                else return false;
            //} else return true;
            } else return false;
        } else return false;
    }
    
    public function getTiemposProcesosEnArray() {
        $format='Y-m-d H:i:s';
        $tiempos=array();
        $arreglo=array();
        if ($this->id!=null && $this->id!=''){
            $inspeccionInicial=new Inspeccion_Inicial('idLlanta', $this->id, null, null);
            //echo $inspeccionInicial->getLlanta()->getFechaInicioProceso();
            if ($inspeccionInicial->getId()!=null && $inspeccionInicial->getId()!=''){
                $arreglo['proceso']='Inspeccion incial';
                if (strtolower($inspeccionInicial->getLlanta()->getFechaInicioProceso())=="sin registrar") $arreglo['tiempo']= getDiffTiempoEnMinutos($inspeccionInicial->getLlanta()->getFechaRegistro(), $inspeccionInicial->getFechaRegistro());
                else $arreglo['tiempo']= getDiffTiempoEnMinutos($inspeccionInicial->getLlanta()->getFechaInicioProceso(), $inspeccionInicial->getFechaRegistro());
                //echo "va...";
                $arreglo['color']='#FF0F00';
                array_push($tiempos, $arreglo);
                $arreglo=array();
                $raspado=new Raspado('idInspeccion', $inspeccionInicial->getId(), null, null);
                if ($raspado->getId()!=null && $raspado->getId()!='') {
                    $arreglo['proceso']='Raspado';
                    $arreglo['tiempo']= getDiffTiempoEnMinutos($inspeccionInicial->getFechaRegistro(), $raspado->getFechaRegistro());
                    $arreglo['color']='#FF6600';
                    array_push($tiempos, $arreglo);
                    $arreglo=array();
                    $preparacion=new Preparacion('idRaspado', $raspado->getId(), null, null);
                    if ($preparacion->getId()!=null && $preparacion->getId()!=''){
                        $arreglo['proceso']='Preparacion';
                        $arreglo['tiempo']= getDiffTiempoEnMinutos($raspado->getFechaRegistro(), $preparacion->getFechaRegistro());
                        $arreglo['color']='#FF9E01';
                        array_push($tiempos, $arreglo);
                        $arreglo=array();
                        $reparacion=new Reparacion('idPreparacion', $preparacion->getId(), null, null);
                        if ($reparacion->getId()!=null && $reparacion->getId()!=''){
                            $arreglo['proceso']='Reparacion';
                            $arreglo['tiempo']= getDiffTiempoEnMinutos($preparacion->getFechaRegistro(), $reparacion->getFechaRegistro());
                            $arreglo['color']='#FCD202';
                            array_push($tiempos, $arreglo);
                            $arreglo=array();
                            $cementado=new Cementado('idReparacion', $reparacion->getId(), null, null);
                            if ($cementado->getId()!=null && $cementado->getId()!=''){
                                $arreglo['proceso']='Cementado';
                                $arreglo['tiempo']= getDiffTiempoEnMinutos($reparacion->getFechaRegistro(), $cementado->getFechaRegistro());
                                $arreglo['color']='#F8FF01';
                                array_push($tiempos, $arreglo);
                                $arreglo=array();
                                $relleno=new Relleno('idCementado', $cementado->getId(), null, null);
                                if ($relleno->getId()!=null && $relleno->getId()!=''){
                                    $arreglo['proceso']='Relleno';
                                    $arreglo['tiempo']= getDiffTiempoEnMinutos($cementado->getFechaRegistro(), $relleno->getFechaRegistro());
                                    $arreglo['color']='#B0DE09';
                                    array_push($tiempos, $arreglo);
                                    $arreglo=array();
                                    $corteBanda=new Corte_Banda('idRelleno', $relleno->getId(), null, null);
                                    if ($corteBanda->getId()!=null && $corteBanda->getId()!=''){
                                        $arreglo['proceso']='Corte Banda';
                                        $arreglo['tiempo']= getDiffTiempoEnMinutos($relleno->getFechaRegistro(), $corteBanda->getFechaRegistro());
                                        $arreglo['color']='#04D215';
                                        array_push($tiempos, $arreglo);
                                        $arreglo=array();
                                        $embandado=new Embandado('idCorteBanda', $corteBanda->getId(), null, null);
                                        if ($embandado->getId()!=null && $embandado->getId()!=''){
                                            $arreglo['proceso']='Embandado';
                                            $arreglo['tiempo']= getDiffTiempoEnMinutos($corteBanda->getFechaRegistro(), $embandado->getFechaRegistro());
                                            $arreglo['color']='#0D8ECF';
                                            array_push($tiempos, $arreglo);
                                            $arreglo=array();
                                            $vulcanizado=new Vulcanizado('idEmbandado', $embandado->getId(), null, null);
                                            if ($vulcanizado->getId()!=null && $vulcanizado->getId()!=''){
                                                $arreglo['proceso']='Vulcanizado';
                                                //$arreglo['tiempo']= getDiffTiempoEnMinutos($embandado->getFechaRegistro(), $vulcanizado->getFechaRegistro());
                                                $arreglo['tiempo']= getDiffTiempoEnMinutos($vulcanizado->getFechaRegistro(), $vulcanizado->getFechaFinalizacion());
                                                $arreglo['color']='#0D52D1';
                                                array_push($tiempos, $arreglo);
                                                $arreglo=array();
                                                $inspeccionFinal=new Inspeccion_Final('idVulcanizado', $vulcanizado->getId(), null, null);
                                                if ($inspeccionFinal->getId()!=null && $inspeccionFinal->getId()!=''){
                                                    $arreglo['proceso']='Inspeccion final';
                                                    $arreglo['tiempo']= getDiffTiempoEnMinutos($vulcanizado->getFechaRegistro(), $inspeccionFinal->getFechaRegistro());
                                                    $arreglo['color']='#2A0CD0';
                                                    array_push($tiempos, $arreglo);
                                                    $arreglo=array();
                                                    $terminacion=new Terminacion('idInspeccion_Final', $inspeccionFinal->getId(), null, null);
                                                    if ($terminacion->getId()!=null && $terminacion->getId()!=''){
                                                        //$servicioFin=new Servicio_Fin('idServicioFin', $terminacion->getId(), null, null);
                                                        $arreglo['proceso']='Terminacion';
                                                        $arreglo['tiempo']= getDiffTiempoEnMinutos($inspeccionFinal->getFechaRegistro(), $terminacion->getFechaRegistro());
                                                        $arreglo['color']='#8A0CCF';
                                                        array_push($tiempos, $arreglo);
                                                        $arreglo=array();
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else getDiffTiempo(date($format), date($format));
        }
        return json_encode($tiempos, JSON_UNESCAPED_UNICODE);
    }
    
    public function getColorEstado() {
        $color='';
        if ($this->id!=null && $this->id!=''){
            /*
            if ($this->getFinRencaucheXProceso()) $color='#b1de96';
            else {
                $inspeccionInicial=new Inspeccion_Inicial('idLlanta', $this->id, null, null);
                if ($inspeccionInicial->getId()!=null && $inspeccionInicial->getId()!='') $color='#d06060';
            }
            if ($this->getFinRencaucheXRechazo()) $color='#313030';*/
            switch ($this->getEstadoInformeRencauche()){
                case 1:
                    $color="#d06060";
                    break;
                case 2:
                    $color="#b1de96";
                    break;
                case 3:
                    $color="#313030";
                    break;
            }
            $salida=new Salida_Llanta('idLlanta', $this->id, null, null);
            if ($salida->getId()!=null) $color="#efe16e";
        }
        return $color;
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

    public function getBackgroudColorIcon($primaryColor){
        if ($primaryColor=='#313030') return '#fffcfc';
        else return '#c577ce';
    }
    
    public function getColorUrgente() {
        if ($this->urgente=='t') return '#87c0f3';
        else return '';
    }
    
    public function getBtnRegistrarDisenoEntregado() {
        $valid=false;
        if ($this->id!=null && $this->id!=''){
            if (!$this->getFinRencaucheXRechazo()){
                if ($this->getFinRencaucheXProceso()) {
                    if (!$this->getAplicacionEntregada()->getEstado()) return true;
                }
            }
        }
        return $valid;
    }
    
    public function getNombreEstadoRencauche() {
        if ($this->id!=null && $this->id!=''){
            if ($this->getFinRencaucheXProceso()) {
                $servicioFin=new Servicio_Fin('idLlanta', $this->id, null, null);
                if ($servicioFin->getId()!=null && $this->id!=''){
                    if ($servicioFin->getEstado()=='t') return 'Procesada (Exitosamente)';
                    else if ($servicioFin->getEstado()=='f') return 'Procesada (Rechazada)';
                }
            } else {
                $inspeccionInicial=new Inspeccion_Inicial('idLlanta', $this->id, null, null);
                if ($inspeccionInicial->getId()!=null && $inspeccionInicial->getId()!='') return 'Rencauchando';
                else return 'Sin procesar';
            }
        } else return 'Desconocido';
    }
    
    public function getEstadoInformeRencauche() {
        /*
         * Los siguientes valores representan el significado del valor retornado
         * al llamado de esta funcion.
         * 
         * 0= Sin procesar.
         * 1= Rencauchando.
         * 2= Rencauchada.
         * 3= Rechazada.
         * 4= Desconocido.
         */
        $status=0;
        if ($this->id!=null && $this->id!=''){
            $servicioFin=new Servicio_Fin('idLlanta', $this->id, null, null);
            if ($servicioFin->getId()!=null){
                if ($servicioFin->getEstado()=='t') $status=2;
                else if ($servicioFin->getEstado()=='f')$status=3;
                else $status=4;
            } else {
                $inspeccionInicial=new Inspeccion_Inicial('idLlanta', $this->id, null, null);
                if ($inspeccionInicial->getId()!=null) $status=1;
            }
        } else $status=4;
        return $status;
    }
    
    public static function getInformeRencauche($filtro, $orden) {
        if ($filtro!=null) $filtro=" and $filtro";
        $JSON=array();
        /*$sql="select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
                pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial, 
                pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor, 
                ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as llantaUrgente, ll.idaplicacionentregada, ll.fechainicioproceso, 
                mll.id as idMarca, mll.nombre as nombreMarca,
                gll.id as idGravado, gll.nombre as nombreGravado,
                'B: ' || dr_ao.base || ' - PR: ' || dr_ao.profundidad || ' - PE: ' || dr_ao.peso || ' - LR: ' || dr_ao.largo as medidasAplicacionOriginal, rtll_dr_ao.referencia as referenciaAplicacionOriginal, tll_ao.nombre as tipoAplicacionOriginal,
                'B: ' || dr_as.base || ' - PR: ' || dr_as.profundidad || ' - PE: ' || dr_as.peso || ' - LR: ' || dr_as.largo as medidasAplicacionSolicitada, rtll_dr_as.referencia as referenciaAplicacionSolicitada, tll_as.nombre as tipoAplicacionSolicitada
                from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll, dimension_referencia as dr_ao, referencia_tipo_llanta as rtll_dr_ao, tipo_llanta as tll_ao, dimension_referencia as dr_as, referencia_tipo_llanta as rtll_dr_as, tipo_llanta as tll_as
                where s.id=ll.idservicio 
                and cl.id=s.idcliente 
                and pcl.identificacion=cl.identificacion 
                and v.id=s.idvendedor 
                and pv.identificacion=v.identificacion 
                and mll.id=ll.idmarca
                and gll.id=ll.idgravado 
                and dr_ao.id=ll.idaplicacionoriginal 
                and rtll_dr_ao.id=dr_ao.idreferenciatipollanta 
                and tll_ao.id=rtll_dr_ao.idtipollanta 
                and dr_as.id=ll.idaplicacionsolicitada 
                and rtll_dr_as.id=dr_as.idreferenciatipollanta 
                and tll_as.id=rtll_dr_as.idtipollanta $filtro $orden";*/
        $sql="select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
                pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial, 
                pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor, 
                ll.id as idLlanta, ll.rp, ll.serie, ll.urgente as llantaUrgente, ll.idaplicacionentregada, ll.fechainicioproceso, ll.idreferenciaoriginal, ll.idreferenciasolicitada, ll.iddimension,  
                mll.id as idMarca, mll.nombre as nombreMarca,
                gll.id as idGravado, gll.nombre as nombreGravado
                from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll
                where s.id=ll.idservicio 
                and cl.id=s.idcliente 
                and pcl.identificacion=cl.identificacion 
                and v.id=s.idvendedor 
                and pv.identificacion=v.identificacion 
                and mll.id=ll.idmarca
                and gll.id=ll.idgravado $filtro $orden";
        $r= Conector::ejecutarQuery($sql, null);
        if ($r!=null){
            if ($r[0]!=null || count($r)>0){
                foreach ($r[0] as $key => $value) ${$key}=$value;
                $JSON['idOs']=$idos;
                $JSON['numeroFactura']=$numerofactura;
                $JSON['os']=$os;
                $JSON['estadoServicio']=$estadoservicio;
                $JSON['identificacionCliente']=$identificacioncliente;
                $JSON['nombresCliente']=$nombrescliente;
                $JSON['razonSocial']=$razonsocial;
                $JSON['identificacionVendedor']=$identificacionvendedor;
                $JSON['nombresVendedor']=$nombresvendedor;
                $JSON['idLlanta']=$idllanta;
                $JSON['rp']=$rp;
                $JSON['serie']=$serie;
                $JSON['llantaUrgente']=$llantaurgente;
                $JSON['idMarca']=$idmarca;
                $JSON['nombreMarca']=$nombremarca;
                $JSON['idGravado']=$idgravado;
                $JSON['nombreGravado']=$nombregravado;

                //LINE INSERT SINCE 2019-02-14 20:11
                //With this now can get "Tipos servicio" or "Garantias"
                $sentence = "select id, idservicio from detalle_servicio where idservicio={$idos} limit 1";
                $JSON["detalleOS"] = json_decode(Detalle_Servicio::getDataJSON(2, null, null, null, null, $sentence, true));

                //END LINE INSERT SINCE 2019-02-14 20:11

                /*$JSON['medidasAplicacionOriginal']=$medidasaplicacionoriginal;
                $JSON['referenciaAplicacionOriginal']=$referenciaaplicacionoriginal;
                $JSON['tipoAplicacionOriginal']=$tipoaplicacionoriginal;
                $JSON['medidasAplicacionSolicitada']=$medidasaplicacionsolicitada;
                $JSON['referenciaAplicacionSolicitada']=$referenciaaplicacionsolicitada;
                $JSON['tipoAplicacionSolicitada']=$tipoaplicacionsolicitada;
                $JSON['idAplicacionEntregada']=$idaplicacionentregada;*/
                $objeto=new Llanta(null, null, null, null);
                $objeto->setId($idllanta);
                $objeto->setIdAplicacionEntregada($idaplicacionentregada);
                $objeto->setIdReferenciaOriginal($idreferenciaoriginal);
                $objeto->setIdReferenciaSolicitada($idreferenciasolicitada);
                $objeto->setIdDimension($iddimension);
                $JSON['rencauche']= json_decode($objeto->getProcesos());
                $JSON['aplicacionEntregada']= json_decode(Dimension_Referencia::getObjetoJSON('id', $objeto->getIdAplicacionEntregada(), null, null));
                $JSON['disenoOriginal']= json_decode(Referencia_Tipo_Llanta::getDataJSON(true, 'id', $objeto->getIdReferenciaOriginal(), null, null, false));
                $JSON['disenoSolicitado']= json_decode(Referencia_Tipo_Llanta::getDataJSON(true, 'id', $objeto->getIdReferenciaSolicitada(), null, null, false));
                $JSON['dimension']= json_decode(Dimension_Llanta::getObjetoJSON('id', $objeto->getIdDimension(), null, null));
                $JSON['nombreEstado']= $objeto->getNombreEstadoRencauche();
                $JSON['valorEstado']= $objeto->getEstadoInformeRencauche();
                $rechazoLlanta=new Rechazo_Llanta('idLlanta', $objeto->getId(), null, null);
                $JSON['rechazos']= json_decode($rechazoLlanta->getRechazosDetalleJSON());
                $JSON['tiemposProcesos']= json_decode($objeto->getTiemposProcesosEnArray());
            }
        }
        $sql="";
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public function getProcesos() {
        $json=array();
        if ($this->id!=null){
            $inspeccionInicial=new Inspeccion_Inicial('idLlanta', $this->id, null, null);
            if ($inspeccionInicial->getId()!=null){
                $raspado=new Raspado('idinspeccion', $inspeccionInicial->getId(), null, null);
                if ($raspado->getId()!=null){
                    $preparacion=new Preparacion('idraspado', $raspado->getId(), null, null);
                    if ($preparacion->getId()!=null){
                        $reparacion=new Reparacion('idpreparacion', $preparacion->getId(), null, null);
                        if ($reparacion->getId()!=null){
                            $cementado=new Cementado('idreparacion', $reparacion->getId(), null, null);
                            if ($cementado->getId()!=null){
                                $relleno=new Relleno('idcementado', $cementado->getId(), null, null);
                                if ($relleno->getId()!=null) {
                                    $corteBanda=new Corte_Banda('idrelleno', $relleno->getId(), null, null);
                                    if ($corteBanda->getId()!=null){
                                        $embandado=new Embandado('idcortebanda', $corteBanda->getId(), null, null);
                                        if ($embandado->getId()!=null){
                                            $vulcanizado=new Vulcanizado('idembandado', $embandado->getId(), null, null);
                                            if ($vulcanizado->getId()!=null){
                                                $inspeccionFinal=new Inspeccion_Final('idvulcanizado', $vulcanizado->getId(), null, null);
                                                if ($inspeccionFinal->getId()!=null){
                                                    $terminacion=new Terminacion('idinspeccion_final', $inspeccionFinal->getId(), null, null);
                                                    if ($terminacion->getId()!=null) {
                                                        $json['procesos']= json_decode (Terminacion::getObjetoJSON ('id', $terminacion->getId(), null, null));
                                                        $json['procesos']['ultimo']= 'Terminacion';
                                                    } else {
                                                        $json['procesos']= json_decode (Inspeccion_Final::getObjetoJSON ('id', $inspeccionFinal->getId(), null, null));
                                                        $json['procesos']['ultimo']= 'InspeccionFinal';
                                                    }
                                                } else {
                                                    $json['procesos']= json_decode (Vulcanizado::getObjetoJSON ('id', $vulcanizado->getId(), null, null));
                                                    $json['procesos']['ultimo']= 'Vulcanizado';
                                                }
                                            } else {
                                                $json['procesos']= json_decode (Embandado::getObjetoJSON ('id', $embandado->getId(), null, null));
                                                $json['procesos']['ultimo']= 'Embandado';
                                            }
                                        } else {
                                            $json['procesos']= json_decode (Corte_Banda::getObjetoJSON ('id', $corteBanda->getId(), null, null));
                                            $json['procesos']['ultimo']= 'CorteBanda';
                                        }
                                    } else {
                                        $json['procesos']= json_decode (Relleno::getObjetoJSON ('id', $relleno->getId(), null, null));
                                        $json['procesos']['ultimo']= 'Relleno';
                                    }
                                } else {
                                    $json['procesos']= json_decode (Cementado::getObjetoJSON ('id', $cementado->getId(), null, null));
                                    $json['procesos']['ultimo']= 'Cementado';
                                }
                            } else {
                                $json['procesos']= json_decode (Reparacion::getObjetoJSON ('id', $reparacion->getId(), null, null));
                                $json['procesos']['ultimo']= 'Reparacion';
                            }
                        } else {
                            $json['procesos']= json_decode (Preparacion::getObjetoJSON ('id', $preparacion->getId(), null, null));
                            $json['procesos']['ultimo']= 'Preparacion';
                        }
                    } else {
                        $json['procesos']= json_decode (Raspado::getObjetoJSON ('id', $raspado->getId(), null, null));
                        $json['procesos']['ultimo']= 'Raspado';
                    }
                } else {
                    $json['procesos']= json_decode (Inspeccion_Inicial::getObjetoJSON ('id', $inspeccionInicial->getId(), null, null));
                    $json['procesos']['ultimo']= 'InspeccionInicial';
                }
            }
        }
        //print_r($json);die();
        return json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getLlantasInformeBodega($filtro, $orden) {
        $JSON=array();
        $datosObjetos= Llanta::getListaEnObjetos($filtro, $orden);
        for ($i = 0; $i < count($datosObjetos); $i++) {
            $objeto=$datosObjetos[$i];
            $arreglo=array();
            $arreglo['servicio']=array();
            $arreglo['gravado']=array();
            $arreglo['aplicacionOriginal']=array();
            $arreglo['aplicacionSolicitada']=array();
            $arreglo['aplicacionEntregada']=array();
            $osArray=array();
            $gravadoArray=array();
            $apoArray=array();
            $apsArray=array();
            $apeArray=array();
            $servicio=$objeto->getServicio();
            $gravado=$objeto->getGravado();
            $marca=$objeto->getMarca();
            $apo=$objeto->getAplicacionOriginal();
            $aps=$objeto->getAplicacionSolicitada();
            $ape=$objeto->getAplicacionEntregada();
            $osArray['os']=$servicio->getOs();
            array_push($arreglo['servicio'], $osArray);
            $arreglo['rp']=$objeto->getRp();
            $arreglo['serie']=$objeto->getSerie();
            $gravadoArray['nombre']=$gravado->getNombre();
            array_push($arreglo['gravado'], $gravadoArray);
            $arreglo['nombreMarca']=$marca->getNombre();
            $apoArray['medidaCompleta']=$apo->getMedidaCompleta();
            array_push($arreglo['aplicacionOriginal'], $apoArray);
            $apsArray['medidaCompleta']=$aps->getMedidaCompleta();
            array_push($arreglo['aplicacionSolicitada'], $apsArray);
            $apeArray['medidaCompleta']=$ape->getMedidaCompleta();
            array_push($arreglo['aplicacionEntregada'], $apeArray);
            $arreglo['nombreUrgente']=$objeto->getNombreUrgente();
            $arreglo['nombreEstado']=$objeto->getNombreEstadoRencauche();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['fechaInicioProceso']=$objeto->getFechaInicioProceso();
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getLlantasInformeBodegaSQL($filtro, $orden) {
        if ($filtro!=null) $filtro=" $filtro and";
        $JSON=array();
        $sql="select s.id as idOs, s.numerofactura, s.os, s.estado as estadoServicio,
               pcl.identificacion as identificacionCliente, pcl.nombres || ' ' || pcl.apellidos as nombresCliente, cl.razonsocial,
               pv.identificacion as identificacionVendedor, pv.nombres || ' ' || pv.apellidos as nombresVendedor,
               ll.id as idLlanta, ll.rp, ll.serie, ll.consecutivo, ll.urgente as llantaUrgente, ll.idaplicacionoriginal as idaplicacionoriginal, ll.idaplicacionsolicitada as idaplicacionsolicitada, ll.idaplicacionentregada as idaplicacionentregada, ll.urgente as urgentellanta, ll.procesado as procesadollanta, ll.observaciones as observacionesllanta, ll.fecharegistro as fecharegistrollanta, ll.fechainicioproceso, ll.idreferenciaoriginal, ll.idreferenciasolicitada, ll.iddimension,
               mll.id as idMarca, mll.nombre as nombreMarca,
               gll.id as idGravado, gll.nombre as nombreGravado
                from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll
                where $filtro s.id=ll.idservicio
                and cl.id=s.idcliente
                and pcl.identificacion=cl.identificacion
                and v.id=s.idvendedor
                and pv.identificacion=v.identificacion
                and mll.id=ll.idmarca
                and gll.id=ll.idgravado $orden";
        //echo $sql;die();
        $r= Conector::ejecutarQuery($sql, null);
        if ($r!=null){
            if (count($r)>0){
                for ($i = 0; $i < count($r); $i++) {
                    foreach ($r[$i] as $key => $value) ${$key}=$value;
                    $arreglo=array();
                    if (isset($nombresvendedor)) $arreglo['nombresVendedor']=$nombresvendedor;
                    if (isset($identificacionvendedor)) $arreglo['identificacionVendedor']=$identificacionvendedor;
                    $arreglo['servicio']=array();
                    $arreglo['gravado']=array();
                    $arreglo['disenoOriginal']=array();
                    $arreglo['disenoSolicitado']=array();
                    $arreglo['aplicacionEntregada']=array();
                    $osArray=array();
                    $gravadoArray=array();
                    $doArray=array();
                    $dsArray=array();
                    $apeArray=array();
                    //$objeto=new Llanta('id', $idllanta, null, null);
                    $objeto=new Llanta(null, null, null, null);
                    $objeto->setId($idllanta);
                    $objeto->setIdServicio($idos);
                    $objeto->setIdMarca($idmarca);
                    $objeto->setIdGravado($idgravado);
                    @$objeto->setConsecutivo($consecutivo);
                    $objeto->setRp($rp);
                    $objeto->setSerie($serie);
                    $objeto->setUrgente($urgentellanta);
                    $objeto->setProcesado($procesadollanta);
                    $objeto->setObservaciones($observacionesllanta);
                    $objeto->setFechaRegistro($fecharegistrollanta);
                    @$objeto->setFechaInicioProceso($fechainicioproceso);
                    @$objeto->setIdReferenciaOriginal($idreferenciaoriginal);
                    @$objeto->setIdReferenciaSolicitada($idreferenciasolicitada);
                    @$objeto->setIdAplicacionEntregada($idaplicacionentregada);
                    @$objeto->setIdDimension($iddimension);
                    $osArray['os']=$os;
                    array_push($arreglo['servicio'], $osArray);
                    @$arreglo['consecutivo']=$consecutivo;
                    $arreglo['rp']=$rp;
                    $arreglo['serie']=$serie;
                    $gravadoArray['nombre']=$nombregravado;
                    array_push($arreglo['gravado'], $gravadoArray);
                    $arreglo['nombreMarca']=$nombremarca;
                    $arreglo['nombreUrgente']=$objeto->getNombreUrgente();
                    $arreglo['nombreEstado']=$objeto->getNombreEstadoRencauche();
                    $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
                    $arreglo['fechaInicioProceso']=$objeto->getFechaInicioProceso();
                    //COMENTADO 2018-09-21 03:33
                    //$arreglo['dimension']=json_decode(Dimension_Llanta::getObjetoJSON('id', $objeto->getIdDimension(), null, null));
                    //END COMENTADO 2018-09-21 03:33
                    $arreglo['dimension']=$objeto->getValorDimension();
                    //COMENTADO 2018-09-21 03:17
                    //$arreglo['referenciaOriginal']=json_decode(Referencia_Tipo_Llanta::getDataJSON(true, 'id', $objeto->getIdReferenciaOriginal(), null, null, false));
                    //END COMENTADO 2018-09-21 03:17
                    $arreglo['referenciaSolicitada']=json_decode(Referencia_Tipo_Llanta::getDataJSON(true, 'id', $objeto->getIdReferenciaSolicitada(), null, null, false));
                    //COMENTADO 2018-09-21 03:20
                    //$arreglo['aplicacionEntregada']=json_decode(Dimension_Referencia::getDataJSON(true, 'id', $objeto->getIdAplicacionEntregada(), null, null, false));
                    //END COMENTADO 2018-09-21 03:20
                    $arreglo['medidas']=json_decode($objeto->getMedidasProcesadas(true));
                    //$arreglo['dataSalida']=json_decode(Salida_Llanta::getDataJSON(0, 'idLlanta', $objeto->getId(), null, null, null));
                    $arreglo['dataSalida']=json_decode(Salida_Llanta::getDataJSON(2, null, null, null, null, "select valor from salida_llanta where idLlanta={$objeto->getId()}"));
                    //2018-09-19
                    if (@$nombrescliente!=null) $arreglo['clienteName']=$nombrescliente;
                    if (@$razonsocial!=null) $arreglo['clienteName']=$razonsocial;
                    //END 2018-09-19
                    //2018-09-21 02:59
                    $arreglo['pesoBanda']=$objeto->getPesoBanda();
                    //END 2018-09-21 02:59
                    //2018-09-21 13:39
                    $arreglo['fechaFinServicio']=$objeto->getFechaFinServicio();
                    //END 2018-09-21 13:39
                    //INSERT SINCE 2019-02-14 22:15
                    //if (count($arreglo['dataSalida'])>0) $JSON["total"] += $arreglo['dataSalida'][0]->valor;
                    //END INSERT SINCE 2019-02-14 22:15
                    array_push($JSON, $arreglo);
                }
            }
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getTotalFacturado($filtro, $orden){
        if ($filtro!=null) $filtro=" $filtro and";
        $total = 0;
        $sql="select s.id as idOs,
               ll.id as idLlanta from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll
                where $filtro s.id=ll.idservicio
                and cl.id=s.idcliente
                and pcl.identificacion=cl.identificacion
                and v.id=s.idvendedor
                and pv.identificacion=v.identificacion
                and mll.id=ll.idmarca
                and gll.id=ll.idgravado $orden";
        $r= Conector::ejecutarQuery($sql, null);
        if ($r!=null) {
            if (count($r) > 0) {
                for ($i = 0; $i < count($r); $i++) {
                    foreach ($r[$i] as $key => $value) ${$key} = $value;
                    $dataSalida = json_decode(Salida_Llanta::getDataJSON(2, null, null, null, null, "select valor from salida_llanta where idLlanta={$idllanta}"));
                    if (count($dataSalida)>0) $total += $dataSalida[0]->valor;
                }
            }
        }
        return "$ " . $total;
    }

    public static function getCountOS($filtro, $orden){
        if ($filtro!=null) $filtro=" $filtro and";
        $total = 0;
        $sql="select count(distinct s.id) from llanta as ll, servicio as s, cliente as cl, persona as pcl, empleado as v, persona as pv, marca_llanta as mll, gravado_llanta as gll
                where $filtro s.id=ll.idservicio
                and cl.id=s.idcliente
                and pcl.identificacion=cl.identificacion
                and v.id=s.idvendedor
                and pv.identificacion=v.identificacion
                and mll.id=ll.idmarca
                and gll.id=ll.idgravado $orden group by s.id";
        $r= Conector::ejecutarQuery($sql, null);
        if ($r!=null) {
            if (count($r) > 0) {
                for ($i = 0; $i < count($r); $i++) $total += $r[$i][0];
            }
        }
        return $total;
    }

    public static function getNextConsecutivo($idServicio){
        if ($idServicio!=null){
            $sql="select max(consecutivo)+1 as consecutivo from llanta where idservicio=$idServicio";
            $result=Conector::ejecutarQuery($sql, null);
            if ($result!=null){
                if ($result[0]['consecutivo']!=null) return $result[0]['consecutivo'];
                else return 1;
            } else return 1;
        } else return 1;
    }

    public function getMedidasProcesadas ($json){
        /*
         * Este metodo retorna las medidas: Ancho y Largo registradas en el proceso de raspado.
         * los datos son retornados en formato JSON
         */
        $medidas=array();
        $medidas['nameEstado']='Sin registrar';
        $medidas['status']=false;
        $medidas['anchobanda']=0;
        $medidas['largobanda']=0;
        if ($this->id!=null && $this->idServicio!=null) {
            $sql="select r.anchobanda, r.largobanda
            from llanta as ll, inspeccion_inicial as ii, raspado as r
            where ll.id=$this->id 
            and ii.idllanta=ll.id
            and r.idinspeccion=ii.id";
            $r=Conector::ejecutarQuery($sql, null);
            for ($i=0; $i<count($r); $i++) {
                foreach ($r[$i] as $key => $val) ${$key}=$val;
                if (@$anchobanda!=null && @$largobanda!=null) {
                    $medidas['nameEstado']='Registrados';
                    $medidas['status']=true;
                    $medidas['anchobanda']=@$anchobanda;
                    $medidas['largobanda']=@$largobanda;
                }
            }
            //$medidas=$r;
        }
        //print_r($medidas);
        //die();
        if ($json) return json_encode($medidas, JSON_UNESCAPED_UNICODE);
        else return $medidas;
    }

    public function getPesoBanda(){
        $value='Sin registar';
        if ($this->id!=null) {
            $sql="select cantidad as peso
                from uso_insumo_proceso_detalle as uipd, uso_insumo_proceso as uip, corte_banda as cb, preparacion as pre, raspado as ras, inspeccion_inicial as ii
                where ii.idllanta=$this->id 
                and ras.idinspeccion=ii.id
                and pre.idraspado=ras.id
                and cb.idpreparacion=pre.id
                and uip.proceso=6 
                and uip.idproceso=cb.id 
                and uipd.idusoinsumoproceso=uip.id;";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null) {
                if ($r[0]['peso']!=null) $value=$r[0]['peso'];
            }
        }
        return $value;
    }

    public function getValorDimension() {
        $value='Sin registrar';
        if ($this->id!=null && $this->idDimension!=null) {
            $sql="select dimension from dimension_llanta where id=$this->idDimension;";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null) {
                if ($r[0]['dimension']) $value=$r[0]['dimension'];
            }
        }
        return $value;
    }

    public function getFechaFinServicio(){
        $value='Sin registrar';
        if ($this->id!=null) {
            $sql="select fechaRegistro from servicio_fin where idllanta=$this->id";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null) {
                if ($r[0]['fecharegistro']!=null) $value=$r[0]['fecharegistro'];
            }
        }
        return $value;
    }

}
