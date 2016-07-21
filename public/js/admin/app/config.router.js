'use strict';
/*!
 * Config for the router
 * Version: 1
 *
 * Copyright 2016 Janaagraha.  
 *
 * Author: Jeeva D <jeevananthamcse@gmail.com>
 * Related to project of Swachh Bharath
 */
app.config(['$stateProvider', '$urlRouterProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide', '$ocLazyLoadProvider', 'JS_REQUIRES',
    function ($stateProvider, $urlRouterProvider, $controllerProvider, $compileProvider, $filterProvider, $provide, $ocLazyLoadProvider, jsRequires) {

        app.controller = $controllerProvider.register;
        app.directive = $compileProvider.directive;
        app.filter = $filterProvider.register;
        app.factory = $provide.factory;
        app.service = $provide.service;
        app.constant = $provide.constant;
        app.value = $provide.value;

        // LAZY MODULES

        $ocLazyLoadProvider.config({
            debug: false,
            events: true,
            modules: jsRequires.modules
        });

        /*
         * APPLICATION ROUTES
         * -----------------------------------
         * For any unmatched url, redirect to /dashboard
         */
        $urlRouterProvider.otherwise("/dashboard");
        /* Set up the states */
        $stateProvider.state('app', {
            url: "/app",
            templateUrl: '/tpl/dashboard.html',
            //resolve: loadSequence('modernizr', 'moment', 'angularMoment', 'uiSwitch', 'perfect-scrollbar-plugin', 'toaster', 'ngAside', 'vAccordion', 'sweet-alert', 'chartjs', 'tc.chartjs', 'oitozero.ngSweetAlert', 'chatCtrl', 'truncate', 'htmlToPlaintext', 'angular-notification-icons'),
            // resolve: loadSequence('angular-notification-icons'),
            abstract: true
        })
                /* Topics routes */
                .state('topic', {
                    url: "/topic",
                    template: '<div  ui-view class="view" ></div>',
                    resolve: loadSequence('topicCtrl'),
                    abstract: true
                }).state('topic.list', {
            url: "/list",
            templateUrl: '/tpl/topics.html',
            //resolve: loadSequence('topicCtrl'),
            title: 'topics'
        }).state('topic.form', {
            url: "/form",
            templateUrl: '/tpl/topic-form.html',
            //resolve: loadSequence('spin', 'ladda', 'angular-ladda'),
            title: 'Topic Form'
        }).state('topic.edit', {
            url: "/edit/:id",
            templateUrl: '/employee/form/edit',
            title: 'Agency Form'
        })
                .state('dashboard', {
                    url: "/dashboard",
                    templateUrl: '/tpl/dashboard.html',
                    //resolve: loadSequence('chartJs','angular-chart','moment', 'daterangepicker', 'date-range-plugin','dashboardCtrl'),
                    title: 'Dashboard'
                }).state('topics', {
            url: "/topics",
            templateUrl: '/tpl/topics.html',
            resolve: loadSequence('topicCtrl'),
            title: 'topics'
        }).state('form', {
            url: "/form",
            templateUrl: '/tpl/form-examples.html',
            //resolve: loadSequence('chartJs','angular-chart','moment', 'daterangepicker', 'date-range-plugin','dashboardCtrl'),
            title: 'Dashboard'
        }).state('table', {
            url: "/table",
            templateUrl: '/tpl/tables.html',
            //resolve: loadSequence('chartJs','angular-chart','moment', 'daterangepicker', 'date-range-plugin','dashboardCtrl'),
            title: 'Dashboard'
        }).state('content', {
            url: "/content",
            templateUrl: '/tpl/components.html',
            //resolve: loadSequence('chartJs','angular-chart','moment', 'daterangepicker', 'date-range-plugin','dashboardCtrl'),
            title: 'Dashboard'
        }).state('list', {
            url: "/list",
            templateUrl: '/tpl/list-view.html',
            //resolve: loadSequence('chartJs','angular-chart','moment', 'daterangepicker', 'date-range-plugin','dashboardCtrl'),
            title: 'Dashboard'
        }).state('category-dashboard', {
            url: "/category-dashboard",
            templateUrl: '/Authenticate/category_dashboard',
            resolve: loadSequence('chartJs', 'angular-chart', 'moment', 'daterangepicker', 'sparklinJs', 'categoryDashboardCtrl'),
            title: 'Category Dashboard'
        }).state('profile', {
            url: "/profile",
            templateUrl: '/tpl/profile-about.html',
            title: 'Add Categories'
        }).state('welcome', {
            url: "/welcome",
            templateUrl: '/Page/welcome',
            title: 'Add Categories'
        }).state('thankyou', {
            url: "/thankyou",
            templateUrl: '/Page/thankyou',
            title: 'Add Categories'
        }).state('addcategories', {
            url: "/addcategories",
            templateUrl: '/Page/addcategories',
            resolve: loadSequence('angular-ladda', 'onBoardFlowCtrl'),
            title: 'Add Categories'
        }).state('error', {
            url: '/error',
            template: '<div ui-view class="fade-in-up"></div>'
        }).state('error.404', {
            url: '/404',
            templateUrl: "assets/views/utility_404.html",
        }).state('error.500', {
            url: '/500',
            templateUrl: "assets/views/utility_500.html",
        })

                /* employee routes */
                .state('employee', {
                    url: "/employee",
                    template: '<div ui-view class="fade-in-right-big smooth" ></div>',
                    resolve: loadSequence('empCtrl'),
                    abstract: true
                }).state('employee.list', {
            url: "/list",
            templateUrl: '/employee/employee_list',
            title: 'Agency'
        }).state('employee.form', {
            url: "/form",
            templateUrl: '/employee/form',
            resolve: loadSequence('spin', 'ladda', 'angular-ladda'),
            title: 'Agency List'
        }).state('employee.edit', {
            url: "/edit/:id",
            templateUrl: '/employee/form/edit',
            title: 'Agency Form'
        })
                /* Complaint routes */
                .state('complaint', {
                    url: "/complaint",
                    template: '<div ui-view class="fade-in-right-big smooth" ></div>',
                    resolve: loadSequence('spin', 'ladda', 'angular-ladda', 'moment', 'daterangepicker', 'date-range-plugin', 'complaintCtrl'),
                    abstract: true
                }).state('complaint.list', {
            url: "/list",
            templateUrl: '/complaint/complaint_list',
            title: 'Complaints List'
        }).state('complaint.escalations', {
            url: "/escalations",
            templateUrl: '/complaint/escalation_list',
            title: 'Complaints List'
        }).state('complaint.approval', {
            url: "/approval",
            templateUrl: '/complaint/approval_list',
            title: 'Complaints List'
        }).state('complaint.rejectedlist', {
            url: "/rejectedlist",
            templateUrl: '/complaint/rejected_list',
            title: 'Complaints List'
        }).state('complaint.duplications', {
            url: "/duplications",
            templateUrl: '/complaint/duplication_list',
            title: 'Complaints List'
        }).state('complaint.map', {
            url: "/map",
            templateUrl: '/complaint/complaint_map',
            resolve: loadSequence('mapLib', 'compMapCtrl'),
            title: 'Complaints Map'
        }).state('complaint.details', {
            url: "/details/:id",
            templateUrl: '/complaint/details',
            resolve: loadSequence('mapLib', 'compDetailsCtrl'),
            title: 'Complaint Details'
        })
                //engineer route
                // employee routes
                .state('user', {
                    url: "/user",
                    //templateUrl: '/Authenticate/dashboard',
                    template: '<div ui-view class="fade-in-right-big smooth" ></div>',
                    resolve: loadSequence('userCtrl'),
                    abstract: true
                }).state('user.list', {
            url: "/list",
            templateUrl: '/user/user_list',
            //resolve: loadSequence('empCtrl'),
            title: 'Engineer'
        }).state('user.form', {
            url: "/form",
            templateUrl: '/user/form',
            //resolve: loadSequence('empCtrl'),
            title: 'Engineer'
        }).state('user.edit', {
            url: "/edit/:id",
            templateUrl: '/user/form/edit',
            //resolve: loadSequence('empCtrl'),
            title: 'engineer'
        })

                /* Login routes */

                .state('login', {
                    url: '/login',
                    templateUrl: '/Authenticate/login_tpl',
                    resolve: loadSequence('authCtrl'),
                    title: 'Login'
                }).state('login.signin', {
            url: '/signin',
            templateUrl: "assets/views/login_login.html"
        }).state('login.forgot', {
            url: '/forgot',
            templateUrl: "assets/views/login_forgot.html"
        }).state('login.registration', {
            url: '/registration',
            templateUrl: "assets/views/login_registration.html"
        }).state('login.lockscreen', {
            url: '/lock',
            templateUrl: "assets/views/login_lock_screen.html"
        });

        /* Generates a resolve object previously configured in constant.JS_REQUIRES (config.constant.js) */
        function loadSequence() {
            var _args = arguments;
            return {
                deps: ['$ocLazyLoad', '$q',
                    function ($ocLL, $q) {
                        var promise = $q.when(1);
                        for (var i = 0, len = _args.length; i < len; i++) {
                            promise = promiseThen(_args[i]);
                        }
                        return promise;
                        function promiseThen(_arg) {
                            if (typeof _arg == 'function')
                                return promise.then(_arg);
                            else
                                return promise.then(function () {
                                    var nowLoad = requiredData(_arg);
                                    if (!nowLoad)
                                        return $.error('Route resolve: Bad resource name [' + _arg + ']');
                                    return $ocLL.load(nowLoad);
                                });
                        }

                        function requiredData(name) {
                            if (jsRequires.modules)
                                for (var m in jsRequires.modules)
                                    if (jsRequires.modules[m].name && jsRequires.modules[m].name === name)
                                        return jsRequires.modules[m];
                            return jsRequires.scripts && jsRequires.scripts[name];
                        }
                    }]
            };
        }
    }]);