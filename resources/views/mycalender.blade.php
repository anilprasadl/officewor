@extends('layouts.app')

@section('content')






<div class="container-fluid" >

<div class="row">

<div class="col-sm-12 p-3">
    <button ng-click="addNewSlot()" title="Add" alt="Add" class=" btn btn-circle btn-mn btn-primary pull-right" data-target="#addSlot" data-toggle="modal">
        <span class="fa fa-plus"></span>
    </button>
</div>
</div>

    <div class="alert alert-success" ng-if="successMessage">
        <a href="#" class="close" data-dismiss="alert">&#10799;</a>
        <span ng-model="successMessage">@{{successMessage}}</span>
    </div>
    <br>

<!-- Modal Dialog -->

<div id="addSlot" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->

            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Schedule your Event</h4>
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                </div>
                <form class="cmxform"  ng-submit="saveSlot()" ng-model="eventtypes">
                <div class="modal-body">
                    <br>
                <!-- Error begins -->
                    <div ng-if="error_msg" class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&#10799;</a>

                    @{{ error_msg }} 

                    </div>
                    <br>
                <!-- Error ends  -->

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9     col-md-offset-1">
                                <div class="form-group">
                                    <label for="Name">Project Name:</label>
                                    <input type="text" class="form-control" ng-model="eventtypes.name" required>
                                </div>
                               
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <div class="input-group" moment-picker="form.event.start_date" format="YYYY-MM-DD HH:mm"  min-date="ctrl.minDateMoment" >
                                        <input class="form-control" placeholder="Select a date" ng-model="form.event.start_date"
                                            ng-model-options="{ updateOn: 'blur' }"  required>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <label for="end_date">End Date</label>
                                    <div class="input-group" moment-picker="form.event.end_date" format="YYYY-MM-DD HH:mm" min-date="ctrl.minDateMoment">
                                        <input class="form-control" placeholder="Select a date" ng-model="form.event.end_date"
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


<md-content flex layout-padding>
    <div class="panel panel-primary">

        <div class="panel-heading">

            MY Calender    
            <div class="center">
                <li>
                <button><a href="addEvent">
                    <i class="far fa-clock"></i>
                    Click to Ad event</a>
                </button>
                </li>
            </div>

        </div>

        <div class="panel-body" >

            {!! $calendar->calendar() !!}

            {!! $calendar->script() !!}

        </div>

    </div>
    </md-content>

</div>
@endsection
@section('pageScript')
<script type="text/javascript">
    var app = angular.module('bookedResource', ['moment-picker']);
    app.controller('bookedResourceController', function ($scope, $http, $compile) {
        $scope.init = function () {
            $scope.addevent = {};
            $scope.error_msg = $scope.successMessage = null;
        }
    
    var ctrl = this;
    
    // set minimum date to yesterday
    ctrl.minDateMoment = moment().add(0,'day');
    //To set end date limit
    // ctrl.maxDateMoment = moment().subtract(1, 'day');


        $scope.getData = function () { 
            var url='home/list/';
            $http.get(url).then(function (response) {
                if (response.status == 200) {
                    $scope.addevent=$scope.momentDate;
                } else {
                    $scope.error_msg = response.data.error.message;
                }
            });
        };
        $scope.addNewSlot= function() {
            $scope.error_msg = $scope.successMessage = null;
            $scope.eventtypes = {};
            $("#addSlot").modal("show");
        };
         //Save event in calendar
        $scope.saveEvent = function(){
            $scope.error_msg = $scope.successMessage = null;
            var url = 'events';
            // console.log($scope.addevent.start_date);return false;
            $http.post(url,$scope.addevent).then(function (response) {
                // console.log(response);
                if (response.status == 200) {
                    $("#addSlot").modal('hide');
                    $scope.successMessage = response.data.message;
                } else {
                    $scope.error_msg= response.data.error.message;
                }
            });
        }

    $scope.init();
});
</script>
@endsection