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
 * Descripcion de la clase Producto:
 *
 * Define las propiedades id, codPuc, idPresentacion, idUnidadMedida, idProvedor, stock, stockMinimo, stockMaximo, foto, costo, ingredientes, tipo, fechaRegistro las cuales permite identificar a los productos del sistema.
 *
 * @author Andres Geovanny Angulo Botina <Sugerencia a andrescabj981@gmail.com>
 *
 */

class Producto{
    //Propiedades
    private $id;
    private $codPuc;
    private $idPresentacion;
    private $idUnidadMedida;
    private $idProvedor;
    private $grupo;
    private $stock;
    private $stockMinimo;
    private $stockMaximo;
    private $peso;
    private $foto;
    private $costo;
    private $ingredientes;
    private $tipo;
    private $fechaRegistro;
    private $idCategoria;
    //Fin propiedades

    //Constructor
    function __construct($campo, $valor, $filtro, $orden){
    	$BD='';
    	$P='';
    	if ($campo!=null) {
            if (is_array($campo)){
                foreach ($campo as $key => $value) $this->$key=$value;
                $this->cargarAtributos($campo);
            } else {
                $sql="select id, codPuc, idPresentacion, idUnidadMedida, idProvedor, grupo, stock, stockMinimo, stockMaximo, peso, foto, costo, ingredientes, tipo, fechaRegistro, idCategoria from {$P}producto where $campo=$valor $filtro $orden";
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
    	$this->codPuc=$arreglo['codpuc'];
    	$this->idPresentacion=$arreglo['idpresentacion'];
    	$this->idUnidadMedida=$arreglo['idunidadmedida'];
    	$this->idProvedor=$arreglo['idprovedor'];
    	$this->stockMinimo=$arreglo['stockminimo'];
    	$this->stockMaximo=$arreglo['stockmaximo'];
    	$this->fechaRegistro=$arreglo['fecharegistro'];
    	$this->idCategoria=$arreglo['idcategoria'];
    }
    
    function getId() {
        return $this->id;
    }

    function getCodPuc() {
        return $this->codPuc;
    }

    function getIdPresentacion() {
        return $this->idPresentacion;
    }

    function getIdUnidadMedida() {
        return $this->idUnidadMedida;
    }

    function getIdProvedor() {
        return $this->idProvedor;
    }
    
    function getGrupo() {
        return $this->grupo;
    }

    function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    function getStock() {
        return $this->stock;
    }

    function getStockMinimo() {
        return $this->stockMinimo;
    }

    function getStockMaximo() {
        return $this->stockMaximo;
    }

    function getFoto() {
        return $this->foto;
    }
    
    function getPeso() {
        return $this->peso;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function getCosto() {
        return $this->costo;
    }

    function getIngredientes() {
        return $this->ingredientes;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getFechaRegistro() {
        return $this->fechaRegistro;
    }
    
    function getIdCategoria() {
        return $this->idCategoria;
    }
        
    function getPuc() {
        if ($this->codPuc!=null) return new Puc('codigo', "'$this->codPuc'", null, null); 
        else return new Puc (null, null, null, null);
    }
    
    function getPresentacion() {
        if ($this->idPresentacion!=null) return new Presentacion_Producto ('id', $this->idPresentacion, null, null); 
        else return new Presentacion_Producto (null, null, null, null);
    }
    
    function getUnidadMedida() {
        if ($this->idUnidadMedida!=null) return new Unidad_Medida('id', $this->idUnidadMedida, null, null); 
        else return new Unidad_Medida(null, null, null, null);
    }
    
    function getProvedor() {
        if ($this->idProvedor!=null) return new Tercero('id', $this->idProvedor, null, null); 
        else return new Tercero(null, null, null, null);
    }
    
    function getCategoria() {
        if ($this->idCategoria!=null) return new Categoria_Producto('id', $this->idCategoria, null, null); 
        else return new Categoria_Producto(null, null, null, null);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodPuc($codPuc) {
        $this->codPuc = $codPuc;
    }

    function setIdPresentacion($idPresentacion) {
        $this->idPresentacion = $idPresentacion;
    }

    function setIdUnidadMedida($idUnidadMedida) {
        $this->idUnidadMedida = $idUnidadMedida;
    }

    function setIdProvedor($idProvedor) {
        $this->idProvedor = $idProvedor;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function setStockMinimo($stockMinimo) {
        $this->stockMinimo = $stockMinimo;
    }

    function setStockMaximo($stockMaximo) {
        $this->stockMaximo = $stockMaximo;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function setIngredientes($ingredientes) {
        $this->ingredientes = $ingredientes;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }
    
    function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }
    
    public function grabar() {
        $P='';
        $sql="insert into {$P}producto (codPuc, idPresentacion, idUnidadMedida, idProvedor, grupo, stock, stockMinimo, stockMaximo, peso, foto, costo, tipo, fechaRegistro, idCategoria) values ('$this->codPuc', $this->idPresentacion, $this->idUnidadMedida, $this->idProvedor, $this->grupo, $this->stock, $this->stockMinimo, $this->stockMaximo, $this->peso, '$this->foto', $this->costo, '$this->tipo', '$this->fechaRegistro', $this->idCategoria)";
        Conector::ejecutarQuery($sql, null);
    }

    public function modificar() {
        $P='';
        $sql="update {$P}producto set codPuc='$this->codPuc', idPresentacion=$this->idPresentacion, idUnidadMedida=$this->idUnidadMedida, idProvedor=$this->idProvedor, stock=$this->stock, stockMinimo=$this->stockMinimo, stockMaximo=$this->stockMaximo, foto='$this->foto', costo=$this->costo, tipo='$this->tipo', peso=$this->peso, grupo=$this->grupo, idCategoria=$this->idCategoria where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }

    public function eliminar() {
        $P='';
        $sql="delete from {$P}producto where id=$this->id";
        Conector::ejecutarQuery($sql, null);
    }
    
    public static function getLista($filtro, $orden) {
        $P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $sql="select id, codPuc, idPresentacion, idUnidadMedida, idProvedor, grupo, stock, stockMinimo, stockMaximo, peso, foto, costo, ingredientes, tipo, fechaRegistro, idCategoria from {$P}producto $filtro $orden";
        //echo $sql;
        return Conector::ejecutarQuery($sql, null);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos= Producto::getLista($filtro, $orden);
        $objetos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objetos[$i]=new Producto($datos[$i], null, null, null);
        }
        return $objetos;
    }
    
    public static function getObjetoJSON($campo, $valor, $filtro, $orden) {
        if ($valor!=null || $valor!='') $objeto=new Producto($campo, $valor, $filtro, $orden);
        else $objeto=new Producto(null, null, null, null);
        $objeto=new Producto($campo, $valor, $filtro, $orden);
        $JSON=array();
        $arreglo=array();
        $arreglo['id']=$objeto->getId();
        $arreglo['codPuc']= rtrim($objeto->getCodPuc());
        $arreglo['idPresentacion']=$objeto->getIdPresentacion();
        $arreglo['idUnidadMedida']=$objeto->getIdUnidadMedida();
        $arreglo['idProvedor']=$objeto->getIdProvedor();
        $arreglo['grupo']=$objeto->getGrupo();
        $arreglo['stock']=$objeto->getStock();
        $arreglo['stockMinimo']=$objeto->getStockMinimo();
        $arreglo['stockMaximo']=$objeto->getStockMaximo();
        $arreglo['peso']=$objeto->getPeso();
        if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
        $arreglo['foto']=$objeto->getFoto();
        $arreglo['costo']=$objeto->getCosto();
        $arreglo['ingredientes']=$objeto->getIngredientes();
        $arreglo['tipo']=$objeto->getTipo();
        $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
        $arreglo['idCategoria']=$objeto->getIdCategoria();
        $arreglo['categoria']= json_decode(Categoria_Producto::getObjetoJSON('id', $objeto->getIdCategoria(), null, null));
        $puc=$objeto->getPuc();
        $presentacion=$objeto->getPresentacion();
        $unidadMedida=$objeto->getUnidadMedida();
        $provedor=$objeto->getProvedor();
        //Puc
            $arreglo['idPuc']=rtrim($puc->getId());
            $arreglo['nombrePuc']=rtrim($puc->getNombre());
            $arreglo['descripcionPuc']=rtrim($puc->getDescripcion());
            $arreglo['nivelPuc']=$puc->getNivel();
            $arreglo['fechaRegistroPuc']=$puc->getFechaRegistro();
        //Presentacion
            $arreglo['nombrePresentacion']=rtrim($presentacion->getNombre());
            $arreglo['descripcionPresentacion']=rtrim($presentacion->getDescripcion());
            $arreglo['fechaRegistroPresentacion']=$presentacion->getFechaRegistro();
        //UnidadMedida
            $arreglo['nombreUnidadMedida']= rtrim($unidadMedida->getNombre());
            $arreglo['siglaUnidadMedida']=rtrim($unidadMedida->getSigla());
            $arreglo['descripcionUnidadMedida']=rtrim($unidadMedida->getDescripcion());
            $arreglo['fechaRegistroUnidadMedida']=$unidadMedida->getFechaRegistro();
        //Proveedor
            $arreglo['codPucTercero']= rtrim($provedor->getCodPuc());
            $arreglo['pucTercero']= Puc::getObjetoJSON('codigo', "'{$provedor->getCodPuc()}'", null, null);
            $arreglo['clienteTercero']= Cliente::getObjetoJSON('id', $provedor->getIdCliente(), null, null);
        if ($provedor->getCliente()->getRazonSocial()!='' || $provedor->getCliente()->getRazonSocial()!=null) $arreglo['nombreProveedor']= rtrim ($provedor->getCliente()->getRazonSocial());
        else $arreglo['nombreProveedor']= rtrim ($provedor->getCliente()->getPersona()->getNombresCompletos());
        array_push($JSON, $arreglo);
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getObjetosJSON($filtro, $orden) {
        $datos= Producto::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['codPuc']= rtrim($objeto->getCodPuc());
            $arreglo['idPresentacion']=$objeto->getIdPresentacion();
            $arreglo['idUnidadMedida']=$objeto->getIdUnidadMedida();
            $arreglo['idProvedor']=$objeto->getIdProvedor();
            $arreglo['grupo']=$objeto->getGrupo();
            $arreglo['stock']=$objeto->getStock();
            $arreglo['stockMinimo']=$objeto->getStockMinimo();
            $arreglo['stockMaximo']=$objeto->getStockMaximo();
            $arreglo['peso']=$objeto->getPeso();
            if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['costo']=$objeto->getCosto();
            $arreglo['ingredientes']=$objeto->getIngredientes();
            $arreglo['tipo']=$objeto->getTipo();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['idCategoria']=$objeto->getIdCategoria();
            $arreglo['categoria']= json_decode(Categoria_Producto::getObjetoJSON('id', $objeto->getIdCategoria(), null, null));
            $puc=$objeto->getPuc();
            $presentacion=$objeto->getPresentacion();
            $unidadMedida=$objeto->getUnidadMedida();
            $provedor=$objeto->getProvedor();
            //Puc
                $arreglo['idPuc']=rtrim($puc->getId());
                $arreglo['nombrePuc']=rtrim($puc->getNombre());
                $arreglo['descripcionPuc']=rtrim($puc->getDescripcion());
                $arreglo['nivelPuc']=$puc->getNivel();
                $arreglo['fechaRegistroPuc']=$puc->getFechaRegistro();
            //Presentacion
                $arreglo['nombrePresentacion']=rtrim($presentacion->getNombre());
                $arreglo['descripcionPresentacion']=rtrim($presentacion->getDescripcion());
                $arreglo['fechaRegistroPresentacion']=$presentacion->getFechaRegistro();
            //UnidadMedida
                $arreglo['nombreUnidadMedida']= rtrim($unidadMedida->getNombre());
                $arreglo['siglaUnidadMedida']=rtrim($unidadMedida->getSigla());
                $arreglo['descripcionUnidadMedida']=rtrim($unidadMedida->getDescripcion());
                $arreglo['fechaRegistroUnidadMedida']=$unidadMedida->getFechaRegistro();
            //Proveedor
                $pucProvedor=$provedor->getPuc();
                $cliente=$provedor->getCliente();
                $arreglo['codPucTercero']= rtrim($provedor->getCodPuc());
                $arreglo['pucTercero']= Puc::getObjetoJSON('codigo', "'{$provedor->getCodPuc()}'", null, null);
                $arreglo['clienteTercero']= json_decode(Cliente::getObjetoJSON('id', $provedor->getIdCliente(), null, null));
                $arreglo['identificacionPersona']= trim($cliente->getIdentificacion());
                $arreglo['nombresPersona']= $cliente->getPersona()->getNombresCompletos();
            if ($provedor->getCliente()->getRazonSocial()!='' || $provedor->getCliente()->getRazonSocial()!=null) $arreglo['nombreProveedor']= rtrim ($provedor->getCliente()->getRazonSocial());
            else $arreglo['nombreProveedor']= rtrim ($provedor->getCliente()->getPersona()->getNombresCompletos());
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getDataJSON($filtro, $orden) {
        $datos= Producto::getListaEnObjetos($filtro, $orden);
        $JSON=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $arreglo=array();
            $arreglo['id']=$objeto->getId();
            $arreglo['codPuc']= rtrim($objeto->getCodPuc());
            $arreglo['idPresentacion']=$objeto->getIdPresentacion();
            $arreglo['idUnidadMedida']=$objeto->getIdUnidadMedida();
            $arreglo['idProvedor']=$objeto->getIdProvedor();
            $arreglo['grupo']=$objeto->getGrupo();
            $arreglo['stock']=$objeto->getStock();
            $arreglo['stockMinimo']=$objeto->getStockMinimo();
            $arreglo['stockMaximo']=$objeto->getStockMaximo();
            $arreglo['peso']=$objeto->getPeso();
            if ($objeto->getFoto()==null || $objeto->getFoto()=='') $arreglo['notImage']=true;
            $arreglo['foto']=$objeto->getFoto();
            $arreglo['costo']=$objeto->getCosto();
            $arreglo['ingredientes']=$objeto->getIngredientes();
            $arreglo['tipo']=$objeto->getTipo();
            $arreglo['fechaRegistro']=$objeto->getFechaRegistro();
            $arreglo['idCategoria']=$objeto->getIdCategoria();
            $arreglo['Puc']= json_decode(Puc::getObjetoJSON('codigo', "'{$objeto->getCodPuc()}'", null, null));
            $arreglo['Categoria']= json_decode(Categoria_Producto::getObjetoJSON('id', $objeto->getIdCategoria(), null, null));
            $arreglo['Presentacion']= json_decode(Presentacion_Producto::getObjetoJSON('id', $objeto->getIdPresentacion(), null, null));
            $arreglo['UnidadMedida']= json_decode(Unidad_Medida::getObjetoJSON('id', $objeto->getIdUnidadMedida(), null, null));
            $arreglo['Proveedor']= json_decode(Tercero::getObjetoJSON('id', $objeto->getIdProvedor(), null, null));
            //if ($provedor->getCliente()->getRazonSocial()!='' || $provedor->getCliente()->getRazonSocial()!=null) $arreglo['nombreProveedor']= rtrim ($provedor->getCliente()->getRazonSocial());
            //else $arreglo['nombreProveedor']= rtrim ($provedor->getCliente()->getPersona()->getNombresCompletos());
            array_push($JSON, $arreglo);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getDataSQLJSON($sql, $filtro, $orden){
        if ($sql!=null) $sql=$sql;
        else $sql="SELECT pr.id as idProducto, pr.stock, pr.stockminimo, pr.stockmaximo, pr.peso, pr.costo, pr.foto,
            pu.id as idPuc, pu.nombre as nombrePuc, pu.descripcion as descripcionPuc,
            pp.id as idPresentacion, pp.nombre as nombrePresentacion, pp.descripcion as descripcionPresentacion,
            um.id as idUnidadMedida, um.nombre as nombreUnidadMedida, um.descripcion as descripcionUnidadMedida, um.sigla as siglaUnidadMedida, 
            c.identificacion as identificacionCliente, c.nit as nitCliente, c.razonsocial as razonSocial, c.id as idCliente,
            per.nombres as nombresCliente, per.apellidos as apellidosCliente, per.celular as celularCliente, per.direccion as direccionCliente, per.email as emailCliente, per.fechanacimiento as fechaNacimientoPersona
            FROM puc as pu, producto as pr, presentacion_producto as pp, unidad_medida as um, tercero as t, cliente as c, persona as per
            WHERE pu.codigo=pr.codpuc
            AND pp.id=pr.idpresentacion
            AND um.id=pr.idunidadmedida
            AND t.id=pr.idprovedor
            AND c.id=t.idcliente
            AND per.identificacion=c.identificacion $filtro $orden";
        $data=Conector::ejecutarQuery($sql, null);
        $JSON=array();
        for ($i=0; $i<count($data); $i++){
            $array=array();
            foreach ($data[$i] as $key => $val) {
                $array["$key"]=$val;
                ${$key}=$val;
            }
            if ($nombrescliente!=null && $apellidoscliente!=null){
                $nombreProvedor=$nombrescliente . " " . $apellidoscliente;
                if ($razonsocial!=null) $nombreProvedor=$nombreProvedor . " ($razonsocial)";
            } else {
                if ($razonsocial!=null) $nombreProvedor=$razonsocial;
            }
            if ($foto==null || $foto=='') $array['notImage']=true;
            $array['nombreProveedor']=$nombreProvedor;
            $object=new Producto(null, null, null, null);
            @$object->setId($idproducto);
            $array['statusDelete']=$object->getStatusDelete();
            array_push($JSON, $array);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }
    
    public static function getNextId() {
        global $P, $BD;
        $sql="select max(id)+1 as id from {$P}producto";
        $result= Conector::ejecutarQuery($sql, null);
        if ($result!=null){
            if ($result[0]['id']!=null) return $result[0]['id'];
            else return 1;
        } else return 1;
    }
    
    public static function getDatosEnOptions($filtro, $orden, $predeterminado) {
        $datos= Producto::getListaEnObjetos($filtro, $orden);
        $options="<option value='#'>Seleccione una opcion</option>";
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            if ($predeterminado==$objeto->getId()) $selected="selected";
            else $selected='';
            $options.="<option value='{$objeto->getId()}' $selected>". rtrim($objeto->getPuc()->getNombre()) ."</option>";
            //$options.="<option value='{$objeto->getId()}' $selected><img class='thumbnail' src='system/Uploads/Productos/{$objeto->getFoto()}'>". rtrim($objeto->getPuc()->getNombre()) ."</option>";
        }
        return $options;
    }
    
    public static function getNombresJSON($filtro, $orden) {
        $datos= Producto::getListaEnObjetos($filtro, $orden);
        $json=array();
        for ($i = 0; $i < count($datos); $i++) {
            $objeto=$datos[$i];
            $json[]= $objeto->getId() . "." . rtrim($objeto->getPuc()->getNombre());
        }
        return json_encode($json);
    }

    public function getStatusDelete(){
        /*
         * Si return true => se puede eliminar el registro en caso contrario NO se puede eliminar (False)
         */
        $status=true;
        if ($this->id!=null) {
            $sql="select id from insumo_puestotrabajo where idinsumo=$this->id";
            $r=Conector::ejecutarQuery($sql, null);
            if ($r!=null) {
                if ($r[0]['id']!=null) $status=false;
            }
        }
        return $status;
    }

    public static function getSQLJSON($sql, $filters, $order, $extras){
        $JSON=array();
        if ($sql==null) $sql="select p.nombre as nombreInsumo, p.descripcion descripcionInsumo, pr.id as idproducto, pr.stock as stockbodega from producto as pr, puc as p where {$filters[0]->filter} p.codigo=pr.codpuc $order;";
        $r=Conector::ejecutarQuery($sql, null);
        for ($i=0; $i<count($r); $i++) {
            $array=array();
            foreach ($r[$i] as $key => $val) {
                $array["$key"]=$val;
                ${$key}=$val;
            }
            if ($extras) {
                $dataCargasKardex = Producto::getTotalCargado(@$idproducto, $filters[1]->filter, null);
                $dataStockPuestoTrabajo = Producto::getTotalAsignadoPuestoTrabajo(@$idproducto, $filters[2]->filter, null);

                if ($filters[1]->filter!=null) $array['stockCargado'] = $dataCargasKardex['totalCargadoFiltro'];
                else $array['stockCargado'] = $dataCargasKardex['totalCargado'];

                if ($filters[2]->filter!=null) $array['stockPuestoTrabajo'] = $dataStockPuestoTrabajo['stockPTFiltro'];
                else $array['stockPuestoTrabajo'] = $dataStockPuestoTrabajo['stockPT'];

                if (@$stockbodega==null) $stockbodega = 0;
                else $stockbodega = round((double) $stockbodega, 2);

                $array['stockbodega'] = round($array['stockbodega'], 2);
                $array['stockOriginal'] = round($stockbodega + $dataStockPuestoTrabajo['stockPT'] - $dataCargasKardex['totalCargado'], 2);
                $array['stockAcumulado'] = $array['stockCargado'] + $array['stockOriginal'];
                $array['totalPuestoTrabajo'] = $dataStockPuestoTrabajo['stockPT'];

                $moreData = Producto::getDataProductoPuestoTrabajo(@$idproducto, $filters, null);

                if ($filters[3]->filter!=null) $array['stockRecargadoPuestoTrabajo'] = $moreData['cantidadCargadaPTFiltro'];
                else $array['stockRecargadoPuestoTrabajo'] = $moreData['cantidadCargadaPT'];

                $array['stockOriginalPuestoTrabajo'] = $array['stockPuestoTrabajo'] - $moreData['cantidadCargadaPT'];
                $array['stockAcumuladoPuestoTrabajo'] = $array['stockOriginalPuestoTrabajo'] + $array['stockRecargadoPuestoTrabajo'];
                $array['numeroUsos'] = $moreData['vecesUsado'];

                if ($filters[4]->filter!=null) $array['stockUsado'] = $moreData['cantidadUsadaFiltro'];
                else $array['stockUsado'] = $moreData['cantidadUsada'];

                if (strtolower($moreData['cantidadUsada'])=='no aplica') $array['stockRestante'] = $array['totalPuestoTrabajo'];
                else {
                    if ($moreData['cantidadUsada']<$array['stockPuestoTrabajo']) $array['stockRestante'] = (double) $array['totalPuestoTrabajo']-(double) $moreData['cantidadUsada'];
                    else if ($moreData['cantidadUsada']>$array['stockPuestoTrabajo']) $array['stockRestante'] = (double) $moreData['cantidadUsada']-(double) $array['totalPuestoTrabajo'];
                    else $array['stockRestante'] = (double) $moreData['cantidadUsada']-(double) $array['totalPuestoTrabajo'];
                }
                //if ($moreData['cantidadUsada'])$array['stockRestante']=$moreData['cantidadUsada']-$array['stockPuestoTrabajo'];
            }
            array_push($JSON, $array);
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

    public static function getTotalCargado($idProducto, $filter, $order){
        $data=array();
        $data['totalCargadoFiltro']=0;
        $data['totalCargado']=0;
        if ($idProducto!=null) {
            if ($filter!=null) {
                $sql="select sum(cantidad) as totalcargado from carga_producto where idproducto=$idProducto $filter $order";
                $result=Conector::ejecutarQuery($sql, null);
                if ($result!=null) {
                    if ($result[0]['totalcargado']!=null) $data['totalCargadoFiltro']=$result[0]['totalcargado'];
                }
            }
            $sql="select sum(cantidad) as totalcargado from carga_producto where idproducto=$idProducto";
            $result=Conector::ejecutarQuery($sql, null);
            if ($result!=null) {
                if ($result[0]['totalcargado']!=null) $data['totalCargado']=$result[0]['totalcargado'];
            }
        }
        return $data;
    }

    public static function getTotalAsignadoPuestoTrabajo($idProducto, $filter, $order){
        $data=array();
        $data['stockPT']=0;
        $data['stockPTFiltro']=0;
        if ($idProducto!=null) {
            if ($filter!=null) {
                $sql="select sum(cantidad) as totalcargado from insumo_puestotrabajo where idinsumo=$idProducto $filter $order";
                $result=Conector::ejecutarQuery($sql, null);
                if ($result!=null) {
                    if ($result[0]['totalcargado']!=null) $data['stockPTFiltro']=$result[0]['totalcargado'];
                }
            }
            $sql="select sum(cantidad) as totalcargado from insumo_puestotrabajo where idinsumo=$idProducto";
            $result=Conector::ejecutarQuery($sql, null);
            if ($result!=null) {
                if ($result[0]['totalcargado']!=null) $data['stockPT']=$result[0]['totalcargado'];
            }
        }
        return $data;
    }

    public static function getDataProductoPuestoTrabajo($idProducto, $filters, $order){
        $array=array();
        $array['vecesUsado'] = 0;
        $array['cantidadUsada'] = 'No aplica';
        $array['cantidadUsadaFiltro'] = 'No aplica';
        $array['cantidadCargadaPTFiltro'] = 0;
        $array['cantidadCargadaPT'] = 0;
        if ($idProducto!=null) {
            $sql="select id from insumo_puestotrabajo where idinsumo=$idProducto {$filters[2]->filter} $order;";
            $result=Conector::ejecutarQuery($sql, null);
            for ($i=0; $i<count($result); $i++) {
                if ($result[$i]['id']!=null) {
                    if ($filters[3]->filter!=null) {
                        $sql="select sum(cantidad) as totalcargadopt from carga_producto_puesto_trabajo where idinsumopuestotrabajo={$result[$i]['id']} {$filters[3]->filter} $order";
                        $r=Conector::ejecutarQuery($sql, null);
                        if ($r!=null) {
                            if ($r[0]['totalcargadopt']!=null) $array['cantidadCargadaPTFiltro']+=$r[0]['totalcargadopt'];
                        }
                    }
                    $sql="select sum(cantidad) as totalcargadopt from carga_producto_puesto_trabajo where idinsumopuestotrabajo={$result[$i]['id']}";
                    $r=Conector::ejecutarQuery($sql, null);
                    if ($r!=null) {
                        if ($r[0]['totalcargadopt']!=null) $array['cantidadCargadaPT']+=$r[0]['totalcargadopt'];
                    }
                }
                if ($result[$i]['id']!=null) {
                    if ($filters[4]->filter!=null) {
                        $sql="select sum(cantidad) as cantidadUsada from uso_insumo_proceso_detalle where idinsumopt={$result[$i]['id']} {$filters[4]->filter} $order";
                        $response=Conector::ejecutarQuery($sql, null);
                        if ($response!=null) {
                            if ($response[0]['cantidadusada']!=null) $array['cantidadUsadaFiltro']=$response[0]['cantidadusada'];
                        }
                    }
                    $sql="select count(id) as numeroVecesUsado, sum(cantidad) as cantidadUsada from uso_insumo_proceso_detalle where idinsumopt={$result[$i]['id']}";
                    $response=Conector::ejecutarQuery($sql, null);
                    if ($response!=null) {
                        if ($response[0]['numerovecesusado']!=null) $array['vecesUsado']=$response[0]['numerovecesusado'];
                        if ($response[0]['cantidadusada']!=null) $array['cantidadUsada']=$response[0]['cantidadusada'];
                    }
                }
            }
        }
        return $array;
    }

}
