var app=angular.module('public-application',['ngResource']);

app.service('dataTransfer',['$http','$httpParamSerializer',function ($http,$httpParamSerializer) {
    this.post=function (url,data) {
        return $http({
            method: 'POST',
            url:url,
            data: $httpParamSerializer(data),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
    }
}])
app.controller('login',['$scope','$resource','dataTransfer',function($scope,$resource,dataTransfer){
    dataTransfer.post('/routers/login.php',{username:'hirosume',password:'cuong299'});
    $scope.checkloginAPI=$resource('/routers/islogin.php',{callback:"JSON_CALLBACK"});
    $scope.checkloginAPI.save().$promise.then(function (data) {
        $scope.username=data.username;
        $scope.islogin=data.login;
        $scope.avatar=data.avatar;
        console.log(data);
    });
}]);
