var PageApp = angular.module('PageApp', []);
PageApp.controller('SecondCtrl', ['$http',function($http){
        var list = this;
        list.tracks = [];
        $http.get('/_application/json/RequestList.php?listMethod=favorites ').success(function(data){
        list.tracks = data;
        });   
    }]);