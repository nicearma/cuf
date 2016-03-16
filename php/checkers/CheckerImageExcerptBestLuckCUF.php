<?php
/**
 *
 * @author nicearma
 */
class CheckerImageExcerptBestLuckCUF extends CheckerImageAbstractCUF{


    function checkImage($id, $src, $optionCUF)
    {
      
      	if ($optionCUF->isExcerptCheck()) {
	        $sql = "SELECT id FROM " .$this->databaseCUF->getPrefix() . "posts WHERE  post_excerpt in (SELECT post_parent FROM " .$this->databaseCUF->getPrefix() . "posts WHERE id=" . $id . " ) and post_excerpt LIKE '%/$src%'";


	        return  $this->databaseCUF->getDb()->get_results($sql, "ARRAY_A");
		}
		return array();
    }
}

