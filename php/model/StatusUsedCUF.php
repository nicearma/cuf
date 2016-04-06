<?php


class StatusUsedCUF {

/* -5 => Backup error
    * -3 => Error
     * -2 => UNKNOWN
     * -1 => Asking...
     * 0 => Unused
     * 1 => Used
     * 2 => Deleted
     * 3 => Erasing
     * 4 => Making backup
     * 5 => backup made
     */
    public static $ERROR=-2;
    public static $UNKNOWN = -1;
    public static $UNUSED=0;
    public static $USED=1;
    public static $ASKING=99;


}