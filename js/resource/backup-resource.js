'use strict';

angular.module('cufPlugin').factory('BackupResource',
    ['$resource',
        function ($resource) {
            return $resource(ajaxurl, [],
                {
                    get: {
                        method: 'GET',
                        params: {
                            action: 'cuf_get_all_backup'
                        }
                    },
                    deleteAll: {
                        method: 'POST',
                        params: {
                            action: 'cuf_delete_all_backup'
                        }
                    },
                    deleteById: {
                        method: 'POST',
                        params: {
                            action: 'cuf_delete_by_id_backup'
                        }
                    },
                    make: {
                        method: 'POST',
                        params: {
                            action: 'cuf_make_backup'

                        }
                    },
                    restore: {
                        method: 'POST',
                        params: {
                            action: 'cuf_restore_backup'
                        }
                    },
                    makeBackupFolder: {
                        method: 'POST',
                        params: {
                            action: 'cuf_make_backup_folder_backup'
                        }
                    },
                    existsBackupFolder: {
                        method: 'POST',
                        params: {
                            action: 'cuf_exists_backup_folder_backup'
                        }
                    }
                }
            );
        }
    ]
);
