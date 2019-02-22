<?php
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
switch ($_GET['metodo']) {
	case 'empleadoJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Rol.php';
		require_once dirname(__FILE__) . '/../Clases/Usuario.php';
		require_once dirname(__FILE__) . '/../Clases/Persona.php';
		require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
		require_once dirname(__FILE__) . '/../Clases/Empleado.php';
		require_once dirname(__FILE__) . '/../Clases/Telefono_Persona.php';
		echo Empleado::getObjetoJSON(null, null, null, null);
		break;
	case 'cargoEmpleadoJSON':
		require_once dirname(__FILE__) . '/../Tools/Conector.php';
		require_once dirname(__FILE__) . '/../Clases/Cargo_Empleado.php';
		//print_r($_GET);
		if ($_GET['accion']!='adicionar') echo Cargo_Empleado::getObjetoJSON('id', $_GET['id'], null, null);
		else echo Cargo_Empleado::getObjetoJSON(null, null, null, null);
		break;
}
?>