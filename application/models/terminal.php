<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class terminal extends REST_Model{

    function __construct(){
        parent::__construct();
    }

    public function updateFacebookPost($param){
      
      return array('status'=>true,'result'=>'me2');  
		// $requireField = array('id','name','image_path','description','url');
  //       if(!self::getRequireParameter($requireField,$param))
  //           return self::response(false,'909','Unable to push new facebook post : Parameter is missing',array());

  //         $state = true;  
		//   $code = '000';
		//    $msg = 'request couldn\'t be complete';
		//   $output = array('/me');

  //       return self::response($state,$code,$msg,$output);

    }//end function 






   
}//end class
