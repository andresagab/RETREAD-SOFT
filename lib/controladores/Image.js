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
panamApp.controller('images', function ($scope, $timeout){
    $scope.thumbnail={
        dataURL: ''
    };
    
    $scope.fileReaderSupported= window.FileReader!=null;
    
    $scope.photoChanged=function(files){
        if (files!=null){
            var file=files[0];
            if ($scope.fileReaderSupported && file.type.indexOf('image') > -1){
                $timeout(function (){
                    var fileReader= new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.onload= function (e){
                        $timeout(function (){
                            $scope.thumbnail.dataURL= e.target.result;
                            $scope.foto=true;
                        })
                    }
                })
            }
        }
    }
    
    $scope.deleteImg=function (){
        $scope.foto=null;
        console.log($scope.thumbnail);
        $("#foto").val(null);
        //Pendiente borrar archivo del input file
    }
    
})