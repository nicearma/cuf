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
      
      $dirBase=$this->helpCUF->uploadDir();
      $recursiveDir = new RecursiveDirectoryIterator($dirBase, RecursiveDirectoryIterator::SKIP_DOTS);

        $iter = new RecursiveIteratorIterator(
            $recursiveDir,
            RecursiveIteratorIterator::SELF_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        $paths = array('base'=>$dirBase);

        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths["dirs"][] = str_replace($dirBase, "", $path);
            }
        }

      

      $this->helpCUF->generateResponseOk($paths);

    }

    public function getAllDirectoriesFromDirectory(){
       // $json=$this->helpCUF->getObjectFromJson();
      $dirBase=$this->helpCUF->uploadDir();
      $dirIterator = new DirectoryIterator($dirBase);

        $iter = new IteratorIterator($dirIterator);

        $dirs = array();

        foreach ($iter as $file) {
            if (!$file->isFile() && !$file->isDot())
                $dirs[] = $file->getFilename();

        }

        $this->helpCUF->generateResponseOk($dirs);
    }

    public function getFilesFromDirectory(){
        //TODO: add security
        $jPath=$this->helpCUF->getObjectFromJson();
        $dirPath=$this->helpCUF->uploadDir().$jPath['path'];



        if(!empty($dirPath)){

            $dirIterator = new DirectoryIterator($dirBase);

        $iter = new IteratorIterator($dirIterator);

        $files = array();

        foreach ($iter as $file) {
             
            if ($file->isFile()) {
                $fileCuf = new FileCUF();
                $fileCuf->setName($file->getFilename());
                $fileCuf->setPath($file->getPath());
                $fileCuf->setSrc($file->getPathname());
                $fileCuf->setType(mime_content_type($file->getPathname()));
                $fileCuf->setSize($file->getSize());
                $fileCuf->status= new StatusCUF();
                $fileCuf->status->inServer=StatusInServerCUF::$INSERVER;
                $files[] = $fileCuf;

            }
        }

        $this->helpCUF->generateResponseOk($files);
    }else{
        //TODO: empty path
    }

        
    }

    public function verifyFile(){
        $jSrc=$this->helpCUF->getObjectFromJson();
        
        $filePath=$this->helpCUF->uploadDir().$jSrc['path'].'/'.$jSrc['name'];
        
        //security 
      if(file_exists($filePath)){
        $uploadDir= $this->helpCUF->uploadDir();
        //TODO: verify if the file is in the upload dir
        if(true){
          $statusCUF= new statusCUF();
          $statusCUF->setInServer(StatusInServerCUF::$INSERVER);

          $checkers= new CheckersCUF($this->databaseCUF);
          $checkerAttach= new CheckerSpecialImageAttachCUF($this->databaseCUF);
          
         
          if($checkers->verify($filePath, $this->optionsCUF)){
            $statusCUF->setUsed(StatusUsedCUF::$USED);
          }else{
            $statusCUF->setUsed(StatusUsedCUF::$UNUSED);
          }
          
          $resultCheckerAttach=$checkerAttach->verify($filePath, $this->optionsCUF);

          if(!empty($result)&&count($result)>0){
             $statusCUF->setAttach(StatusAttachCUF::$ATTACH);
          }else{
             $statusCUF->setAttach(StatusAttachCUF::$UNATTACH);
          }
        }

        $this->helpCUF->generateResponseOk($statusCUF);

      }else{

      } 

    }

    public function deleteFile(){

    }

    

    
}