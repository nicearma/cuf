<?php

/**
 * Description of StatusResponse
 *
 * @author detn
 */
class StatusResponseCUF implements JsonSerializable{
    
    public $status;
    public $id;
    
    function getStatus() {
        return $this->status;
    }

    function getId() {
        return $this->id;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
    
}
