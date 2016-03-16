<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 16/03/2016
 * Time: 20:46
 */

class BasicRestCUF {

    protected $databaseCUF;
    protected $optionsCUF;
    protected $helpCUF;

    function __construct()
    {
        $this->databaseCUF = new DatabaseCUF();
        $this->optionsCUF = OptionsRestCUF::readOptions();
        $this->helpCUF = new HelperCUF();

    }


}