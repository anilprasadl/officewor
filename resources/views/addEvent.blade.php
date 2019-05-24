@extends('layouts.app')

@section('content')
<div class="container" ng-cloak ng-app="eventtypeApp" ng-controller="eventtypeController">
    <div class="row">
        <div class="col-md-12  col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Event Types</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 p-3">
                            <button ng-click="addEventType()" title="Add" alt="Add"
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
                    <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">

                            <table class="table" id="eventtype_listing">
                                <thead>
                                    <tr>
                                    <th>Name</th>
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

    <div id="eventtypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&#10799;</button>
                    <h4 class="modal-title">Event Type</h4>
                </div>
                <form class="cmxform"  ng-submit="saveEventType()" ng-model="eventtypes">
                <div class="modal-body">
                    <br>
                <!-- Error begins -->
                    <div ng-if="errors" class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&#10799;</a>

                    @{{ errors }} 

                    </div>
                    <br>
                <!-- Error ends  -->

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9     col-md-offset-1">
                                <div class="form-group">
                                    <label for="Name">Name:</label>
                                    <input type="text" class="form-control" ng-model="eventtypes.name" required>
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

var app = angular.module('eventtypeApp', []);

app.controller('eventtypeController', function ($scope, $http, $compile) {

    $scope.init = function () {
        $scope.eventtypes = {};
    }


//Add eventtype
    $scope.addEventType = function(){
        $scope.errors = $scope.successMessage = null;
        $scope.eventtypes = {};
        $("#eventtypeModal").modal("open");
    }

//Edit eventtype
    $scope.editEventType = function(id){
        $scope.errors = $scope.successMessage = null;
        var url = 'eventtype/' + id;
        $http.get(url).then(function (response) {
            if (response.status == 200) {
                $("#eventtypeModal").modal('show');
                $scope.eventtypes  = response.data.data;
            } else {
                $scope.errors = response.data.error.message;
            }
        });
    }


//Delete eventtype
    $scope.deleteEventType = function(id){
        $scope.errors = $scope.successMessage = null;
        $scope.selected_eventtype_id = id;
        $scope.show_delete = true;
        $scope.delete_msg = 'You are going to remove this record.  Are you Sure?';
        $("#deleteEventType").modal('show');
    }

    $scope.deleteConfirmed = function(){
        var url = '/eventtype/'+ $scope.selected_eventtype_id;
        $http.delete(url).then(function (response) {
            $scope.error_msg = $scope.successMessage = null;
            if (response.status == 200) {
               $scope.successMessage =response.data.data.message;                    
                $("#deleteEventType").modal('hide');
            }else{
                $scope.show_delete = false;
                $scope.error_msg = response.data.error.message;
            }
        });
    }

    $scope.saveEventType = function(){
        $scope.error_msg = $scope.successMessage = null;
        var url = 'eventtype';
        $http.post(url,$scope.eventtypes).then(function (response) {
            if (response.status == 200) {
                $("#eventtypeModal").modal('hide');
                $scope.successMessage = response.data.message;
            } else {
                $scope.errors = response.data.error.message;
            }
        });
    }

  $scope.init();

});
</script>
@endsection
