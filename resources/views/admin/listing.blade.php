@extends('layouts.app') @section('content')
<div class="container" ng-cloak ng-app="userApp" ng-controller="userController as ctrl">
    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 p-3">
                            <button ng-click="addUser()" title="Add" alt="Add" class=" btn btn-circle btn-mn btn-primary pull-right">
                                <span class="fa fa-plus"></span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="alert alert-success" ng-if="successMessage" id="success-alert">
                        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                        <span ng-model="successMessage">@{{successMessage}}</span>
                    </div>
                    <br>
                    <div class="alert alert-danger" ng-if="error_msg">
                        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                        <span ng-model="error_msg">@{{error_msg}}</span>
                    </div>
                    <br/>
                    <div raw-ajax-busy-indicator class="bg_load text-center" ng-show="loading" id="loading-block">
                        <img src="{{asset('img/Infinity-1s-200px.svg')}}" style="margin-left: 0px;margin-top: 300px;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table class="table" id="myevent_listing">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Admin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add / edit modal eventtype begins -->

    <div id="addUser" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->

            <div class="modal-content">
                <div class="modal-header">
                    <span class="heading">
                        <h4 class="modal-title">Schedule your Event</h4>
                        </span>
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                </div>
                <form class="cmxform" ng-submit="saveUser()" ng-model="user">
                    <div class="modal-body">
                        <br>
                        <!-- Error begins -->
                        <div class="alert alert-danger" id="error-alert" ng-if="error_msg">
                            <a href="#" class="close" data-dismiss="alert">&times;</a> @{{ error_msg }}
                        </div>
                        <br>
                        <!-- Error ends  -->

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-9     col-md-offset-1">
                                    <div class="form-group">
                                        <label for="Name">User Name:</label>
                                        <input type="text" class="form-control" ng-model="user.name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Email:</label>
                                        <input type="text" class="form-control" ng-model="user.email" required>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" ng-true-value='1' ng-model="user.is_admin" /> Make Admin</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add /edit eventtype modal ends  -->
    <!-- delete modal begins -->
    <div id="deleteUser" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                    <p>@{{ delete_msg }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        @{{show_delete ? 'No' : 'OK'}}</button>
                    <button type="button" ng-if="show_delete" ng-click="deleteConfirmed()" data-dismiss="modal" class="btn btn-danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete ends -->

</div>
@endsection @section('pageScript')

<script type="text/javascript">
    var app = angular.module('userApp', ['moment-picker']);

    app.controller('userController', function($scope, $http, $compile) {

        $scope.init = function() {
            $scope.user = {};
            $scope.listUsers();
        }

        //Script to list eventtypes
        $scope.listUsers = function() {
            $('#myevent_listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                "oLanguage": {
                    "sEmptyTable": "No Event Created till Now !!"
                },
                ajax: 'users/list',
                columns: [{
                    data: 'name'
                }, {
                    data: 'email',
                    searchable: false
                }, {
                    data: 'is_admin'

                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }, ],
                createdRow: function(row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                },
                "fnDrawCallback": function() {
                    if ($(this).DataTable().row().data() === undefined && $(this).DataTable().page.info().page != 0) {
                        $(this).DataTable().state.clear();
                        $scope.listUsers();
                    }
                }
            });
        }

        $scope.addUser = function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.user = {};
            $("#addUser").modal("show");
        };
        //Edit eventtype
        $scope.editUser = function(id) {
            $scope.errors = $scope.successMessage = null;
            var url = 'users/' + id;
            $http.get(url).then(function(response) {
                // console.log(response);
                if (response.status == 200) {
                    console.log(response);
                    $("#addUser").modal('show');

                    $scope.user = response.data.data;
                    // console.log($scope.user);
                    $scope.listUsers();

                } else {
                    $scope.errors = response.data.error.message;
                }
            });
        }

        //Delete eventtype
        $scope.deleteUser = function(id) {
            console.log(id);
            $scope.errors = $scope.successMessage = null;
            $scope.selected_user_id = id;
            $scope.show_delete = true;
            $scope.delete_msg = 'You are going to remove this record.  Are you Sure?';
            $("#deleteUser").modal('show');
            // console.log("Test");return false;
        }

        $scope.deleteConfirmed = function() {
            var url = '/users/' + $scope.selected_user_id;
            $http.delete(url).then(function(response) {
                console.log(response);
                $scope.error_msg = $scope.successMessage = null;
                if (response.status == 200) {
                    $scope.successMessage = response.data.data;
                    $scope.listUsers();
                    $("#deleteUser").modal('hide');
                } else {
                    $scope.show_delete = false;
                    $scope.error_msg = response.data.error.message;
                }
            });
        }

        $scope.saveUser = function() {
            $scope.loading = true;
            // $scope.error_msg = $scope.successMessage = null;
            $http.post('users', $scope.user).then(function(response) {
                console.log($scope.user);
                // console.log(response);return false;
                if (response.status == 200) {
                    $("#addUser").modal('hide');
                    // console.log(response);
                    $scope.successMessage = response.data.message;
                    $scope.listUsers();

                    // window.location.reload();
                } else {
                    $scope.error_msg = response.data.data.error;
                }
            }).finally(function() {
                $scope.loading = false;
            });
        }

        //Cancel Event
        $scope.CancelEvent = function(id, status) {
            $scope.errors = $scope.successMessage = null;
            $scope.loading = true;
            var url = '/cancelEvent/' + id;
            $http.post(url).then(function(response) {
                if (response.status == 200) {
                    $scope.successMessage = response.data.message;
                    $scope.listMyEvents();
                } else {
                    $scope.errors = response.data.error.message;

                }

            }).finally(function() {
                $scope.loading = false;
            });
        }
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
        $scope.init();
    });
</script>
@endsection