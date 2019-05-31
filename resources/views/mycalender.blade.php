@extends('layouts.app')

@section('content')
<div class="container" ng-cloak ng-app="addEvent" ng-controller="addEventController">
    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Calendar</div>
                <div class="panel-body">
                    <!-- <div class="row">
                        <div class="col-sm-12 p-3">
                            <button ng-click="addNewSlot()" title="Add" alt="Add"
                            class=" btn btn-circle btn-mn btn-primary pull-right">
                                <span class="fa fa-plus"></span> Add Event
                            </button>
                        </div>
                    </div> -->
                    <br >
                    <div class="alert alert-success" ng-if="successMessage">
                        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                      <span ng-model="successMessage">@{{successMessage}}</span>
                    </div>
                    <br/>
                    <div raw-ajax-busy-indicator class="bg_load text-center" ng-show="loading"  id="loading-block">
                        <img src="{{asset('img/Infinity-1s-200px.svg')}}"style="margin-left: 0px;margin-top: 300px;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        {!! $calendar->calendar() !!}
                        {!! $calendar->script() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Dialog -->

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
                    <form class="cmxform"  ng-submit="saveSlot()" ng-model="eventtypes">
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
    </div>

    
</div>
@endsection

@push('scripts')



<script type="text/javascript">
    var app = angular.module('addEvent', ['moment-picker','ngRoute']);
    app.controller('addEventController', function ($scope, $http, $compile,$route) {
        $scope.init = function () {
            $scope.addevent = {};
            $scope.loading = false;
            $scope.error_msg = $scope.successMessage = null;
        }
    
    var ctrl = this;
    
    // set minimum date to yesterday
    ctrl.minDateMoment = moment().add(0,'day');
    //To set end date limit
    ctrl.maxDateMoment = moment().subtract(1, 'day');


        $scope.getData = function () { 
            var url='home/list/';
            $http.get(url).then(function (response) {
                if (response.status == 200) {
                    $scope.addevent=$scope.momentDate;
                } else {
                    $scope.error_msg = response.data.data.error;
                }
            });
        };
        $scope.addNewSlot= function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.addevent = {};
            $("#addSlot").modal("show");
        };
         //Save event in calendar
        $scope.saveSlot = function(){
            $scope.loading = true;
            // $scope.error_msg = $scope.successMessage = null;
            $http.post('events',$scope.addevent).then(function (response) {
                // console.log(response.data.data.error);
                if (response.status == 200) {
                    $("#addSlot").modal('hide');
                    $scope.successMessage = response.data.data.message;
                    window.location.reload();
                } else {
                    $scope.error_msg= response.data.data.error;
                }
            }).finally(function(){
                $scope.loading = false;
            });
        }
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });
        $("#error-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#error-alert").slideUp(500);
        });

    $scope.init();
});
</script>
@endpush
