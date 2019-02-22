<?php

/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** Descripcion de la clase Inspecccion_Inicial:
 *
 * Define las propiedades id, idLlanta, IdEmpleado, numeroRencauche, foto, observaciones, checked, estado y fechaRegistro las cuales permite identificar el proceso de inspeccion inicial de una llanta.
 *
 * El atributo idLlanta ayudara a relacionar la inspeccion con el servicio y la llanta seleccionada.
 * El atributo idEmpleado nos permitira identificar al empleado de tipo operario el cual sera el responsable de realizar el proceso de inspeccion.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */

class Inspeccion_Inicial {
    //Propiedades
    private $id;
    private $idLlanta;
    private $idEmpleado;
    private $numeroRencauche;
    private $foto;
    private $observaciones;
    private $estado;
    private $checked;
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
                $sql="select id, idLlanta, idEmpleado, numeroRencauche, foto, estado, checked, observaciones, fechaRegistro from {$P}inspeccion_inicial where $campo=$valor $filtro $orden";
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
    	$this->idLlanta=$arreglo['idllanta'];
    	$this->idEmpleado=$arreglo['idempleado'];
    	$this->numeroRencauche=$arreglo['numerorencauche'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdLlanta() {
        return $this->idLlanta;
    }

    function getIdEmpleado() {
        return $this->idEmpleado;
    }

    function getNumeroRencauche() {
        return $this->numeroRencauche;
    }

    function getFoto() {
        return $this->foto;
    }

    function getObservaciones() {
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
        else return "Sin observaciones";
    }

    function getEstado() {
        return $this->estado;
    }

    function getChecked() {
        return $this->checked;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdLlanta($idLlanta) {
        $this->idLlanta = $idLlanta;
    }

    function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }

    function setNumeroRencauche($numeroRencauche) {
        $this->numeroRencauche = $numeroRencauche;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setObservaciones($observaciones) {
        if ($this->observaciones!=null && $this->observaciones!="" && $this->observaciones!='-' && $this->observaciones!='---' && $this->observaciones!=' - ') return $this->observaciones;
        else return "Sin observaciones";
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setChecked($checked) {
        $this->checked = $checked;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    function getNombreChecked() {
        if ($this->checked) return 'Aprobado';
        else return 'Reprobado';
    }
    
    function getNombreEstado() {
        switch ($this->estado){
            case 'spr':
                return 'Sin procesar';
                break;
            case 'prs':
                return 'Procesando';
                break;
            case 'prf':
                return 'Procesado';
                break;
            default :
                return 'Desconocido';
                break;
        }
    }

    function getLlanta() {
        if ($this->idLlanta!=null) return new Llanta ('id', $this->idLlanta, null, null);
        else return new Llanta (null, null, null, null);
    }

    function getEmpleado() {
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }

    public function grabar() {
        $P='';
        $sql="insert into {$P}inspeccion_inicial (idLlanta, idEmpleado, numeroRencauche, foto, estado, checked, observaciones, fechaRegistro) values ($this->idLlanta, $this->idEmpleado, $this->numeroRencauche, '$this->foto', '$this->estado', '$this->checked', '$this->observaciones', '$this->fechaRegistro')";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}inspeccion_inicial set idLlanta=$this->idLlanta, idEmpleado=$this->idEmpleado, foto='$this->foto', estado='$this->estado', checked='$this->checked', observaciones='$this->observaciones' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function finalizar($observaciones) {
        $P='';
        $sql="update {$P}inspeccion_inicial set foto='$this->foto', observaciones='".rtrim($this->observaciones)." - $observaciones', checked='$this->checked', estado='$this->estado' where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}inspeccion_inicial where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, idLlanta, idEmpleado, numeroRencauche, foto, estado, checked, observaciones, fechaRegistro from {$P}inspeccion_inicial $filtro $orden";
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Inspeccion_Inicial::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Inspeccion_Inicial($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null && $valor!='') $objeto=new Inspeccion_Inicial($campo, $valor, $filtro, $orden);
        else $objeto=new Inspeccion_Inicial(null, null, null, null);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['idLlanta']=$objeto->getIdLlanta();
        $arreglo['idEmpleado']=$objeto->getIdEmpleado();
        $arreglo['numeroRencauche']=$objeto->getNumeroRencauche();
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['estado']=$objeto->getEstado();
        $arreglo['nombreEstado']=$objeto->getNombreEstado();
        $arreglo['checked']=$objeto->getChecked();
        $arreglo['nombreChecked']=$objeto->getNombreChecked();
        $arreglo['observaciones']=$objeto->getObservaciones();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['llanta']= json_decode(Llanta::getObjetoJSON('id', $objeto->getIdLlanta(), null, null));
        $empleado=$objeto->getEmpleado();
        $arreglo['empleado']=json_decode($empleado->getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
            $persona=$empleado->getPersona();
            $arreglo['persona']=json_decode($persona->getObjetoJSON('identificacion', "'{$persona->getIdentificacion()}'", null, null));
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Inspeccion_Inicial::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['idLlanta']=$objeto->getIdLlanta();
            $arreglo['idEmpleado']=$objeto->getIdEmpleado();
            $arreglo['numeroRencauche']=$objeto->getNumeroRencauche();
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['estado']=$objeto->getEstado();
            $arreglo['nombreEstado']=$objeto->getNombreEstado();
            $arreglo['checked']=$objeto->getChecked();
            $arreglo['nombreChecked']=$objeto->getNombreChecked();
            $arreglo['observaciones']=$objeto->getObservaciones();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['llanta']= json_decode(Llanta::getObjetoJSON('id', $objeto->getIdLlanta(), null, null));
            $empleado=$objeto->getEmpleado();
            $arreglo['empleado']=json_decode($empleado->getObjetoJSON('id', $objeto->getIdEmpleado(), null, null));
                $persona=$empleado->getPersona();
                $arreglo['persona']=json_decode($persona->getObjetoJSON('identificacion', "'{$persona->getIdentificacion()}'", null, null));
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getProximoNumeroRencauhe() {
        $P='';
        $sql="select max(numeroRencauche)+1 as numerorencauche from {$P}inspeccion_Inicial";
        $resultado= Conector::ejecutarQuery($sql, null);
        if ($resultado!=null){
            if ($resultado[0]['numerorencauche']!=null) return $resultado[0]['numerorencauche'];
            else return 1;
        } else return 0;
    }
    
    public function getRechazos() {
        $objetosRechazos= Rechazo::getListaEnObjetos(null, null);
        $RII=new Rechazo_Inspeccion_Inicial('idInspeccionInicial', $this->id, null, null);
        $JSON=array();
        if ($RII->getId()!=NULL){
            $objetosRII_Detalles= RII_Detalles::getListaEnObjetos("idRII={$RII->getId()}", null);
            for ($i = 0; $i < count($objetosRechazos); $i++) {
                $objetoRechazo=$objetosRechazos[$i];
                $arreglo=array();
                $arreglo['id']=$objetoRechazo->getId();
                $arreglo['nombre']= rtrim($objetoRechazo->getNombre());
                $arreglo['observaciones']= rtrim($objetoRechazo->getObservaciones());
                for ($j = 0; $j < count($objetosRII_Detalles); $j++) {
                    $objetoRIIDetalles=$objetosRII_Detalles[$j];
                    //echo $objetoRechazo->getId()." - ".$objetoRIIDetalles->getIdRechazo()."\n";
                    //if (in_array($objetoRechazo->getId(), $objetoRIIDetalles)) $arreglo['checked']= "true";
                    if ($objetoRechazo->getId()==$objetoRIIDetalles->getIdRechazo()){
                        $arreglo['checked']= "true";
                        $j= count($objetosRII_Detalles);
                    } //else $arreglo['checked']= "false";
                }
                array_push($JSON, $arreglo);
            }
        } else {
            for ($i = 0; $i < count($objetosRechazos); $i++) {
                $objetoRechazo=$objetosRechazos[$i];
                $arreglo=array();
                $arreglo['id']=$objetoRechazo->getId();
                $arreglo['nombre']= rtrim($objetoRechazo->getNombre());
                $arreglo['observaciones']= rtrim($objetoRechazo->getObservaciones());
                //$arreglo['checked']= "false";
                array_push($JSON, $arreglo);
            }
        }
        return json_encode($JSON,JSON_UNESCAPED_UNICODE);
    }
    
    public function getFinRencaucheXRechazoEnInspeccionInicial(){
        //True = Proceso de rencauche finalizado por rechazo de la llanta
        //Else = Proceso de rencauche sin finalizar (Procesos pendientes)
        if ($this->id!=null && $this->id!=''){
            $rechazoLlanta=new Rechazo_Inspeccion_Inicial('idInspeccionInicial', $this->id, null, null);
            if ($rechazoLlanta->getId()!=null && $rechazoLlanta->getId()!='') return true;
            else return false;
        } else return false;
    }
}
