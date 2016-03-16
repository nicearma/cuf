'use strict';

angular.module('cufPlugin').factory('OptionsResource',
    ['$resource',
        function ($resource) {
            return $resource(ajaxurl, [],
                {
                    get: {
                        method: 'GET',
                        params: {
                            action: 'cuf_get_options'
                        }
                    },
                    update: {
                        method: 'POST',
                        params: {
                            action: 'cuf_update_options'
                        }
                    },
		            restore: {
                        method: 'POST',
                        params: {
                            action: 'cuf_restore_options'
                        }
                    },
                    haveWC:{
                        method:'GET',
                        params: {
                            action: 'cuf_pro_have_wc_options'
                        }
                    }

                }
            );
        }
    ]
);
