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

function incompleteData(url) {
    setTimeout(function () {
        if (url==null) window.history.back();
        else window.location = url;
    }, 5000);
}

function disabledComponnentPage(id, status) {
    if (document.getElementById(id)!=null) document.getElementById(id).disabled = status;
}

function validDataResponse(data) {
    var status = false;
    if (data!=null) status = true;
    else if (data.length>0) {
        if (data[0]!=null) status = true;
    }
    return status;
}

function validSimpleResponseHTTP(response, idToast) {
    switch (response) {
        case 'OK':
            showToastDialog(true, 'Acción ejecutada exitosamente', idToast);
            break;
        case 'SD':
            showToastDialog(true, 'Solicitud desconocida, intentalo nuevamente', idToast);
            break;
        case 'IR':
            showToastDialog(true, 'Solicitud invalida, intentalo nuevamente', idToast);
            break;
        case 'ID':
            showToastDialog(true, 'No se pudo completar la acción por falta de datos', idToast);
            break;
        case 'SDE':
            showToastDialog(true, 'Uoops! ocurrio un error al guardar el registro', idToast);
            break;
        default:
            showToastDialog(true, 'Error desconocido', idToast);
            break;
    }
}

/**
 * @description Validar si el parametro es un numero
 * @param val {String|Number}
 * @return status {Boolean} True si es un número, false no lo es.
 **/
function isNummber(val) {
    let status = false;
    let expreg = /^([0-9])*$/;
    if (expreg.test(val)) status = true;
    return status;
}