<?php

/*####################################################################*/
add_action('wp_ajax_cuf_get_all_backup', 'cuf_get_all_backup');

function cuf_get_all_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->readAll();
}

add_action('wp_ajax_cuf_delete_all_backup', 'cuf_delete_all_backup');

function  cuf_delete_all_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->deleteAll();
}

add_action('wp_ajax_cuf_delete_by_id_backup', 'cuf_delete_by_id_backup');

function cuf_delete_by_id_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->deleteById();
}


add_action('wp_ajax_cuf_make_backup', 'cuf_make_backup');

function cuf_make_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->make();
}


add_action('wp_ajax_cuf_restore_backup', 'cuf_restore_backup');

function cuf_restore_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->restoreBackup();
}


add_action('wp_ajax_cuf_make_backup_folder_backup', 'cuf_make_backup_folder_backup');

function cuf_make_backup_folder_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->makeBackupFolder();
}


add_action('wp_ajax_cuf_exists_backup_folder_backup', 'cuf_exists_backup_folder_backup');

function cuf_exists_backup_folder_backup()
{
    $backupRest = new BackupRestCUF();
    $backupRest->existsBackupFolder();
}

/*####################################################################*/

add_action('wp_ajax_cuf_get_options', 'cuf_get_options');

function cuf_get_options()
{
    $optionsRest = new OptionsRestCUF();
    $optionsRest->read();
}

add_action('wp_ajax_cuf_update_options', 'cuf_update_options');

function cuf_update_options()
{
    $optionsRest = new OptionsRestCUF();
    $optionsRest->update();
}

add_action('wp_ajax_cuf_restore_options', 'cuf_restore_options');

function cuf_restore_options()
{
    $optionsRest = new OptionsRestCUF();
    $optionsRest->restore();
}
add_action('wp_ajax_cuf_have_wc_options', 'cuf_have_wc_options');

function cuf_have_wc_options()
{
    $optionsRest = new OptionsRestCUF();
    $optionsRest->haveWooCommerce();
}

/*####################################################################*/

add_action('wp_ajax_cuf_get_directories_file', 'cuf_get_directories_file');

function cuf_get_directories_files()
{
    $filesRest = new FileRestCUF();
    $filesRest->getAllDirectories();
}

add_action('wp_ajax_cuf_get_directory_from_directory_file', 'cuf_get_directory_from_directory_file');

function cuf_get_directory_from_directory_file()
{
    $filesRest = new FileRestCUF();
    $filesRest->getAllDirectoryFromDirectory();
}

add_action('wp_ajax_cuf_get_files_from_directory_file', 'cuf_get_files_from_directory_file');

function cuf_get_files_from_directory_file()
{
    $filesRest = new FileRestCUF();
    $filesRest->getFilesFromDirectory();
}