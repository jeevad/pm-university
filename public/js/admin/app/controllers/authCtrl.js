/*!
 * AngularJS controllers
 * Version: 1
 *
 * Copyright 2016 Janaagraha.  
 *
 * Author: Jeeva D <jeevananthamcse@gmail.com>
 * Related to project of Swachh Bharath
 */
//app.controller('AppCtrl', function ($scope, $location, $http, Data, $window) {
//    
//});
//var app = angular.module('myApp', []);
var app = angular.module('myApp', [], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
app.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }]);
app.controller('authCtrl', function ($scope, $location, $http, $window) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.mobile_number = '';
    $scope.doLogin = function (user) {
        if ($scope.loginForm.$invalid) {
            return false;
        }
        var config = {
            headers: {
                'Content-Type': 'application/json'
            }
        }

        $http.post('auth/login', {
            user: user
        }, config).success(function (results) {
            statusCode = results.httpCode;
            console.log(results);
            if (statusCode === 200) {
                console.log('fksdjkdfjs');
                $window.location.href = globalConfig.siteURL + 'page#/dashboard';
            }
            else if (statusCode === 500) {
                $scope.invalid_login = results.message;
            }
            else {
                $scope.invalid_login = results.message;
            }

        });
    };
    $scope.engLogin = function (user) {
        $scope.mobile_number = user.mobile;
        $http.defaults.headers.post[globalConfig.csrf_token_name] = getCookie(globalConfig.csrf_cookie_name);
        $http.post('Authenticate/ajax_engineer_login', {
            user: user
        }).success(function (results) {
            console.log(results);
            if (results.status == "success") {
                $('#loginModal').modal('hide');
                $scope.userId = results.user_id;
                $('#modalEngineerLogin').modal('show');
            } else if (results.status == "error") {
                $scope.invalid_login = results.message;
            }
        });
    };
    $scope.otpResend = function (mobile, userId) {
        $http.defaults.headers.post[globalConfig.csrf_token_name] = getCookie(globalConfig.csrf_cookie_name);
        $http.post('Authenticate/otp_resend', {number: mobile, user: userId}).success(function (results) {
            if (results.status == "success") {

            }
        });
    }
    $scope.otpVerification = function (otp, user) {
        $http.defaults.headers.post[globalConfig.csrf_token_name] = getCookie(globalConfig.csrf_cookie_name);
        $http.post('Authenticate/engineer_login', {otp: otp, userId: user}).success(function (results) {
            if (results.status == "success") {
                $window.location.href = globalConfig.siteURL + results.redirect + '#/dashboard';
            } else if (results.status == "error") {
                console.log(results.message);
                $scope.invalid_otp = results.message;
            }
        });
    }
});

app.controller('navCtrl', function ($scope, Data, $window) {
    $scope.logout = function () {
        Data.get('Authenticate/logout').then(function (results) {
            Data.toast(results);
            $window.location.href = '/login';
        });
    }
});
