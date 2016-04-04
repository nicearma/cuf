<?php
/**
*
* @author nicearma
*/
class StatusBackupCUF implements JsonSerializable
{


/*
* -4 backup id path can not be delete
* -3 => can not be delete backup path
* -2 => status unknow
*  0 => backup path not exists
*  1 => backup path exist
*  2 => moved to upload path (restore option)
*  3 => backup id path have been deleted
*  4 => Restoring...
*  5 => Deleting...
*  6 => Restored and deleted
*  7 => Restored and deleting...
*/
public $inServer = -2;


/**
* @return int
*/
public function getInServer()
{
return $this->inServer;
}

/**
* @param int $inServer
*/
public function setInServer($inServer)
{
$this->inServer = $inServer;
}


public function jsonSerialize()
{
return get_object_vars($this);
}
}


