var app = angular.module('shop', []);
app.controller('dashboard', function($scope,$http){
    var url = document.querySelector('meta[property="categoryUrl"]')['content'];
       
    console.log(url);
        $scope.getCategories = function(){
            $http({
                method: 'GET',
                url: url
              }).then(function successCallback(response) {
                    console.log(response);
                });
        }
        $scope.getCategories();
});






