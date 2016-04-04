'use strict';

angular.module('cufPlugin').factory('FilesResource',
    ['$resource',
        function ($resource) {
            return $resource(ajaxurl, [],
                {
                    getAllDirectories: {
                        method: 'POST',
                        params: {
                            action: 'cuf_all_directories_file'
                        }
                    },
                    getDirectoriesFromDirectory: {
                        method: 'POST',
                        params: {
                            action: 'cuf_get_directories_from_directory_file'
                        }
                    },
		            getFilesFromDirectory: {
                        method: 'POST',
                        params: {
                            action: 'cuf_get_files_from_directory_file'
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
