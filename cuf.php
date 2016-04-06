<?php
/*
  Plugin Name: CUF (Clean upload path)
  Version: 1.0
  Plugin URI: https://wordpress.org/plugins/cuf-cleanup-upload-path/
  Author: Nicearma
  Author URI: http://www.nicearma.com/
  Text Domain: cuf
  Domain Path: /languages
  Description: Find all files from your upload path, and find out if there are not used file or simple not refered in the database.
 */

/*
  Copyright (c) 2016 http://www.nicearma.com
  Released under the GPL license
  http://www.gnu.org/licenses/gpl.txt
 */

add_action('admin_init', 'CUF_admin_js');

add_action('admin_menu', 'CUF_admin_menu');

function CUF_admin_js()
{
    wp_register_style('cuf-css-bootstrap', plugins_url('css/bootstrap.min.css', __FILE__));

    wp_register_style('cuf-css', plugins_url('css/cuf.css', __FILE__));

    //angular dependency
    wp_register_script('cuf-angular', plugins_url('js/external/angular.min.js', __FILE__), array('jquery', 'underscore'));
    wp_register_script('cuf-angular-resource', plugins_url('js/external/angular-resource.min.js', __FILE__), array('cuf-angular'));
    wp_register_script('cuf-angular-animate', plugins_url('js/external/angular-animate.min.js', __FILE__), array('cuf-angular'));

    wp_register_script('cuf-bootstrap', plugins_url('js/external/bootstrap.min.js', __FILE__), array('cuf-angular'));

    wp_register_script('cuf-angular-ui', plugins_url('js/external/ui-bootstrap-tpls-1.2.2.min.js', __FILE__), array('cuf-angular', 'cuf-bootstrap'));

    //resources
    wp_register_script('cuf-options-resource', plugins_url('js/resource/options-resource.js', __FILE__), array('cuf-angular-resource'));
    wp_register_script('cuf-files-resource', plugins_url('js/resource/files-resource.js', __FILE__), array('cuf-angular-resource'));
    wp_register_script('cuf-backup-resource', plugins_url('js/resource/backup-resource.js', __FILE__), array('cuf-angular-resource'));

    //controller
    wp_register_script('cuf-cuf-ctrl', plugins_url('js/ctrl/cuf-ctrl.js', __FILE__), array('cuf-angular'));
    wp_register_script('cuf-options-ctrl', plugins_url('js/ctrl/options-ctrl.js', __FILE__), array('cuf-options-resource'));
    wp_register_script('cuf-files-ctrl', plugins_url('js/ctrl/files-ctrl.js', __FILE__), array('cuf-files-resource'));
    wp_register_script('cuf-backup-ctrl', plugins_url('js/ctrl/backup-ctrl.js', __FILE__), array('cuf-backup-resource'));
	wp_register_script('cuf-log-ctrl', plugins_url('js/ctrl/log-ctrl.js', __FILE__), array('cuf-cuf-ctrl'));


    //cuf principal JS
    wp_register_script('cuf-js', plugins_url('js/cuf.js', __FILE__), array('cuf-angular', 'cuf-angular-animate', 'cuf-bootstrap', 'cuf-angular-ui'));
}


function CUF_admin_menu()
{

    /* Add our plugin submenu and administration screen */
    $page_hook_suffix = add_submenu_page('tools.php', // The parent page of this submenu
        __('CUF Clean upload path', 'cuf'), // The submenu title
        __('CUF Clean upload path', 'cuf'), // The screen title
        'activate_plugins', // The capability required for access to this submenu
        'cuf', // The slug to use in the URL of the screen
        'CUF_display_menu' // The function to call to display the screen
    );

    /*
      * Use the retrieved $page_hook_suffix to hook the function that links our script.
      * This hook invokes the function only on our plugin administration screen,
      * see: http://codex.wordpress.org/Administration_Menus#Page_Hook_Suffix
      */
    add_action('admin_print_scripts-' . $page_hook_suffix, 'CUF_admin_scripts');

}

function CUF_admin_scripts()
{
	wp_enqueue_style('cuf-css-bootstrap');
    wp_enqueue_style('cuf-css');

    /* Link our already registered script to a page */
    wp_enqueue_script('cuf-js');

    //include resources
    wp_enqueue_script('cuf-options-resource');
    wp_enqueue_script('cuf-files-resource');
    wp_enqueue_script('cuf-backup-resource');

    //include controllers
    wp_enqueue_script('cuf-cuf-ctrl');
    wp_enqueue_script('cuf-options-ctrl');
    wp_enqueue_script('cuf-files-ctrl');
    wp_enqueue_script('cuf-backup-ctrl');
 	wp_enqueue_script('cuf-log-ctrl');
}

/* Display our administration screen */
function CUF_display_menu()
{
    ?>

    <div ng-app="cufPlugin">

        <div ng-controller="CufCtrl">

            <uib-tabset>

                <uib-tab  heading="<?php _e('Warning', 'cuf') ?>">
                    <h1>
                        <?php _e('WARNING ABOUT THIS PLUGIN', 'cuf') ?>
                    </h1>
                    <?php include_once 'html/warning.php'; ?>
                </uib-tab>

                <uib-tab select='tabFiles()' heading="<?php _e('Files', 'cuf') ?>">
                    <h1>
                        <?php _e('CUF search unused/used image in the upload path', 'cuf') ?>
                    </h1>
                    <?php include_once 'html/files.php'; ?>
                </uib-tab>

                <uib-tab select='tabBackups()' heading="<?php _e('Backups', 'cuf') ?>">
                    <h1>
                        <?php _e('CUF backup', 'cuf') ?>
                    </h1>
                    <?php include_once 'html/backup.php'; ?>

                </uib-tab>

                <uib-tab select='tabOptions()' heading="<?php _e('Options', 'cuf') ?>">
                    <h1>
                        <?php _e('CUF options', 'cuf') ?>
                    </h1>
                    <?php include_once 'html/options.php'; ?>
                </uib-tab>

                <uib-tab select='tabLogs()' heading="<?php _e('Logs', 'cuf') ?>">
                    <h1>
                        <?php _e('CUF Logs', 'cuf') ?>
                    </h1>
                    <?php include_once 'html/log.php'; ?>
                </uib-tab>

            </uib-tabset>
        </div>
    </div>

<?php

}

add_action('plugins_loaded', 'cuf_load_textdomain');
function cuf_load_textdomain() {
    load_plugin_textdomain( 'cuf', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
//
//function CUF_activate() {
//    BackupRest::makeBackupFolder();
//}
//
//
//
//register_activation_hook( __FILE__, 'CUF_activate' );
if (is_admin()) {

    include_once 'php/php5_3/JsonSerializable.php';
/*
	if (!class_exists('ErrorHandlerCUF')) {
        include_once 'php/model/ErrorHandlerCUF.php';
    }
*/
 	if (!class_exists('RestResponseCUF')) {
        include_once 'php/model/RestResponseCUF.php';
    }

    if (!class_exists('FileCUF')) {
        include_once 'php/model/FileCUF.php';
    }

    if (!class_exists('HelperCUF')) {
        include_once 'php/helpers/HelperCUF.php';
    }

	if (!class_exists('OptionsCUF')) {
        include_once 'php/model/OptionsCUF.php';
    }
	if (!class_exists('DatabaseCUF')) {
        include_once 'php/model/DatabaseCUF.php';
    }
	
	if (!class_exists('StatusBackupCUF')) {
        include_once 'php/model/StatusBackupCUF.php';
    }
    if (!class_exists('StatusCUF')) {
        include_once 'php/model/StatusCUF.php';
    }

    if (!class_exists('StatusAttachCUF')) {
        include_once 'php/model/StatusAttachCUF.php';
    }
    if (!class_exists('StatusUsedCUF')) {
        include_once 'php/model/StatusUsedCUF.php';
    }
    if (!class_exists('StatusInServerCUF')) {
        include_once 'php/model/StatusInServerCUF.php';
    }


    if (!class_exists('ConvertJsonToSavePHP')) {
        include_once 'php/converters/ConvertJsonToSavePHP.php';
    }
    if (!class_exists('ConvertOptionsCUF')) {
        include_once 'php/converters/ConvertOptionsCUF.php';
    }
    if (!class_exists('ConvertWordpressToCUF')) {
        include_once 'php/converters/ConvertWordpressToCUF.php';
    }


    if (!class_exists('BasicRestCUF')) {
        include_once 'php/rest/BasicRestCUF.php';
    }
    if (!class_exists('OptionsRestCUF')) {
        include_once 'php/rest/OptionsRestCUF.php';
    }
    if (!class_exists('FileRestCUF')) {
        include_once 'php/rest/FileRestCUF.php';
    }
    if (!class_exists('BackupRestCUF')) {
        include_once 'php/rest/BackupRestCUF.php';
    }


    if (!class_exists('CheckerImageAbstractCUF')) {
        include_once 'php/checkers/CheckerImageAbstractCUF.php';
    }
    if (!class_exists('CheckerImageExcerptAllCUF')) {
        include_once 'php/checkers/CheckerImageExcerptAllCUF.php';
    }
    if (!class_exists('CheckerImageExcerptBestLuckCUF')) {
        include_once 'php/checkers/CheckerImageExcerptBestLuckCUF.php';
    }
    if (!class_exists('CheckerImagePostAndPageAllCUF')) {
        include_once 'php/checkers/CheckerImagePostAndPageAllCUF.php';
    }
    if (!class_exists('CheckerImagePostAndPageBestLuckCUF')) {
        include_once 'php/checkers/CheckerImagePostAndPageBestLuckCUF.php';
    }
    if (!class_exists('CheckerImagePostMetaCUF')) {
        include_once 'php/checkers/CheckerImagePostMetaCUF.php';
    }
    if (!class_exists('CheckerImagePostMetaCUF')) {
        include_once 'php/checkers/CheckerImagePostMetaCUF.php';
    }
    if (!class_exists('CheckersCUF')) {
        include_once 'php/checkers/CheckersCUF.php';
    }

    include_once 'php/rest/ConfRestCUF.php';
    


}
