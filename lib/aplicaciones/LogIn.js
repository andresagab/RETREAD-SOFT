var panamApp=angular.module('navegacion', ['ngMaterial']);

//console.log(document.location);

panamApp.constant('configuracionGlobal', {
    'nombreDelSitio': 'PANAM.sas',//Parametro que ccnfigura el nombre del sitio por defecto
    'scripts': document.location.origin + '/PANAM/system/scripts',//Configuracion de la carpeta de datos
    'templatesPrint': document.location.origin + '/PANAM/system/Print',
    'carpeta_imagenes': '/AngularJS/imagenes'//Configuracion de la ruta de la carpeta de imagenes
});

panamApp.directive('uploaderModel', ["$parse", function ($parse){
    return {
        restrict: 'A',
        link: function (scope, iElement, iAttrs){
            iElement.on("change", function (e){
               $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
            });
        }
    };
}]);