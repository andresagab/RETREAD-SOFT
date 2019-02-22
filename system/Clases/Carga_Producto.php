<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 1/10/2018
 * Time: 21:55
 */

class Carga_Producto {

    private $id;
    private $idProducto;
    private $idEmpleado;
    private $cantidad;
    private $fechaRegistro;

    public function __construct($field, $val, $filter, $order) {
        if ($field!=null) {
            if (is_array($field)) {
                foreach ($field as $key => $val) $this->$field=$val;
                $this->setAttributesCaseSensitive($field);
            } else {
                if ($val!=null){
                    $sql="select id, idproducto, idempleado, cantidad, fechaRegistro from carga_producto $filter $order";
                    $r=Conector::ejecutarQuery($sql, null);
                    if (count($r)>0) {
                        foreach ($r[0] as $key => $val) $this->$field=$val;
                        $this->setAttributesCaseSensitive($r[0]);
                    }
                }
            }
        }
    }

    public function setAttributesCaseSensitive($data){
        if ($data!=null) {
            $this->idProducto=$data['idproducto'];
            $this->idEmpleado=$data['idempleado'];
            $this->fechaRegistro=$data['fecharegistro'];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * @param mixed $idProducto
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    /**
     * @return mixed
     */
    public function getIdEmpleado()
    {
        return $this->idEmpleado;
    }

    /**
     * @param mixed $idEmpleado
     */
    public function setIdEmpleado($idEmpleado)
    {
        $this->idEmpleado = $idEmpleado;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @param mixed $fechaRegistro
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getProducto(){
        if ($this->idProducto!=null) return new Producto('id', $this->idProducto, null, null);
        else return new Producto(null, null, null, null);
    }

    public function getEmpleado(){
        if ($this->idEmpleado!=null) return new Empleado('id', $this->idEmpleado, null, null);
        else return new Empleado(null, null, null, null);
    }

    public function add($valid){
        $sql="insert into carga_producto (idproducto, idempleado, cantidad, fecharegistro) values ($this->idProducto, $this->idEmpleado, $this->cantidad, '$this->fechaRegistro')";
        $r=Conector::ejecutarQuery($sql, null);
        if ($valid) {
            if ($r!=null) return true;
            else return false;
        }
    }

    public function update($valid){
        $sql="update carga_producto set idproducto=$this->idProducto, idempleado=$this->idEmpleado, cantidad=$this->cantidad where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($valid) {
            if ($r!=null) return true;
            else return false;
        }
    }

    public function delete($valid){
        $sql="delete from carga_producto where id=$this->id";
        $r=Conector::ejecutarQuery($sql, null);
        if ($valid) {
            if ($r!=null) return true;
            else return false;
        }
    }

    public static function getList($filter, $order){
        if ($filter!=null) $filter=" and $filter ";
        $sql="select id, idproducto, idempleado, cantida, fecharegistro from carga_producto $filter $order";
        return Conector::ejecutarQuery($sql, null);
    }

    public static function getListObjects($filter, $order){
        $objects=array();
        $data=Carga_Producto::getList($filter, $order);
        for ($i=0; $i<count($data); $i++) $objects[$i]=new Carga_Producto($data[$i], null, null, null);
        return $objects;
    }

    public static function getDataJSON($type, $field, $value, $filter, $order, $sql, $extras){
        $JSON=array();
        switch ($type) {
            case 0:
                if ($field!=null && $value!=null) {
                    $object=new Carga_Producto($field, $value, $filter, $order);
                    foreach ($object as $key => $val) $JSON["$key"]=$val;
                }
                break;
            case 1:
                $data=Carga_Producto::getListObjects($filter, $order);
                for ($i=0; $i<count($data); $i++) {
                    $array = array();
                    foreach ($data[$i] as $key => $val) $array["$key"] = $val;
                    array_push($JSON, $array);
                }
                break;
            case 2:
                if ($sql!=null) {
                    $r=Conector::ejecutarQuery($sql, null);
                    for ($i=0; $i<count($r); $i++) {
                        $array = array();
                        foreach ($r[$i] as $key => $val) $array["$key"] = $val;
                        array_push($JSON, $array);
                    }
                }
                break;
        }
        return json_encode($JSON, JSON_UNESCAPED_UNICODE);
    }

}