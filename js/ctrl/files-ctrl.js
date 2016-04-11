'use strict';


angular.module('cufPlugin')
    .controller('FilesCtrl', ['$scope', '$rootScope','FilesResource',
        function ($scope, $rootScope,FilesResource) {

        	$scope.directories=[];
            $scope.files={data:{base:'',dirs:[]}};

      		$rootScope.$on('tabFiles', function () {
                $scope.directories = FilesResource.getAllDirectories();

            });


            $scope.scanPathDir=function(){
                
                if(!_.isUndefined($scope.pathDir)&&$scope.pathDir!=""){
                    
                  FilesResource.getFilesFromDirectory({path:$scope.pathDir}).$promise.then(function(resultFiles){
                    $scope.files=resultFiles;
                    if(!_.isUndefined(resultFiles.data)){

                        angular.forEach(resultFiles.data,function(file){
                            FilesResource.verifyFile({path:$scope.pathDir,src:file.src}).$promise.then(function(resultVerify){
                               file.status= resultVerify.data.status;
                            });
                        });
                    }
                  });
                }

            }
        }]
);
