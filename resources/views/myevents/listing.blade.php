@extends('layouts.app') @section('content')
<div class="container" ng-cloak ng-app="eventtypeApp" ng-controller="eventtypeController as ctrl">
    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Event</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 p-3">
                            <button ng-click="addNewSlot()" title="Add" alt="Add" class=" btn btn-circle btn-mn btn-primary pull-right">
                                <span class="fa fa-plus"></span>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="alert alert-success" ng-if="successMessage" id="success-alert">
                        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                        <span ng-model="successMessage">@{{successMessage}}</span>
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
                                            <th>Date</th>
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

    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Deleted Events</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table class="table" id="my_deletedevent_listing">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <!-- <th>Action</th> -->
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

    <div id="addSlot" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->

            <div class="modal-content">
                <div class="modal-header">
                    <span class="heading">
                        <h4 class="modal-title">Schedule your Event</h4>
                        </span>
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                </div>
                <form class="cmxform" ng-submit="saveSlot()" ng-model="addevent">
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
                                        <input id="title" type="text" class="form-control" ng-model="addevent.title" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <div class="input-group" moment-picker="addevent.start_date" format="YYYY-MM-DD HH:mm" min-date="ctrl.minDateMoment">
                                            <input class="form-control" placeholder="Select a date" ng-model="addevent.start_date" ng-model-options="{ updateOn: 'blur' }" required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <br>
                                        <label for="end_date">End Date</label>
                                        <div class="input-group" moment-picker="addevent.end_date" format="YYYY-MM-DD HH:mm" min-date="ctrl.minDateMoment">
                                            <input class="form-control" placeholder="Select a date" ng-model="addevent.end_date" ng-model-options="{ updateOn: 'blur' }" required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
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
    <div id="cancelTask" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                    <h4 class="modal-title">Cancel Task</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9    col-md-offset-1">
                                <form class="cmxform" ng-submit="cancelConfirmed()" ng-model="myevents">
                                    <div class="form-group">
                                        <p>@{{ delete_msg }}</p>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="myevents">State * </label>
                                            <select class="form-control"  ng-init="fetchState()" ng-model="form.myevents.state" data-size="10" ng-required="required" ng-options=" st.name for st in state">
                                            <option value="" selected disabled hidden>Select State</option>
                                            </select>
                                        </div>

                                        <label>Comments *</label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" cols="54" placeholder="Please give us a comment for cancellation!" ng-model="form.myevents.comments" required></textarea>
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
    <!-- delete ends -->

</div>
@endsection @section('pageScript')

<script type="text/javascript">
    var app = angular.module('eventtypeApp', ['moment-picker']);

    app.controller('eventtypeController', function($scope, $http, $compile) {

        $scope.init = function() {
            $scope.listEventTypes();
            $scope.listDeletedEvents();
        }
        var ctrl = this;

        ctrl.minDateMoment = moment().add(0, 'day');
        ctrl.maxDateMoment = moment().subtract(1, 'day');

        //Script to list eventtypes
        $scope.listEventTypes = function() {
            $('#myevent_listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                "oLanguage": {
                    "sEmptyTable": "No Tasks Created till Now"
                },
                ajax: 'myevents/list',
                columns: [{
                    data: 'title'
                }, {
                    data: 'start_date',
                    searchable: false,
                    format: 'dd:mm:yyyy'
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
                        $scope.listEventTypes();
                        $scope.listDeletedEvents();
                    }
                }
            });
        }

        $scope.fetchState = function() {

            $scope.state = [{
                id: 1,
                name: '{{App\Event::USER_STATE_RU}}'
            }, {
                id: 2,
                name: '{{App\Event::USER_STATE_RS}}'
            }, {
                id: 3,
                name: '{{App\Event::USER_STATE_CW}}'
            }, {
                id: 4,
                name: '{{App\Event::USER_STATE_OTHER}}'
            }];

        }

        //Script to list eventtypes
        $scope.listDeletedEvents = function() {
            $('#my_deletedevent_listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                "oLanguage": {
                    "sEmptyTable": "No Tasks Deleted till Now"
                },
                ajax: 'myevents/deleted-list',
                columns: [{
                        data: 'title'
                    }, {
                        data: 'start_date',
                        searchable: false,
                        format: 'dd-mm-yyyy'
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                },
                "fnDrawCallback": function() {
                    if ($(this).DataTable().row().data() === undefined && $(this).DataTable().page.info().page != 0) {
                        $(this).DataTable().state.clear();
                        $scope.listEventTypes();
                        $scope.listDeletedEvents();
                    }
                }
            });
        }

        $scope.addNewSlot = function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.addevent = {};
            $scope.addevent.status = '{{App\Event::STATUS_CREATED}}'
            console.log($scope.addevent);
            $("#addSlot").modal("show");
        };
        //Edit eventtype
        $scope.editEventType = function(id) {
            $scope.errors = $scope.successMessage = null;
            var url = 'myevents/' + id;
            $http.get(url).then(function(response) {
                if (response.status == 200) {
                    console.log(response);
                    $("#addSlot").modal('show');
                    $scope.addevent = response.data.data;
                    $scope.listEventTypes();
                    $scope.listDeletedEvents();
                } else {
                    $scope.errors = response.data.error;
                }
            });
        }

        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
        //Delete eventtype
        $scope.cancelEvent = function(id, status) {
            console.log(id);
            $scope.myevents = {};
            $scope.errors = $scope.successMessage = null;
            $scope.myevents.id = id;
            $scope.myevents.status = status;
            $scope.show_delete = true;
            $scope.delete_msg = 'You are going to Cancel this event. Are you Sure?';
            $("#cancelTask").modal('show');
        }

        $scope.cancelConfirmed = function() {
            $scope.loading = true;
            console.log($scope.myevents);
            $http.post('/myevents-cancel', $scope.myevents).then(function(response) {

                $scope.error_msg = $scope.successMessage = null;
                if (response.status == 200) {
                    $scope.successMessage = response.data.message;
                    $scope.listEventTypes();
                    $scope.listDeletedEvents();
                    $("#cancelTask").modal('hide');
                } else {
                    $scope.show_delete = false;
                    $scope.error_msg = response.data.error;
                }
            }).finally(function() {
                $scope.loading = false;
            });
        }

        $scope.saveSlot = function() {
            $scope.loading = true;
            $http.post('myevents', $scope.addevent).then(function(response) {
                if (response.status == 200) {
                    $("#addSlot").modal('hide');
                    $scope.successMessage = response.data.message;
                    $scope.listEventTypes();
                    $scope.listDeletedEvents();
                    // window.location.reload();
                } else {
                    $scope.error_msg = response.data.error;
                }
            }).finally(function() {
                $scope.loading = false;
            });
        }

        $scope.init();
    });
</script>
@endsection