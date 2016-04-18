<?php
/**
 *
 * @author nicearma
 */
class CheckerImagePostAndPageAllCUF extends CheckerImageAbstractCUF
{

    function checkImage($src, $option)
    {

    	 if ($option->isDraftCheck()) {
            $sql = "SELECT id FROM " .$this->database->getPrefix() . "posts  WHERE post_content is not null and post_content!=''  and post_type not in ('attachment','nav_menu_item') and post_content LIKE '%/$src%' limit 0,1";
        }else{
        	$sql = "SELECT id FROM " . $this->database->getPrefix() . "posts  WHERE post_content is not null and post_content!=''  and post_type not in ('attachment','nav_menu_item','revision') and post_status !='draft' and post_content LIKE '%/$src%' limit 0,1";
        }
        
        return $this->database->getDb()->get_results($sql, "ARRAY_A");
    }

}