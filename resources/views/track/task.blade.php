@extends('layouts.app') @section('content')
<div class="container" ng-cloak ng-app="bookedslotsApp" ng-controller="bookedslotsController as ctrl">
    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Booked Events</div>
                <div class="panel-body">
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
                                            <th>Status</th>
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

            <div id="showTask" class="modal fade" role="dialog">
            <div class="modal-dialog">
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
                                    <div class="col-md-12">
                                
                                            <!-- <ul id="nav_ctrl">
                                            <li class="icon-up-open" data-title="Next"></li>
                                            <li class="icon-down-open" data-title="Previous"></li>
                                            </ul> -->
                                                <ul class="timeline">
                                                    <li ng-repeat="track in timeline" ng-class-even="'timeline-inverted'" >
                                                        <div class="timeline-badge" ng-class="track.id">
                                                            @{{track.start_date}}
                                                        </div>
                                                        <div class="timeline-panel">
                                                            <div class="timeline-heading">
                                                                <h4 class="timeline-title">@{{track.title}}</h4>
                                                            </div>
                                                            <div class="timeline-body">
                                                                <label ng-if="track.status">Status:</label>@{{track.status}}
                                                                <label ng-if="track.assigned_to">Assigned To:</label>@{{track.assigned_to}}
                                                                <label ng-if="track.completed_by">Completed By:</label>
                                                                <label ng-if="track.created_by">Created By:</label>
                                                                <label ng-if="track.comments">Comments:</label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            <!-- @{{track}}     -->
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
    <!-- Add /edit eventtype modal ends  -->
</div>
@endsection @section('pageScript')

<script type="text/javascript">
    var app = angular.module('bookedslotsApp',  []);

    app.controller('bookedslotsController', function($scope, $http, $compile) {

        $scope.init = function() {
            $scope.task = {};
            $scope.listSlots();
            $scope.timeline_track = [];
        }

        // angular.forEach($scope.timeline, function(value, key){
                      
        //         $scope.timeline_track.push(parseInt(key));
            
        //     });   

        //Script to list eventtypes
        $scope.listSlots = function() {
            $('#myevent_listing').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                destroy: true,
                "oLanguage": {
                    "sEmptyTable": "No Tasks Created till Now !!"
                },
                ajax: 'task-track/list',
                columns: [{
                    data: 'title'
                }, {
                    data: 'start_date',
                    searchable: false
                }, {
                    data: 'status',
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


        $scope.showTask = function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.task = {};
            $("#showTask").modal("show");
        };
        //Edit eventtype
        $scope.showAllTask = function(id) {
            $scope.errors = $scope.successMessage = null;
            var url = '/task-track/' + id;
            $http.get(url).then(function(response) {
                // console.log(response);
                if (response.status == 200) {
                    console.log(response);
                    $("#showTask").modal('show');
                    $scope.timeline = response.data.data;
                    console.log($scope.timeline);
                    $scope.listSlots();

                } else {
                    $scope.errors = response.data.error.message;
                }
            });
        }
        $scope.listTimeline = function(){

        }
        $scope.init();
        
        

    });
</script>
@endsection