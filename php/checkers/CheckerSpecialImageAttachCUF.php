<?php

/**
 *
 * @author nicearma
 */
class CheckerSpecialImageAttachCUF {

    protected $databaseCUF;

    function __construct($databaseCUF) {
        $this->databaseCUF = $databaseCUF;
    }

    function verify($src, $optionCUF) {

        if ($optionCUF->isPostMetaCheck()) {
            $sql = "SELECT post_id FROM " . $this->databaseCUF->getPrefix() . "postmeta WHERE meta_key='_wp_attached_file' and meta_value LIKE '%/$src%'";
            return $this->databaseCUF->getDb()->get_results($sql, "ARRAY_A");
        }

        return array();
    }

}
