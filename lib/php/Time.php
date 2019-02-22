<?php

function getDiffTiempoEnMinutos($timeStar, $timeEnd) {
    $timepoInicial=new DateTime($timeStar, null);
    $timepoActual=new DateTime($timeEnd, null);
    $diff=date_diff($timepoInicial, $timepoActual, null);
    foreach ($diff as $key => $value) ${$key}=$value;   
    return getHorasEnMinutos(getDiasEnHoras($d)+$h)+$i;
}

function getDiffTiempoHoras($timeStar, $timeEnd) {
    $timepoInicial=new DateTime($timeStar, null);
    $timepoActual=new DateTime($timeEnd, null);
    $diff=date_diff($timepoInicial, $timepoActual, null);
    foreach ($diff as $key => $value) ${$key}=$value;
    $diferencia="$y-$m-$d $h:$i:$s";
    $horas= getDiasEnHoras($d)+$h;
    return $horas;
}

function getDiffTiempo($timeStar, $timeEnd) {
    $timepoInicial=new DateTime($timeStar, null);
    $timepoActual=new DateTime($timeEnd, null);
    $diff=date_diff($timepoInicial, $timepoActual, null);
    //print_r($diff);die();
    foreach ($diff as $key => $value) ${$key}=$value;
    $diferencia="$y-$m-$d $h:$i:$s";
    return $diferencia;
}

function getDiasEnHoras($dias) {
    return $dias*24;
}

function getHorasEnMinutos($horas) {
    return $horas*60;
}