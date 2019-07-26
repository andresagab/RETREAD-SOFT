<?php
date_default_timezone_set('America/Bogota');

function getDiffTimeInSeconds($timeStar, $timeEnd) {
    $timepoInicial=new DateTime($timeStar, null);
    $timepoActual=new DateTime($timeEnd, null);
    $diff=date_diff($timepoInicial, $timepoActual, null);
    foreach ($diff as $key => $value) ${$key}=$value;   
    return getMinutesInSeconds(getHorasEnMinutos(getDiasEnHoras($d)+$h)+$i)+$s;
}

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


function getDiffTiempoString($timeStar, $timeEnd) {
    $diferencia = '';
    if (strtolower($timeStar) == 'sin registrar' || strtolower($timeEnd == 'sin registrar')) $diferencia = $timeStar;
    else {
        $timepoInicial = new DateTime($timeStar, null);
        $timepoActual = new DateTime($timeEnd, null);
        $diff = date_diff($timepoInicial, $timepoActual, null);
        foreach ($diff as $key => $value) ${$key}=$value;
        if ($y!=0 && $y!='0') $diferencia = "$y años ";
        if ($m!=0 && $m!='0') $diferencia .= "$m meses ";
        if ($d!=0 && $d!='0') $diferencia .= "$d dias ";
        if ($h!=0 && $h!='0') $diferencia .= "$h horas ";
        if ($i!=0 && $i!='0') $diferencia .= "$i minutos ";
        if ($s!=0 && $s!='0') $diferencia .= "$s segundos ";
    }
    return $diferencia;
}

function getDiasEnHoras($dias) {
    return $dias*24;
}

function getHorasEnMinutos($horas) {
    return $horas*60;
}

function getMinutesInSeconds($minutes) {
    return $minutes*60;
}