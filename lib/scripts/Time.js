/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** 
 * Descripcion del archivo Time.js 
 * 
 * En este archivo se dijitaran y encontraran la funciones realcionadas con tiempo (años, meses, dias, horas, minutos, segundos o similares).
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */
var fecha=new Date();
var horas=fecha.getHours();
var minutos=fecha.getMinutes();
var segundos=fecha.getSeconds();

function ejecutarReloj(){
    //Convertimos la hora, minutos y segundo en formato 06, es decir de 6 a 06
    horas = (horas<=9)?("0"+horas):horas;
    minutos = (minutos<=9)?("0"+minutos):minutos;
    segundos=(segundos<=9)? ("0"+segundos):segundos; 
    console.log(horas+":"+minutos+":"+segundos);
}

function ejecutarTiempoRestante(_FechaInicio, _FechaFin){
    if (_FechaInicio!=_FechaFin){
        fechaInicio=new Date(_FechaInicio);
        
    }
}
function descontarSegundos(_segundoInicial){
    document.write(segundos++);
}