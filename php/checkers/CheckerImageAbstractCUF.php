<?php

/**
 *
 * @author nicearma
 */
abstract class CheckerImageAbstractCUF {

    protected $databaseCUF;
    protected $checkersCUF;

    function __construct($databaseCUF, $checkersCUF)
    {
        $this->databaseCUF = $databaseCUF;
        $this->checkersCUF=$checkersCUF;
        $this->checkersCUF->addChecker($this);
    }


    abstract function checkImage($id,$src,$optionCUF);


}