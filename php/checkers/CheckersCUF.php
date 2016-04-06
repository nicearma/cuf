<?php
/**
 *
 * @author nicearma
 */
class CheckersCUF
{

    private $checkers = array();

    function __construct($databaseCUF)
    {
        new CheckerImagePostMetaCUF($databaseCUF,$this);
        new CheckerImagePostAndPageAllCUF($databaseCUF,$this);
        new CheckerImageExcerptAllCUF($databaseCUF,$this);
    }

        public function addChecker($checker)
    {
        array_push($this->checkers, $checker);
    }

    public function verify($src,$optionCUF){

        for($i=0;$i<count($this->checkers);$i++){
           $result= call_user_func_array(array($this->checkers[$i], "checkImage"), array($src,$optionCUF));
            if(!empty($result)&&count($result)>0){
               return 1; //is used
            }
        }
        return 0; //is unused/not used

}

}