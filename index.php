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
date_default_timezone_set("America/Bogota");
session_start();
if (isset($_SESSION['usuario'])){
    require_once dirname(__FILE__) . "/system/Tools/Conector.php";
    require_once dirname(__FILE__) . "/system/Clases/Usuario.php";
    require_once dirname(__FILE__) . "/system/Clases/Bitacora.php";
    $user=unserialize($_SESSION['usuario']);
    Bitacora::preparedAndExecuteAdd($user->getUsuario(), 'S', null);
}
session_unset();
session_destroy();
define("RUTA_BASE", dirname(realpath(__FILE__))."/");
include './lib/php/core.php';
if (isset($_GET['mjs'])) $mensaje="<div id='alertaMensaje' class='alert alert-danger col-md-12 text text-center'>{$_GET['mjs']}</div>";
else $mensaje='';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inicio de sesion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="design/pics/iconos/IconoPanam.ico">
        <link rel="stylesheet" href="lib/frameworks/AngularJS/bower-material-master/angular-material.min.css">
        <link rel="stylesheet" href="lib/frameworks/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <script src="lib/frameworks/JQuery/jquery-3.2.1.min.js"></script>
        <script src="lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="lib/frameworks/AngularJS/angular-1.6.7/angular.min.js"></script>
        <script src="lib/frameworks/AngularJS/angular-1.6.7/angular-animate.min.js"></script>
        <script src="lib/frameworks/AngularJS/angular-1.6.7/angular-aria.min.js"></script>
        <script src="lib/frameworks/AngularJS/angular-1.6.7/angular-messages.min.js"></script>
        <script src="lib/frameworks/AngularJS/bower-material-master/angular-material.min.js"></script>
        <script src="lib/aplicaciones/LogIn.js"></script>
        <script src="lib/controladores/Material.js"></script>
    </head>
    <body ng-app="navegacion">
        <div id="inputContainer" ng-controller="angular_material" ng-cloak>
            <md-content>
                <div style="padding-top: 180px; padding-bottom: 39%">
                    <div class="col-sm-12 col-md-3 col-lg-3"></div>
                    <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                        <h2 class="text text-primary">PANAM</h2>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3"></div>
                    <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px" layout="row">
                        <div flex="20"></div>
                        <div flex="60">
                            <?= $mensaje ?>
                        </div>
                        <div flex="20"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 20px">
                        <form name="formulario" method="POST" action="system/Tools/validar.php">
                            <div class="col-sm-12 col-md-4 col-lg-4"></div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <md-input-container class="md-block md-accent">
                                    <label>Usuario</label>
                                    <input required name="usuario" ng-model="project.usuario" autofocus autocomplete="off">
                                    <div ng-messages="formulario.usuario.$error">
                                        <div ng-message="required">Este campo es requerido.</div>
                                    </div>
                                </md-input-container>
                                <md-input-container class="md-block md-accent">
                                    <label>Contrase&ntilde;a</label>
                                    <input required id="txtUsuario" name="clave" type="password" ng-model="project.clave" autocomplete="off">
                                    <div ng-messages="formulario.clave.$error">
                                        <div ng-message="required">Este campo es requerido.</div>
                                    </div>
                                </md-input-container>
                                <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
                                    <md-button class="md-raised md-primary" type="submit">Ingresar</md-button>
                                </section> 
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4"></div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 140px">
                        <p class="text-muted">Copyrigth &copy; <?= date("Y") ?> Todos los derechos reservados</p>
                        <p class="text-muted">Desarrollado por: Andres Angulo - Info: andrescabj981@gmail.com</p>
                    </div>
                </div>
            </md-content>
        </div>
        <script>
            $(document).ready(function() {
                $("#inputContainer").click();
            });
        </script>
    </body>
</html>
