@extends('layouts.app') @section('content')
<div class="container" ng-cloak ng-app="bookedslotsApp" ng-controller="bookedslotsController as ctrl">
    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Booked Events</div>
                <div class="panel-body">
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
                                            <th>Event Name</th>
                                            <th>Start Date</th>
                                            <th>Assigned To</th>
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
                        <h4 class="modal-title">User</h4>
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

    <!-- User Task Assign Modal Starts-->
    <div id="showTask" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->

            <div class="modal-content">
                <div class="modal-header">
                    <span class="heading">
                        <h4 class="modal-title">Project Task Assignment</h4>
                        </span>
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                </div>
                <form class="cmxform" ng-submit="saveTask()" ng-model="task">
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
                                        <label for="Name">Project Name:</label>
                                        @{{task.title}}
                                    </div>
                                    <div class="form-group">
                                        <label for="Name">Status:</label>
                                        @{{task.status}}
                                    </div>
                                    <div class="form-group" ng-init="userslist()">
                                        <label for="userlist">User Name</label>
                                        <select class="form-control" ng-model="task.assigned_to" ng-options="cat.id as cat.name for cat in users" ng-required="required">
                                        </select>
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
    <!-- User Task Assign Modal Ends -->
    <!-- Close Task Modal Starts -->
    <div id="closeTask" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                    <h4 class="modal-title">Close Task</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9    col-md-offset-1">
                                <form class="cmxform" ng-model="mytasks">
                                    <div class="form-group">
                                        <p>@{{ delete_msg }}</p>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="mytasks">State * </label>
                                            <select class="form-control" ng-init="fetchState()" ng-model="mytasks.state" data-size="10" ng-required="required" ng-options=" st.name for st in state">
                                            <option value="" selected disabled hidden>Select State</option>
                                            </select>
                                        </div>
                                        <label>Comments *</label>
                                        <div class="form-group">
                                            <textarea class="input-group" rows="3" cols="50" placeholder="Please give us a comment for cancellation!" ng-model="mytasks.comments" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                            No</button>
                                        <button type="submit" class="btn btn-danger">Yes</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Close Task Modal Ends -->
</div>
@endsection @section('pageScript')

<script type="text/javascript">
    var app = angular.module('bookedslotsApp', []);

    app.controller('bookedslotsController', function($scope, $http, $compile) {

        $scope.init = function() {
            $scope.user = {};
            $scope.task = {};
            $scope.listSlots();
        }

        //Script to list eventtypes
        $scope.listSlots = function() {
            $('#myevent_listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                "oLanguage": {
                    "sEmptyTable": "No Tasks Created till Now "
                },
                ajax: 'slots/booked',
                columns: [{
                    data: 'title'
                }, {
                    data: 'start_date',
                    searchable: false
                }, {
                    data: 'assigned_to',
                    searchable: false
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
                        $scope.listSlots();
                    }
                }
            });
        }

        $scope.addUser = function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.user = {};
            $("#addUser").modal("show");
        };
        $scope.fetchState = function() {
            $scope.state = [{
                id: 1,
                name: '{{App\Event::ADMIN_STATE_COMPLETED}}'
            }, {
                id: 2,
                name: '{{App\Event::ADMIN_STATE_RS}}'
            }, {
                id: 3,
                name: '{{App\Event::ADMIN_STATE_DE}}'
            }, {
                id: 4,
                name: '{{App\Event::ADMIN_STATE_OTHER}}'
            }];

        };
        //Edit eventtype
        $scope.editUser = function(id) {
            $scope.errors = $scope.successMessage = null;
            var url = 'users/' + id;
            $http.get(url).then(function(response) {
                if (response.status == 200) {
                    $("#addUser").modal('show');
                    $scope.user = response.data.data;
                    $scope.listSlots();

                } else {
                    $scope.errors = response.data.error.message;
                }
            });
        }

        $scope.closeTask = function($id, $status) {
            $scope.mytasks = {};
            $scope.errors = $scope.successMessage = null;
            $scope.mytasks.id = $id;
            $scope.mytasks.status = $status;
            $scope.show_delete = true;
            $scope.delete_msg = 'You are going to Cancel this event. Are you Sure?';
            $("#closeTask").modal('show');
        }

        $scope.closeConfirmed = function() {
            console.log($scope.mytasks);
            $http.post('/saveSlot', $scope.mytasks).then(function(response) {
                $scope.error_msg = $scope.successMessage = null;
                if (response.status == 200) {
                    $scope.successMessage = response.data.message;
                    $scope.listSlots();
                    $("#closeTask").modal('hide');
                } else {
                    $scope.show_delete = false;
                    $scope.error_msg = response.data.error.message;
                }
            });
        }

        $scope.saveUser = function() {
            $scope.loading = true;
            $http.post('users', $scope.user).then(function(response) {
                if (response.status == 200) {
                    $("#addUser").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listSlots();
                    // window.location.reload();
                } else {
                    $scope.error_msg = response.data.data.error;
                }
            }).finally(function() {
                $scope.loading = false;
            });
        }

        //Cancel Event
        $scope.closeSlot = function(id, status) {
            $scope.errors = $scope.successMessage = null;
            $scope.loading = true;
            var url = '/slots/' + id + '/' + status;
            $http.post(url).then(function(response) {
                if (response.status == 200) {
                    $scope.successMessage = response.data.message;
                    $scope.listSlots();
                } else {
                    $scope.errors = response.data.error.message;

                }

            }).finally(function() {
                $scope.loading = false;
            });
        }

        // Task Modal Show and Save 
        $scope.assignUser = function(id) {
            $scope.task = {};

            var url = '/tasks/' + id;
            $http.get(url).then(function(response) {
                if (response.status == 200) {
                    $('#showTask').modal('show');
                    $scope.task = response.data.data;
                    // console.log(response);
                }
            });
        }
        $scope.saveTask = function() {
            $scope.loading = true;
            console.log($scope.task);
            $http.post('/saveTasks', $scope.task).then(function(response) {

                if (response.status == 200) {
                    $("#showTask").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listSlots();
                } else {
                    $scope.error_msg = response.data.data.error;
                }
            }).finally(function() {
                $scope.loading = false;
            });
        }

        $scope.userslist = function() {
            $scope.errors = $scope.successMessage = null;
            var url = 'admin/list';
            $http.get(url).then(function(response) {
                if (response.status == 200) {
                    $scope.users = response.data.data;
                } else {
                    $scope.errors = response.data.error.message;
                }
            });
        }
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
        $scope.init();
    });
</script>
@endsection