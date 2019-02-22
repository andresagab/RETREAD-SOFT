<?php
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Tools/Conector.php';
require_once dirname(__FILE__) . '/../Clases/Rol.php';
require_once dirname(__FILE__) . '/../Clases/Usuario.php';
require_once dirname(__FILE__) . '/../Clases/Contacto_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Telefono_Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Producto.php';
require_once dirname(__FILE__) . '/../Clases/Puc.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Llanta.php';
global $P, $BD;
if(isset($_GET['P'])) $P=$_GET['P'];
else $P='';
if(isset($_GET['BD'])) $BD=$_GET['BD'];
else $BD='';
foreach ($_GET as $key => $value) ${$key}=$value;
foreach ($_POST as $key => $value) ${$key}=$value;
switch ($metodo) {
    case 'getIdentificacionesClientes':
        $term=strtolower($term);
        //echo Cliente::getIdentificacionesJSON("identificacion like '%$term%' or identificacion in (select identificacion from persona where nombres like '%$term%' or apellidos like '%$term%') or razonSocial like '%$term%'", null);
        echo Cliente::getIdentificacionesJSON("lower(identificacion) like '%$term%' or identificacion in (select identificacion from persona where lower(nombres) like '%$term%' or lower(apellidos) like '%$term%') or lower(razonSocial) like '%$term%'", null);
        //echo Cliente::getIdentificacionesJSON("identificacion like '%$term%'", null);
        break;
    case 'getIdentificacionesEmpleado':
        $term=strtolower($term);
        echo Empleado::getIdentificacionesJSON("lower(identificacion) like '%$term%' or identificacion in (select identificacion from persona where lower(nombres) like '%$term%' or lower(apellidos) like '%$term%')", null);
        //echo Empleado::getIdentificacionesJSON("identificacion like '%$term%' or identificacion in (select identificacion from persona where nombres like '%$term%' or apellidos like '%$term%')", null);
        //echo Empleado::getIdentificacionesJSON("identificacion like '%$term%'", null);
        break;
    case 'getNombreProductos':
        //$datosPuc=Puc::getListaEnObjetos("nombre like '%$term%'", null);
        //$datosProductos= Producto::getListaEnObjetos("idCategoria=$idCategoria", null);
        //echo Producto::getNombresJSON("idCategoria=$idCategoria and codpuc in (select codigo from puc where producto.codpuc=puc.codigo and lower(puc.nombre) like '%" . strtolower($term) . "%')", null);
        echo Producto::getNombresJSON("stock>=stockminimo and idCategoria=$idCategoria and codpuc in (select codigo from puc where producto.codpuc=puc.codigo and lower(puc.nombre) like '%" . strtolower($term) . "%')", null);
        break;
    case 'getDimensiones':
        echo Dimension_Llanta::getDimensionesAutocompleteJSON("dimension like '%{$_GET['term']}%'", null);
        break;
}
?>