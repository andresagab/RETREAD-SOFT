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
require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Referencia.php';
require_once dirname(__FILE__) . '/../Clases/Puc.php';
require_once dirname(__FILE__) . '/../Clases/Producto.php';
global $P, $BD;
if(isset($_GET['P'])) $P=$_GET['P'];
else $P='';
if(isset($_GET['BD'])) $BD=$_GET['BD'];
else $BD='';
foreach ($_GET as $key => $value) ${$key}=$value;
foreach ($_POST as $key => $value) ${$key}=$value;
/*
 * 
 * Significado de abreviaciones de respuesta:
 * 
 * ID: INCOMPLETE DATA -> DATOS INCOMPLETOS
 * OK: TASK SUCCESSFULL -> TAREA EJECUTADA CORRECTAMENTE
 * 
 */
switch ($metodo) {
    case 'getReferenciasTipoLlantaOptions':
        echo Referencia_Tipo_Llanta::getDatosEnOptions("idTipoLlanta=$idTipoLlanta", null, null);
        break;
    case 'getInsumosCategoria':
        if (isset($idCategoria)){
            echo Producto::getDatosEnOptions("idCategoria=$idCategoria and stock>=stockMinimo", null, null);
            //echo Producto::getDatosEnOptions("idCategoria=$idCategoria and stock>stockMinimo and stock<=stockMaximo", null, null);
            //echo Producto::getDatosEnOptions("idCategoria=$idCategoria", null, null);
        } else echo 'ID';
        break;
}
?>