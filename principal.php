<!DOCTYPE html>
<!--
* 
* Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
* Este archivo fue desarrollado por Andres Geovanny Angulo Botina
* Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
* o llamar directamente al (+57) 3128293384
*
-->
<?php
set_time_limit(0);
ob_start();
session_start();
//print_r($_SESSION);
require_once dirname(__FILE__)."/system/Tools/Conector.php";
require_once dirname(__FILE__)."/system/Clases/Rol.php";
require_once dirname(__FILE__)."/system/Clases/Opcion.php";
require_once dirname(__FILE__)."/system/Clases/Rol_Accesos.php";
require_once dirname(__FILE__)."/system/Clases/Usuario.php";
if (!isset($_SESSION['usuario'])) header('Location: index.php?mjs=Se ha tratado de ingresar incorrectamente, intenta iniciar sesion nuevamente');
date_default_timezone_set('America/Bogota');
$USUARIO= unserialize($_SESSION['usuario']);
$ROL=$USUARIO->getRol();
//$ROL->setId(2);
//$ROL->setNombre('gerente');
if (!isset($_GET['CON'])) $_GET['CON']='system/Pages/comodin.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PANAM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="design/pics/iconos/IconoPanam.ico">
        <link rel="stylesheet" href="lib/frameworks/mdl/material.min.css"/>
        <link rel="stylesheet" href="lib/frameworks/bootstrap-3.3.7-dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="lib/frameworks/font-awesome-4.7.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.css"/>
        <link rel="stylesheet" href="lib/frameworks/AngularJS/iconfont/material-icons.css"/>
        <link type="text/css" rel="stylesheet" href="design/estilos/estilos.css"/>
        <script src="lib/frameworks/AngularJS/1.5.0/angular.min.js"></script>
        <script src="lib/frameworks/JQuery/jquery-3.2.1.min.js"></script>
        <script src="lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="lib/frameworks/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script src="lib/frameworks/mdl/material.min.js"></script>
        <script src="lib/frameworks/AngularJS/1.5.0/angular-route.min.js"></script>
        <script src="lib/frameworks/AngularJS/1.5.0/ngStorage.min.js"></script>
        <script src="lib/frameworks/PushJs/push.min.js"></script>
        <script src="lib/frameworks/AmChart/amcharts.js"></script>
        <script src="lib/frameworks/AmChart/serial.js"></script>
        <script src="lib/frameworks/AmChart/dark.js"></script>
        <script src="lib/scripts/ObjectsHTML.js"></script>
        <script src="lib/scripts/Option.js"></script>
        <script src="lib/scripts/Tooltips.js"></script>
        <script src="lib/aplicaciones/panamApp.js"></script>
        <script src="lib/controladores/usuarios.js"></script>
        <script src="lib/controladores/empleados.js"></script>
        <script src="lib/controladores/cargosEmpleado.js"></script>
        <script src="lib/controladores/badges.js"></script>
        <script src="lib/controladores/badgesNovedadesPT.js"></script>
        <script src="lib/controladores/Image.js"></script>
        <script src="lib/controladores/Timer.js"></script>
        <script src="lib/controladores/maskPaginator.js"></script>
        <script src="lib/scripts/Toast.js"></script>
        <script src="lib/factorys/Exel.js"></script>
    </head>
    <body ng-app="navegacion">
        <div class="container-fluid text-center" id="ContenedorLogIn" ng-controller="maskPaginator as maskPaginator">
            <div class="col-md-12" id="banner"></div>
            <div id="menu">
                <header>
                    <nav class="navbar navbar-link navbar-static-top" role="navigation">
                        <div class="container-fluid">
                            <div class="navbar-default">
                                <button type="button" class="navbar-toggle collapsed" data-toggle='collapse' data-target="#navegacion">
                                    <span class="sr-only">Desplegar/Ocultar menu</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a href="principal.php?CON=system/pages/inicio.php" id="enlaceInicio" class="navbar-brand"><span class="text-danger">PANAM.sas</span></a>
                                <div class="mdl-tooltip" for="enlaceInicio">Ir a la pagina de inicio</div>
                            </div>
                            <?= $ROL->getMenu($USUARIO->getUsuario()) ?>
                        </div>
                    </nav>
                </header>
            </div>
            <div class="container col-sm-12 col-md-12 col-lg-12"><?php include $_GET['CON'];?></div>
            <div class="col-lg-12" id="paddinTop20"></div>
            <footer>
                <div class="container row col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 140px">
                    <p class="text-muted">Copyrigth &copy; <?= date("Y") ?> Todos los derechos reservados</p>
                    <p class="text-muted">Desarrollado por: Andres Angulo - Info: andrescabj981@gmail.com</p>
                </div>
            </footer>
            <?php include './system/Pages/cambiarClave.php'; ?>
        </div>
        <div id="toast-principal" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </body>
</html>
