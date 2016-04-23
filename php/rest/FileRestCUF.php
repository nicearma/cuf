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

    public function getAllDirectoriesFromDirectory(){
       // $json=$this->helpCUF->getObjectFromJson();
        $dirs=  $this->helpCUF->getDirsFromDir($this->helpCUF->uploadDir());
        $this->helpCUF->generateResponseOk($dirs);
    }

    public function getFilesFromDirectory(){
        //TODO: add security
        $jPath=$this->helpCUF->getObjectFromJson();
        if(!empty($jPath['path'])){
            $files=$this->helpCUF->getFilesFromFolder($jPath['path']);
        $this->helpCUF->generateResponseOk($files);
    }else{
        //TODO: empty path
    }

        
    }

    public function verifyFile(){
        $jSrc=$this->helpCUF->getObjectFromJson();
        //security 
      if(file_exists($jSrc->src)){
        $uploadDir= $this->helpCUF->uploadDir();

          if ((0 === strpos($jSrc->src, $uploadDir)) && (false ==!strpos($jSrc->src, ".."))) {


          $checkers= new CheckersCUF($this->databaseCUF);
          $statusCUF= new statusCUF();
          $checkerAttach= new CheckerSpecialImageAttachCUF($this->databaseCUF);

          if($checkers->verify($jSrc->src, $this->optionsCUF)){
            $statusCUF->setUsed(StatusUsedCUF::$USED);
          }else{
            $statusCUF->setUsed(StatusUsedCUF::$UNUSED);
          }
          
          $resultCheckerAttach=$checkerAttach->verify($jSrc->src, $this->optionsCUF);

          if(!empty($resultCheckerAttach)&&count($resultCheckerAttach)>0){
             $statusCUF->setAttach(StatusAttachCUF::$ATTACH);
          }else{
             $statusCUF->setAttach(StatusAttachCUF::$UNATTACH);
          }
        }


      } 

    }

    public function deleteFile(){

    }

    

    
}