<?php
/**
 * Description of Backup
 *
 * @author nicearma
 */
class FileRestCUF extends BasicRestCUF
{

    function __construct()
    {
        parent::__construct();
    }


    public function getAllDirectories(){
      $dirs=  $this->helpCUF->getAllDirs($this->helpCUF->uploadDir());
      $this->helpCUF->generateResponseOk($dirs);

    }

    public function getAllDirectoryFromDirectory(){
       // $json=$this->helpCUF->getObjectFromJson();
        $dirs=  $this->helpCUF->getDirsFromDir($this->helpCUF->uploadDir());
        $this->helpCUF->generateResponseOk($dirs);
    }

    public function getFilesFromDirectory(){
        $files=$this->helpCUF->getFilesFromFolder($this->helpCUF->uploadDir());
        $this->helpCUF->generateResponseOk($files);
    }

    public function deleteFile(){

    }

    

    
}