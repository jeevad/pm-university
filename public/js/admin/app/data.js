/*
 * AngularJS factory
 * Version: 1
 *
 * Copyright 2016 Janaagraha.  
 *
 * Author: Jeeva D <jeevananthamcse@gmail.com>
 * Related to project of Swachh Bharath
 */
app.factory("Data", ['$http', 'toaster', '$window',
    function ($http, toaster, $window) { // This service connects to our REST API


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
            return $http.post(serviceBase + q, object).then(function (response) {
                return response.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (response) {
                return response.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (response) {
                return response.data;
            });
        };

        return obj;
    }]);