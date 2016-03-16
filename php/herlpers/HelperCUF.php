<?php

/**
 * Description of HelperCUF
 *
 * @author nicearma
 */
class HelperCUF
{


    public function getAllDirs($dirBase)
    {

        $recursiveDir = new RecursiveDirectoryIterator($dirBase, RecursiveDirectoryIterator::SKIP_DOTS);

        $iter = new RecursiveIteratorIterator(
            $recursiveDir,
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        $paths = array($dirBase);

        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

    public function getDirsFromDir($dirBase)
    {

        $recursiveDir = new RecursiveDirectoryIterator($dirBase, RecursiveDirectoryIterator::SKIP_DOTS);

        $iter = new RecursiveIteratorIterator(
            $recursiveDir,
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        $paths = array($dirBase);

        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }

        return $paths;
    }


    public function getFilesFromFolder($dirBase)
    {

        $dirIterator = new DirectoryIterator($dirBase);

        $iter = new IteratorIterator($dirIterator);

        $paths = array();

        foreach ($iter as $path => $dir) {
            if (!$dir->isDir()) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

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
        json_encode(new RestResponseCuf($data));
    }

    public function getObjectFromJson()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

}
