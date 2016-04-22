<?php

/**
 * Description of Backup
 *
 * @author nicearma
 */
class FileRestCUF extends BasicRestCUF {

    function __construct() {
        parent::__construct();
    }

    public function getAllDirectories() {

        $dirBase = $this->help->uploadDir();
        $recursiveDir = new RecursiveDirectoryIterator($dirBase, RecursiveDirectoryIterator::SKIP_DOTS);

        $iter = new RecursiveIteratorIterator(
                $recursiveDir, RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        $paths = array('base' => $dirBase);

        foreach ($iter as $path => $dir) {
            if ($dir->isDir()) {
                $paths["dirs"][] = str_replace($dirBase, "", $path);
            }
        }



        $this->help->generateResponseOk($paths);
    }

    public function getAllDirectoriesFromDirectory() {
        // $json=$this->helpCUF->getObjectFromJson();
        $dirBase = $this->help->uploadDir();
        $dirIterator = new DirectoryIterator($dirBase);

        $iter = new IteratorIterator($dirIterator);

        $dirs = array();

        foreach ($iter as $file) {
            if (!$file->isFile() && !$file->isDot())
                $dirs[] = $file->getFilename();
        }

        $this->help->generateResponseOk($dirs);
    }

    public function getFilesFromDirectory() {
        //TODO: add security
        $jPath = $this->help->getObjectFromJson();
        $dirPath = $this->help->uploadDir() . $jPath['path'];



        if (!empty($dirPath)) {

            $dirIterator = new DirectoryIterator($dirPath);

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
                    $fileCuf->status = new StatusCUF();
                    $fileCuf->status->inServer = StatusInServerCUF::$INSERVER;
                    $files[] = $fileCuf;
                }
            }

            $this->help->generateResponseOk($files);
        } else {
            //TODO: empty path
        }
    }

    public function verifyFile() {
        $jSrc = $this->help->getObjectFromJson();

        //this is for security reasons
        if (stripos("..", $jSrc['name']) !== false || stripos("..", $jSrc['path']) !== false) {
            return;
        }


        $filePath = $jSrc['path'] . '/' . $jSrc['name'];

        //security 
        if (file_exists($this->help->uploadDir() . $filePath)) {

            $statusResponse = new StatusResponseCUF();
            $status = new statusCUF();
            $status->setInServer(StatusInServerCUF::$INSERVER);
            $statusResponse->setStatus($status);
            $checkers = new CheckersCUF($this->database);
            $checkerAttach = new CheckerSpecialImageAttachCUF($this->database);
            $checkerAttachPostMeta = new CheckerSpecialImageAttachPostMetaCUF($this->database);

            if ($checkers->verify($filePath, $this->options)) {
                $status->setUsed(StatusUsedCUF::$USED);
            } else {
                $status->setUsed(StatusUsedCUF::$UNUSED);
            }

            $status->setAttach(StatusAttachCUF::$UNATTACH);

            $resultCheckerAttach = $checkerAttach->verify($filePath, $this->options);

            if (!empty($resultCheckerAttach)) {
                $count = count($resultCheckerAttach);
                
                $status->setAttach(StatusAttachCUF::$ATTACH_ORIGINAL);
                
                if ($count == 1) {
                   $statusResponse->setId($resultCheckerAttach['0']['id']);
                 
                } else if($count > 1) {
                    //TODO:......
                    $statusResponse->setId($resultCheckerAttach['0']['id']);                  
                   
                }
            }else{
              $resultCheckerAttachPostMeta=  $checkerAttachPostMeta->verify($jSrc['name'], $this->options);
            
              if (!empty($resultCheckerAttachPostMeta)) {
                $count = count($resultCheckerAttachPostMeta);
                
                $status->setAttach(StatusAttachCUF::$ATTACH_META);
                
                if ($count == 1) {
                   $statusResponse->setId($resultCheckerAttachPostMeta['0']['post_id']);
                 
                } else if($count > 1) {
                    //TODO:......
                    $statusResponse->setId($resultCheckerAttachPostMeta['0']['post_id']);                  
                   
                }
            }
              
              
              
              
            }
            $this->help->generateResponseOk($statusResponse);
        } else {
            
        }
    }

    public function deleteFile() {
        
    }
    
    

}
