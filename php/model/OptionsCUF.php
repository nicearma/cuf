<?php

/**
 * Description of Option
 *
 * @author nicearma
 */
class OptionsCUF implements JsonSerializable
{

    public $version;
    public $updateInServer;
    public $backup;
    public $admin;
    public $ignoreFolder;
    public $ignoreExtension;
    public $showUsedImage;
    
    public $galleryCheck;
    public $shortCodeCheck;
    public $excerptCheck;
    public $postMetaCheck;
    public $draftCheck;
    
    public $order;
    public $maxSize;
    public $debug;

    function __construct()
    {
        $this->version = "2.0";
        $this->updateInServer = true;
        //default active if the backup path exist
        $helper= new HelperCUF();
        $this->backup =$helper->backupFolderExist();
        $this->admin = true;
        $this->ignoreExtension=array(".htaccess",".php");
        $this->ignoreFolder = array("dnui");
        $this->showUsedImage=false;

        $this->galleryCheck = true;
        $this->shortCodeCheck = true;
        $this->excerptCheck = true;
        $this->postMetaCheck = true;
        $this->draftCheck = true;
               
        $this->order = 0;
        $this->maxSize=8;
        $this->debug=false;
    }

    //TODO: update all get and set
    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return boolean
     */
    public function isUpdateInServer()
    {
        return $this->updateInServer;
    }

    /**
     * @param boolean $updateInServer
     */
    public function setUpdateInServer($updateInServer)
    {
        if (is_bool($updateInServer)) {
            $this->updateInServer = $updateInServer;
        }

    }

    /**
     * @return boolean
     */
    public function isBackup()
    {
        return $this->backup;
    }

    /**
     * @param boolean $backup
     */
    public function setBackup($backup)
    {
        if (is_bool($backup)) {
            $this->backup = $backup;
        }

    }

    /**
     * @return boolean
     */
    public function isShowUsedImage()
    {
        return $this->showUsedImage;
    }

    /**
     * @param boolean $showUsedImage
     */
    public function setShowUsedImage($showUsedImage)
    {
        if (is_bool($showUsedImage)) {
            $this->showUsedImage = $showUsedImage;
        }
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param boolean $admin
     */
    public function setAdmin($admin)
    {
        if (is_bool($admin)) {
            $this->admin = $admin;
        }


    }


    /**
     * @return boolean
     */
    public function isGalleryCheck()
    {
        return $this->galleryCheck;
    }

    /**
     * @param boolean $galleryCheck
     */
    public function setGalleryCheck($galleryCheck)
    {
        if (is_bool($galleryCheck)) {
            $this->galleryCheck = $galleryCheck;
        }

    }

    /**
     * @return boolean
     */
    public function isShortCodeCheck()
    {
        return $this->shortCodeCheck;
    }

    /**
     * @param boolean $shortCodeCheck
     */
    public function setShortCodeCheck($shortCodeCheck)
    {
        if (is_bool($shortCodeCheck)) {
            $this->shortCodeCheck = $shortCodeCheck;
        }
    }

    /**
     * @return boolean
     */
    public function isExcerptCheck()
    {
        return $this->excerptCheck;
    }

    /**
     * @param boolean $excerptCheck
     */
    public function setExcerptCheck($excerptCheck)
    {
        if (is_bool($excerptCheck)) {
            $this->excerptCheck = $excerptCheck;
        }

    }

    /**
     * @return boolean
     */
    public function isPostMetaCheck()
    {
        return $this->postMetaCheck;
    }

    /**
     * @param boolean $postMetaCheck
     */
    public function setPostMetaCheck($postMetaCheck)
    {
        if (is_bool($postMetaCheck)) {
            $this->postMetaCheck = $postMetaCheck;
        }

    }

    /**
     * @return boolean
     */
    public function isDraftCheck()
    {
        return $this->draftCheck;
    }

    /**
     * @param boolean $draftCheck
     */
    public function setDraftCheck($draftCheck)
    {
        if (is_bool($draftCheck)) {
            $this->draftCheck = $draftCheck;
        }

    }

    /**
     * @return int
     */
    public function getOrder()
    {

        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        if (!is_int($order)) {
            $order = 0;
        }
        $this->order = $order;
    }


    /**
     * @return int
     */
    public function getMaxSize()
    {

        return $this->maxSize;
    }

    /**
     * @param int $maxSize
     */
    public function setMaxSize($maxSize)
    {
        if (!is_int($maxSize)) {
            $maxSize = 8;
        }
        $this->maxSize = $maxSize;
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug=$debug;
    }

    /**
     * @return array
     */
    public function getIgnoreFolder()
    {
        return $this->ignoreFolder;
    }

    /**
     * @param array $ignoreFolder
     */
    public function setIgnoreFolder($ignoreFolder)
    {
        $this->ignoreFolder = $ignoreFolder;
    }

    /**
     * @return array
     */
    public function getIgnoreExtension()
    {
        return $this->ignoreExtension;
    }

    /**
     * @param array $ignoreExtension
     */
    public function setIgnoreExtension($ignoreExtension)
    {
        $this->ignoreExtension = $ignoreExtension;
    }




    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


}
