<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
if (isset($_GET['id'])) {
    $objeto=new Cliente('id', $_GET['id'], null, null);
    $persona=$objeto->getPersona();
    $accion="Modificar";
    if ($objeto->getRazonSocial()!='' && $objeto->getPersona()->getApellidos()=='') {
        $chkCliente='';
        $chkEmpresa='checked';
    } else if ($objeto->getRazonSocial()!='' && $objeto->getPersona()->getApellidos()!=''){
        $chkCliente='checked';
        $chkEmpresa='checked';
    } else {
        $chkCliente='checked';
        $chkEmpresa='';
    }
} else {
    $objeto=new Cliente(null, null, null, null);
    $accion="Adicionar";
    $persona=$objeto->getPersona();
    $persona->setFechaNacimiento(date("Y-m-d"));
    $chkCliente='checked';
    $chkEmpresa='';
}
?>
<div class="col-lg-12">
	<div class="col-lg-4" ></div>
	<div class="col-lg-4" >
        <strong class="text mdl-color-text--indigo control-label text-uppercase"><h2><?=$accion?> cliente</h2></strong>
	</div>
	<div class="col-lg-4"></div>
        <div class="col-lg-12" id="paddinTop20"></div>
        <div class="col-lg-12">
            <div class="col-lg-3 col-md-1"></div>
            <div class="col-lg-6 col-md-10">
                <div class="col-lg-12">
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Cliente:</span>
                                <span class="input-group-addon"><input class="has-primary" id="chkCliente" type="checkbox" name="chkCliente" <?=$chkCliente?>></span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">Empresa:</span>
                                <span class="input-group-addon"><input class="has-primary" id="chkEmpresa" type="checkbox" name="chkEmpresa" <?=$chkEmpresa?>></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-1"></div>
        </div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/clientesActualizar.php">
                <div class="col-lg-12">
                    <alert class="col-md-12 alert alert-warning small" id="alertMarcarChks">Debes marcar uno de los campos cliente, empresa o ambos</alert>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group" id="divIdentificacion">
                        <div class="input-group">
                            <label class="input-group-addon">* Identificacion/Nit:</label>
                            <input type="number" class="form-control has-primary" id="identificacion" name="identificacion" value="<?= rtrim($objeto->getIdentificacion())?>" placeholder="Ejemplo: 1457822" maxlength="20" required/>
                        </div>
                    </div>
                    <div class="form-group" id="divNombres">
                        <div class="input-group">
                            <label class="input-group-addon">* Nombres:</label>
                            <input type="text" class="form-control has-primary" id="txtNombres" name="nombres" value="<?= rtrim($objeto->getPersona()->getNombres())?>" placeholder="Ejemplo: Juan" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group" id="divApellidos">
                        <div class="input-group">
                            <label class="input-group-addon">* Apellidos:</label>
                            <input type="text" id="txtApellidos" class="form-control has-primary" name="apellidos" value="<?= rtrim($objeto->getPersona()->getApellidos())?>" placeholder="Ejemplo: Martinez" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group" id="divEmail">
                        <div class="input-group">
                            <label class="input-group-addon">Email:</label>
                            <input type="email" class="form-control has-primary" name="email" value="<?= rtrim($objeto->getPersona()->getEmail())?>" placeholder="Ejemplo: algo@gmail.com" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group" id="divCelular">
                        <div class="input-group">
                            <label class="input-group-addon">Celular:</label>
                            <input type="number" class="form-control has-primary" name="celular" value="<?= rtrim($objeto->getPersona()->getCelular())?>" placeholder="Ejemplo: 3001232233" min="0" required=""/>
                        </div>
                    </div>
                    <div class="form-group" id="divFechaNacimiento">
                        <div class="input-group">
                            <label class="input-group-addon" id="lblFecha"></label>
                            <input type="date" id="fechaNacimiento" class="form-control has-primary" name="fechaNacimiento" value="<?= rtrim($persona->getFechaNacimiento())?>" required=""/>
                        </div>
                    </div>
                    <div class="form-group" id="divRazonSocial">
                        <div class="input-group">
                            <label class="input-group-addon">* Razon social:</label>
                            <input type="text" class="form-control has-primary" id="razonSocial" name="razonSocial" value="<?= rtrim($objeto->getRazonSocial())?>" placeholder="Ejemplo: PANAM.sas" maxlength="50" />
                        </div>
                    </div>
                    <div class="form-group" id="divDireccion">
                        <div class="input-group">
                            <label class="input-group-addon">Direccion:</label>
                            <input type="text" class="form-control has-primary" id="direccion" name="direccion" value="<?= rtrim($objeto->getPersona()->getDireccion())?>" placeholder="Ejemplo: Cll 16 Cra 23" maxlength="100" required=""/>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="identificacionAnterior" value="<?= rtrim($objeto->getPersona()->getIdentificacion())?>"></div>
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="accion" value="<?=$accion?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <button onclick="window.location='principal.php?CON=system/Pages/clientes.php'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-success" id="btnAccion" type="button" name="accion" value="<?=$accion?>">
                    </div>
                </div>
            </form>
            <div class="col-md-3"></div>
        </div>
        <div class="col-md-1"></div>
	</div>
</div>
<script>
    /*$("#fechaNacimiento").datepicker({
       inline: true
    });*/
    
    $(document).ready(function (){
        $("#alertMarcarChks").hide();
        camposCliente(document.getElementById("chkCliente").checked);
        camposEmpresa(document.getElementById("chkEmpresa").checked);
    })
    
    $("#btnAccion").click(function(){
        if (!document.getElementById("chkCliente").checked && !document.getElementById("chkEmpresa").checked){
            alertaChks(false);
        } else {
            enviarDatos(true);
        }
    });
    
    $("#chkCliente").click(function(){
        camposCliente(this.checked);
        if (!this.checked && !document.getElementById("chkEmpresa").checked) {
            alertaChks(false);
        } else {
            alertaChks(true);
            if (this.checked && document.getElementById("chkEmpresa").checked) cargarLblFecha(true);
            else cargarLblFecha(false);
        }
    });
    
    $("#chkEmpresa").click(function(){
        camposEmpresa(this.checked);
        if (!this.checked && !document.getElementById("chkCliente").checked) {
            alertaChks(false);
        } else {
            alertaChks(true);
            if (this.checked && document.getElementById("chkCliente").checked) cargarLblFecha(true);
            else cargarLblFecha(false);
        }
    });
    
    function cargarLblFecha(valido){
        if (valido) document.getElementById("lblFecha").innerHTML="Fecha Nacimiento/Fecha creacion:";
    }
    
    function camposCliente(valido){
        if (valido){
            //$("#divIdentificacion").show("slow");
            $("#divNombres").show("slow");
            $("#divApellidos").show("slow");
            document.getElementById("lblFecha").innerHTML="Fecha Nacimiento:";
        } else {
            //$("#divIdentificacion").hide("slow");
            $("#divNombres").hide("slow");
            $("#divApellidos").hide("slow");
            limpiarCamposCliente();
        }
    }
    
    function camposEmpresa(valido){
        if (valido){
            //$("#divNit").show("slow");
            $("#divRazonSocial").show("slow");
            document.getElementById("lblFecha").innerHTML="Fecha creacion de empresa:";
        } else {
            //$("#divNit").hide("slow");
            $("#divRazonSocial").hide("slow");
            limpiarCamposEmpresa();
        }
    }
    
    function alertaChks(valido){
        if (valido){
            $("#alertMarcarChks").hide("slow");
        } else {
            $("#alertMarcarChks").show("slow");
        }
    }
    
    function enviarDatos(valido){
        if (valido) document.formulario.submit();
    }
    
    function limpiarCamposCliente(){
        $("#txtNombres").val("");
        $("#txtApellidos").val("");
    }
    
    function limpiarCamposEmpresa(){
        $("#razonSocial").val("");
    }
    
</script>