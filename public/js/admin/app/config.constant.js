'use strict';

/**
 * Config constant
 */
app.constant('APP_MEDIAQUERY', {
    'desktopXL': 1200,
    'desktop': 992,
    'tablet': 768,
    'mobile': 480
});
app.constant('JS_REQUIRES', {
    //*** Scripts
    scripts: {
        //*** Javascript Plugins
        //'modernizr': ['../bower_components/components-modernizr/modernizr.js'],
        //'moment': ['../bower_components/moment/min/moment.min.js'],
        'moment': ['https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js'],
        
        'spin': '/lib/spin.min.js',

        //*** jQuery Plugins
        'mapLib': 'http://maps.googleapis.com/maps/api/js?key= AIzaSyBJ6nF9Tg7yOPE_W_s5-8SXffyA4rkS4Lk&sensor=false&libraries=places&extension=.js',
        //'mapLibDetails': 'http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false',        
        'date-range-plugin': ['https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.13/daterangepicker.min.js','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.13/daterangepicker.min.css'],
        //'morris-plugin': ['https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js','//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js'],
        'chartJs': ['/assets/lib/Chart.min.js'],
        'ladda': ['/lib/ladda.min.js', '/css/ladda-themeless.min.css'],
        
        'ckeditor-plugin': '../bower_components/ckeditor/ckeditor.js',
        'touchspin-plugin': ['../bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js', '../bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css'],
        'sparklinJs': ['/assets/plugins/jquery.sparkline.min.js'],
        

        //*** Controllers
        'topicCtrl': '/js/admin/app/controllers/topicCtrl.js',
        
        'authCtrl': '/assets/js/app/controllers/authCtrl.js',
        'dashboardCtrl': '/assets/js/app/controllers/dashboardCtrl.js',
        'empCtrl': '/assets/js/app/controllers/empCtrl.js',
        'complaintCtrl': '/assets/js/app/controllers/complaintCtrl.js',
        'compMapCtrl': '/assets/js/app/controllers/compMapCtrl.js',
        'userCtrl': '/assets/js/app/controllers/userCtrl.js',
        'compDetailsCtrl': '/assets/js/app/controllers/compDetailsCtrl.js',
        'onBoardFlowCtrl': '/assets/js/app/controllers/onBoardFlowCtrl.js',
        'categoryDashboardCtrl': '/assets/js/app/controllers/categoryDashboardCtrl.js',
        //*** Filters
        'htmlToPlaintext': 'assets/js/filters/htmlToPlaintext.js'
    },
    //*** angularJS Modules
    modules: [ {
        name: 'daterangepicker',
        files: ['/assets/lib/angular-daterangepicker.min.js']
    },{
        name: 'googleapis',
        files: ['http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false']
    }, {
        name: 'angular-morris-chart',
        files: ['//cdnjs.cloudflare.com/ajax/libs/angular-morris-chart/1.2.0/angular-morris-chart.min.js']
    }, {
        name: 'angular-chart',
        files: ['/assets/lib/angular-chart.min.js', '/assets/css/angular-chart.min.css']
    }, {
        name: 'angular-ladda',
        files: ['/lib/angular-ladda.min.js']
    }, {
        name: 'ngTable',
        files: ['../bower_components/ng-table/dist/ng-table.min.js', '../bower_components/ng-table/dist/ng-table.min.css']
    }, {
        name: 'ui.select',
        files: ['../bower_components/angular-ui-select/dist/select.min.js', '../bower_components/angular-ui-select/dist/select.min.css', '../bower_components/select2/dist/css/select2.min.css', '../bower_components/select2-bootstrap-css/select2-bootstrap.min.css', '../bower_components/selectize/dist/css/selectize.bootstrap3.css']
    }, {
        name: 'ui.mask',
        files: ['../bower_components/angular-ui-utils/mask.min.js']
    }, {
        name: 'ngImgCrop',
        files: ['../bower_components/ngImgCrop/compile/minified/ng-img-crop.js', '../bower_components/ngImgCrop/compile/minified/ng-img-crop.css']
    }, {
        name: 'angularFileUpload',
        files: ['../bower_components/angular-file-upload/angular-file-upload.min.js']
    }, {
        name: 'ngAside',
        files: ['../bower_components/angular-aside/dist/js/angular-aside.min.js', '../bower_components/angular-aside/dist/css/angular-aside.min.css']
    }, {
        name: 'truncate',
        files: ['../bower_components/angular-truncate/src/truncate.js']
    }, {
        name: 'ngMap',
        files: ['../bower_components/ngmap/build/scripts/ng-map.min.js']
    }, {
        name: 'ckeditor',
        files: ['../bower_components/angular-ckeditor/angular-ckeditor.min.js']
    }, {
        name: 'ng-nestable',
        files: ['../bower_components/ng-nestable/src/angular-nestable.js']
    }, {
        name: 'xeditable',
        files: ['../bower_components/angular-xeditable/dist/js/xeditable.min.js', '../bower_components/angular-xeditable/dist/css/xeditable.css', 'assets/js/config/config-xeditable.js']
    }]
});
