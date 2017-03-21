var app = angular.module('pfp',['ngRoute','ngSanitize']);

app.controller('showNotes', function($scope, $http, $route, $routeParams, $location) {
    $scope.tg_sean = 'eight'; // current count of Sean's Twin Galaxies world records

    $scope.patrons = [  'Rory Coleman',
                        'Michael D\'Angelo',
                        'Kyle Etter',
                        'Nathaniel Lockhart',
                        'Greg Polander',
                        'Jonas Rullo',
                        'Keith Sheehan',
                        'Underground Retrocade',
                        'Richard Valdez'
                    ];

    $scope.messageChars = 0;
    $scope.cemail = '';
    $scope.cname = '';
    $scope.ctellus = '';
    $scope.messageSent = false;
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
    $scope.aboutHosts = 'about';
    
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
    
    $scope.submitContact = function() {
        var errors = '';
        var misc_message = '';

        if ($scope.cname.length < 1) {
            errors += '\nWe need your e-mail address. (We won\'t share it with anyone!)';
        }
        if (!doesThisEmailAddressNotSuck($scope.cemail)) {
            errors += '\n\nThe e-mail address you provided isn\'t valid.';
        } else if ($scope.cemail.toLowerCase().indexOf('gmail.com') > 0 && $scope.cemail.indexOf('+') > 0) {
            misc_message += '\nAhhh, using a Gmail alias, eh? We see what you did there. :)';
        }
        if ($scope.ctellus.length < 25) {
            errors += '\n\nSurely you have SOMETHING to tell us!';
        }
        if (errors) {
            alert(errors);
            return false;
        }
        if (!errors && misc_message) {
            alert(misc_message);
        }
        
        $http({
            url: "index.php/levelzero/submitContact",
                method: "POST",
                headers: {'Content-Type' : 'application/x-www-form-urlencoded'},
                data: $.param( {
                    name: $scope.cname,
                    email: $scope.cemail,
                    tellus: $scope.ctellus
                })
        }).success(function(data, status, headers, config){
            $scope.data = data;
            $scope.messageSent = true;
        }).error(function(data, status, headers, config) {
            $scope.status = status;
            alert("Hmmm...sorry, there was a problem. Your feedback may not have been received.");
        });
    };
    
    $scope.getRatings = function() {
        $http.get('index.php/levelzero/get_ratings').success(
            function($data) {
                $scope.ratings = $data;
            }
        );
    };
    
    $scope.changeHost = function(talkerguy) {
        switch(talkerguy) {
            case 'jim':
                $scope.aboutHosts = 'jim';
                break;
            case 'sean':
                $scope.aboutHosts = 'sean';
                break;
            case 'credits':
                $scope.aboutHosts = 'credits';
                break;
            default:
                $scope.aboutHosts = 'about';
                break;
        }
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
    
    $scope.countCharacters = function() {
        $scope.messageChars = $scope.ctellus.length;
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
    };
    
    $scope.showShows = function() {
        $scope.getRatings();
    };
    
    $scope.snClick = function(link) {
        $scope.linkTitle = link === 'shownotes' ? 'show notes' : link;
    };
    
    $scope.scroll = function() {
        Scroll();
    };
    
    $scope.$watch(function() {
        return $location.path();
    }, function() {
        if ($location.path() === '/news') {
            $scope.linkTitle = 'Pie Factory Podcast News';
        } else {
            switch ($location.path().substr(1)) {
                case '':
                    $scope.linkTitle = 'Pie Factory Podcast News';
                    break;
                case 'shownotes':
                    $scope.linkTitle = 'show notes';
                    break;
                case 'aboutus':
                    $scope.linkTitle = 'about us';
                    break;
                case 'cactus':
                    $scope.linkTitle = 'contact us';
                    $scope.messageSent = false;
                    break;
                default:
                    $location.path().substr(1);
                    break;
            }
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
                }).when("/aboutus", {
                    controller: "showNotes",
                    templateUrl: "index.php/levelzero/aboutus"
                }).when("/cactus", {
                    controller: "showNotes",
                    templateUrl: "index.php/levelzero/cactus"
                }).otherwise({
                    redirectTo:"/"
                });
	}
]);

function doesThisEmailAddressNotSuck(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}