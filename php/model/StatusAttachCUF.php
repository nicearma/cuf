<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 04/04/2016
 * Time: 19:40
 */

class StatusAttachCUF {

    public static $ERROR=-2;
    public static $UNKNOWN = -1;
    public static $UNATTACH=0;
    public static $ATTACH_ORIGINAL=1;
    public static $ATTACH_META=5;
    public static $BACKUP_ATTACH=2;
    public static $DELETED_ATTACH=3;
    public static $DELETING_ATTACH=4;
    
    public static $ASKING=99;
}