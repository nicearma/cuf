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
         $sql = "SELECT id FROM " . $this->database->getPrefix() . "posts WHERE post_content is not null and post_content!=''  and post_type in ('attachment') and post_content LIKE '%$src%' limit 0, 1";
        return $this->database->getDb()->get_results($sql, "ARRAY_A");
    }

}
