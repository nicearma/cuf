'use strict';


angular.module('cufPlugin')
    .controller('FilesCtrl', ['$scope', '$rootScope','FilesResource',
        function ($scope, $rootScope,FilesResource) {

        	$scope.directories=[];
            $scope.files=[];

      		$rootScope.$on('tabFiles', function () {
                $scope.directories = FilesResource.getAllDirectories();

            });


            $scope.scanPathDir=function(){
                
                if(!_.isUndefined($scope.pathDir)&&$scope.pathDir!=""){
                  $scope.files=FilesResource.getFilesFromDirectory($scope.pathDir);
                }

            }
        }]
);
