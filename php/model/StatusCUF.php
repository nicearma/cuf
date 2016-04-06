<?php

class StatusCUF implements JsonSerializable
{


    
    public $used;

    public $attach;
    
    public $inServer;



    function __construct()
    {
        $this->used=StatusUsedCUF::$UNKNOWN;
        $this->attach=StatusAttachCUF::$UNKNOWN;
        $this->inServer=StatusInServerCUF::$UNKNOWN;
    }



    /**
     * @return int
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param int $used
     */
    public function setUsed($used)
    {
        $this->used = $used;
    }

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