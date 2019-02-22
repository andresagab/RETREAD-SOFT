/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** 
 * Descripcion del archivo Option.js 
 * 
 * En este archivo se dijitaran y encontraran la funciones realcionadas con tiempo los objetos option de html.
 * 
 * El principal objetivo es realizar una validacion para cuando el value del option es #
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */
function validarOption(_value){
    //console.log(_value);
    var valido=false;
    if (_value!="#" && _value!='' && _value!=null) valido=true;
    return valido;
}