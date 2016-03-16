<?php



function CUF_get_all_dir_or_files($dir, $type) {
    //get only dir
    if ($type == 0) {
        return CUF_get_dirs(array($dir));
    } else if ($type == 1) {
        $out = array();
        $arrayDirOrFile = CUF_scan_dir($dir);
        foreach ($arrayDirOrFile as $key => $filename) {
            
            if (!is_dir("$dir/$filename")) {
                array_push($out, $filename);
            }
        }
        return $out;
    }
    return array();
}

function CUF_get_files($dir, $attachement = true, $used = true,$ignores = array(),$slice=0,$offset=0) {
    
    $out = array();
    $files = CUF_get_all_dir_or_files($dir, 1);
    if($slice>0){
       $length=count($files)/$slice;
       $files=  array_slice($files, $length*$offset,$length); 
    }
    
    foreach ($files as $file) {
        $tmpOut = array();
        foreach ($ignores as $ignore) {
            if (preg_match("/.*\.$ignore/", $file)) {
                continue;
            }
        }
        $tmpOut['fileName']=$file;
        if ($attachement) {
            $attachementResult=CUF_check_db_attachement($file);
            if(!empty($attachementResult)){
               $tmpOut['attachement']= true; 
               $tmpOut['urlAttachement']= wp_get_attachment_url($attachementResult[0]['post_id']);
            }else{
               $tmpOut['attachement']= false; 
            }
             
        }
        if ($used) {
            $usedResult=CUF_check_db_used($file);
            if(!empty($usedResult)){
               $tmpOut['used']= true; 
               $tmpOut['urlUsed']= get_permalink($usedResult[0]['id']);
            }else{
               $tmpOut['used']= false; 
            }
        }
        $out[]=$tmpOut;
    }
    return $out;
}

/**
 * Cleanup the .. and . of folder
 * @param type $dirBase
 * @return type
 */
function CUF_scan_dir($dirBase) {
    return array_diff(scandir($dirBase), array('..', '.'));
}

/**
 * Only the folders
 * @param type $dirBase
 * @return array
 */
function CUF_get_dirs($dirBase) {

    $out = array();
    foreach ($dirBase as $dir) {
        array_push($out, $dir);
        $result = glob($dir . '/*', GLOB_ONLYDIR);
        if (!empty($result)) {
            $result2 = CUF_get_dirs($result);
            foreach ($result2 as $value) {
                array_push($out, $value);
            }
        }
    }
    return $out;
}
