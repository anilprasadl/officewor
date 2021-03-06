angular
 .module('ui.bootstrap.demo', ['ngAnimate', 'ui.bootstrap'])
 .controller('DatepickerDemoCtrl', function ($scope) {
   
  $scope.today = function() {
    var dt = new Date();
    dt.setMinutes( 0 );
    $scope.dt = dt;
    

  };
  $scope.today();
  

  $scope.clear = function () {
    $scope.dt = null;
  };

  // Disable weekend selection
  $scope.enabled = function(date, mode) {
    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };


  $scope.open = function($event) {
    $scope.status.opened = true;
  };

  $scope.formats = ['MMM dd, yyyy hh:mm', 'dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];

  $scope.status = {
    opened: false
  };

  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  var afterTomorrow = new Date();
  afterTomorrow.setDate(tomorrow.getDate() + 2);
  $scope.events =
    [
      {
        date: tomorrow,
        status: 'full'
      },
      {
        date: afterTomorrow,
        status: 'partially'
      }
    ];

  $scope.getDayClass = function(date, mode) {
    if (mode === 'day') {
      var dayToCheck = new Date(date).setHours(0,0,0,0);

      for (var i=0;i<$scope.events.length;i++){
        var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

        if (dayToCheck === currentDay) {
          return $scope.events[i].status;
        }
      }
    }

    return '';
  };

});