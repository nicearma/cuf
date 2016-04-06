<?php

/**
 *
 * @author nicearma
 */
 class CheckerSpecialImageAttachCUF {

    protected $databaseCUF;
    protected $checkersCUF;

    function __construct($databaseCUF, $checkersCUF)
    {
        $this->databaseCUF = $databaseCUF;
        $this->checkersCUF=$checkersCUF;
        
    }

    //TODO: change this for attach
    function checkAttach($src,$optionCUF){

    	if ($optionCUF->isPostMetaCheck()) {
       
	        $sql = "SELECT post_id FROM " .$this->databaseCUF->getPrefix() . "postmeta WHERE meta_key not in  ('_wp_attachment_metadata','_wp_attached_file') and meta_value LIKE '%/$src%'";

	        return  $this->databaseCUF->getDb()->get_results($sql, "ARRAY_A");
		}

		return array();

    }


}