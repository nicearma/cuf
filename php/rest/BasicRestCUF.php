<?php

class BasicRestCUF {

    protected $database;
    protected $options;
    protected $help;

    function __construct()
    {
        $this->database = new DatabaseCUF();
        $this->options = OptionsRestCUF::readOptions();
        $this->help = new HelperCUF();

    }


}