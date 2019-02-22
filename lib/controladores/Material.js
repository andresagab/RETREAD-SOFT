panamApp.controller('angular_material', themeController, inputController)
        .config(function ($mdThemingProvider) {
            $mdThemingProvider.theme('customTheme')
            .primaryPalette('grey')
            .accentPalette('orange')
            .warnPalette('red');
    
});

function themeController($scope) {
    
}

function inputController($scope) {
    $scope.project={
        comments: 'Comments'
    };
}