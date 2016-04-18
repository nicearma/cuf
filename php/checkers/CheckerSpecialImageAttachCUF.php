<?php

/**
 *
 * @author nicearma
 */
class CheckerSpecialImageAttachCUF {

    protected $database;

    function __construct($database) {
        $this->database = $database;
    }

    function verify($src, $option) {
        $sql = "SELECT post_id FROM " . $this->database->getPrefix() . "postmeta WHERE meta_key in ('_wp_attached_file','_wp_attachment_metadata') and meta_value LIKE '%$src%' limit 0, 1";
        return $this->database->getDb()->get_results($sql, "ARRAY_A");
    }

}
