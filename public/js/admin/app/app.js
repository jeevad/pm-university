'use strict';
/*!
 * AngularJS app
 * Version: 1
 *
 * Copyright 2016 Janaagraha.  
 *
 * Author: Jeeva D <jeevananthamcse@gmail.com>
 * Related to project of Swachh Bharath
 */
/** 
 * declare 'swach-app' module with dependencies
 */
angular.module("pm-app", [
    'ngAnimate',
    'ui.router',
    'ui.bootstrap',
    'oc.lazyLoad',
    'cfp.loadingBar',
    'toaster',
    'ngMaterial',
]);
// Declare app level module which depends on filters, and services
var app = angular.module('pmApp', ['pm-app']);
///* Set request header */
//app.config(['$httpProvider', function ($httpProvider) {
//        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//    }]);
app.config(['$interpolateProvider', function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  }]);

app.factory('BearerAuthInterceptor', function ($window, $q) {
    return {
        request: function (config) {
            config.headers = config.headers || {};
            if ($window.localStorage.getItem('token')) {
                // may also use sessionStorage
                config.headers.Authorization = 'Bearer ' + $window.localStorage.getItem('token');
            }
            return config || $q.when(config);
        },
        response: function (response) {
            return response || $q.when(response);
        },
        responseError: function (rejection) {
            // do something on error

            if (rejection.status == 401)  {
                //$rootScope.signOut();
                console.log(statusText);
            }

            return $q.reject(rejection);
        }
    };
});

// Register the previously created AuthInterceptor.
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push('BearerAuthInterceptor');

});
app.run(['$rootScope', '$state', '$stateParams', 'Data', '$window',
    function ($rootScope, $state, $stateParams, Data, $window) {

        // Set some reference to access them from any scope
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;

        // GLOBAL APP SCOPE
        // set below basic information
        $rootScope.app = {
            name: 'SBM', // name of your project
            author: 'Janaagraha', // author's name or company name
            description: 'Angular Bootstrap Admin Template', // brief description
            version: '2.0', // current version
            year: ((new Date()).getFullYear()), // automatic current year (for copyright information)
            isMobile: (function () {// true if the browser is a mobile device
                var check = false;
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    check = true;
                }
                ;
                return check;
            })(),
            layout: {
                isNavbarFixed: true, //true if you want to initialize the template with fixed header
                isSidebarFixed: true, // true if you want to initialize the template with fixed sidebar
                isSidebarClosed: false, // true if you want to initialize the template with closed sidebar
                isFooterFixed: false, // true if you want to initialize the template with fixed footer
                theme: 'theme-1', // indicate the theme chosen for your project
                logo: 'assets/images/logo.png', // relative path of the project logo
            }
        };

        $rootScope.user = {
            name: 'Peter',
            job: 'ng-Dev',
            picture: 'app/img/user/02.jpg'
        };

        $rootScope.$on("$stateChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            return;
            Data.get('Authenticate/check_session').then(function (results) {
                if (results.id) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.id;
                    $rootScope.name = results.full_name;
                    $rootScope.role_id = results.role_id;
                    //$location.path('dashboard');
                    //$state.go();
                } else {
                    //var nextUrl = next.$$route.originalPath;
                    //$state.go('login');
                    $window.location.href = '/login';
//                        if (nextUrl == '/signup' || nextUrl == '/login') {
//
//                        } else {
//                            //$location.path("/login");
//                            //$window.location.href = '/login';
//                            $state.go('login');
//                        }
                }
            });
        });

    }]);


