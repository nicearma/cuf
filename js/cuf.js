'use strict';
//not the best, what to do??
var logsDNUI=[];
var logDNUI={log:false};

angular
    .module('cufPlugin', [
        'ngResource',
        'ngAnimate',
        'ui.bootstrap'
    ]).factory('logFactoroy', function () {


        return {
            'isLog': function () {
                return logDNUI.log;

            },
            'setLog': function (optionDebug) {
                logDNUI.log = optionDebug;
            },

            'addLogs': function (type, message) {
                logsDNUI.push({type: type, message: message});
            },
            'getLogs': function () {
                return logsDNUI;
            }


        }
    })
    .factory('myHttpInterceptor', function ($q, $injector, logFactoroy) {
        return {
            // optional method
            'request': function (config) {
                if (logFactoroy.isLog()) {
                    logFactoroy.addLogs('request: ' + (_.isUndefined(config.params)? '':config.params.action),config);

                }


                return config;
            },

            // optional method
            'requestError': function (rejection) {
                logFactoroy.addLogs('requestError',rejection);
                return $q.reject(rejection);
            },


            // optional method
            'response': function (response) {
                if (logFactoroy.isLog()) {
                    var name='response';
                    if(!_.isUndefined(response.config)){
                        if(!_.isUndefined( response.config.params)){
                            name+=': '+response.config.params.action;
                        }
                    }
                    logFactoroy.addLogs( name,response);
                }
                return response;
            },

            // optional method
            'responseError': function (rejection) {
                logFactoroy.addLogs('responseError',rejection);
                
                return $q.reject(rejection);
            }
        };
    }).config(['$httpProvider', 'logFactoroyProvider', function ($httpProvider, logFactoroyProvider) {


        var oldTransformResponse = $httpProvider.defaults.transformResponse;


        function appendTransform(defaults, transform) {

            // We can't guarantee that the default transformation is an array
            defaults = angular.isArray(defaults) ? defaults : [defaults];

            // Append the new transformation to the defaults
            return defaults.concat(transform);
        }

        var newTransformResponse=appendTransform(function (value) {
            if(logFactoroyProvider.$get().isLog()){
                logFactoroyProvider.$get().addLogs('transform',value);
            }

            return value;
        }, oldTransformResponse);

        $httpProvider.defaults.transformResponse = appendTransform(newTransformResponse,function (value) {

            if(!_.isUndefined(value.httpStatus)){
                var httpStatus= value.httpStatus;
                delete value.httpStatus;
                if (httpStatus == 400) {
                    logFactoroyProvider.$get().addLogs('errorsHttp', value);
                }
            }

            return value;
        });

        $httpProvider.interceptors.push('myHttpInterceptor');

    }])
.constant('STATUS',{
        ATTACH:{
            ERROR:-2,
            UNKNOWN:-1,
            UNATTACH:0,
            ATTACH:1,
            BACKUP_ATTACH:2,
            DELETED_ATTACH:3
            ASKING:99
        },
        IN_SERVER:{
            ERROR:-2,
            UNKNOWN:-1,
            NOT_INSERVER:0,
            INSERVER:1,
            ASKING:99
        },
        USED:{
            ERROR:-2,
            UNKNOWN:-1,
            UNUSED:0,
            USED:1,
            ASKING:99
        }

        });


   

