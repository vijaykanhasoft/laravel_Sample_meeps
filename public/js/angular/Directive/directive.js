app.directive('focusMe', function ($timeout, $parse) {
    return {
        link: function (scope, element, attrs) {
            var model = $parse(attrs.focusMe);
            scope.$watch(model, function (value) {
                if (value === true) {
                    $timeout(function () {
                        element[0].focus();
                    });
                }
            });
            element.bind('blur', function () {
                scope.$apply(model.assign(scope, false));
            })
        }
    };
});

app.directive('header', function ($templateRequest, $compile) {
    return {
        restrict: 'A',
        controller: 'frontCtrl',
        templateUrl: function (element, attrs) {
            return "resources/views/header.html";
        }
    }
});

app.directive('sidebar', function () {
    return {
        restrict: 'A', //This menas that it will be used as an attribute and NOT as an element. I don't like creating custom HTML elements
        templateUrl: function (element, attrs) {
            return "resources/views/sidebar.html";
        }
    }
});

app.directive('footer', function () {
    return {
        restrict: 'A', //This menas that it will be used as an attribute and NOT as an element. I don't like creating custom HTML elements
        templateUrl: function (element, attrs) {
            return "resources/views/footer.html";
        }
    }
});
app.directive('loader', ['$http', function ($http) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                scope.loader = function () {
                    if ($http.pendingRequests[0] != undefined && ($http.pendingRequests[0].url.indexOf("save-invoice") != -1 || $http.pendingRequests[0].url.indexOf("import-invoice.html") != -1)) {
                        return false;
                    }
                    return $http.pendingRequests.length > 0;
                };
                scope.$watch(scope.loader, function (value) {
                    if (value) {
                        element.removeClass('ng-hide');
                    } else {
                        element.addClass('ng-hide');
                    }
                });
            }
        };
    }]);
app.directive('ngConfirmClick', [
    function () {
        return {
            link: function (scope, element, attr) {
                var msg = attr.ngConfirmClick || "Are you sure?";
                var clickAction = attr.confirmedClick;
                element.bind('click', function (event) {
                    if (window.confirm(msg)) {
                        scope.$eval(clickAction)
                    }
                });
            }
        };
    }]);
