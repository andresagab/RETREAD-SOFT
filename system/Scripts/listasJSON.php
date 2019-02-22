<?php
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
switch ($_GET['metodo']) {
	case 'cargosEmpleadoJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
		echo Cargo_Empleado::getObjetosJSON(null, null);
		break;
	case 'menusJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Opcion.php';
		echo Opcion::getMenusOpcionesJSON("ruta is null", null);
		break;
	case 'opcionesMenuJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Opcion.php';
		echo Opcion::getObjetosJSON("idMenu is not null and ruta is not null", null);
		break;
	case 'opcionesJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Opcion.php';
		echo Opcion::getObjetosJSON("ruta is not null and idmenu is null", null);
		break;
	case 'rolesJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Rol.php';
		echo Rol::getObjetosJSON(null, null);
		break;
	case 'usuariosJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Rol.php';
		require_once dirname(__FILE__) . '/../Clases/Usuario.php';
		echo Usuario::getObjetosJSON(null, null);
		break;
	case 'empleadosJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Persona.php';
		require_once dirname(__FILE__) . '/../Clases/Rol.php';
		require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
		require_once dirname(__FILE__) . '/../Clases/Empleado.php';
		echo Empleado::getObjetosJSON(null, null);
		break;
	case 'clientesJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Persona.php';
		require_once dirname(__FILE__) . '/../Clases/Cliente.php';
		echo Cliente::getObjetosJSON(null, 'order by fecharegistro desc');
		break;
	case 'usuariosPersonaJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Persona.php';
		require_once dirname(__FILE__) . '/../Clases/Rol.php';
		require_once dirname(__FILE__) . '/../Clases/Usuario.php';
		require_once dirname(__FILE__) . '/../Clases/Usuario_Persona.php';
                //print_r($_GET);
		echo Usuario_Persona::getObjetosJSON("identificacion='{$_GET['identificacion']}'", "order by fechaRegistro asc");
		break;
	case 'tiposLlantaJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
		echo Tipo_Llanta::getObjetosJSON(null, null);
		break;
	case 'marcasLlantaJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
		echo Marca_Llanta::getObjetosJSON(null, null);
		break;
		break;
	case 'llantasJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Persona.php';
		require_once dirname(__FILE__) . '/../Clases/Cliente.php';
		require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
		require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
		require_once dirname(__FILE__) . '/../Clases/Llanta.php';
		echo Llanta::getObjetosJSON(null, "order by rp asc");
		break;
            
	
	default:
		echo "[{null: null}]";
		break;
}
?>