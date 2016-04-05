var app = angular.module('pfp',['ngRoute','ngSanitize']);

app.controller('showNotes', function($scope, $http, $route, $routeParams, $location) {
    $scope.ratingsToShow = [];
    $scope.clickedLink = '';
    $scope.linkTitle = 'Pie Factory Podcast News';
    $scope.shows = [];
    $scope.news = [];
    $scope.rangeStart = 0;
    $scope.rangeEnd = 10;
    $scope.displayPerPage = 10;
    $scope.returnedShows = [];
    $scope.page = [];
    $scope.pageNews = [];
    $scope.show_story = [];
    $scope.numberOfPages = 0;
    $scope.numberOfNewsPages = 0;
    $scope.currentPage = 0;
    $scope.currentNewsPage = 0;
    $scope.displayNotes = false;
    $scope.displayIndex = 0;
    $scope.displayCurrent = 0;
    $scope.hideMe = false;
    $scope.show_news = [];
    $scope.lastNewsPopped = 0;
    
    // retrieve news upon load
    $http.get('index.php/levelzero/get_news').success(
        function($data) {
            $scope.news = $data.news;
            $scope.totalNews = $scope.news.length;
            $scope.numberOfNewsPages = Math.ceil($scope.news.length / $scope.displayPerPage);

            for (var x = 0; x < $scope.numberOfNewsPages; x++) {
                $scope.pageNews[x] = [];
                for (var y = 0; y < $scope.displayPerPage; y++) {
                    if ($scope.news[(x*$scope.displayPerPage+y)]) {
                        $scope.pageNews[x][y] = $scope.news[(x*$scope.displayPerPage+y)];
                    } else {
                        break;
                    }
                }
            }
        }
    );

    // retrieve show notes upon load
    $http.get('index.php/levelzero/get_show_notes').success(
        function($data) { 
            $scope.shows = $data.episode; 
            $scope.totalShows = $scope.shows.length;
            $scope.numberOfPages = Math.ceil($scope.shows.length / $scope.displayPerPage);
            
            for (var x = 0; x < $scope.numberOfPages; x++) {
                $scope.page[x] = [];
                for (var y = 0; y < $scope.displayPerPage; y++) {
                    if ($scope.shows[(x*$scope.displayPerPage+y)]) {
                        $scope.page[x][y] = $scope.shows[(x*$scope.displayPerPage+y)];
                    } else {
                        break;
                    }
                }
            }
        }
    );
    
    $scope.getRatings = function() {
        $http.get('index.php/levelzero/get_ratings').success(
            function($data) {
                $scope.ratings = $data;
            }
        );
    };
    
    $scope.incrementPage = function () { $scope.currentPage++; };        
    $scope.decrementPage = function () { $scope.currentPage--; };
    $scope.incrementNewsPage = function () { $scope.currentNewsPage++; };        
    $scope.decrementNewsPage = function () { $scope.currentNewsPage--; };

    $scope.showRatings = function(epnum) {
        $scope.hideMe = true;
        $scope.ratingsToShow[epnum] = true;
    };
    
    $scope.canShowIt = function(show_epnum) {
        if ($scope.ratingsToShow.indexOf(show_epnum) > -1) {
            return true;
        } else {
            return false;
        }
    };
    
    $scope.newsPop = function(idx) {
        if (!$scope.show_story[idx]) {
            $scope.show_story[idx] = true;
            $scope.show_news[$scope.lastNewsPopped] = false;
            $scope.show_news[idx] = true;
            $scope.lastNewsPopped = idx;
        } else {
            $scope.show_story[idx] = false;
            $scope.show_news[idx] = false;
        }
    };
    
    $scope.showNotesPop = function(idx) {
        $scope.hideMe = false;
        $scope.displayIndex = idx;
        $scope.displayNotes = true;
        $scope.displayCurrent = $scope.page[$scope.currentPage][idx];
        console.log("displayCurreent:");
        console.dir($scope.displayCurrent);
    };
    
    $scope.showShows = function() {
        $scope.getRatings();
    };
    
    $scope.snClick = function(link) {
        $scope.linkTitle = link === 'shownotes' ? 'show notes' : link;
    };
    
    $scope.$watch(function() {
        return $location.path();
    }, function() {
        if ($location.path() === '/news') {
            $scope.linkTitle = 'Pie Factory Podcast News';
        } else {
            var locpath = $location.path().substr(1);
            $scope.linkTitle = locpath === 'shownotes' ? 'show notes' : locpath;
        }
        if ($scope.linkTitle == '') {
            $scope.linkTitle = 'Pie Factory Podcast News';
        }
    });
});


app.config(["$routeProvider",
	function($routeProvider) {
             $routeProvider.
                when("/home", {
                    controller: "showNotes",
                    templateUrl: "index.php/levelzero/news"
                }).when("/", {
                    controller: "showNotes",
                    templateUrl: "index.php/levelzero/news"
                }).when("/shownotes", {
                    controller: "showNotes",
                    templateUrl: "index.php/levelzero/show_notes"
                }).when("/news", {
                    controller: "showNotes",
                    templateUrl: "index.php/levelzero/news"
                }).otherwise({
                    redirectTo:"/"
                });
	}
]);
