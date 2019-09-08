panamApp.controller('maskPaginator', function ($scope) {

    $scope.generalElements = {
        notifyInSettings: false
    };

    $scope.elementsPaginator = {
        previousPage: true,
        nextPage: true,
        availableRecordsForPage: [5, 10, 25, 50, 75, 100],
        recordsForPage: 25,
        totalRecords: 0,
        pages: 1,
        currentPage: 1,
        initialRecord: 0,
        finalRecord: 0,
        cacheObjects: {}
    };

    //PAGINATOR

    $scope.initValues=function (data) {
        if (data!=null) $scope.elementsPaginator.cacheObjects=data;
        if ($scope.elementsPaginator.cacheObjects!=null){
            $scope.elementsPaginator.totalRecords=$scope.elementsPaginator.cacheObjects.length;
            $scope.elementsPaginator.pages=$scope.getPages();
            $scope.elementsPaginator.initialRecord=$scope.getInitialRecord();
            $scope.elementsPaginator.finalRecord=$scope.getFinalRecord();
        } else {
            $scope.elementsPaginator.totalRecords=0;
            $scope.elementsPaginator.pages=1;
            $scope.elementsPaginator.initialRecord=0;
            $scope.elementsPaginator.finalRecord=0;
        }
    };

    $scope.getPages=function () {
        if ($scope.elementsPaginator!=null && $scope.elementsPaginator.cacheObjects!=null) return Math.ceil($scope.elementsPaginator.totalRecords/$scope.elementsPaginator.recordsForPage);
        else return 1;
    };

    $scope.getInitialRecord=function () {
        if ($scope.elementsPaginator!=null && $scope.elementsPaginator.cacheObjects!=null) return (($scope.elementsPaginator.currentPage*$scope.elementsPaginator.recordsForPage)-($scope.elementsPaginator.recordsForPage-1));
        else return 1;
    };

    $scope.getFinalRecord=function () {
        if ($scope.elementsPaginator!=null && $scope.elementsPaginator.cacheObjects!=null) return ($scope.elementsPaginator.currentPage*$scope.elementsPaginator.recordsForPage);
        else return null;
    };

    $scope.setCurrentPage=function (_accion) {
        if (_accion!=null){
            if (_accion) $scope.elementsPaginator.currentPage++;
            else $scope.elementsPaginator.currentPage--;
            $scope.elementsPaginator.initialRecord=$scope.getInitialRecord();
            $scope.elementsPaginator.finalRecord=$scope.getFinalRecord();
        } else $scope.elementsPaginator.currentPage=1;
        if ($scope.elementsPaginator.currentPage==1){
            $scope.elementsPaginator.previousPage=true;
        }
        if ($scope.elementsPaginator.pages>1) {
            $scope.elementsPaginator.nextPage=false;
            if ($scope.elementsPaginator.pages==$scope.elementsPaginator.currentPage) {
                $scope.elementsPaginator.nextPage=true;
                $scope.elementsPaginator.previousPage=false;
            } else {
                if ($scope.elementsPaginator.currentPage>1) $scope.elementsPaginator.previousPage=false;
            }
        } else $scope.elementsPaginator.nextPage=true;
    }

    $scope.setRecordsPage=function (value) {
        if (value!=null){
            $scope.elementsPaginator.recordsForPage=value;
            $scope.setCurrentPage(null);
            $scope.initValues(null);
            $scope.setCurrentPage(null);
        }
    };

    //END PAGINATOR

});