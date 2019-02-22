<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
$objeto=new Servicio('id', $_GET['idServicio'], null, null);
$inspeccionInicial=new Inspeccion_Inicial('idServicio', $objeto->getId(), null, null);
//$inspeccionInicial->setId(1);
//Validaciones de Inspeccion inicial
//Validamos que se tenga la inspeccion inicial registrada, de cumplirse la condicion el mensaje de alerta (Este servicio no ha iniciado ningun proceso) se ocultara, en caso contrario se mostrara
if ($inspeccionInicial->getId()==null) {
    $disabledBtnReloj='disabled';
    $hideAlertaNingunProceso='';
    $hideLineaInspeccionInicial='hidden';
    $hideLineaRaspado='hide';
    $hideLineaPreparacion='hide';
    $hideBarraPorcentaje0='';
    $colorBarraProgreso='';
    $porcentajeProgreso=0;
    $panelInspeccionInicial='';
    $hideBtnRegistrarInspeccionInicial='';
    $hideDatosInspeccionInicial='hide';
    $disabledbtnRegistrarInspeccionInicial='';
    $hideDivBtnFotoInspeccionInicial='hide';
    $disabledBtnFotoInspeccionInicial='disabled';
    $hideDivBtnFinalizarInspeccionInicial='hide';
    $disabledbtnFinalizarInspeccionInicial='disabled';
    //Raspado
    $raspado=new Raspado(null, null, null, null);
    $panelRaspado='hidden';
    $hideBtnRegistrarRaspado='hide';
    $disabledbtnRegistrarRaspado='disabled';
    $hideDatosRaspado='hide';
    $hideDivBtnFinalizarRaspado='hide';
    $disabledbtnFinalizarRaspado='disabled';
    $hideDivBtnFotoRaspado='hide';
    $disabledBtnFotoRaspado='disabled';
    //Preparacion
    $preparacion=new Preparacion(null, null, null, null);
    $panelPreparacion='hide';
    $hideBtnRegistrarPreparacion='hide';
    $disabledbtnRegistrarPreparacion='disabled';
    $hideDatosPreparacion='hide';
    $hideDivBtnFinalizarPreparacion='hide';
    $disabledbtnFinalizarPreparacion='disabled';
    $hideDivBtnFotoPreparacion='hide';
    $disabledBtnFotoPreparacion='disabled';
    //Reparacion
    $reparacion=new Reparacion(null, null, null, null);
    $hideLineaReparacion='hide';
    $panelReparacion='hide';
    $hideBtnRegistrarReparacion='hide';
    $disabledBtnRegistrarReparacion='disabled';
    $hideDatosReparacion='hide';
    $hideDivBtnFinalizarReparacion='hide';
    $disabledbtnFinalizarReparacion='disabled';
    $hideDivBtnFotoReparacion='hide';
    $disabledBtnFotoReparacion='disabled';
    //Cementado
    $cementado=new Cementado(null, null, null, null);
    $hideLineaCementado='hide';
    $panelCementado='hide';
    $hideBtnRegistrarCementado='hide';
    $disabledBtnRegistrarCementado='disabled';
    $hideDatosCementado='hide';
    $hideDivBtnFinalizarCementado='hide';
    $disabledbtnFinalizarCementado='disabled';
    $hideDivBtnFotoCementado='hide';
    $disabledBtnFotoCementado='disabled';
    //Relleno
    $relleno=new Relleno(null, null, null, null);
    $hideLineaRelleno='hide';
    $panelRelleno='hide';
    $hideBtnRegistrarRelleno='hide';
    $disabledBtnRegistrarRelleno='disabled';
    $hideDatosRelleno='hide';
    $hideDivBtnFinalizarRelleno='hide';
    $disabledbtnFinalizarRelleno='disabled';
    $hideDivBtnFotoRelleno='hide';
    $disabledBtnFotoRelleno='disabled';
    //Corte_Banda
    $corte_banda=new Corte_Banda(null, null, null, null);
    $hideLineaCorte_Banda='hide';
    $panelCorte_Banda='hide';
    $hideBtnRegistrarCorte_Banda='hide';
    $disabledBtnRegistrarCorte_Banda='disabled';
    $hideDatosCorte_Banda='hide';
    $hideDivBtnFinalizarCorte_Banda='hide';
    $disabledbtnFinalizarCorte_Banda='disabled';
    $hideDivBtnFotoCorte_Banda='hide';
    $disabledBtnFotoCorte_Banda='disabled';
    //
    $alertaSiguienteProceso='';
} else {
    $disabledBtnReloj='';
    $hideAlertaNingunProceso='hidden';
    $hideLineaInspeccionInicial='';
    $hideLineaRaspado='hide';
    $hideLineaPreparacion='hide';
    $hideBarraPorcentaje0='hidden';
    $colorBarraProgreso='danger';
    $porcentajeProgreso=10;
    $panelInspeccionInicial='';
    $hideDatosInspeccionInicial='';
    $hideBtnRegistrarInspeccionInicial='hide';
    $disabledbtnRegistrarInspeccionInicial='disabled';
    $hideDivBtnFinalizarInspeccionInicial='';
    $disabledbtnFinalizarInspeccionInicial='';
    //Raspado
    $raspado=new Raspado(null, null, null, null);
    $hideBtnRegistrarRaspado='hide';
    $disabledbtnRegistrarRaspado='disabled';
    $hideDatosRaspado='hide';
    $hideDivBtnFinalizarRaspado='hide';
    $disabledbtnFinalizarRaspado='disabled';
    $hideDivBtnFotoRaspado='hide';
    $disabledBtnFotoRaspado='disabled';
    //Preparacion
    $preparacion=new Preparacion(null, null, null, null);
    $panelPreparacion='hide';
    $hideBtnRegistrarPreparacion='hide';
    $disabledbtnRegistrarPreparacion='disabled';
    $hideDatosPreparacion='hide';
    $hideDivBtnFinalizarPreparacion='hide';
    $disabledbtnFinalizarPreparacion='disabled';
    $hideDivBtnFotoPreparacion='hide';
    $disabledBtnFotoPreparacion='disabled';
    //Reparacion
    $reparacion=new Reparacion(null, null, null, null);
    $hideLineaReparacion='hide';
    $panelReparacion='hide';
    $hideBtnRegistrarReparacion='hide';
    $disabledBtnRegistrarReparacion='disabled';
    $hideDatosReparacion='hide';
    $hideDivBtnFinalizarReparacion='hide';
    $disabledbtnFinalizarReparacion='disabled';
    $hideDivBtnFotoReparacion='hide';
    $disabledBtnFotoReparacion='disabled';
    //Fin Reparacion
    //Cementado
    $cementado=new Cementado(null, null, null, null);
    $hideLineaCementado='hide';
    $panelCementado='hide';
    $hideBtnRegistrarCementado='hide';
    $disabledBtnRegistrarCementado='disabled';
    $hideDatosCementado='hide';
    $hideDivBtnFinalizarCementado='hide';
    $disabledbtnFinalizarCementado='disabled';
    $hideDivBtnFotoCementado='hide';
    $disabledBtnFotoCementado='disabled';
    //Relleno
    $relleno=new Relleno(null, null, null, null);
    $hideLineaRelleno='hide';
    $panelRelleno='hide';
    $hideBtnRegistrarRelleno='hide';
    $disabledBtnRegistrarRelleno='disabled';
    $hideDatosRelleno='hide';
    $hideDivBtnFinalizarRelleno='hide';
    $disabledbtnFinalizarRelleno='disabled';
    $hideDivBtnFotoRelleno='hide';
    $disabledBtnFotoRelleno='disabled';
    //Corte_Banda
    $corte_banda=new Corte_Banda(null, null, null, null);
    $hideLineaCorte_Banda='hide';
    $panelCorte_Banda='hide';
    $hideBtnRegistrarCorte_Banda='hide';
    $disabledBtnRegistrarCorte_Banda='disabled';
    $hideDatosCorte_Banda='hide';
    $hideDivBtnFinalizarCorte_Banda='hide';
    $disabledbtnFinalizarCorte_Banda='disabled';
    $hideDivBtnFotoCorte_Banda='hide';
    $disabledBtnFotoCorte_Banda='disabled';
    //--------------------------------------------------------------------------
    if ($inspeccionInicial->getChecked() && $inspeccionInicial->getEstado()=='prf') {
        $raspado=new Raspado('idInspeccion', $inspeccionInicial->getId(), null, null);
        $hideDivBtnFinalizarInspeccionInicial='hide';
        $disabledbtnFinalizarInspeccionInicial='disabled';
        $hideDivBtnFotoInspeccionInicial='';
        $disabledBtnFotoInspeccionInicial='';
        $panelRaspado='';
    } else {
        $panelRaspado='hidden';
        $raspado=new Raspado(null, null, null, null);
    }
}
//Fin validaciones de inspeccion inicial
//------------------------------------------------------------------------------
//Validaciones de raspado
if ($raspado->getId()==null){
    //Revisar porque la validacion es diferente (si el proceso de inspeccion inicial ya teremino se desactiva hide);
    $hideBtnRegistrarRaspado='';
    $disabledbtnRegistrarRaspado='';
    $hideDatosRaspado='hide';
} else {
    $hideLineaRaspado='';
    $hideBtnRegistrarRaspado='hide';
    $disabledbtnRegistrarRaspado='disabled';
    $hideDatosRaspado='';
    $colorBarraProgreso='danger';
    $porcentajeProgreso=20;
    $hideDivBtnFinalizarRaspado='';
    $disabledbtnFinalizarRaspado='';
    if ($raspado->getChecked() && $raspado->getEstado()=='prf'){
        $hideDivBtnFinalizarRaspado='hide';
        $disabledbtnFinalizarRaspado='disabled';
        $hideDivBtnFotoRaspado='';
        $disabledBtnFotoRaspado='';
        //Preparacion
        $preparacion=new Preparacion('idRaspado', $raspado->getId(), null, null);
        $panelPreparacion='';
    } else {
        $preparacion=new Preparacion(null, null, null, null);
        $panelPreparacion='hide';
    }
}
//fin validaciones de raspado
//------------------------------------------------------------------------------
//Validaciones preparacion
if ($preparacion->getId()==null){
    $hideBtnRegistrarPreparacion='';
    $disabledbtnRegistrarPreparacion='';
} else {
    $hideLineaPreparacion='';
    $hideBtnRegistrarPreparacion='hide';
    $disabledbtnRegistrarPreparacion='disabled';
    $hideDatosPreparacion='';
    $colorBarraProgreso='danger';
    $porcentajeProgreso=30;
    $hideDivBtnFinalizarPreparacion='';
    $disabledbtnFinalizarPreparacion='';
    if ($preparacion->getChecked() && $preparacion->getEstado()=='prf'){
        $hideDivBtnFinalizarPreparacion='hide';
        $disabledbtnFinalizarPreparacion='disabled';
        $hideDivBtnFotoPreparacion='';
        $disabledBtnFotoPreparacion='';
        //Reparacion
        $reparacion=new Reparacion('idPreparacion', $preparacion->getId(), null, null);
        $panelReparacion='';
    } else {
        $reparacion=new Reparacion(null, null, null, null);
        $panelReparacion='hide';
    }
}
//Fin validaciones preparacion
//------------------------------------------------------------------------------
//Validaciones Reparacion
if ($reparacion->getId()==null){
    $hideBtnRegistrarReparacion='';
    $disabledBtnRegistrarReparacion='';
} else {
    $hideLineaReparacion='';
    $hideBtnRegistrarReparacion='hide';
    $disabledBtnRegistrarReparacion='disabled';
    $hideDatosReparacion='';
    $colorBarraProgreso='warning';
    $porcentajeProgreso=40;
    $hideDivBtnFinalizarReparacion='';
    $disabledbtnFinalizarReparacion='';
    if ($reparacion->getChecked() && $reparacion->getEstado()=='prf'){//Validacion para cuando la reparacion haya finalizado
        $hideDivBtnFinalizarReparacion='hide';
        $disabledbtnFinalizarReparacion='disabled';
        $hideDivBtnFotoReparacion='';
        $disabledBtnFotoReparacion='';
        //Cementado declaracion
        $cementado=new Cementado('idReparacion', $reparacion->getId(), null, null);
        $panelCementado='';
    } else {
        $cementado=new Cementado(null, null, null, null);
        $panelCementado='hide';
    }
}
//Fin validaciones Reparacion
//------------------------------------------------------------------------------
//Validaciones Cementado
if ($cementado->getId()==null){
    $hideBtnRegistrarCementado='';
    $disabledBtnRegistrarCementado='';
} else {
    $hideLineaCementado='';
    $hideBtnRegistrarCementado='hide';
    $disabledBtnRegistrarCementado='disabled';
    $hideDatosCementado='';
    $colorBarraProgreso='warning';
    $porcentajeProgreso=50;
    $hideDivBtnFinalizarCementado='';
    $disabledbtnFinalizarCementado='';
    if ($cementado->getChecked() && $cementado->getEstado()=='prf'){
        $hideDivBtnFinalizarCementado='hide';
        $disabledbtnFinalizarCementado='disabled';
        $hideDivBtnFotoCementado='';
        $disabledBtnFotoCementado='';
        //Declaracion de Relleno
        $relleno=new Relleno('idCementado', $cementado->getId(), null, null);
        $panelRelleno='';
    } else {
        $relleno=new Relleno(null, null, null, null);
        $panelRelleno='hide';
    }
}
//Fin Validaciones Cementado
//------------------------------------------------------------------------------
//Validaciones Relleno
if ($relleno->getId()==null){
    $hideBtnRegistrarRelleno='';
    $disabledBtnRegistrarRelleno='';
} else {
    $hideLineaRelleno='';
    $hideBtnRegistrarRelleno='hide';
    $disabledBtnRegistrarRelleno='disabled';
    $hideDatosRelleno='';
    $colorBarraProgreso='warning';
    $porcentajeProgreso=60;
    $hideDivBtnFinalizarRelleno='';
    $disabledbtnFinalizarRelleno='';
    if ($relleno->getChecked() && $relleno->getEstado()=='prf'){
        $hideDivBtnFinalizarRelleno='hide';
        $disabledbtnFinalizarRelleno='disabled';
        $hideDivBtnFotoRelleno='';
        $disabledBtnFotoRelleno='';
        //Declaracion del Corte de banda
        $corte_banda=new Corte_Banda('idRelleno', $relleno->getId(), null, null);
        $panelCorte_Banda='';
    } else {
        $corte_banda=new Corte_Banda(null, null, null, null);
        $panelCorte_Banda='hide';
    }
}
//Fin Validaciones Relleno
//------------------------------------------------------------------------------
//Validaciones Corte_Banda
if ($corte_banda->getId()==null){
    $hideBtnRegistrarCorte_Banda='';
    $disabledBtnRegistrarCorte_Banda='';
} else {
    $hideLineaCorte_Banda='';
    $hideBtnRegistrarCorte_Banda='hide';
    $disabledBtnRegistrarCorte_Banda='disabled';
    $hideDatosCorte_Banda='';
    $colorBarraProgreso='info';
    $porcentajeProgreso=70;
    $hideDivBtnFinalizarCorte_Banda='';
    $disabledbtnFinalizarCorte_Banda='';
    //if ($corte_banda->getChecked() && $corte_banda->getEstado()=='prf'){
        $hideDivBtnFinalizarCorte_Banda='hide';
        $disabledbtnFinalizarCorte_Banda='disabled';
        $hideDivBtnFotoCorte_Banda='';
        $disabledBtnFotoCorte_Banda='';
        //Declaracion del Embandado
        //$embandado=new Embandado('idCorte_Banda', $corte_banda->getId(), null, null);
        //$panelEmbandado='';
    //} else {
        //$corte_banda=new Corte_Banda(null, null, null, null);
        //$panelCorte_Banda='hide';
    //}
}
//Fin Validaciones Corte_Banda
//------------------------------------------------------------------------------
?>
<!--<script src="lib/controladores/serviciosLlanta.js"></script>-->
<script src="lib/controladores/procesoServicio.js"></script>
<div class="col-lg-12" ng-controller="proceso">
    <div class="col-md-12 text-center page-header" id="marginTop-20">
        <div class="col-lg-4">
            <button class="btn btn-danger" id="btnRegresar" type="button">Regresar</button>
        </div>
        <div class="col-lg-4">
            <h3 class="text text-primary text-uppercase">Proceso de rencauche </h3><small class="text-capitalize"><i>(OS: <?=$objeto->getOs()?>)</i></small>
        </div>
        <div class="col-lg-4">
            <button class="btn btn-success" id="btnDetallesServicio" type="button">Detalles del servicio</button>
        </div>
    </div>
    <div class="col-md-12" id="paddinTop20"></div>
    <div class="col-md-12 page-header table-responsive" id="marginTop-20paddingBottom20">
        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="col-md-2 col-sm-4"><div class="text-justify">Linea de progreso: </div></div>
                <div class="col-md-10 text-center">
                    <div class="col-lg-12 col-sm-4 <?=$hideAlertaNingunProceso?>">
                        <div class="alert alert-warning small <?=$hideAlertaNingunProceso?>" id="marginBottom-10">!Este servicio no a iniciado ningun proceso¡</div>
                    </div>
                    <div class="col-lg-2">
                        <label class="label label-success <?=$hideLineaInspeccionInicial?>">Inspeccion Inicial</label>
                    </div>
                    <div class="col-lg-1">
                        <label class="label label-success <?=$hideLineaRaspado?>">Raspado</label>
                    </div>
                    <div class="col-lg-1">
                        <label class="label label-success <?=$hideLineaPreparacion?>">Preparacion</label>
                    </div>
                    <div class="col-lg-1">
                        <label class="label label-success <?=$hideLineaReparacion?>">Reparacion</label>
                    </div>
                    <div class="col-lg-1">
                        <label class="label label-success <?=$hideLineaCementado?>">Cementado</label>
                    </div>
                    <div class="col-lg-1">
                        <label class="label label-success <?=$hideLineaRelleno?>">Relleno</label>
                    </div>
                    <div class="col-lg-1">
                        <label class="label label-success <?=$hideLineaCorte_Banda?>">Corte de banda</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 page-header" id="marginTop-5">
        <div class="progress" id="marginBottom6">
            <div class="progress-bar progress-bar-<?=$colorBarraProgreso?> progress-bar-striped active" role="progressbar" style="width: <?=$porcentajeProgreso?>%;min-width: 0%">
                <?=$porcentajeProgreso?>% completado
            </div>
            <div class="<?=$hideBarraPorcentaje0?>">
                <div class="progress-bar progress-bar progress-bar-striped active" role="progressbar" style="width: 100%;min-width: 0%">
                    0% completado
                </div>
            </div>
        </div>
    </div>
    <!--Panel de procesos-->
    <div class="col-md-12 page-header" id="marginTop-5">
        <div class="col-lg-7 col-md-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading text-left">Procesos</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist">
                            <!---Panel para Inspeccion inicial-->
                            <div class="panel panel-info <?=$panelInspeccionInicial?>">
                                <div class="panel-heading" role="tab" id="inspeccionInicial">
                                    <h4 class="panel-title">
                                        <a id="accionInspeccionInicial" href="#inspeccionInicial1" data-toggle="collapse" data-parent="#accordion">
                                            Inspeccion Inicial
                                        </a>
                                    </h4>
                                </div>
                                <div id="inspeccionInicial1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarInspeccionInicial?>">
                                            <button class="btn btn-success" id="btnRegistrarInspeccionInicial" type="button" name="accion" <?=$disabledbtnRegistrarInspeccionInicial?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosInspeccionInicial?>">
                                            <button class="hidden" <?=$disabledBtnReloj?> id="iniciarReloj" ng-click="startTimer(<?=$inspeccionInicial->getId()?>)"></button>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$inspeccionInicial->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Numero de rencauche: <span class="text-muted"><?=$inspeccionInicial->getNumeroRencauche()?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($inspeccionInicial->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?= rtrim($inspeccionInicial->getNombreChecked())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?= rtrim($inspeccionInicial->getNombreEstado())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($inspeccionInicial->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarInspeccionInicial?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarInspeccionInicial" type="button" <?=$disabledbtnFinalizarInspeccionInicial?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoInspeccionInicial?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFinalizarInspeccionInicial" type="button" <?=$disabledBtnFotoInspeccionInicial?> data-toggle="modal" href="/#fotoInspeccionInicial">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoInspeccionInicial'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Inspeccion_Inicial/<?= $inspeccionInicial->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel Inspeccion inicial-->
                            <!------------------------------------------------->
                            <!---Panel para Raspado-->
                            <div class="panel panel-success <?=$panelRaspado?>">
                                <div class="panel-heading" role="tab" id="Raspado">
                                    <h4 class="panel-title">
                                        <a id="accionRaspado" href="#raspado1" data-toggle="collapse" data-parent="#accordion">
                                            Raspado
                                        </a>
                                    </h4>
                                </div>
                                <div id="raspado1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarRaspado?>">
                                            <button class="btn btn-success" id="btnRegistrarRaspado" type="button" name="accion" <?=$disabledbtnRegistrarRaspado?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosRaspado?>">
                                            <div class="col-lg-12 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$raspado->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Ancho banda: <span class="text-muted"><?= rtrim($raspado->getAnchoBanda())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Largo banda: <span class="text-muted"><?= rtrim($raspado->getLargoBanda())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Retiro cinturon: <span class="text-muted"><?= rtrim($raspado->getNombreCinturon())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Cantidad: <span class="text-muted"><?= rtrim($raspado->getCinturonCantidad())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Profundidad: <span class="text-muted"><?= rtrim($raspado->getProfundidad())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Radio: <span class="text-muted"><?= rtrim($raspado->getRadio())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($raspado->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?= rtrim($raspado->getNombreChecked())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?= rtrim($raspado->getNombreEstado())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($raspado->getFechaRegistro())?></span></h5>
                                            </div>
                                            <!--<div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarRaspado?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarRaspado" type="button" <?=$disabledbtnFinalizarRaspado?>>Finalizar proceso</button>
                                            </div>-->
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoRaspado?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoRaspado" type="button" <?=$disabledBtnFotoRaspado?> data-toggle="modal" href="/#fotoRaspado">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoRaspado'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Raspado/<?= $raspado->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel raspado-->
                            <!------------------------------------------------->
                            <!--Panel para Preparacion-->
                            <div class="panel panel-warning <?=$panelPreparacion?>">
                                <div class="panel-heading" role="tab" id="Preparacion">
                                    <h4 class="panel-title">
                                        <a id="accionPreparacion" href="#preparacion1" data-toggle="collapse" data-parent="#accordion">
                                            Preparacion
                                        </a>
                                    </h4>
                                </div>
                                <div id="preparacion1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarPreparacion?>">
                                            <button class="btn btn-success" id="btnRegistrarPreparacion" type="button" name="accion" <?=$disabledbtnRegistrarPreparacion?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosPreparacion?>">
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$preparacion->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($preparacion->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?= rtrim($preparacion->getNombreChecked())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?= rtrim($preparacion->getNombreEstado())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($preparacion->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarPreparacion?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarPreparacion" type="button" <?=$disabledbtnFinalizarPreparacion?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoPreparacion?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoRaspado" type="button" <?=$disabledBtnFotoPreparacion?> data-toggle="modal" href="/#fotoPreparacion">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoPreparacion'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Preparacion/<?= $preparacion->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel preparacion-->
                            <!------------------------------------------------->
                            <!--Panel para Reparacion-->
                            <div class="panel panel-danger <?=$panelReparacion?>">
                                <div class="panel-heading" role="tab" id="Reparacion">
                                    <h4 class="panel-title">
                                        <a id="accionReparacion" href="#reparacion1" data-toggle="collapse" data-parent="#accordion">
                                            Reparacion
                                        </a>
                                    </h4>
                                </div>
                                <div id="reparacion1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarReparacion?>">
                                            <button class="btn btn-success" id="btnRegistrarReparacion" type="button" name="accion" <?=$disabledBtnRegistrarReparacion?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosReparacion?>">
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$reparacion->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <!--<div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <button class="btn btn-info" id="btnVerParches" type="button" >Parches</button>
                                            </div>
                                            Pendiente... Visulizar insumos de la mesa de trabajo
                                            -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($reparacion->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?= rtrim($reparacion->getNombreChecked())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?= rtrim($reparacion->getNombreEstado())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($reparacion->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarReparacion?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarReparacion" type="button" <?=$disabledbtnFinalizarReparacion?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoReparacion?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoReparacion" type="button" <?=$disabledBtnFotoReparacion?> data-toggle="modal" href="/#fotoReparacion">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoReparacion'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Reparacion/<?= $reparacion->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel reparacion-->
                            <!------------------------------------------------->
                            <!--Panel para Cementado-->
                            <div class="panel panel-default <?=$panelCementado?>">
                                <div class="panel-heading" role="tab" id="Cementado">
                                    <h4 class="panel-title">
                                        <a id="accionCementado" href="/#cementado_1" data-toggle="collapse" data-parent="#accordion">
                                            Cementado
                                        </a>
                                    </h4>
                                </div>
                                <div id="cementado_1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarCementado?>">
                                            <button class="btn btn-success" id="btnRegistrarCementado" type="button" name="accion" <?=$disabledBtnRegistrarCementado?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosCementado?>">
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$cementado->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <!--<div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <button class="btn btn-info" id="btnVerParches" type="button" >Parches</button>
                                            </div>
                                            Pendiente... Visulizar insumos de la mesa de trabajo
                                            -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($cementado->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?= rtrim($cementado->getNombreChecked())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?= rtrim($cementado->getNombreEstado())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($cementado->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarCementado?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarCementado" type="button" <?=$disabledbtnFinalizarCementado?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoCementado?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoCementado" type="button" <?=$disabledBtnFotoCementado?> data-toggle="modal" href="/#fotoCementado">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoCementado'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Cementado/<?= $cementado->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel cementado-->
                            <!------------------------------------------------->
                            <!--Panel para Relleno-->
                            <div class="panel panel-danger <?=$panelRelleno?>">
                                <div class="panel-heading" role="tab" id="Relleno">
                                    <h4 class="panel-title">
                                        <a id="accionRelleno" href="/#relleno_p" data-toggle="collapse" data-parent="#accordion">
                                            Relleno
                                        </a>
                                    </h4>
                                </div>
                                <div id="relleno_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarRelleno?>">
                                            <button class="btn btn-success" id="btnRegistrarRelleno" type="button" name="accion" <?=$disabledBtnRegistrarRelleno?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosRelleno?>">
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$relleno->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>N° empates: <span class="text-muted"><?=$relleno->getEmpates()?></span></h5>
                                            </div>
                                            <!--<div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <button class="btn btn-info" id="btnVerParches" type="button" >Parches</button>
                                            </div>
                                            Pendiente... Visulizar insumos de la mesa de trabajo
                                            -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($relleno->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?= rtrim($relleno->getNombreChecked())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?= rtrim($relleno->getNombreEstado())?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($relleno->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarRelleno?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarRelleno" type="button" <?=$disabledbtnFinalizarRelleno?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoRelleno?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoRelleno" type="button" <?=$disabledBtnFotoRelleno?> data-toggle="modal" href="/#fotoRelleno">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoRelleno'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Relleno/<?= $relleno->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel relleno-->
                            <!------------------------------------------------->
                            <!--Panel para Corte_Banda-->
                            <div class="panel panel-warning <?=$panelCorte_Banda?>">
                                <div class="panel-heading" role="tab" id="Corte_Banda">
                                    <h4 class="panel-title">
                                        <a id="accionCorte_Banda" href="/#corte_banda_p" data-toggle="collapse" data-parent="#accordion">
                                            Corte_Banda
                                        </a>
                                    </h4>
                                </div>
                                <div id="corte_banda_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarCorte_Banda?>">
                                            <button class="btn btn-success" id="btnRegistrarCorte_Banda" type="button" name="accion" <?=$disabledBtnRegistrarCorte_Banda?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosCorte_Banda?>">
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$corte_banda->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <!--<div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <button class="btn btn-info" id="btnVerParches" type="button" >Parches</button>
                                            </div>
                                            Pendiente... Visulizar insumos de la mesa de trabajo
                                            -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($corte_banda->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($corte_banda->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFinalizarCorte_Banda?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarCorte_Banda" type="button" <?=$disabledbtnFinalizarCorte_Banda?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoCorte_Banda?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoCorte_Banda" type="button" <?=$disabledBtnFotoCorte_Banda?> data-toggle="modal" href="/#fotoCorte_Banda">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoCorte_Banda'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Corte_Banda/<?= $corte_banda->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel corte_banda-->
                        </div>
                    </div>
                    <div class="col-md-12 <?=$alertaSiguienteProceso?>">
                        <div class="alert alert-success small">
                            <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            El siguiente proceso aparecera cuando el proceso actual finalize y sea aprobado
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin panel de procesos-->
        <!---->
        <!--Panel de datos o estadisticas-->
        <div class="col-lg-5 col-md-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading text-left">Datos:</div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h4 class="text text-nowrap">Fecha/Hora entrega: <span class="text-muted"><?=$objeto->getFechaEntrega()?></span></h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h5>Fecha/Hora inicio: <span class="text-muted"><?=$inspeccionInicial->getFechaRegistro()?></span></h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <!--<h5>Tiempo transcurrido: <span class="text-muted"><?= Servicio::getTiempoTranscurrido($inspeccionInicial->getFechaRegistro())?></span></h5>-->
                            <h5>Tiempo transcurrido: <span class="text-muted" >{{ tiempo }}</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Funcionalidades con JS-->
<script>
    
    $(document).ready(function (){
        setInterval(function (){
            $("#iniciarReloj").click();
        }, 1000); 
        $("#accionInspeccionInicial").click();
        $("#accionRaspado").click();
        $("#accionPreparacion").click();
        $("#accionReparacion").click();
        $("#accionCementado").click();
        $("#accionRelleno").click();
    });
    
    //Click en headers de los paneles
    //
    //Fin click en headers de los paneles
    
    //Funciones de click para acciones de acordion de cada panel
    //
    //Fin funciones de click para acciones de acordion de cada panel
    //--------------------------------------------------------------------------
    $("#btnRegresar").click(function (){
        //document.location="principal.php?CON=system/Pages/serviciosLlanta.php&idLlanta=<?=$objeto->getIdLlanta()?>";
        document.location="principal.php?CON=system/Pages/llantas.php";
    });
    //Inspeccion inicial
    $("#btnRegistrarInspeccionInicial").click(function (){
        document.location="principal.php?CON=system/Pages/inspeccionInicialFormulario.php&idServicio=<?=$objeto->getId()?>";
    });
    $("#btnFinalizarInspeccionInicial").click(function (){
        document.location="principal.php?CON=system/Pages/inspeccionInicialFormularioFinalizar.php&id=<?=$inspeccionInicial->getId()?>";
    });
    //Fin inspeccion inicial
    //--------------------------------------------------------------------------
    //Raspado
    $("#btnRegistrarRaspado").click(function (){
        document.location="principal.php?CON=system/Pages/raspadoFormulario.php&idInspeccion=<?=$inspeccionInicial->getId()?>";
    });
    $("#btnFinalizarRaspado").click(function (){
        document.location="principal.php?CON=system/Pages/raspadoFormularioFinalizar.php&id=<?=$raspado->getId()?>";
    });
    //Fin raspado
    //--------------------------------------------------------------------------
    //Preparacion
    $("#btnRegistrarPreparacion").click(function (){
        document.location="principal.php?CON=system/Pages/preparacionFormulario.php&idRaspado=<?=$raspado->getId()?>";
    });
    $("#btnFinalizarPreparacion").click(function (){
        document.location="principal.php?CON=system/Pages/preparacionFormularioFinalizar.php&id=<?=$preparacion->getId()?>";
    });
    //Fin preparacion
    //--------------------------------------------------------------------------
    //Reparacion
    $("#btnRegistrarReparacion").click(function (){
        document.location="principal.php?CON=system/Pages/reparacionFormulario.php&idPreparacion=<?=$preparacion->getId()?>";
    });
    $("#btnFinalizarReparacion").click(function (){
        document.location="principal.php?CON=system/Pages/reparacionFormularioFinalizar.php&id=<?=$reparacion->getId()?>";
    });
    //Fin reparacion
    //--------------------------------------------------------------------------
    //Cementado
    $("#btnRegistrarCementado").click(function (){
        document.location="principal.php?CON=system/Pages/cementadoFormulario.php&idReparacion=<?=$reparacion->getId()?>";
    });
    $("#btnFinalizarCementado").click(function (){
        document.location="principal.php?CON=system/Pages/cementadoFormularioFinalizar.php&id=<?=$cementado->getId()?>";
    });
    //Fin cementado
    //--------------------------------------------------------------------------
    //Relleno
    $("#btnRegistrarRelleno").click(function (){
        document.location="principal.php?CON=system/Pages/rellenoFormulario.php&idCementado=<?=$cementado->getId()?>";
    });
    $("#btnFinalizarRelleno").click(function (){
        document.location="principal.php?CON=system/Pages/rellenoFormularioFinalizar.php&id=<?=$relleno->getId()?>";
    });
    //Fin relleno
    //--------------------------------------------------------------------------
    //Corte_Banda
    $("#btnRegistrarCorte_Banda").click(function (){
        document.location="principal.php?CON=system/Pages/corteBandaFormulario.php&idRelleno=<?=$relleno->getId()?>";
    });
    $("#btnFinalizarCorte_Banda").click(function (){
        document.location="principal.php?CON=system/Pages/corteBandaFormularioFinalizar.php&id=<?=$corte_banda->getId()?>";
    });
    //Fin corte_banda
    //--------------------------------------------------------------------------
</script>
<script>
    
</script>