@extends('layouts.app')

@section('content')

<div class="container" ng-cloak ng-app="addEvent" ng-controller="addEventController">
        <div class="center">
            <li>
                <button class="btn-primary-dark"><a href="events" style="background-color:white">
                    <i class="far fa-clock"></i>
                    Click here to go to Calendar</a>
                </button>
            </li>
        </div>
    <br>
            <div class="alert alert-success" ng-if="successMessage">
                <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                <span ng-model="successMessage">@{{ successMessage }}</span>
            </div>
    <br>
            <div class="alert alert-danger" ng-if="error_msg">
                <a href="#" class="close" data-dismiss="alert">&#10799;</a>
                <span ng-model="error_msg">@{{error_msg}}</span>
            </div>
    <br>
    <form ng-model='addevent' ng-submit="saveEvent()">

                                <div class="form-group" class="form-control">
                                Enter Event Name:&nbsp;&nbsp;&nbsp;
                                <input type="name" ng-model='addevent.title'/><br><br>&nbsp;&nbsp;&nbsp
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
        <button type="submit" class="btn btn-primary">Submit</button>
        
    </form>
</div>

@endsection

@section('pageScript')
<script type="text/javascript">

var app = angular.module('addEvent', ['moment-picker', 'ui.bootstrap']);

app.controller('addEventController', function ($scope, $http, $compile) {

    $scope.init = function () {
        $scope.addevent = {};

    }
    var ctrl = this;
    
    // set minimum date to yesterday
    ctrl.minDateMoment = moment().add(0,'day');
    ctrl.maxDateMoment = moment().subtract(1, 'day');

//Save eventcategory
    $scope.saveEvent = function(){
        $scope.error_msg = $scope.successMessage = null;
        var url = 'events';
        // console.log($scope.addevent.start_date);return false;
        $http.post(url,$scope.addevent).then(function (response) {
            // console.log(response);
            if (response.status == 200) {
                $scope.successMessage = response.data.message;
                $scope.addevent={};
            } else {
                $scope.errors= response.data.error.message;
            }
        });
    }

    $scope.init();

});
</script>
@endsection
