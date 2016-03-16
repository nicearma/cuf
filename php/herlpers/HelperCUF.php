<?php
/**
 * Description of HelperCUF
 *
 * @author nicearma
 */
class HelperCUF {


    /**
     * Only the folders
     * @param type $dirBase
     * @return array
     */
    public static function getAllDirs($dirBase) {

        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirBase, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
        );

        $paths = array($dirBase);
        
        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }
        
        return $paths;
    }
    
/**
     * Only the folders
     * @param type $dirBase
     * @return array
     */
    public static function getDirsFromDir($dirBase) {

        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirBase, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
        );

        $paths = array($dirBase);
        
        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths[] = $path;
            }
        }
        
        return $paths;
    }


    public static function getFilesByFolder($dirBase) {

        $dirIterator=new DirectoryIterator($dirBase, DirectoryIterator::SKIP_DOTS);

        $iter = new IteratorIterator(
            new DirectoryIterator($dirBase, DirectoryIterator::SKIP_DOTS));

        $paths = array();
        
        foreach ($iter as $path => $dir) {
            if (!$dir->isDir()) {
                $paths[] = $path;
            }
        }
        
        return $paths;
    }

    public static function fileExist($src){
        $uploadDir = wp_upload_dir();
        if( file_exists($uploadDir['basedir'].'/'.$src)){
            return 1;
        }
        return 0;
    }


	public static function backupFolderExist(){
		return file_exists(HelperCUF::backupDir());
	}

 public static function backupDir()
    {
        $uploadDir = wp_upload_dir();
        $basedir = $uploadDir['basedir'];
        $backupDir = $basedir . '/' . 'cuf_backups';
        return $backupDir;
    }

    public static function copy($source, $dest) {
        if (file_exists($source)) {
            return copy($source, $dest);
        } else {
            return false;
        }
    }

    public static function generateResponseOk($data){
        json_encode(new RestResponseCuf($data));
    }

    public static function getObjectFromJson(){
        return json_decode(file_get_contents('php://input'), true);
    }

}
