<?php


class RestResponseCUF
{
	public $httpStatus;
	public $data;

 function __construct($data,$httpStatus=200)
    {
        $this->data=$data;
        $this->httpStatus=$httpStatus;
        
    }

    public function setHttpStatus($httpStatus){
		$this->httpStatus=$httpStatus;

    }

   public function getHttpStatus(){
		return $this->httpStatus;

    }


    public function setData($data){
		$this->data=$data;

    }

     public function getData(){
		return $this->data;

    }

}