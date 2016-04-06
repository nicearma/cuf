<?php


class StatusInServerCUF {

	/*
     * -5 => Backup error
    * -2 => UNKNOWN
    * -1 => Asking...
    *  0 => Not in server
    *  1 => In server
     * 4 => Making backup
     * 5 => backup made
     *
    */

    public static $ERROR=-2;
    public static $UNKNOWN = -1;
    public static $NOTINSERVER=0;
    public static $INSERVER=1;
    public static $ASKING=99;

}