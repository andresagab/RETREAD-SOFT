'use strict';
panamApp.factory('LlantasFactory', function ($http, configuracionGlobal) {

    var url = configuracionGlobal.scripts;

    var LlantasFactory = {
        getData: function (file) {
            return $http.get(url + '/' + file, {responseType: 'json'}).then(function (r) {
                return r;
            }).then(function (r) {
                return r;
            });
        },
        getDirectSearch: function (file, data) {
            return $http.post(url + '/' + file, data, {responseType: 'json'}).then(function (r) {
                return r;
            }).then(function (r) {
                return r;
            });
        }
    };

    return LlantasFactory;

});