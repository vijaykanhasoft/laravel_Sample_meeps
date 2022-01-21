var path = 'api/';
app.controller('frontCtrl', ['$rootScope', '$scope', '$window', '$http', '$location', '$stateParams', '$cookies', '$filter', '$timeout', '$uibModal', '$uibModalStack', 'DTOptionsBuilder', 'DTColumnBuilder', 'DTColumnDefBuilder', '$compile', function ($rootScope, $scope, $window, $http, $location, $stateParams, $cookies, $filter, $timeout, $uibModal, $uibModalStack, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder, $compile) {

        var hash = window.location.hash.substr(1);
        $scope.show_in_active = '';

        $scope.refresh_messages = function () {
            $scope.user_list_success = false;
            $scope.user_list_success_message = '';
            $scope.user_list_error = false;
            $scope.user_list_error_message = '';
        }

        $scope.set_message = function (message, type) {
            if (type == 'success') {
                $scope.user_list_error = false;
                $scope.user_list_error_message = '';
                $scope.user_list_success_message = message;
                $scope.user_list_success = true;
            } else if (type == 'error') {
                $scope.user_list_success = false;
                $scope.user_list_success_message = '';
                $scope.user_list_error = true;
                $scope.user_list_error_message = message;
            } else {
                $scope.user_list_success = false;
                $scope.user_list_success_message = '';
                $scope.user_list_error = false;
                $scope.user_list_error_message = '';
            }

        }

        $scope.close_model = function () {
            var top = $uibModalStack.getTop();
            if (top) {
                $uibModalStack.dismiss(top.key);
                $scope.$parent.user_detail = [];
            }
            $scope.$parent.refresh_messages();
        }

        $scope.dtIntanceCallback = function (instance) {
            $scope.dtInstanceUsers = instance;
        }

        $scope.dtInstanceUsers = {};

        var flag = 0;
        $scope.dtOptionPermission = DTOptionsBuilder.newOptions().withOption('ajax', function (data, callback, settings) {
            if (flag == 0) {
                flag = 1;
                var sque = 'desc';
                var columnmna = 'id';
            } else {
                var sque = data.order[0].dir;
                var columnmna = data.columns[data.order[0].column].name;
            }
            $http({
                method: "post",
                url: path + 'user-list',
                data: {
                    length: data.length,
                    start: data.start,
                    draw: data.draw,
                    column_name: columnmna,
                    order: sque,
                    search: data.search.value,
                    show_in_active: $scope.show_in_active
                }
            }).success(function (result) {
                if (result.success) {
                    callback({
                        draw: result.draw,
                        recordsTotal: result.recordsTotal,
                        recordsFiltered: result.recordsFiltered,
                        data: result.data
                    });
                } else {

                }
            });
        })
                .withDataProp('data')
                .withOption('processing', true)
                .withOption('serverSide', true)
                .withOption('createdRow', createdRow)
                .withOption('destroy', true)
                .withDisplayLength(10)
                .withBootstrap()
                .withPaginationType('full_numbers');
        $scope.dtColumnPermission = [
            DTColumnBuilder.newColumn('name').withTitle("User Name").withOption('sName', 'name'),
            DTColumnBuilder.newColumn('email').withTitle("Email").withOption('sName', 'email'),
            DTColumnBuilder.newColumn('is_active').withTitle("Status").withOption('sName', 'is_active').renderWith(function (data, type, full) {
                var class_name = (full.is_active == 1) ? 'label-success' : 'label-danger';
                var title = (full.is_active == 1) ? 'Active' : 'In-active';
                return '<span class="label label-sm ' + class_name + '">' + title + '</span>';
            }),
            DTColumnBuilder.newColumn('id').withTitle("Actions").withOption('sName', 'id').renderWith(function (data, type, full) {
                var is_not_admin = !full.is_admin;
                var title = (full.is_active == 1) ? 'De-activate' : 'Activate';
                var class_name = (full.is_active == 1) ? 'fa-minus-circle' : 'fa-check-circle';
                var _HTML = '<i class="fa fa-edit" ng-show=' + is_not_admin + ' ng-click="edit_user(' + full.id + ')"></i>&nbsp;<i type="button" ng-show=' + is_not_admin + ' title="' + title + '" class="fa ' + class_name + '" confirmed-click="delete_user(' + full.id + ', ' + full.is_active + ')" ng-confirm-click="Are you sure you want to ' + ((full.is_active) ? 'de-' : '') + 'activate the record?"></i>';
                return _HTML;
            }),
        ];
        $scope.dtColumnPermissionDefs = [
            DTColumnDefBuilder.newColumnDef(3).notSortable()
        ];
        function createdRow(row, data, dataIndex) {
            $compile(angular.element(row).contents())($scope);
        }

        $scope.addUser = function () {
            $scope.refresh_messages();
            $scope.user_detail = [];
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'resources/views/modals/user.html',
                controller: 'frontCtrl',
                show: true,
                scope: $scope
            });
        }

        $scope.reload = function (sort) {
            flag = sort;
            $scope.dtInstanceUsers.rerender();
        }

        $scope.edit_user = function (id) {
            $scope.refresh_messages();
            $scope.user_detail = [];
            $http({
                method: "post",
                url: path + 'user-detail',
                data: {user_id: id}
            }).success(function (response) {
                $scope.user_detail.user_name = response.data.name;
                $scope.user_detail.email = response.data.email;
                $scope.user_detail.password = '';
                $scope.user_detail.user_id = response.data.id;
                var modalInstance = $uibModal.open({
                    animation: true,
                    templateUrl: 'resources/views/modals/user.html',
                    controller: 'frontCtrl',
                    show: true,
                    scope: $scope
                });
            }).error(function () {
                $scope.user_detail = [];
            });
        }

        $scope.delete_user = function (id, is_active) {
            $scope.refresh_messages();
            $http({
                method: "post",
                url: path + 'user-delete',
                data: {user_id: id, is_active: ((is_active) ? 0 : 1)}
            }).success(function (response) {
                if (is_active) {
                    $scope.set_message('User de-activated successfully.', 'success');
                } else {
                    $scope.set_message('User activated successfully.', 'success');
                }
                $scope.reload(0);
            }).error(function () {
                $scope.set_message('Some internal server error occured.', 'error');
            });
        }

        $scope.add_user = function () {
            $scope.refresh_messages();
            if ($scope.create_user.$valid) {
                $('[name="user_name"]').closest('.form-group').removeClass('has-error');
                $('[name="email"]').closest('.form-group').removeClass('has-error');
                $('[name="password"]').closest('.form-group').removeClass('has-error');
                data = {
                    user_name: $scope.user_detail.user_name,
                    email: $scope.user_detail.email,
                    password: $scope.user_detail.password,
                    created_by: 0,
                    updated_by: 0,
                    user_id: $scope.user_detail.user_id
                }
                $http({
                    method: "post",
                    url: path + 'create-user',
                    data: data
                }).success(function (response) {
                    if (response.success == true) {
                        var message = ($scope.user_detail.user_id == '' || $scope.user_detail.user_id == undefined) ? 'User added successfully.' : 'User updated successfully.';
                        $scope.$parent.set_message(message, 'success');
                        $scope.$parent.user_detail = [];
                        $scope.$parent.reload(0);
                        $scope.$parent.close_model();
                    } else if (response.success == false && response.email_exists != undefined && response.email_exists == true) {
                        $scope.$parent.set_message('Email address already exists', 'error');
                        $scope.$parent.close_model();
                    } else {
                        $scope.$parent.set_message('Some internal server error occured while creating user record.', 'error');
                        $scope.$parent.close_model();
                    }
                }).error(function () {
                    $scope.set_message('Some internal server error occured while creating user record.', 'error');
                    $scope.$parent.close_model();
                });
            } else {
                if (!$scope.create_user.user_name.$valid) {
                    $('[name="user_name"]').closest('.form-group').addClass('has-error');
                    $('[name="user_name"]').focus();
                } else if (!$scope.create_user.email.$valid) {
                    $('[name="email"]').closest('.form-group').addClass('has-error');
                    $('[name="user_name"]').closest('.form-group').removeClass('has-error');
                    $('[name="email"]').focus();
                } else if (!$scope.create_user.password.$valid) {
                    $('[name="password"]').closest('.form-group').addClass('has-error');
                    $('[name="email"]').closest('.form-group').removeClass('has-error');
                    $('[name="user_name"]').closest('.form-group').removeClass('has-error');
                    $('[name="password"]').focus();
                }
            }
        }
        $scope.show_in_active_records = function ($event) {
            $scope.refresh_messages();
            var checkbox = $event.currentTarget;
            if ($scope.show_in_active) {
                checkbox.checked = true;
            } else {
                $scope.show_in_active = 0;
                checkbox.checked = false;
            }
            $scope.dtInstanceUsers.rerender();
        }
    }])