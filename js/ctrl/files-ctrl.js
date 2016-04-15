'use strict';


angular.module('cufPlugin')
    .controller('FilesCtrl', ['$scope', '$rootScope','FilesResource','STATUS',
        function ($scope, $rootScope,FilesResource,STATUS) {

            $scope.status=STATUS;
        	$scope.base='';
            $scope.base=[];
            $scope.files={data:{}};
            
      		$rootScope.$on('tabFiles', function () {
                $scope.directories = FilesResource.getAllDirectories().$promise.then(function(resultDirs){
                     $scope.base =resultDirs.data.base;
                     $scope.dirs=resultDirs.data.dirs;
                    
                });

            });
                        

            $scope.scanPathDir=function(){
                
                if(!_.isUndefined($scope.pathDir)&&$scope.pathDir!=""){
                    
                  FilesResource.getFilesFromDirectory({path:$scope.pathDir}).$promise.then(function(resultFiles){
                    $scope.files=resultFiles.data;
                    if(!_.isUndefined(resultFiles.data)){

                        angular.forEach(resultFiles.data,function(file){
                            file.status.inServer=STATUS.USED.ASKING;
                            file.status.attach=STATUS.ATTACH.ASKING;
                            FilesResource.verifyFile({path:$scope.pathDir,name:file.name}).$promise.then(function(resultVerify){
                               
                                file.status= resultVerify.data;
                                console.log( file.status);
                                if(file.status.used==STATUS.USED.UNUSED&&file.status.attach==STATUS.ATTACH.UNATTACH){
                                    
                                    if(file.type.indexOf("image")==-1){
                                        file.toDelete=true;
                                    }
                                   
                                }
                            });
                        });
                        
                                
                    }
                  });
                }

            };
            
            
            var makeBackup=function(file){
                //TODO:
            };
            
            var makeDelete=function(file){
                //TODO:
            }
            
            $scope.deleteFile=function(file){
                //TODO:
            };
        }]
);
