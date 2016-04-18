<?php

/**
 *
 * @author nicearma
 */
abstract class CheckerImageAbstractCUF {

    protected $database;
    protected $checkers;

    function __construct($database, $checkers)
    {
        $this->database = $database;
        $this->checkers=$checkers;
        $this->checkers->addChecker($this);
    }


    abstract function checkImage($src,$optionCUF);


}