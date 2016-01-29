var app = angular.module('pfp',[]);

app.controller('showNotes', function($scope, $http) {
    $scope.ratingsToShow = [];
    
    $scope.showRatings = function(epnum) {
        $scope.ratingsToShow[epnum] = true;
    };
    
    $scope.canShowIt = function(show_epnum) {
        if ($scope.ratingsToShow.indexOf(show_epnum) > -1) {
            return true;
        } else {
            return false;
        }
    };
});