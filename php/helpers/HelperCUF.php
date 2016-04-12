<?php

/**
 * Description of HelperCUF
 *
 * @author nicearma
 */
class HelperCUF
{


    public function fileExist($src)
    {
        $uploadDir = wp_upload_dir();
        if (file_exists($uploadDir['basedir'] . '/' . $src)) {
            return 1;
        }
        return 0;
    }


    public function backupFolderExist()
    {
        return file_exists($this->backupDir());
    }

    public function backupDir()
    {

        $backupDir = $this->uploadDir() . '/' . 'cuf_backups';
        return $backupDir;
    }


    public function uploadDir()
    {
        $uploadDir = wp_upload_dir();
        $basedir = $uploadDir['basedir'];
        return $basedir;
    }

    public function copy($source, $dest)
    {
        if (file_exists($source)) {
            return copy($source, $dest);
        } else {
            return false;
        }
    }

    public function generateResponseOk($data)
    {
        echo json_encode(new RestResponseCuf($data));
        wp_die();
    }

    public function generateResponseBad($data)
    {
        echo json_encode(new RestResponseCuf($data),400);
        wp_die();
    }

    public function getObjectFromJson()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

}
