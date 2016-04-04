<div id="optionsCUF" ng-controller="OptionsCtrl">

 <h3>General</h3>

<table class="wp-list-table widefat fixed">
        <tbody>


        <tr>
            <td scope="row">
                <p>
                    <?php _e("Plugin version", 'cuf'); ?>
                </p>

            </td>
            <td>
                <p><b>1.x</b></p>
            </td>
        </tr>

        <tr>
            <td scope="row">
                <p>
                    <?php _e("Only admin user", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("For the moment only Administrator can use this plugin", 'cuf'); ?>
                    </small>
                </p>

            </td>
            <td>
                <input ng-disabled="true" type="checkbox"
                       ng-model="options.admin" ng-disabled/>
            </td>
        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Update in server (make changes to database)", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("The plugin will try to update the server status every action made, if you want the classic button (bulk)save/update uncheck this", 'cuf'); ?>
                    </small>
                </p>

            </td>
            <td>
                <input ng-disabled="true" type="checkbox"
                       ng-model="options.updateInServer"/>
            </td>
        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Backup system", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Uncheck this if you don't want to use the backup system, because this plugin will delete images and update information in the database, is recommended to MAKE BACKUPS EVERY TIME YOU USE THIS PLUGIN however the MAIN USE OF THIS PLUGIN IS DELETE IMAGE AND UPDATE THE DATABASE, SO THIS BACKUP SYSTEM IS VERY SIMPLE AND NOT BULLET PROOF, SO USE ANOTHER BACKUP SYSTEM where possible", 'cuf'); ?>
                    </small>
                </p>

            </td>
            <td>
                <input ng-disabled="disabledBackupOption" type="checkbox"
                       ng-model="options.backup"/>
            </td>
        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Create backup folder", 'cuf'); ?>
                </p>
            </td>
            <td>
                <button ng-if="statusBackup.inServer<1"
                        ng-click="makeBackupFolder()"> <?php _e("Create backup folder", 'cuf'); ?></button>
                <p style="color: #00FF00"
                   ng-if="statusBackup.inServer>0"> <?php _e("Backup folder exist", 'cuf'); ?></p>

                <p style="color: #FF0000"
                   ng-if="statusBackup.inServer===-3"> <?php _e("Can not create backup folder, ask for help", 'cuf'); ?></p>
            </td>
        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Debug", 'cuf'); ?>
                    <small>
                        <?php _e("Use this only if think the plugin is not workning fine", 'cuf'); ?>
                        <br/>
                        <b> <?php _e("If you use this option for normal use, you will have performance issues", 'cuf'); ?></b>
                    </small>
                </p>

            </td>

            <td>
               <input type="checkbox" ng-model="options.debug" />

            </td>

        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Default options", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Restore default options", 'cuf'); ?>
                    </small>
                </p>

            </td>

            <td>
                <button ng-click="restore()"> <?php _e("Restore", 'cuf'); ?></button>

            </td>

        </tr>

        </tbody>
    </table>

    <h3>Show</h3>
     <table class="wp-list-table widefat fixed">
        <tbody>

        <tr>
            <td scope="row">
                <p>
                    <?php _e("Show used file", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("This can clean the view; i.e. only show only the file you want to be deleted", 'cuf'); ?>
                    </small>
                </p>

            </td>
            <td>
                <input type="checkbox"
                       ng-model="options.showUsedFile"/>
            </td>
        </tr>
                
        </tbody>
    </table>


     <h3>Check</h3>
    <table class="wp-list-table widefat fixed">
        <tbody>
        <tr>


            <td scope="row">
                <p>
                    <?php _e("Check in excerpt", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Theme or plugin can use the short description to show images, check this option to search files the in excerpt (short description)", 'cuf'); ?>
                        <br/>
                        <?php _e("If you check the shorcode logic, shortcodes will be search to", 'cuf'); ?>
                    </small>
                </p>

            </td>

            <td>
                <input type="checkbox" ng-model="options.excerptCheck"/>
            </td>

        </tr>
        <tr>


            <td scope="row">
                <p>
                    <?php _e("Check in Post meta", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Theme or plugin can use the post meta table to save information, the plugin can search here, but only will work if the file is in clear" , 'cuf');
                        ?>
                    </small>
                </p>

            </td>

            <td>
                <input type="checkbox" ng-model="options.postMetaCheck"/>
            </td>

        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Check if file is used in gallery", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Search in gallery", 'cuf'); ?>
                        <br/>
                        <?php _e("Certain gallery makers generate various sizes for responsive website use.", 'cuf'); ?>

                    </small>
                </p>

            </td>

            <td>
                <input type="checkbox" ng-model="options.galleryCheck"/>
            </td>

        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Check in shortcodes", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Search file in shortcode, the plugin will found out every shortcode used and get the html", 'cuf'); ?>
                        <br/>

                    </small>
                </p>

            </td>

            <td>
                <input type="checkbox" ng-model="options.shortCodeCheck"/>
            </td>

        </tr>
        <tr>
            <td scope="row">
                <p>
                    <?php _e("Check in draft", 'cuf'); ?>
                </p>

                <p>
                    <small>
                        <?php _e("Search file in draft", 'cuf'); ?>
                    </small>
                </p>

            </td>

            <td>
                <input type="checkbox" ng-model="options.draftCheck"/>
            </td>

        </tr>
        </tbody>
    </table>

</div>