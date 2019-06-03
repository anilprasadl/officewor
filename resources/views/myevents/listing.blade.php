@extends('layouts.app')

@section('content')
<div class="container" ng-cloak ng-app="eventtypeApp" ng-controller="eventtypeController as ctrl">
<div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Event</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 p-3">
                            <button ng-click="addNewSlot()" title="Add" alt="Add"
                            class=" btn btn-circle btn-mn btn-primary pull-right">
                                <span class="fa fa-plus"></span>
                            </button>
                        </div>
                    </div>
                    <br >
                    <div class="alert alert-success" ng-if="successMessage">
                        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                      <span ng-model="successMessage">@{{successMessage}}</span>
                    </div>
                    <br>
                    <div class="alert alert-danger" ng-if="error_msg">
                        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                      <span ng-model="error_msg">@{{error_msg}}</span>
                    </div>
                    <br/>
                    <div raw-ajax-busy-indicator class="bg_load text-center" ng-show="loading"  id="loading-block">
                        <img src="{{asset('img/Infinity-1s-200px.svg')}}"style="margin-left: 0px;margin-top: 300px;">
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
                    <form class="cmxform"  ng-submit="saveSlot()" ng-model="addevent">
                    <div class="modal-body">
                        <br>
                    <!-- Error begins -->
                        <div class="alert alert-danger" id="error-alert" ng-if="error_msg">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        @{{ error_msg }}
                        </div>
                        <br>
                    <!-- Error ends  -->

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-9     col-md-offset-1">
                                    <div class="form-group">
                                        <label for="Name">Project Name:</label>
                                        <input type="text" class="form-control" ng-model="addevent.title" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <div class="input-group" moment-picker="addevent.start_date" format="YYYY-MM-DD HH:mm"  min-date="ctrl.minDateMoment" >
                                        <input class="form-control" placeholder="Select a date" ng-model="addevent.start_date"
                                            ng-model-options="{ updateOn: 'blur' }"  required>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <label for="end_date">End Date</label>
                                        <div class="input-group" moment-picker="addevent.end_date" format="YYYY-MM-DD HH:mm" min-date="ctrl.minDateMoment">
                                            <input class="form-control" placeholder="Select a date" ng-model="addevent.end_date"
                                                ng-model-options="{ updateOn: 'blur' }" required >
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

<!-- Add /edit eventtype modal ends  -->

<!-- delete modal begins -->
    <div id="deleteEventType" class="modal fade" role="dialog">
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
@endsection

@section('pageScript')

<script type="text/javascript">

var app = angular.module('eventtypeApp', ['moment-picker']);

app.controller('eventtypeController', function ($scope, $http, $compile) {

    $scope.init = function () {
        $scope.eventtypes = {};
        $scope.listEventTypes();
        $scope.listDeletedEvents();
    }
    var ctrl = this;

    ctrl.minDateMoment = moment().add(0,'day');
    ctrl.maxDateMoment = moment().subtract(1, 'day');

//Script to list eventtypes
    $scope.listEventTypes = function () {
        $('#myevent_listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                "oLanguage": {
                                "sEmptyTable": "No Event Types Created till Now !!"
                            },
                ajax: 'myevents/list',
                columns: [
                    {data: 'title'},
                    {data: 'start_date', searchable: false},
                    {data: 'action', orderable: false, searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $compile(angular.element(row).contents())($scope);
                },"fnDrawCallback":function(){
                    if($(this).DataTable().row().data()===undefined && $(this).DataTable().page.info().page !=0){
                        $(this).DataTable().state.clear();
                        $scope.listEventTypes();
                        $scope.listDeletedEvents();
                    }
                }
            });
        }


//Script to list eventtypes
        $scope.listDeletedEvents = function () {
                $('#my_deletedevent_listing').DataTable({
                        processing: true,
                        stateSave: true,
                        serverSide: true,
                        destroy: true,
                        "oLanguage": {
                                        "sEmptyTable": "No Event Types Created till Now !!"
                                    },
                        ajax: 'myevents/deleted-list',
                        columns: [
                            {data: 'title'},
                            {data: 'start_date', searchable: false},
                            // {data: 'action', orderable: false, searchable: false},
                        ],
                        createdRow: function (row, data, dataIndex) {
                            $compile(angular.element(row).contents())($scope);
                        },"fnDrawCallback":function(){
                            if($(this).DataTable().row().data()===undefined && $(this).DataTable().page.info().page !=0){
                                $(this).DataTable().state.clear();
                                $scope.listEventTypes();
                                $scope.listDeletedEvents();
                            }
                        }
                    });
                }

    $scope.addNewSlot= function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.addevent = {};
            $("#addSlot").modal("show");
            };
//Edit eventtype
    $scope.editEventType = function(id){
        $scope.errors = $scope.successMessage = null;
        var url = 'myevents/' + id;
        $http.get(url).then(function (response) {
            if (response.status == 200) {
                console.log(response);
                $("#addSlot").modal('show');
                $scope.addevent  = response.data.data;
                $scope.listEventTypes();
                $scope.listDeletedEvents();
            } else {
                $scope.errors = response.data.error.message;
            }
        });
    }


//Delete eventtype
    $scope.deleteEventType = function(id){
        console.log(id);
        $scope.errors = $scope.successMessage = null;
        $scope.selected_event_id = id;
        $scope.show_delete = true;
        $scope.delete_msg = 'You are going to remove this record.  Are you Sure?';
        $("#deleteEventType").modal('show');
        // console.log("Test");return false;
    }

    $scope.deleteConfirmed = function(){
        var url = '/myevents/'+ $scope.selected_event_id;
        $http.delete(url).then(function (response) {
            console.log(response);
            $scope.error_msg = $scope.successMessage = null;
            if (response.status == 200) {
               $scope.successMessage =response.data.data.message;
               $scope.listEventTypes();
               $scope.listDeletedEvents();
                $("#deleteEventType").modal('hide');
            }else{
                $scope.show_delete = false;
                $scope.error_msg = response.data.error.message;
            }
        });
    }

    $scope.saveSlot = function(){
            $scope.loading = true;
            // $scope.error_msg = $scope.successMessage = null;
            $http.post('myevents',$scope.addevent).then(function (response) {
                // console.log(response);return false;
                if (response.status == 200) {
                    $("#addSlot").modal('hide');
                    console.log(response);
                    $scope.successMessage = response.data.message;
                    $scope.listEventTypes();
                    $scope.listDeletedEvents();
                    // window.location.reload();
                } else {
                    $scope.error_msg= response.data.data.error;
                }
            }).finally(function(){
                $scope.loading = false;
            });
    }

    //Cancel Event
    $scope.CancelEvent = function(id,status){
        $scope.errors = $scope.successMessage = null;
        $scope.loading = true;
        var url = '/cancelEvent/'+ id ;
        $http.post(url).then(function (response) {
        if (response.status == 200) {
            $scope.successMessage = response.data.message;
            $scope.listMyEvents();
        }else
        {
            $scope.errors = response.data.error.message;

        }

}).finally(function(){
                $scope.loading = false;
            });
    }
$scope.init();
});


</script>
@endsection
