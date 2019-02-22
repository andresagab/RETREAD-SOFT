/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** 
 * Descripcion del archivo ObjectsHTML.js 
 * 
 * En este archivo se dijitaran y encontraran la funciones realcionadas con los objetos de html.
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */
function valueTextArea(_value){
    console.log("***" + _value);
    var valido=false;
    if (_value!=null && _value!="") valido=true;
    return valido;
}

function validarInput(_val){
    /*
     * Esta funcion valida que el valor de una etiqueta input de tipo text no
     * contenga valores nulos o similares, como respuesta retorna un valor
     * booleano;
     * 
     * TRUE: valor con caracteres validos.
     * FALSE: valor nulo o con caracteres que representan el mismo significado.
     * 
     */
    var valid=false;
    if (_val!=null && _val!='' && _val!='#' && _val!='-' && _val!='--' && _val!='---' && _val!='.' && _val!=',' && _val!=':' && _val!=';') valid=true;
    return valid;
}

function getCutText(string, chars) {
    return string.substringData(0, chars);
}