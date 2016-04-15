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
        $sql = "SELECT post_id FROM " . $this->databaseCUF->getPrefix() . "postmeta WHERE meta_key in ('_wp_attached_file','_wp_attachment_metadata') and meta_value LIKE '%$src%' limit 0, 1";
        return $this->databaseCUF->getDb()->get_results($sql, "ARRAY_A");
    }

}
