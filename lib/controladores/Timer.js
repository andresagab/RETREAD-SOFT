/*
 *
 * Todos los derechos de este archivo pertenecen a PANAM.SAS colombia y a el desarrollador de del mismo.
 * Este archivo fue desarrollado por Andres Geovanny Angulo Botina
 * Para mayor informacion redactar un mensaje a: andrescabj981@gmail.com - - Cell: +573128293384
 * o llamar directamente al (+57) 3128293384
 *
 */
 
 /** 
 * Descripcion del archivo Image.js
 * 
 * En este archivo se podra encontrar las funciones relacionadas a los archivos de tipo imagen,
 * ya sea para cargar, subir o presentar una imagen en tiempo real
 * 
 * @author Andres Geovanny Angulo Botina <Sugerencias a andrescabj981@gmail.com>
 *
 */
panamApp.controller('timer', function ($scope, $timeout, $http, configuracionGlobal){
    
    $scope.time={
        tiempoInicial: '',
        timeTotal: ''
    }
    
    $scope.startTimer=function (_IdPuestoTrabajo){
        //setInterval(function (){
            $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getDiffTiempoInsumoPT&idPuestoTrabajo="+_IdPuestoTrabajo)
            .then(function (responsive){
                //console.log(responsive);
                $scope.tiempo=responsive.data;
            })
        //}, 1000);
    }
    
})