<?php
if ($USUARIO->getClave()== md5("usuariopanam")) $alertaClaveGenerica='';
else $alertaClaveGenerica='hide';
if (isset($_GET['CC'])) $alertaClaveGenerica='hide';
?>
<h1 class="text text-uppercase text-warning">Bienvenido <label class="text text-uppercase text-info hide"></label></h1>
<div class="col-sm-12 col-lg-12 <?= $alertaClaveGenerica ?>">
    <div class="alert alert-danger" id="accessCambiarClave">RECUERDA CAMBIAR LA CONTRASE&Ntilde;A DE TU CUENTA <span class="text text-muted small">Haz click en este mensaje</span></div>
</div>
<div class="col-xs-12 cols-sm-12 col-md-12 col-lg-12" style="padding-top: 60px">
    <center>
        <img class="img-responsive img-fluid" src="design/pics/imagenes/PanamLogoEmpresa.png" width="350px">
    </center>
</div>
<script>
    $("#accessCambiarClave").click(function() {
        $("#btnCambiarClave").click();
    });
</script>