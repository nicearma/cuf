<?php
/**
 * Description of Backup
 *
 * @author nicearma
 */
class FileRestCUF
{

    private $databaseCUF;
    private $optionsCUF;
    private $helpCUF;

    function __construct()
    {
        $this->databaseCUF = new DatabaseCUF();
        $this->optionsCUF = OptionsRestCUF::readOptions();
        $this->helpCUF = new HelperCUF();
    }


    public function getAllDirectories(){
      $dirs=  $this->helpCUF::getAllDirs();
      $this->helpCUF->generateResponseOk($dirs);
    }

    public function getAllDirectoryFromDirectory(){
        $json=$this->helpCUF->getObjectFromJson();
        $dirs=  $this->helpCUF->getDirsFromDir();
        $this->helpCUF->generateResponseOk($dirs);
    }

    public function getFilesFromDirectory(){

    }

    public function deleteFile(){

    }

    

    
}