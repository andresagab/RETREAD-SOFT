panamApp.factory('Exel', function ($window) {
    var uri='data:application/vnd.ms-excel;base64,',
        template='' +
            '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">' +
                '<head>' +
                '<!--[if gte mso 9]>' +
                '<xml>' +
                    '<x:ExcelWorkbook>' +
                        '<x:ExcelWorksheets>' +
                            '<x:ExcelWorksheet>' +
                                '<x:Name>{worksheet}</x:Name>' +
                                '<x:WorksheetOptions>' +
                                    '<x:DisplayGridlines/>' +
                                '</x:WorksheetOptions>' +
                    '       </x:ExcelWorksheet>' +
                    '   </x:ExcelWorksheets>' +
                    '</x:ExcelWorkbook>' +
                '</xml>' +
                '<![endif]-->' +
                '</head>' +
                '<body>' +
                    '<table border="1">{tableContent}</table>' +
                '</body>' +
            '</html>',
        base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
        format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
    return {
        tableToExcel:function( tableContentId, worksheetName, fileName){
            var tableContent=$(tableContentId),
                ctx={worksheet:worksheetName,tableContent:tableContent.html()};
                //href=uri+base64(format(template,ctx));
            var file = document.createElement('a');
            if (fileName==null) fileName='archivo' + newDate().getFullYear() + '-' + (newDate().getMonth() + 1) + '-' + newDate().getDate();
            file.download=fileName + '.xls';
            file.href=uri+base64(format(template,ctx));
            file.click();
        }
    };

}).controller('ExelController', function (Exel, $scope) {

    $scope.exportExel = function (idTableContent, fileName) {
        $scope.exportHref=Exel.tableToExcel(idTableContent, 'Bodega', fileName);
    }

});