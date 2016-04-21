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
            
            var verifyStatus=function(file){
                if(file.status.used==STATUS.USED.UNUSED){
                                
                                    
                                    if($scope.options.deleteAttached ||file.status.attach==STATUS.ATTACH.UNATTACH){
                                        file.toDelete=true;
                                    }else{
                                        file.toDelete=false;
                                    }
                                
                                    
                                   
                                }
            };
            
           $scope.filesOrdered={};
            
            var orderFile=function(file){
                if(!_.isUndefined(file.id)){
                    if(_.isUndefined( $scope.filesOrdered[file.id])){
                        $scope.filesOrdered[file.id]=[];
                    }
                    $scope.filesOrdered[file.id].push(file);
                }else{
                     if(_.isUndefined( $scope.filesOrdered['unattached'])){
                        $scope.filesOrdered['unattached']=[];
                    }
                    $scope.filesOrdered[file.id].push(file);
                }
                
            };

            $scope.scanPathDir=function(){
                
                if(!_.isUndefined($scope.pathDir)&&$scope.pathDir!=""){
                    
                  FilesResource.getFilesFromDirectory({path:$scope.pathDir}).$promise.then(function(resultFiles){
                    $scope.files=resultFiles.data;
                    if(!_.isUndefined(resultFiles.data)){

                        angular.forEach(resultFiles.data,function(file){
                            
                            orderFile(file);
                            file.status.used=STATUS.USED.ASKING;
                            file.status.attach=STATUS.ATTACH.ASKING;
                            FilesResource.verifyFile({path:$scope.pathDir,name:file.name}).$promise.then(function(resultVerify){
                               
                                file.status= resultVerify.data.status;
                                
                                file.id=resultVerify.data.id;
                                
                                verifyStatus(file);
                            });
                        });
                        
                                
                    }
                  });
                }

            };
            
            
            
            $rootScope.$on('refreshDeleteButton', function () {
                angular.forEach($scope.files,function(file){
                        verifyStatus(file);
                });
            });
            
            var makeBackup=function(file){
                //TODO:
                
                makeDelete(file);
                
            };
            
            var makeDelete=function(file){
                //TODO:
            }
            
            $scope.deleteFile=function(file){
                //TODO:
                
                if(file.type.indexOf("image")>-1){
                    //TODO: verify if original image, if original show popup, warning
                }else{
                    if($scope.options.backup){
                        makeBackup(file);
                    }else{
                        makeDelete(file);
                    }
                    
                }
                
            };
        }]
);
