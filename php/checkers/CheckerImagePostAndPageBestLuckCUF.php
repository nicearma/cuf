<?php
/**
 *
 * @author nicearma
 */
class CheckerImagePostAndPageBestLuckCUF extends CheckerImageAbstractCUF{


    function checkImage($id, $src, $optionCUF)
    {
        //FIND in the post parent the reference, this will useful if the image is used where was uploaded
        $sql = "SELECT id FROM " .$this->databaseCUF->getPrefix() . "posts WHERE  post_parent in (SELECT post_parent FROM " .$this->databaseCUF->getPrefix() . "posts WHERE id=" . $id . " ) and post_content LIKE '%/$src%'";

        return  $this->databaseCUF->getDb()->get_results($sql, "ARRAY_A");

    }
}

