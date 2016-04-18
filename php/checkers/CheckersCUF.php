<?php
/**
 *
 * @author nicearma
 */
class CheckersCUF
{

    private $checkers = array();

    function __construct($database)
    {
        new CheckerImagePostMetaCUF($database,$this);
        new CheckerImagePostAndPageAllCUF($database,$this);
        new CheckerImageExcerptAllCUF($database,$this);
    }

        public function addChecker($checker)
    {
        array_push($this->checkers, $checker);
    }

    public function verify($src,$option){

        for($i=0;$i<count($this->checkers);$i++){
           $result= call_user_func_array(array($this->checkers[$i], "checkImage"), array($src,$option));
            if(!empty($result)&&count($result)>0){
               return 1; //is used
            }
        }
        return 0; //is unused/not used

}

}