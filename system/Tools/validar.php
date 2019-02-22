 <?php
date_default_timezone_set('America/Bogota');
require_once dirname(__FILE__).'/./Conector.php';
require_once dirname(__FILE__).'/../Clases/Usuario.php';
require_once dirname(__FILE__).'/../Clases/Bitacora.php';
$P='';
//$BD='panam';
foreach ($_POST as $key => $value) ${$key}=$value;
if (Usuario::validar($usuario, $clave)){
    session_start();
    $usuario=new Usuario('usuario', "'$usuario'", null, null);
    $_SESSION['usuario']= serialize($usuario);
    Bitacora::preparedAndExecuteAdd($usuario->getUsuario(), 'I', null);
    header('Location: ../../principal.php?CON=system/Pages/inicio.php');
} else {
    $mensaje='Este usuario esta bloqueado o el nombre y/o contraseña son incorrectos';
    Bitacora::preparedAndExecuteAdd($usuario, 'F', null, null);
    header("Location: ../../index.php?mjs=$mensaje");
}
