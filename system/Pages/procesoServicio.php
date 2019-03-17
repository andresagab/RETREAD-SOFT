<?php
include dirname(__FILE__) . "\..\..\lib\php\Time.php";
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Referencia.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Puesto_Trabajo.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
require_once dirname(__FILE__).'\..\Clases\Embandado.php';
require_once dirname(__FILE__).'\..\Clases\Vulcanizado.php';
require_once dirname(__FILE__).'\..\Clases\Posicion_Camara.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Final.php';
require_once dirname(__FILE__).'\..\Clases\Terminacion.php';
require_once dirname(__FILE__).'\..\Clases\Servicio_Fin.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Rechazo_Inspeccion_Inicial.php';
$llanta=new Llanta('id', $_GET['id'], null, null);
//print_r($llanta->getFechaInicioProceso());die();
$objeto=new Servicio('id', $llanta->getIdServicio(), null, null);
$inspeccionInicial=new Inspeccion_Inicial('idLlanta', $llanta->getId(), null, null);

if (strtolower($llanta->getFechaInicioProceso())=='sin registrar') $fechaInicioLlanta=$llanta->getFechaRegistro();
else $fechaInicioLlanta=$llanta->getFechaInicioProceso();

if (!$llanta->getFinRencaucheXProceso()){
    if ($llanta->getFinRencaucheXRechazo()){
        header("Location: principal.php?CON=system/Pages/servicioFinActualizar.php&id={$llanta->getId()}&accion=FinalizarXRechazo");
    } else $servicioFin=new Servicio_Fin(null, null, null, null);
} else $servicioFin=new Servicio_Fin('idLlanta', $llanta->getId(), null, null);
if ($llanta->getFechaInicioProceso()!=null && strtolower($llanta->getFechaInicioProceso())!="sin registrar"){
    $alertaTiempoInicial="hide";
    $btnAddTiempoInicial="disabled";
    $panelProcesos="";
} else {
    $alertaTiempoInicial="hide";
    $btnAddTiempoInicial="hide";
    $panelProcesos="";
}
//Validaciones de Inspeccion inicial
//Validamos que se tenga la inspeccion inicial registrada, de cumplirse la condicion el mensaje de alerta (Este servicio no ha iniciado ningun proceso) se ocultara, en caso contrario se mostrara
if ($inspeccionInicial->getId()==null) {
    $inspeccionInicial->setId("0");
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
    $hideDivBtnPuestoTrabajoRaspado='hide';
    $disabledBtnPuestoTrabajoRaspado='disabled';
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
    $hideDivBtnPuestoTrabajoPreparacion='hide';
    $disabledBtnPuestoTrabajoPreparacion='disabled';
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
    $hideDivBtnPuestoTrabajoReparacion='hide';
    $disabledBtnPuestoTrabajoReparacion='disabled';
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
    $hideDivBtnPuestoTrabajoCementado='hide';
    $disabledBtnPuestoTrabajoCementado='disabled';
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
    $hideDivBtnPuestoTrabajoRelleno='hide';
    $disabledBtnPuestoTrabajoRelleno='disabled';
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
    $hideDivBtnPuestoTrabajoCorteBanda='hide';
    $disabledBtnPuestoTrabajoCorteBanda='disabled';
    $divAlertCorteBanda='hide';
    //Embadado
    $embandado=new Embandado(null, null, null, null);
    $hideLineaEmbandado='hide';
    $panelEmbandado='hide';
    $hideBtnRegistrarEmbandado='hide';
    $disabledBtnRegistrarEmbandado='disabled';
    $hideDatosEmbandado='hide';
    $hideDivBtnFinalizarEmbandado='hide';
    $disabledbtnFinalizarEmbandado='disabled';
    $hideDivBtnFotoEmbandado='hide';
    $disabledBtnFotoEmbandado='disabled';
    $hideDivBtnPuestoTrabajoEmbandado='hide';
    $disabledBtnPuestoTrabajoEmbandado='disabled';
    //Vulcanizado
    $vulcanizado=new Vulcanizado(null, null, null, null);
    $hideAlertaPosicionesCamaras='hide';
    $hideLineaVulcanizado='hide';
    $panelVulcanizado='hide';
    $hideBtnRegistrarVulcanizado='hide';
    $disabledBtnRegistrarVulcanizado='disabled';
    $hideDatosVulcanizado='hide';
    $hideDivBtnFinalizarVulcanizado='hide';
    $disabledbtnFinalizarVulcanizado='disabled';
    $hideDivBtnRegistrarPosicionesCamara='hide';
    $disabledbtnRegistrarPosicionesCamara='disabled';
    $ver='';
    $hideDivBtnFotoVulcanizado='hide';
    $disabledBtnFotoVulcanizado='disabled';
    $hideDivBtnPuestoTrabajoVulcanizado='hide';
    $disabledBtnPuestoTrabajoVulcanizado='disabled';
    //Inspeccion final
    $inspeccionFinal=new Inspeccion_Final(null, null, null, null);
    $hideLineaInspeccionFinal='hide';
    $panelInspeccionFinal='hide';
    $hideBtnRegistrarInspeccionFinal='hide';
    $disabledBtnRegistrarInspeccionFinal='disabled';
    $hideDatosInspeccionFinal='hide';
    $hideDivBtnFinalizarInspeccionFinal='hide';
    $disabledbtnFinalizarInspeccionFinal='disabled';
    $hideDivBtnFotoInspeccionFinal='hide';
    $disabledBtnFotoInspeccionFinal='disabled';
    $hideDivBtnPuestoTrabajoInspeccionFinal='hide';
    $disabledBtnPuestoTrabajoInspeccionFinal='disabled';
    //Terminacion
    $terminacion=new Terminacion(null, null, null, null);
    $hideLineaTerminacion='hide';
    $panelTerminacion='hide';
    $hideBtnRegistrarTerminacion='hide';
    $disabledBtnRegistrarTerminacion='disabled';
    $hideDatosTerminacion='hide';
    $hideDivBtnFinalizarTerminacion='hide';
    $disabledbtnFinalizarTerminacion='disabled';
    $hideDivBtnFotoTerminacion='hide';
    $disabledBtnFotoTerminacion='disabled';
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
    $hideDivBtnFotoInspeccionInicial='hide';
    $disabledBtnFotoInspeccionInicial='disabled';
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
    $hideDivBtnPuestoTrabajoRaspado='hide';
    $disabledBtnPuestoTrabajoRaspado='disabled';
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
    $hideDivBtnPuestoTrabajoPreparacion='hide';
    $disabledBtnPuestoTrabajoPreparacion='disabled';
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
    $hideDivBtnPuestoTrabajoReparacion='hide';
    $disabledBtnPuestoTrabajoReparacion='disabled';
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
    $hideDivBtnPuestoTrabajoCementado='hide';
    $disabledBtnPuestoTrabajoCementado='disabled';
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
    $hideDivBtnPuestoTrabajoRelleno='hide';
    $disabledBtnPuestoTrabajoRelleno='disabled';
    $hideDivBtnPuestoTrabajoRelleno='hide';
    $disabledBtnPuestoTrabajoRelleno='disabled';
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
    $hideDivBtnPuestoTrabajoCorteBanda='hide';
    $disabledBtnPuestoTrabajoCorteBanda='disabled';
    $divAlertCorteBanda='hide';
    //Embadado
    $embandado=new Embandado(null, null, null, null);
    $hideLineaEmbandado='hide';
    $panelEmbandado='hide';
    $hideBtnRegistrarEmbandado='hide';
    $disabledBtnRegistrarEmbandado='disabled';
    $hideDatosEmbandado='hide';
    $hideDivBtnFinalizarEmbandado='hide';
    $disabledbtnFinalizarEmbandado='disabled';
    $hideDivBtnFotoEmbandado='hide';
    $disabledBtnFotoEmbandado='disabled';
    $hideDivBtnPuestoTrabajoEmbandado='hide';
    $disabledBtnPuestoTrabajoEmbandado='disabled';
    //Vulcanizado
    $vulcanizado=new Vulcanizado(null, null, null, null);
    $hideAlertaPosicionesCamaras='hide';
    $hideLineaVulcanizado='hide';
    $panelVulcanizado='hide';
    $hideBtnRegistrarVulcanizado='hide';
    $disabledBtnRegistrarVulcanizado='disabled';
    $hideDatosVulcanizado='hide';
    $hideDivBtnFinalizarVulcanizado='hide';
    $disabledbtnFinalizarVulcanizado='disabled';
    $ver='';
    $hideDivBtnRegistrarPosicionesCamara='hide';
    $disabledbtnRegistrarPosicionesCamara='disabled';
    $hideDivBtnFotoVulcanizado='hide';
    $disabledBtnFotoVulcanizado='disabled';
    $hideDivBtnPuestoTrabajoVulcanizado='hide';
    $disabledBtnPuestoTrabajoVulcanizado='disabled';
    //Inspeccion final
    $inspeccionFinal=new Inspeccion_Final(null, null, null, null);
    $hideLineaInspeccionFinal='hide';
    $panelInspeccionFinal='hide';
    $hideBtnRegistrarInspeccionFinal='hide';
    $disabledBtnRegistrarInspeccionFinal='disabled';
    $hideDatosInspeccionFinal='hide';
    $hideDivBtnFinalizarInspeccionFinal='hide';
    $disabledbtnFinalizarInspeccionFinal='disabled';
    $hideDivBtnFotoInspeccionFinal='hide';
    $disabledBtnFotoInspeccionFinal='disabled';
    $hideDivBtnPuestoTrabajoInspeccionFinal='hide';
    $disabledBtnPuestoTrabajoInspeccionFinal='disabled';
    //Terminacion
    $terminacion=new Terminacion(null, null, null, null);
    $hideLineaTerminacion='hide';
    $panelTerminacion='hide';
    $hideBtnRegistrarTerminacion='hide';
    $disabledBtnRegistrarTerminacion='disabled';
    $hideDatosTerminacion='hide';
    $hideDivBtnFinalizarTerminacion='hide';
    $disabledbtnFinalizarTerminacion='disabled';
    $hideDivBtnFotoTerminacion='hide';
    $disabledBtnFotoTerminacion='disabled';
    //
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
        //$hideDivBtnFinalizarInspeccionInicial='hide';
        //$disabledbtnFinalizarInspeccionInicial='disabled';
        $raspado=new Raspado(null, null, null, null);
    }
}
//Fin validaciones de inspeccion inicial
//------------------------------------------------------------------------------
//Validaciones de raspado
if ($raspado->getId()==null || $raspado->getIdEmpleado()==null){
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
    $hideDivBtnPuestoTrabajoRaspado='';
    $disabledBtnPuestoTrabajoRaspado='';
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
if ($preparacion->getId()==null || $preparacion->getIdEmpleado()==null){
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
    $hideDivBtnPuestoTrabajoPreparacion='';
    $disabledBtnPuestoTrabajoPreparacion='';
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
if ($reparacion->getId()==null || $reparacion->getIdEmpleado()==null){
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
    $hideDivBtnPuestoTrabajoReparacion='';
    $disabledBtnPuestoTrabajoReparacion='';
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
if ($cementado->getId()==null || $cementado->getIdEmpleado()==null){
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
    $hideDivBtnPuestoTrabajoCementado='';
    $disabledBtnPuestoTrabajoCementado='';
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
if ($relleno->getId()==null || $relleno->getIdEmpleado()==null){
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
    $hideDivBtnPuestoTrabajoRelleno='';
    $disabledBtnPuestoTrabajoRelleno='';
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
//print_r($corte_banda);die();
if ($corte_banda->getId()==null || $corte_banda->getIdEmpleado()==null){
    $hideBtnRegistrarCorte_Banda='hide';
    $disabledBtnRegistrarCorte_Banda='hide';
    $divAlertCorteBanda='';
} else {
    $hideLineaCorte_Banda='';
    $hideBtnRegistrarCorte_Banda='hide';
    $disabledBtnRegistrarCorte_Banda='disabled';
    $hideDatosCorte_Banda='';
    $colorBarraProgreso='info';
    $porcentajeProgreso=70;
    $hideDivBtnFinalizarCorte_Banda='';
    $disabledbtnFinalizarCorte_Banda='';
    $hideDivBtnPuestoTrabajoCorteBanda='';
    $disabledBtnPuestoTrabajoCorteBanda='';
    //if ($corte_banda->getChecked() && $corte_banda->getEstado()=='prf'){
        $hideDivBtnFinalizarCorte_Banda='hide';
        $disabledbtnFinalizarCorte_Banda='disabled';
        $hideDivBtnFotoCorte_Banda='';
        $disabledBtnFotoCorte_Banda='';
        //Declaracion del Embandado
    if ($corte_banda->getEstado()) {
        $divAlertCorteBanda='hide';
        $embandado=new Embandado('idCorteBanda', $corte_banda->getId(), null, null);
        $panelEmbandado='';
    } else {
        $divAlertCorteBanda='';
        $embandado=new Embandado(null, null, null, null);
        $panelEmbandado='hide';
    }
    //} else {
        //$corte_banda=new Corte_Banda(null, null, null, null);
        //$panelCorte_Banda='hide';
    //}
}
//Fin Validaciones Corte_Banda
//------------------------------------------------------------------------------
//Validaciones Embandado
if ($embandado->getId()==null  || $embandado->getIdEmpleado()==null){
    $hideBtnRegistrarEmbandado='';
    $disabledBtnRegistrarEmbandado='';
} else {
    $hideLineaEmbandado='';
    $hideBtnRegistrarEmbandado='hide';
    $disabledBtnRegistrarEmbandado='disabled';
    $hideDatosEmbandado='';
    $colorBarraProgreso='info';
    $porcentajeProgreso=75;
    $hideDivBtnFinalizarEmbandado='';
    $disabledbtnFinalizarEmbandado='';
    $hideDivBtnPuestoTrabajoEmbandado='';
    $disabledBtnPuestoTrabajoEmbandado='';
    if ($embandado->getChecked() && $embandado->getEstado()=='prf'){
        $hideDivBtnFinalizarEmbandado='hide';
        $disabledbtnFinalizarEmbandado='disabled';
        $hideDivBtnFotoEmbandado='';
        $disabledBtnFotoEmbandado='';
        //Declaracion del Corte de banda
        $vulcanizado=new Vulcanizado('idEmbandado', $embandado->getId(), null, null);
        $panelVulcanizado='';
    } else {
        $vulcanizado=new Vulcanizado(null, null, null, null);
        $panelVulcanizado='hide';
    }
}
//Fin Validaciones Embandado
//------------------------------------------------------------------------------
//Validaciones Vulcanizado
if ($vulcanizado->getId()==null || $vulcanizado->getIdEmpleado()==null){
    $hideBtnRegistrarVulcanizado='';
    $disabledBtnRegistrarVulcanizado='';
} else {
    //$hideAlertaPosicionesCamaras='';
    $hideLineaVulcanizado='';
    $hideBtnRegistrarVulcanizado='hide';
    $disabledBtnRegistrarVulcanizado='disabled';
    $hideDatosVulcanizado='';
    $colorBarraProgreso='info';
    $porcentajeProgreso=80;
    $hideDivBtnPuestoTrabajoVulcanizado='';
    $disabledBtnPuestoTrabajoVulcanizado='';
    /*COMENTADO EL 2018-09-09 01:47
    if (!$vulcanizado->getEstadoPosicionesCamaras()){
        $hideAlertaPosicionesCamaras='';
        $hideDivBtnRegistrarPosicionesCamara='';
        $disabledbtnRegistrarPosicionesCamara='';
        $hideDivBtnFinalizarVulcanizado='hide';
        $disabledbtnFinalizarVulcanizado='disabled';
        $ver='';
    } else {
        $hideAlertaPosicionesCamaras='hide';
        $hideDivBtnRegistrarPosicionesCamara='';
        $disabledbtnRegistrarPosicionesCamara='';
        $hideDivBtnFinalizarVulcanizado='';
        $disabledbtnFinalizarVulcanizado='';
        $ver='&V=Y';
    }
    */
    //INSERTADO EL 2018-09-09 01:47
    $hideAlertaPosicionesCamaras='hide';
    $hideDivBtnRegistrarPosicionesCamara='';
    $disabledbtnRegistrarPosicionesCamara='';
    $hideDivBtnFinalizarVulcanizado='';
    $disabledbtnFinalizarVulcanizado='';
    $ver='&V=Y';
    //FIN INSERTADO EL 2018-09-09 01:47
    if ($vulcanizado->getChecked() && $vulcanizado->getEstado()=='prf'){
        $hideDivBtnFinalizarVulcanizado='hide';
        $disabledbtnFinalizarVulcanizado='disabled';
        $hideDivBtnFotoVulcanizado='';
        $disabledBtnFotoVulcanizado='';
        //Declaracion del Corte de banda
        $inspeccionFinal=new Inspeccion_Final('idVulcanizado', $vulcanizado->getId(), null, null);
        $panelInspeccionFinal='';
    } else {
        $inspeccionFinal=new Inspeccion_Final(null, null, null, null);
        $panelInspeccionFinal='hide';
    }
}
//Fin Validaciones Vulcanizado
//------------------------------------------------------------------------------
//Validaciones InspeccionFinal
if ($inspeccionFinal->getId()==null || $inspeccionFinal->getIdEmpleado()==null){
    $hideBtnRegistrarInspeccionFinal='';
    $disabledBtnRegistrarInspeccionFinal='';
} else {
    $hideLineaInspeccionFinal='';
    $hideBtnRegistrarInspeccionFinal='hide';
    $disabledBtnRegistrarInspeccionFinal='disabled';
    $hideDatosInspeccionFinal='';
    $colorBarraProgreso='info';
    $porcentajeProgreso=90;
    $hideDivBtnFinalizarInspeccionFinal='';
    $disabledbtnFinalizarInspeccionFinal='';
    $hideDivBtnPuestoTrabajoInspeccionFinal='';
    $disabledBtnPuestoTrabajoInspeccionFinal='';
    if ($inspeccionFinal->getChecked() && $inspeccionFinal->getEstado()=='prf'){
        $hideDivBtnFinalizarInspeccionFinal='hide';
        $disabledbtnFinalizarInspeccionFinal='disabled';
        $hideDivBtnFotoInspeccionFinal='';
        $disabledBtnFotoInspeccionFinal='';
        //Declaracion de la terminacion
        $terminacion=new Terminacion('idInspeccion_final', $inspeccionFinal->getId(), null, null);
        $panelTerminacion='hide';
    } else {
        $terminacion=new Terminacion(null, null, null, null);
        $panelTerminacion='hide';
    }
}
//Fin Validaciones InspeccionFinal
//------------------------------------------------------------------------------
//Validaciones Terminacion
if ($terminacion->getId()==null){
    $alertaSiguienteProceso='hide';
    $hideBtnRegistrarTerminacion='';
    $disabledBtnRegistrarTerminacion='';
} else {
    $alertaSiguienteProceso='hide';
    //COMENTADA 2018-09-21 15:04 $hideLineaTerminacion='';//
    $hideLineaTerminacion='hide';
    $hideBtnRegistrarTerminacion='hide';
    $disabledBtnRegistrarTerminacion='disabled';
    $hideDatosTerminacion='';
    $colorBarraProgreso='success';
    $porcentajeProgreso=100;
    if ($terminacion->getChecked() && $terminacion->getEstado()=='prf'){
        $hideDivBtnFinalizarTerminacion='hide';
        $disabledbtnFinalizarTerminacion='disabled';
        $hideDivBtnFotoTerminacion='';
        $disabledBtnFotoTerminacion='';
        //Declaracion de la terminacion
        $servicioFin=new Servicio_Fin('idLlanta', $llanta->getId(), null, null);
    } else {
        $servicioFin=new Servicio_Fin(null, null, null, null);
    }
}
//Fin Validaciones Terminacion
//------------------------------------------------------------------------------
//Validaciones Servicio fin
if ($servicioFin->getId()==null){
    $alertaProcesoFinalizado='hide';
    $mjsProcesoFinalizado='';
    $colorAlertaProcesoFinalizado='';
    $hideTiempoTranscurrido='';
    $hideTiempoTotal='hide';
    $hideFechaFinalizacion='hide';
} else {
    $alertaProcesoFinalizado='';
    if ($llanta->getFinRencaucheXRechazo()) {
        $mjsProcesoFinalizado='El proceso de rencauche a finalizado, esta llanta fue rechazada';
        $colorAlertaProcesoFinalizado='danger';
    } else {
        $mjsProcesoFinalizado="El proceso de rencauche a finalizado exitosamente";
        $colorAlertaProcesoFinalizado='success';
    }
    $hideTiempoTranscurrido='hide';
    $hideTiempoTotal='';
    $hideFechaFinalizacion='';
    //
    $hideDivBtnFinalizarInspeccionInicial='hide';
    $disabledbtnFinalizarInspeccionInicial='disabled';
    $hideDivBtnFotoInspeccionInicial='';
    $disabledBtnFotoInspeccionInicial='';
    //
    $hideDivBtnFinalizarRaspado='hide';
    $disabledbtnFinalizarRaspado='disabled';
    $hideDivBtnFotoRaspado='';
    $disabledBtnFotoRaspado='';
    //
    $hideDivBtnFinalizarPreparacion='hide';
    $disabledbtnFinalizarPreparacion='disabled';
    $hideDivBtnFotoPreparacion='';
    $disabledBtnFotoPreparacion='';
    //
    $hideDivBtnFinalizarReparacion='hide';
    $disabledbtnFinalizarReparacion='disabled';
    $hideDivBtnFotoReparacion='';
    $disabledBtnFotoReparacion='';
    //
    $hideDivBtnFinalizarCementado='hide';
    $disabledbtnFinalizarCementado='disabled';
    $hideDivBtnFotoCementado='';
    $disabledBtnFotoCementado='';
    //
    $hideDivBtnFinalizarRelleno='hide';
    $disabledbtnFinalizarRelleno='disabled';
    $hideDivBtnFotoRelleno='';
    $disabledBtnFotoRelleno='';
    //
    $hideDivBtnFinalizarCorte_Banda='hide';
    $disabledbtnFinalizarCorte_Banda='disabled';
    $hideDivBtnFotoCorte_Banda='';
    $disabledBtnFotoCorte_Banda='';
    //
    $hideDivBtnFinalizarEmbandado='hide';
    $disabledbtnFinalizarEmbandado='disabled';
    $hideDivBtnFotoEmbandado='';
    $disabledBtnFotoEmbandado='';
    //
    $hideDivBtnFinalizarVulcanizado='hide';
    $disabledbtnFinalizarVulcanizado='disabled';
    $hideDivBtnFotoVulcanizado='';
    $disabledBtnFotoVulcanizado='';
    //
    $hideDivBtnFinalizarInspeccionFinal='hide';
    $disabledbtnFinalizarInspeccionFinal='disabled';
    $hideDivBtnFotoInspeccionFinal='';
    $disabledBtnFotoInspeccionFinal='';
    //
    $hideDivBtnFinalizarTerminacion='hide';
    $disabledbtnFinalizarTerminacion='disabled';
    $hideDivBtnFotoTerminacion='';
    $disabledBtnFotoTerminacion='';
}
//Fin Validaciones Servicio fin
//------------------------------------------------------------------------------
?>
<script src="lib/controladores/procesoServicio.js"></script>
<div class="col-lg-12" ng-controller="proceso">
    <div class="col-md-12 text-center page-header" id="marginTop-20">
        <div class="col-lg-4">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-danger" id="btnRegresar" type="button">
                <i class="fa fa-arrow-left"></i>
            </button>
            <div class="mdl-tooltip" for="btnRegresar">Regresar a la orden de servicio</div>
        </div>
        <div class="col-lg-4">
            <h3 class="text text-primary text-uppercase">Proceso de rencauche </h3><small><i>(OS: <?=$objeto->getOs()?> -<span class="mdl-typography--font-bold"> RP: <?= $llanta->getRp(); ?></span>)</i></small>
        </div>
        <div class="col-lg-4">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnDetalles" type="button" href="/#_Dialog_DetallesProceso" data-toggle="modal">
                <i class="fa fa-info-circle"></i>
            </button>
            <div class="mdl-tooltip" for="btnDetalles">Detalles de la llanta y la orden de servicio</div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 <?= $alertaProcesoFinalizado ?>" id="paddinTop10">
            <div class="alert alert-<?= $colorAlertaProcesoFinalizado ?>"><?= $mjsProcesoFinalizado ?></div>
        </div>
    </div>
    <div class="col-md-12" id="paddinTop20"></div>
    <div class="col-md-12 page-header table-responsive" id="marginTop-20paddingBottom20">
        <div class="container-fluid">
            <div class="">
                <div class="col-md-1 col-sm-12">
                    <h4 class="text text-muted">PROCESOS: </h4>
                </div>
                <div class="col-md-11 col-sm-12 text-center">
                    <div class="col-lg-12 col-sm-4 <?=$alertaTiempoInicial?>">
                        <div class="alert alert-warning small <?=$alertaTiempoInicial?>" id="marginBottom-10">
                            <strong>!A&uacute;n no se ha iniciado el tiempo del proceso de rencauche¡ </strong>
                            <button class="btn btn-success" <?= $btnAddTiempoInicial ?> ng-click="setInitialTime(<?= $llanta->getId() ?>)">Iniciar <span class="fa fa-play"></span></button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-4 <?=$hideAlertaNingunProceso?>">
                        <div class="alert alert-warning small <?=$hideAlertaNingunProceso?>" id="marginBottom-10">!Esta llanta no a iniciado el proceso de rencauche¡</div>
                    </div>
                    <div class="<?= $panelProcesos ?>">
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaInspeccionInicial?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">II</span>
                            <span class="mdl-chip__text">Inspeccion inicial</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaRaspado?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">R</span>
                            <span class="mdl-chip__text">Raspado</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaPreparacion?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">P</span>
                            <span class="mdl-chip__text">Preparacion</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaReparacion?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">R</span>
                            <span class="mdl-chip__text">Reparacion</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaCementado?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">C</span>
                            <span class="mdl-chip__text">Cementado</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaRelleno?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">R</span>
                            <span class="mdl-chip__text">Relleno</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaCorte_Banda?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">C</span>
                            <span class="mdl-chip__text">Corte de banda</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaEmbandado?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">E</span>
                            <span class="mdl-chip__text">Embandado</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaVulcanizado?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">V</span>
                            <span class="mdl-chip__text">Vulcanizado</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaInspeccionFinal?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">IF</span>
                            <span class="mdl-chip__text">Inspeccion final</span>
                        </span>
                        <span class="mdl-chip mdl-chip--contact <?=$hideLineaTerminacion?>">
                            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">T</span>
                            <span class="mdl-chip__text">Terminacion</span>
                        </span>
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
    <div class="col-md-12 page-header <?= $panelProcesos ?>" id="marginTop-5">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading text-left">PANEL</div>
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
                                        <div class="col-md-12 <?= $hideBtnRegistrarInspeccionInicial; ?>">
                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" id="btnRegistrarInspeccionInicial" type="button" name="accion">GESTIONAR</button>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                                <h4 class="text-uppercase mdl-color-text--green-500">INFORMACIÓN REGISTRADA</h4>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 <?= $hideDatosInspeccionInicial; ?>" id="paddinTop20" align="left">
                                                <p>
                                                    <span class="text-uppercase">EMPLEADO: </span><span class="text-muted"><?= $inspeccionInicial->getEmpleado()->getPersona()->getNombresCompletos() ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">NUMERO REENCAUCHE: </span><span class="text-muted"><?= $inspeccionInicial->getNumeroRencauche() ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">ESTADO: </span><span class="text-muted"><?= $inspeccionInicial->getNombreChecked(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">OBSERVACIONES: </span><span class="text-muted"><?= $inspeccionInicial->getObservaciones() ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">TIEMPO DE EJECUCIÓN: </span><span class="text-muted"><?= getDiffTiempoString($llanta->getFechaInicioProceso(), $inspeccionInicial->getFechaRegistro()) ?></span>
                                                </p>
                                                <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="center">
                                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" id="btnRegistrarInspeccionInicial" type="button" name="accion" onclick="document.location='principal.php?CON=system/Pages/inspeccionInicialFormulario.php&id=<?= $llanta->getId(); ?>';">GESTIONAR</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                                <p>
                                                    <span class="text-uppercase">EVIDENCIA FOTOGRÁFICA: </span><span class="text-muted">
                                                </p>
                                                <p align="center">
                                                    <img class="img img-responsive" ng-src="system/Uploads/Imgs/Inspeccion_Inicial/<?= $inspeccionInicial->getFoto() ?>" width="350px">
                                                </p>
                                            </div>
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
                                        <div class="col-md-12 <?= $hideBtnRegistrarRaspado; ?>">
                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" id="btnRegistrarRaspado" type="button" name="accion">GESTIONAR</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosRaspado?>">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                                    <h4 class="text-uppercase mdl-color-text--green-500">INFORMACIÓN REGISTRADA</h4>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="left">
                                                    <p>
                                                        <span class="text-uppercase">EMPLEADO: </span><span class="text-muted"><?= $raspado->getEmpleado()->getPersona()->getNombresCompletos() ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">PUESTO DE TRABAJO: </span><span class="text-muted"><?= $raspado->getPuestoTrabajo()->getNombre() ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">ANCHO DE BANDA: </span><span class="text-muted"><?= $raspado->getAnchoBanda(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">LARGO DE BANDA: </span><span class="text-muted"><?= $raspado->getLargoBanda(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">RETIRO DE CINTURÓN: </span><span class="text-muted"><?= $raspado->getNombreCinturon(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">CANTIDAD: </span><span class="text-muted"><?= $raspado->getCinturonCantidad(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">PROFUNDIDAD: </span><span class="text-muted"><?= $raspado->getProfundidad(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">RADIO: </span><span class="text-muted"><?= $raspado->getRadio(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">OBSERVACIONES: </span><span class="text-muted"><?= $raspado->getObservaciones(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">ESTADO: </span><span class="text-muted"><?= $raspado->getNombreChecked(); ?></span>
                                                    </p>
                                                    <p>
                                                        <span class="text-uppercase">TIEMPO DE EJECUCIÓN: </span><span class="text-muted"><?= getDiffTiempoString($raspado->getFechaInicioProceso(), $raspado->getFechaRegistro()); ?></span>
                                                    </p>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="center">
                                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" id="btnRegistrarRaspado" type="button" name="accion" onclick="document.location='principal.php?CON=system/Pages/raspadoFormulario.php&id=<?= $llanta->getId(); ?>';">GESTIONAR</button>
                                                    <button ng-click="cargarInfoUsosInsumos(<?= $raspado->getId() ?>, 1);" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoRaspado?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                                    <p>
                                                        <span class="text-uppercase">EVIDENCIA FOTOGRÁFICA: </span><span class="text-muted">
                                                    </p>
                                                    <p align="center">
                                                        <img class="img img-responsive" ng-src="system/Uploads/Imgs/Raspado/<?= $raspado->getFoto(); ?>" width="350px">
                                                    </p>
                                                </div>
                                            </div>
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
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarPreparacion?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarPreparacion" type="button" <?=$disabledbtnFinalizarPreparacion?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoPreparacion?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoRaspado" type="button" <?=$disabledBtnFotoPreparacion?> data-toggle="modal" href="/#fotoPreparacion">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoPreparacion?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $preparacion->getId() ?>, 2)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoPreparacion?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
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
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarReparacion?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarReparacion" type="button" <?=$disabledbtnFinalizarReparacion?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoReparacion?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoReparacion" type="button" <?=$disabledBtnFotoReparacion?> data-toggle="modal" href="/#fotoReparacion">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoReparacion?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $reparacion->getId() ?>, 3)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoReparacion?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
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
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarCementado?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarCementado" type="button" <?=$disabledbtnFinalizarCementado?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoCementado?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoCementado" type="button" <?=$disabledBtnFotoCementado?> data-toggle="modal" href="/#fotoCementado">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoCementado?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $cementado->getId() ?>, 4)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoCementado?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
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
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarRelleno?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarRelleno" type="button" <?=$disabledbtnFinalizarRelleno?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoRelleno?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoRelleno" type="button" <?=$disabledBtnFotoRelleno?> data-toggle="modal" href="/#fotoRelleno">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoRelleno?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $relleno->getId() ?>, 5)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoRelleno?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
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
                                            Corte Banda
                                        </a>
                                    </h4>
                                </div>
                                <div id="corte_banda_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarCorte_Banda?>">
                                            <button class="btn btn-success" id="btnRegistrarCorte_Banda" type="button" name="accion" <?=$disabledBtnRegistrarCorte_Banda?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?= $divAlertCorteBanda ?>">
                                            <div class="alert alert-danger">No se puede continuar con el proceso de rencacuche ya que a&uacute;n no se ha registrado el corte de la banda</div>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosCorte_Banda?>">
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$corte_banda->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Empates: <span class="text-muted"><?=$corte_banda->getEmpates()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($corte_banda->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($corte_banda->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarCorte_Banda?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarCorte_Banda" type="button" <?=$disabledbtnFinalizarCorte_Banda?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoCorte_Banda?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoCorte_Banda" type="button" <?=$disabledBtnFotoCorte_Banda?> data-toggle="modal" href="/#fotoCorte_Banda">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoCorteBanda?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $corte_banda->getId() ?>, 6)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoCorteBanda?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
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
                            <!------------------------------------------------->
                            <!--Panel para Embandado-->
                            <div class="panel panel-success <?=$panelEmbandado?>">
                                <div class="panel-heading" role="tab" id="Embandado">
                                    <h4 class="panel-title">
                                        <a id="accionEmbandado" href="/#embandado_p" data-toggle="collapse" data-parent="#accordion">
                                            Embandado
                                        </a>
                                    </h4>
                                </div>
                                <div id="embandado_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarEmbandado?>">
                                            <button class="btn btn-success" id="btnRegistrarEmbandado" type="button" name="accion" <?=$disabledBtnRegistrarEmbandado?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosEmbandado?>">
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$embandado->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Gravado: <span class="text-muted"><?=$embandado->getGravado()->getNombre()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Ancho banda: <span class="text-muted"><?=$embandado->getAnchoBanda()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Largo banda: <span class="text-muted"><?=$embandado->getLargoBanda()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?=$embandado->getNombreEstado()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?=$embandado->getNombreChecked()?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($embandado->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($embandado->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarEmbandado?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarEmbandado" type="button" <?=$disabledbtnFinalizarEmbandado?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoEmbandado?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoEmbandado" type="button" <?=$disabledBtnFotoEmbandado?> data-toggle="modal" href="/#fotoEmbandado">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoEmbandado?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $embandado->getId() ?>, 7)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoEmbandado?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoEmbandado'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Embandado/<?= $embandado->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel embandado-->
                            <!------------------------------------------------->
                            <!--Panel para Vulcanizado-->
                            <div class="panel panel-info <?=$panelVulcanizado?>">
                                <div class="panel-heading" role="tab" id="Vulcanizado">
                                    <h4 class="panel-title">
                                        <a id="accionVulcanizado" href="/#vulcanizado_p" data-toggle="collapse" data-parent="#accordion">
                                            Vulcanizado
                                        </a>
                                    </h4>
                                </div>
                                <div id="vulcanizado_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarVulcanizado?>">
                                            <button class="btn btn-success" id="btnRegistrarVulcanizado" type="button" name="accion" <?=$disabledBtnRegistrarVulcanizado?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosVulcanizado?>">
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?= $hideAlertaPosicionesCamaras ?>">
                                                <div class="alert alert-warning">Recuerda que debes registrar las <strong>(<?= $vulcanizado->getMaxPC() ?>)</strong> revisiones para finalizar el proceso de vulcanizado</div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$vulcanizado->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Metodo: <span class="text-muted"><?=$vulcanizado->getNombreMetodo()?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                                <h5>Revisiones: <span class="text-muted"><strong><?= $vulcanizado->getPCRegistradas() ?></strong>/<?=$vulcanizado->getCamaras()?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?=$vulcanizado->getNombreEstado()?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?=$vulcanizado->getNombreChecked()?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($vulcanizado->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($vulcanizado->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora finalizacion: <span class="text-muted"><?= rtrim($vulcanizado->getFechaFinalizacion())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarVulcanizado?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarVulcanizado" type="button" <?=$disabledbtnFinalizarVulcanizado?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnRegistrarPosicionesCamara?>" id="paddinTop20">
                                                <button class="btn btn-info" id="btnRegistrarPosicionesCamara" type="button" <?=$disabledbtnRegistrarPosicionesCamara?>>Revisiones <span class="fa fa-check"></span></button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoVulcanizado?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoVulcanizado" type="button" <?=$disabledBtnFotoVulcanizado?> data-toggle="modal" href="/#fotoVulcanizado">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoVulcanizado?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $vulcanizado->getId() ?>, 8)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoVulcanizado?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoVulcanizado'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Vulcanizado/<?= $vulcanizado->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel vulcanizado-->
                            <!------------------------------------------------->
                            <!--Panel para InspeccionFinal-->
                            <div class="panel panel-success <?=$panelInspeccionFinal?>">
                                <div class="panel-heading" role="tab" id="InspeccionFinal">
                                    <h4 class="panel-title">
                                        <a id="accionInspeccionFinal" href="/#inspeccionFinal_p" data-toggle="collapse" data-parent="#accordion">
                                            Inspeccion Final
                                        </a>
                                    </h4>
                                </div>
                                <div id="inspeccionFinal_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarInspeccionFinal?>">
                                            <button class="btn btn-success" id="btnRegistrarInspeccionFinal" type="button" name="accion" <?=$disabledBtnRegistrarInspeccionFinal?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosInspeccionFinal?>">
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$inspeccionFinal->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?=$inspeccionFinal->getNombreEstado()?></span></h5>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?=$inspeccionFinal->getNombreChecked()?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($inspeccionFinal->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($inspeccionFinal->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarInspeccionFinal?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarInspeccionFinal" type="button" <?=$disabledbtnFinalizarInspeccionFinal?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFotoInspeccionFinal?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoInspeccionFinal" type="button" <?=$disabledBtnFotoInspeccionFinal?> data-toggle="modal" href="/#fotoInspeccionFinal">Ver foto</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnPuestoTrabajoInspeccionFinal?>" id="paddinTop20">
                                                <button ng-click="cargarInfoUsosInsumos(<?= $inspeccionFinal->getId() ?>, 9)" class="btn btn-default" id="btnFotoRaspado" type="button" <?=$disabledBtnPuestoTrabajoInspeccionFinal?> data-toggle="modal" href="/#_puestoTrabajo">Informacion puesto trabajo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoInspeccionFinal'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/InspeccionFinal/<?= $inspeccionFinal->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel inspeccionFinal-->
                            <!------------------------------------------------->
                            <!--Panel para Terminacion-->
                            <div class="panel panel-warning <?=$panelTerminacion?>">
                                <div class="panel-heading" role="tab" id="Terminacion">
                                    <h4 class="panel-title">
                                        <a id="accionTerminacion" href="/#terminacion_p" data-toggle="collapse" data-parent="#accordion">
                                            Terminacion
                                        </a>
                                    </h4>
                                </div>
                                <div id="terminacion_p" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="col-md-12 <?=$hideBtnRegistrarTerminacion?>">
                                            <button class="btn btn-success" id="btnRegistrarTerminacion" type="button" name="accion" <?=$disabledBtnRegistrarTerminacion?>>Registar</button>
                                        </div>
                                        <div class="col-md-12 <?=$hideDatosTerminacion?>">
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Operario: <span class="text-muted"><?=$terminacion->getEmpleado()->getPersona()->getNombresCompletos()?></span></h5>
                                            </div>
<!--                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Actualmente: <span class="text-muted"><?=$terminacion->getNombreEstado()?></span></h5>
                                            </div>-->
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                                <h5>Estado: <span class="text-muted"><?=$terminacion->getNombreChecked()?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Observaciones: <span class="text-muted"><?= rtrim($terminacion->getObservaciones())?></span></h5>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <h5>Fecha/Hora inicio: <span class="text-muted"><?= rtrim($terminacion->getFechaRegistro())?></span></h5>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 text-center <?=$hideDivBtnFinalizarTerminacion?>" id="paddinTop20">
                                                <button class="btn btn-warning" id="btnFinalizarTerminacion" type="button" <?=$disabledbtnFinalizarTerminacion?>>Finalizar proceso</button>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center <?=$hideDivBtnFotoTerminacion?>" id="paddinTop20">
                                                <button class="btn btn-success" id="btnFotoTerminacion" type="button" <?=$disabledBtnFotoTerminacion?> data-toggle="modal" href="/#fotoTerminacion">Ver foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='modal fade' id='fotoTerminacion'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">Foto</h3>
                                            <div class="thumbnail">
                                                <img src="system/Uploads/Imgs/Terminacion/<?= $terminacion->getFoto() ?>">
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Fin panel terminacion-->
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
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel">
                <div class="panel-heading text-left">ESTADISTICAS:</div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div class="col-lg-4 col-md-6 col-sm-12" ng-init="inspeccionInicial.id=<?=$inspeccionInicial->getId()?>">
                            <h5>Fecha/Hora inicio: <span class="text-muted"><?=$llanta->getFechaInicioProceso()?></span></h5>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 <?= $hideTiempoTranscurrido ?>">
                            <h5>Tiempo transcurrido: <span class="text-muted" >{{ tiempo }}</span></h5>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 <?= $hideTiempoTotal ?>">
                            <h5>Tiempo total: <span class="text-muted" ><?= getDiffTiempo($fechaInicioLlanta, $servicioFin->getFechaRegistro()) ?></span></h5>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 <?= $hideFechaFinalizacion ?>">
                            <h5>Fecha/Hora finalizacion: <span class="text-muted" ><?= $servicioFin->getFechaRegistro() ?></span></h5>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='_Dialog_DetallesProceso'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal' ng-click="cleanPosicionCamara();">&times;</button>
                    <h3 class="text text-primary">INFORMACION<br><small>(Llanta y OS)</small></h3>
                </div>
                <div class="modal-header">
                    <div class="text-justify">
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>OS: <?= $objeto->getOs() ?></h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Cliente:</label><span class="text text-muted"> <?= $objeto->getCliente()->getNombreEmpresa() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Vendedor:</label><span class="text text-muted"> <?= $objeto->getVendedor()->getPersona()->getNombresCompletos() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $objeto->getObservaciones() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $objeto->getNombreEstado() ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>Llanta</h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">RP:</label><span class="text text-muted"> <?= $llanta->getRp() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Serie:</label><span class="text text-muted"> <?= $llanta->getSerie() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Marca:</label><span class="text text-muted"> <?= $llanta->getMarca()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Gravado:</label><span class="text text-muted"> <?= $llanta->getGravado()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o original:</label><span class="text text-muted"> <?= $llanta->getReferenciaOriginal()->getReferencia() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dimension:</label><span class="text text-muted"> <?= $llanta->getDimension()->getDimension() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o solicitada:</label><span class="text text-muted"> <?= $llanta->getReferenciaSolicitada()->getReferencia() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o entregado:</label><span class="text text-muted"> <?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getTipoLlanta()->getNombre() ?> / <?= $llanta->getAplicacionEntregada()->getMedidaCompleta() ?> (<?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getReferencia() ?>)</span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $llanta->getNombreProcesado()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Urgente:</label><span class="text text-muted"> <?= $llanta->getNombreUrgente()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $objeto->getObservaciones() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
    </div>
    <div class='modal fade' id='_puestoTrabajo'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">{{ usosInsumos[0].puestoTrabajo }}</h3>
                    <div class="mdl-spinner mdl-js-spinner is-active" ng-show="html.spinnerCargaDialogPT"></div>
                </div>
                <div class='modal-header'>
                    <div class="col-sm-12 col-lg-12 text-center">
                        <div class="col-sm-12 col-lg-12">
                            <h4 class="control-label">Herramientas usadas ({{ usosInsumos.length }}):</h4>
                        </div>
                        <center>
                            <div class="col-sm-12 col-lg-12 table-responsive container" id="paddinTop10">
                                <table class="mdl-data-table mdl-js-data-table">
                                    <thead>
                                        <tr>
                                            <th ng-click="orden='insumo'">Insumo</th>
                                            <th ng-click="orden='cantidad'">Cantidad</th>
                                            <th ng-click="orden='nombreUsado'">Usado</th>
                                            <th ng-click="orden='nombreTerminado'">Terminado</th>
                                            <th ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                            <th ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="objeto in usosInsumos | orderBy: orden" ng-show="html.listaUsosInsumo">
                                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                            <td>{{ objeto.cantidad }}</td>
                                            <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                            <td>{{ objeto.nombreTerminado }}</td>
                                            <td>{{ objeto.empleadoUso }}</td>
                                            <td>{{ objeto.empleadoEnvio }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <div id="toast-content-dialogPT" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<!--Funcionalidades con JS-->
<script>
    $(document).ready(function (){
        $("#accionInspeccionInicial").click();
        $("#accionRaspado").click();
        $("#accionPreparacion").click();
        $("#accionReparacion").click();
        $("#accionCementado").click();
        $("#accionRelleno").click();
        $("#accionCorte_Banda").click();
        $("#accionEmbandado").click();
        $("#accionVulcanizado").click();
        $("#accionInspeccionFinal").click();
        $("#accionTerminacion").click();
    });

    //Fin funciones de click para acciones de acordion de cada panel
    //--------------------------------------------------------------------------
    $("#btnRegresar").click(function (){
        document.location="principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=<?=$llanta->getIdServicio()?>";
    });
    //Inspeccion inicial
    $("#btnRegistrarInspeccionInicial").click(function (){
        document.location="principal.php?CON=system/Pages/inspeccionInicialFormulario.php&id=<?=$llanta->getId()?>";
    });
    //Fin inspeccion inicial
    //--------------------------------------------------------------------------
    //Raspado
    $("#btnRegistrarRaspado").click(function (){
        document.location="principal.php?CON=system/Pages/raspadoFormulario.php&id=<?= $llanta->getId(); ?>";
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
        document.location="principal.php?CON=system/Pages/rellenoFormularioFinalizar.php&id=<?=$relleno->getId()?>&idPreparacion=<?=$preparacion->getId()?>";
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
    //Embandado
    $("#btnRegistrarEmbandado").click(function (){
        document.location="principal.php?CON=system/Pages/embandadoFormulario.php&idCorteBanda=<?=$corte_banda->getId()?>";
    });
    $("#btnFinalizarEmbandado").click(function (){
        document.location="principal.php?CON=system/Pages/embandadoFormularioFinalizar.php&id=<?=$embandado->getId()?>";
    });
    //Fin embandado
    //--------------------------------------------------------------------------
    //Vulcanizado
    $("#btnRegistrarVulcanizado").click(function (){
        document.location="principal.php?CON=system/Pages/vulcanizadoFormulario.php&idEmbandado=<?=$embandado->getId()?>";
    });
    $("#btnRegistrarPosicionesCamara").click(function (){
        document.location="principal.php?CON=system/Pages/vulcanizadoPosicionesCamara.php&id=<?=$vulcanizado->getId()?><?=$ver?>";
    });
    $("#btnFinalizarVulcanizado").click(function (){
        document.location="principal.php?CON=system/Pages/vulcanizadoFormularioFinalizar.php&id=<?=$vulcanizado->getId()?>";
    });
    //Fin vulcanizado
    //--------------------------------------------------------------------------
    //InspeccionFinal
    $("#btnRegistrarInspeccionFinal").click(function (){
        document.location="principal.php?CON=system/Pages/inspeccionFinalFormulario.php&idVulcanizado=<?=$vulcanizado->getId()?>";
    });
    $("#btnFinalizarInspeccionFinal").click(function (){
        document.location="principal.php?CON=system/Pages/inspeccionFinalFormularioFinalizar.php&id=<?=$inspeccionFinal->getId()?>";
    });
    //Fin inspeccionFinal
    //--------------------------------------------------------------------------
    //Terminacion
    $("#btnRegistrarTerminacion").click(function (){
        document.location="principal.php?CON=system/Pages/terminacionFormulario.php&idInspeccionFinal=<?=$inspeccionFinal->getId()?>";
    });
    $("#btnFinalizarTerminacion").click(function (){
        document.location="principal.php?CON=system/Pages/terminacionFormularioFinalizar.php&id=<?=$terminacion->getId()?>";
    });
    //Fin terminacion
    //--------------------------------------------------------------------------
</script>
<script>
    var chart;

    var chartData = <?= $llanta->getTiemposProcesosEnArray() ?>;


    AmCharts.ready(function () {
        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartData;
        chart.categoryField = "proceso";
        // the following two lines makes chart 3D
        chart.depth3D = 20;
        chart.angle = 30;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.labelRotation = 90;
        categoryAxis.dashLength = 5;
        categoryAxis.gridPosition = "start";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.title = "Tiempo empleado en cada proceso (Minutos)";
        valueAxis.dashLength = 5;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.valueField = "tiempo";
        graph.colorField = "color";
        graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b> minutos</span>";
        graph.type = "column";
        graph.lineAlpha = 0;
        graph.fillAlphas = 1;
        chart.addGraph(graph);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);

        chart.creditsPosition = "top-right";


        // WRITE
        chart.write("chartdiv");
    });
</script>