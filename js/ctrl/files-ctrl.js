'use strict';


angular.module('cufPlugin')
    .controller('FilesCtrl', ['$scope', '$rootScope','FilesResource'
        function ($scope, $rootScope,FilesResource) {

        	$scope.directories=[];
 
  			$rootScope.$on('tabFiles', function () {
              $scope.directories=[ FilesResource.getAllDirectories();
            });

        }]
);
