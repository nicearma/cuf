'use strict';


angular.module('cufPlugin')
    .controller('LogCtrl', ['$scope', '$rootScope', 'logFactoroy',
        function ($scope, $rootScope, logFactoroy) {

            $scope.logs = [];
            //tab image is call

            $rootScope.$on('tabLogs', function () {

                $scope.logs = logFactoroy.getLogs();
            });


        }]
);