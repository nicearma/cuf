<?php
/*
  Plugin Name: CUF (Cleanup upload folder)
  Version: 1.0
  Plugin URI: http://www.nicearma.com/cleanup-upload-folder-cuf/
  Author: Nicearma
  Author URI: http://www.nicearma.com/
  Text Domain: cuf
  Description: Find all file from your upload folder that are not used or simple not refered in the database of the wordpress site. 
 */

/*
  Copyright (c) 2014 http://www.nicearma.com
  Released under the GPL license
  http://www.gnu.org/licenses/gpl.txt
 */

   
include_once 'php/cufL.php';

//add the js and the css to wordpress
add_action('admin_init', 'CUF_js');
function CUF_js() {
    wp_register_style('cuf-css', plugins_url('css/cuf.css', __FILE__));
    wp_register_script('cuf-js', plugins_url('js/cuf.js', __FILE__), array('backbone', 'jquery', 'jquery-ui-tabs'));
}


//add to the menu the cuf url
add_action('admin_menu', 'CUF_option_menu');
function CUF_option_menu() {
    $cufOption = CUF_option();
    $cufOptionDefault=  CUF_default();
    //For the update problem
    if($cufOption['version']!='0.1'){
        foreach ($cufOption as $key=>$value){
            if(key_exists($key, $cufOptionDefault)){
              $cufOptionDefault[$key]=$value;  
            }
        }
        CUF_add_option($cufOptionDefault);
    }
    add_options_page('CUF cleanup upload folder', 'CUF', 'activate_plugins', basename(__FILE__), 'CUF');
}


function CUF_option(){
    return unserialize(get_option("cuf_options"));
}



//principal html of cuf
function CUF() {
    include_once 'html/backup.php';
    include_once 'html/option.php';
    include_once 'html/table.php';

    add_thickbox();
    wp_enqueue_style('cuf-css');
    wp_enqueue_script('cuf-js');
    ?>

    <p><?php _e('CUF - Cleanup upload folder') ?></p>

    <div id="cuf_general">
        <ul id="cuf_tabs_button">
            <li><a class="cuf_fd" href="#cuf_tabs_folder"><?php _e('Scan folder','cuf') ?></a></li>
            <li><a class="cuf_bk" href="#cuf_tabs_backup"><?php _e('Backup','cuf') ?></a></li>
            <li><a class="cuf_op" href="#cuf_tabs_option"><?php _e('Option','cuf') ?></a></li>
        </ul>
        <div class="tabDetails">
            <div id="cuf_tabs_folder">
                <h1><?php _e('Search by folder','cuf') ?></h1>
            </div>
            <div id="cuf_tabs_backup">
                <h1><?php _e('Backup made','cuf') ?></h1>
                <h4>Still in dev</h4>
            </div>
            <div id="cuf_tabs_option">
                <h1><?php _e('Option','cuf') ?></h1>
            </div>
        </div>


    </div>
    <?php
  
}


//call the install logic went the plugin is activate
register_activation_hook(__FILE__, 'CUF_install');
function CUF_install() {
    CUF_add_option(CUF_default());
}

function CUF_add_option($options) {
    $validator = array_filter(CUF_validator($options));

    if (empty($validator)) {
        $options = serialize($options);
        update_option("cuf_options", $options);
    }
}

function CUF_validator(&$options) {
    $validator = array();
    CUF_transform_bool($options["backup"]);
    CUF_transform_bool($options["attachement"]);
    CUF_transform_bool($options["canDelete"]);
    CUF_transform_bool($options["used"]);
    if (!(is_numeric($options["slice"]))) {
        array_push($validator, "slice is not good");
    } else {
        if (($options["slice"] == 0)) {
            $options["slice"] = intval($options["slice"]);
        }
    }
    return $validator;
}

function CUF_transform_bool(&$var) {
    if ($var == 'true') {
        $var = true;
    } else {
        $var = false;
    }
}


//default option
function CUF_default(){
      $option = array(
        'version'=>'0.1',
        'backup' => false,
        'canDelete' => false,
        'attachement' => true,
        'used' => true, 
        'slice'=>0,
        'ignore'=>array(),
          );
      return $option;
}



//************************DIRECTORY ACTION****************************************
add_action('wp_ajax_cuf_get_dirs', 'CUF_ajax_get_dirs');

function CUF_ajax_get_dirs() {
    $base = wp_upload_dir();
    $base = $base['basedir'];
    $dirs=CUF_get_all_dir_or_files($base, 0);
    $out=array();
    foreach ($dirs as $key=>$dir) {
      $out[$key]['name']=$dir;  
    }
    echo json_encode($out);
    die();
}


add_action('wp_ajax_cuf_get_files', 'CUF_ajax_get_files');

function CUF_ajax_get_files() {
    $dir=$_POST['dir'];
    $cufOption=CUF_option();
    echo json_encode(array('status'=>200,'results'=>CUF_get_files($dir,$cufOption['attachement'],$cufOption['used'])));
    die();
}

add_action('wp_ajax_cuf_delete_files', 'CUF_ajax_delete_files');

function CUF_ajax_delete_files() {
    $dir=$_POST['dir'];
    $files=$_POST['files'];
    $result=array('status'=>200);
    try{
        CUF_delete_files($dir,$files);
        
    } catch (Exception $ex) {
        $result['status']=500;
    }
    echo json_encode($result);
    die();
}



//***************************BACKUP SYSTEM****************************************
add_action('wp_ajax_cuf_get_backup', 'CUF_ajax_get_backup');

function CUF_ajax_get_backup() {
    echo json_encode(CUF_get_backup());
    die();
}

add_action('wp_ajax_cuf_restore_backup', 'CUF_ajax_restore_backup');

function CUF_ajax_restore_backup() {

    echo json_encode(CUF_restore_backup($_POST["restore"]));
    die();
}
//TODO:CHange this
add_action('wp_ajax_cuf_delete_backup', 'CUF_ajax_delete_backup');

function CUF_ajax_delete_backup() {
    echo json_encode(CUF_delete_backups($_POST["delet"]));
    die();
}

add_action('wp_ajax_cuf_cleanup_backup', 'CUF_ajax_cleanup_backup');

function CUF_ajax_cleanup_backup() {
    echo json_encode(CUF_cleanup_backup());
    die();
}


add_action('wp_ajax_cuf_get_option', 'CUF_ajax_get_option');

function CUF_ajax_get_option() {
    $cufOption = unserialize(get_option("cuf_options"));
    echo json_encode($cufOption);
    die();
}

add_action('wp_ajax_cuf_save_option', 'CUF_ajax_save_option');

function CUF_ajax_save_option() {
    $option= $_POST['option'];
    CUF_add_option($option);
    CUF_option();
    echo json_encode($option);
    die();
}

?>