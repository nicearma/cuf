'use strict';

angular.module('cufPlugin').factory('FilesResource',
    ['$resource',
        function ($resource) {
            return $resource(ajaxurl, [],
                {
                    getAllDirectories: {
                        method: 'POST',
                        params: {
                            action: 'cuf_all_directories'
                        }
                    },
                    getDirectoriesFromDirectory: {
                        method: 'POST',
                        params: {
                            action: 'cuf_directories_from_directory'
                        }
                    },
		            getFilesFromDirectory: {
                        method: 'POST',
                        params: {
                            action: 'cuf_files_from_directory'
                        }
                    },
                    deleteFileFromDirectory:{
                        method:'POST',
                        params: {
                            action: 'cuf_delete_file'
                        }
                    },
                    verifyFile:{
                        method:'POST',
                        params: {
                            action: 'cuf_verify_file'
                        }
                    }

                }
            );
        }
    ]
);
