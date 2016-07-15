/*
 * AngularJS factory
 * Version: 1
 *
 * Copyright 2016 Janaagraha.  
 *
 * Author: Jeeva D <jeevananthamcse@gmail.com>
 * Related to project of Swachh Bharath
 */
app.factory("Data", ['$http', 'toaster','$window',
    function ($http, toaster,$window) { // This service connects to our REST API
        	

        var serviceBase = globalConfig.siteURL;
        
        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        }
        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            $http.defaults.headers.post[globalConfig.csrf_token_name] = getCookie(globalConfig.csrf_cookie_name);
            return $http.post(serviceBase + q, object).then(function (results) {
                if(results.status == 'error' && results.message == '') {
                    $window.location.href = '/login';
                }
                return results.data;
            });
        };
        obj.put = function (q, object) {
            $http.defaults.headers.post[globalConfig.csrf_token_name] = getCookie(globalConfig.csrf_cookie_name);
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            $http.defaults.headers.post[globalConfig.csrf_token_name] = getCookie(globalConfig.csrf_cookie_name);
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);