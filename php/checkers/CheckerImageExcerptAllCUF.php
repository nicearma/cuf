<?php

/**
 *
 * @author nicearma
 */
class CheckerImageExcerptAllCUF extends CheckerImageAbstractCUF
{

    function checkImage($src, $optionCUF, $id=null)
    {

    	if ($optionCUF->isExcerptCheck()) {
			
			if ($optionCUF->isDraftCheck()) {
		            $sql = "SELECT id FROM " .$this->databaseCUF->getPrefix() . "posts  WHERE post_excerpt is not null and post_excerpt!=''  and post_type not in ('attachment','nav_menu_item') and post_excerpt LIKE '%/$src%' limit 0,1";
		    }else{
		        	$sql = "SELECT id FROM " . $this->databaseCUF->getPrefix() . "posts  WHERE post_excerpt is not null and post_excerpt!=''  and post_type not in ('attachment','nav_menu_item','revision') and post_status !='draft' and post_excerpt LIKE '%/$src%' limit 0,1";
		    }

	        return $this->databaseCUF->getDb()->get_results($sql, "ARRAY_A");
    	}

    	return array();
    }

}


