/*!
 * AngularJS complaint controllers
 * Version: 1
 *
 * Copyright 2016 Janaagraha.  
 *
 * Author: Jeeva D <jeevananthamcse@gmail.com>
 * Related to project of PM University
 */
app.controller('topicCtrl', function ($scope, Data, $uibModal) {
    $scope.topics = [];
    $scope.loading = false;

    /* pagination settings */
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.itemsPerPage = 10;
    $scope.maxSize = 5;
    $scope.filterTitle = 'All Complaints';

    /* for sorting */
    $scope.state = 'DESC';
    $scope.orderby = 'id';
    getResultsPage();
    function getResultsPage() {
        $scope.loading = true;
        var url = '/api/v1/admin/1/topics?api_token=032FF917-8F9F-7907-E9F9-5DCC1374E38A&locale=en&perPage=' + $scope.itemsPerPage + '&page=' + $scope.currentPage;
        //var url = '/api/v1/admin/1/topics?locale=en&perPage='+$scope.itemsPerPage+'&page='+$scope.currentPage;
        //Data.post('complaint/lists/' + $scope.itemsPerPage + '/' + $scope.currentPage + '/' + $scope.orderby + '/' + $scope.state,
        Data.get(url, {filters: ''}).then(function (response) {
            $scope.loading = false;
            $scope.topics = response.data.topics;
            //console.log(response.data.topics);
            $scope.totalItems = response.data.total;
        });
    }
});
app.controller('compListCtrl', function ($scope, Data, $uibModal, $filter) {
    $scope.complaints = [];
    $scope.loading = false;
    $scope.checkedAny = false;
    /* pagination settings */
    $scope.totalItems = 0;
    $scope.currentPage = 1;
    $scope.itemsPerPage = 10;
    $scope.maxSize = 5;
    $scope.filterTitle = 'All Complaints';
    /* Status defaults */
    $scope.statusOpen = 0;
    $scope.statusOnthejob = 0;
    $scope.statusResolved = 0;
    /* for sorting */
    $scope.state = 'DESC';
    $scope.orderby = 'id';
    $scope.filter = {city: '', status: '', category: '', ward: '', term: '', priority: ''};
    /*set page*/
    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };
    /*on page change*/
    $scope.pageChanged = function () {
        getResultsPage();
    };
    /* pagination settings */
    /* Check all */
    $scope.toggleAll = function () {
        var toggleStatus = $scope.isAllSelected;
        angular.forEach($scope.complaints, function (itm) {
            itm.cChecked = toggleStatus;
            //$scope.checkedAny = toggleStatus;
        });
    };
    /* Check each check box */
    $scope.optionToggled = function () {
        $scope.isAllSelected = $scope.complaints.every(function (itm) {
            return itm.cChecked;
        });
    };

    $scope.$watch("complaints", function (n, o) {
        var trues = $filter("filter")(n, {cChecked: true});
        $scope.checkedAny = (trues.length) ? true : false;
    }, true);
    /***Date range***/
    $scope.day = 1;
    $scope.date = {
        startDate: moment().subtract($scope.day, "days"),
        endDate: moment()
    };
    $scope.setRange = function (day) {
        $scope.day = day;
        $scope.date = {
            startDate: moment().subtract(day, "days"),
            endDate: moment()
        };
    };

    //Watch for date changes
    $scope.$watch('date', function (newDate) {
        $scope.filter.startDate = newDate.startDate.format('YYYY-MM-DD');
        $scope.filter.endDate = newDate.endDate.format('YYYY-MM-DD');

        var days = Math.round((newDate.endDate - newDate.startDate) / 86400000);
        //console.log('days='+days);

        if ((newDate.endDate.format('YYYY-MM-DD') == moment().format('YYYY-MM-DD')) && (days == 7 || days == 30 || days == 1)) {
            $scope.day = days;
        } else {
            $scope.day = 0;
        }
        getResultsPage();
    }, false);
    /***Date range***/

    /* Filters */
    $scope.sortingList = function (filterColumn, order) {
        $scope.orderby = filterColumn;
        $scope.state = (order == 'DESC') ? 'ASC' : 'DESC';
        getResultsPage()
    }

    $scope.setStatus = function (key, name) {
        $scope.filter.priority = '';
        $scope.filter.status = key;
        $scope.filterTitle = name;
        getResultsPage();
    }
    $scope.setPriority = function (key, name) {
        $scope.filter.priority = key;
        $scope.filter.status = '';
        $scope.filterTitle = name;
        getResultsPage();
    }
    $scope.setCategory = function (key) {
        $scope.filter.category = key;
        getResultsPage();
    }
    $scope.setCity = function (key) {
        $scope.filter.city = key;
        getResultsPage();
    }
    $scope.setWard = function (key) {
        $scope.filter.ward = key;
        getResultsPage();
    }
    $scope.termSearch = function (term) {
        $scope.filter.term = term;
        getResultsPage();
    }
    /* Search */
    $scope.isSearch = false;

    $scope.openSearch = function () {
        $scope.isSearch = true;
    }

    $scope.closeSearch = function () {
        $scope.filter.term = '';
        getResultsPage();
        $scope.isSearch = false;
    }
    /* change priority */
    $scope.savePriority = function (complaintId, priority) {
        Data.put('complaint/changepriority', {complaintId: complaintId, priority: priority}).then(function (response) {
            Data.toast(response);
        });
    }

    function getResultsPage() {
        $scope.loading = true;
        //$scope.complaints = [];
        Data.post('complaint/lists/' + $scope.itemsPerPage + '/' + $scope.currentPage + '/' + $scope.orderby + '/' + $scope.state,
                {filters: $scope.filter}).then(function (response) {
            $scope.loading = false;
            $scope.complaints = response.result;
            $scope.totalItems = response.total_count;
            $scope.statusOpen = response.open;
            $scope.statusOnthejob = response.onthejob;
            $scope.statusResolved = response.resolved;
        });
    }
    $scope.engineers = [];
    Data.get('user/lists/0/' + $scope.currentPage + '/' + $scope.orderby).then(function (response) {
        $scope.engineers = response.result;
    });
    $scope.animationsEnabled = true;
    $scope.complaint_id = '';
    $scope.open = function (complaintId) {
        $scope.complaintId = complaintId;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            backdrop: 'static',
            templateUrl: 'assignComplaintModal.html',
            controller: 'ModalInstanceCtrl',
            resolve: {
                items: function () {
                    return $scope.engineers;
                },
                id: function () {
                    return $scope.complaintId;
                }
            }
        });
    };
    $scope.escengineers = [];
    Data.get('user/get_escengineers').then(function (response) {
        $scope.escengineers = response.result;
    });
    $scope.animationsEnabled = true;
    $scope.complaint_id = '';
    $scope.openEsc = function (complaintId) {
        $scope.complaintId = complaintId;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            backdrop: 'static',
            templateUrl: 'assingEscalationModal.html',
            controller: 'EscModalInstanceCtrl',
            resolve: {
                items: function () {
                    return $scope.escengineers;
                },
                id: function () {
                    return $scope.complaintId;
                }
            }
        });
    };
    /* for status popup */
    $scope.statusPopup = function (status, compId) {
        $scope.status = status;
        $scope.compId = compId;
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            backdrop: 'static',
            templateUrl: 'commentForStatusModal.html',
            controller: 'StatusModalInstanceCtrl',
            resolve: {
                comment: function () {
                    return $scope.comment;
                },
                status: function () {
                    return $scope.status;
                },
                compId: function () {
                    return $scope.compId;
                }
            }
        });
    }
});
// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.

app.controller('ModalInstanceCtrl', function ($scope, $rootScope, $location, $http, Data, $window, $uibModalInstance, items, id, Data) {
    $scope.items = items;
    $scope.compId = id;
    $scope.assignEngineer = function (compId, engiId) {
        Data.post('complaint/assign_engineer', {complaint_id: compId, engineer_id: engiId}).then(function (response) {
            if (response.status == 'success') {
                Data.toast(response);
                $uibModalInstance.dismiss('cancel');
            } else {
                $scope.error_complaint_assigned = response.message;
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
app.controller('EscModalInstanceCtrl', function ($scope, $rootScope, $location, $http, Data, $window, $uibModalInstance, items, id, Data) {
    $scope.items = items;
    $scope.compId = id;
    $scope.assignEscEngineer = function (compId, engiId) {
        Data.post('complaint/assign_escalation_eng', {complaint_id: compId, engineer_id: engiId}).then(function (response) {
            if (response.status == 'success') {
                Data.toast(response);
                $uibModalInstance.dismiss('cancel');
            } else {
                $scope.error_complaint_assigned = response.message;
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});
app.controller('StatusModalInstanceCtrl', function ($scope, $rootScope, $location, $http, Data, $window, $uibModalInstance, comment, status, compId) {
    $scope.comment = comment;
    $scope.compId = compId;
    $scope.status = status;
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
    $scope.writeComment = function (compId, comment, status) {
        Data.put('complaint/changestatus', {complaintId: compId, comment: comment, status: status}).then(function (response) {
            Data.toast(response);
            $uibModalInstance.dismiss('cancel');
        });
    };
});

