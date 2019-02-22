/* 
 * 
 * @author : ANDRES GEOVANNY ANGULO BOTINA
 * 
 * Este script contiene funciones que permiten generan la presentacion de una 
 * notificacion de tipo toast en el sistema de informacion, la presentacion de
 * la misma se hace de acuerdo al id del elemento (div) html.
 * 
 */
function showToast(_valido, _mjs){
    if (_valido){
        'use strict';
        var snackbarContainer = document.querySelector('#toast-content');
        snackbarContainer.MaterialSnackbar.showSnackbar({
            message: _mjs
        });
    }
}

function showToastPrincipal(_valido, _mjs){
    if (_valido){
        'use strict';
        var snackbarContainer = document.querySelector('#toast-principal');
        snackbarContainer.MaterialSnackbar.showSnackbar({
            message: _mjs
        });
    }
}

function showToastDialog(_valido, _mjs, _IdElemento){
    if (_valido){
        'use strict';
        var snackbarContainer = document.querySelector('#' + _IdElemento);
        snackbarContainer.MaterialSnackbar.showSnackbar({
            message: _mjs
        });
    }
}


