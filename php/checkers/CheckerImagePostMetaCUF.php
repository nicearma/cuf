<?php
/**
 *
 * @author nicearma
 */
class CheckerImagePostMetaCUF extends CheckerImageAbstractCUF{


    function checkImage($src, $option)
    {

    	if ($option->isPostMetaCheck()) {
       
	        $sql = "SELECT post_id FROM " .$this->database->getPrefix() . "postmeta WHERE meta_key not in  ('_wp_attachment_metadata','_wp_attached_file') and meta_value LIKE '%/$src%'";

	        return  $this->database->getDb()->get_results($sql, "ARRAY_A");
		}

		return array();
    
    }


}

