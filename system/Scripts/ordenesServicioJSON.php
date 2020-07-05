<?php
/**
 * @version 1.0 | Aqui se procesan los datos del la página ordenesServicio.php | 04-07-2020
 * @author Andres Angulo - andrescabj981@gmail.com
 */

include_once dirname(__FILE__) . '/../../lib/php/Time.php';
include_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Servicio.php';

if (count($_GET) > 0) foreach ($_GET as $item => $val) ${$item} = $val;
if (count($_POST) > 0) foreach ($_POST as $item => $val) ${$item} = $val;

$JSON = array();
$JSON['status'] = false;
$JSON['data'] = [];
//Definimos el filtro de busqueda en vacio
$filter = "";
//Comprobamos si tenememos datos http, en caso de ser afirmativo significa que el usuario realizo una busqueda
$httpData = getDataPOST_GET();
//Definimos una variable para determinar que no se encontraron resultados
$finded =  false;
if ($httpData['status']) {
    if (isset($httpData['data']->valueSearch)) {
        if (($idServicio = Servicio::getDirectSearch($httpData['data']->valueSearch)) != null) {
            $filter = "s.id='$idServicio' and";
            $finded = true;
        }
    }
}
//Cargamos los ultimos 50 registros de la tabla servicio
$sql="select s.id as idOs, s.numerofactura, s.os, s.estado estadoOs, s.fecharegistro as fecharegistroos, s.fecharecoleccion as fecharecoleccionos, 
          c.id as idCliente, c.identificacion as identificacionCliente, c.razonsocial, c.nit, 
          pc.nombres as nombresCliente, pc.apellidos as apellidosCliente, pc.email as emailCliente, pc.direccion as direccionCliente, pc.celular as celularCliente, pc.fechanacimiento as clienteFechaNacimiento, 
          e.id as idEmpleado, e.identificacion as identificacionEmpleado,  
          pe.nombres as nombresEmpleado, pe.apellidos as apellidosEmpleado, pe.email as emailEmpleado, pe.direccion as direccionEmpleado, pe.celular as celularEmpleado, pe.fechanacimiento as empleadoFechaNacimiento, 
          r.id as idRol, r.nombre as nombreRol, r.estado as estadoRol
          from servicio as s, cliente as c, persona as pc, empleado as e, persona as pe, rol as r 
          where $filter c.id=s.idcliente 
          and pc.identificacion=c.identificacion 
          and e.id=s.idvendedor 
          and pe.identificacion=e.identificacion
          and r.id=e.idcargo
          order by s.fecharecoleccion desc limit 50";
//Validamos si se encontro algun en la busqueda o si no se hizo una petición de busqueda, de ser así ejecutamos la consulta correspondiente, en caso contrario dejamos a $JSON['data] como json vacio
if ($finded || !$httpData['status']) $JSON['data'] = json_decode(Servicio::getDataJSON(false, $sql, null, null, null, null));
if (count($JSON['data']) > 0) $JSON['status'] = true;
echo json_encode($JSON, JSON_UNESCAPED_UNICODE);
die();