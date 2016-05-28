<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Response{


	function __construct(){
	
	}


	public function hellox(){
		return array('hello->response');
	}



	public function response($status=false,$errorCode='909',$message='',$result=array()){
		if( empty($message))
			$message = ($status)? "Request Success":"Request Fail ,Check the errorCode";

		return array(
			"status"=>$status,
			"errorCode"=>$errorCode,
			"message"=>$message,
			"result"=>$result
			);
	}//end function


	 public function getResultWithPage($tableName,$page){
        $offset = 0;
        $items = 100;

        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        return $this->db->get($tableName,$items,$offset);
    }//end function


    public function dateOnly($string){
        $date = substr($string,0,10);
        $date = explode('-', $date);

        $output = $date[2].'/'.$date[1].'/'.($date[0]+543);
        return $output;
    }//end function 



    public function isCarOwn($uid,$cid){
    	$qString = "SELECT cid FROM (`tbt_car_own`) WHERE cid =".$cid." AND uid = ".$uid;
    	$result = $this->db->query($qString);
        return ($result->num_rows()==1)?true:false;//$qString;
    }//end function




 



    public function getTimeStampFromString(){
        // return 
        //TODO :: implement timeStamp from string 
    }

    public function getExpireDateInXMonth($month){
    	return date("Y-m-d H:i:s",time()+(2592000*$month));
    }

    public function getCurrentDateTimeForMySQL(){
        return date("Y-m-d H:i:s", time()); //return date("Y-m-d H:i:s");
    }

    public function getIntIdFromPhoneNo($phoneNo){
    	$target = array(' ','-','+','_');
    	$replaceWith = '';
    	return intval(str_replace($target, $replaceWith , $phoneNo));
    }


    public function getRequireParameter($requireField,$paramSet){
    	foreach ($requireField as $key => $value) {
    		if(empty($paramSet[$value]))return false;
    	}
    	return true;
    }

    public function requireInt($requireField,$paramSet){
    	$valid = true;
    	foreach ($requireField as $key => $value) {
    		$inInt = intval($paramSet[$value]);
    		$paramSet[$value] = $inInt;
    		if($inInt==0){
    			$valid = false;           
    		}
    	}
    	return array('status'=>$valid,'result'=>$paramSet);
    }


    public function turnStringToArray( $delimiter,$string ){
    	if(!isset($string)) return array();
    	return explode($delimiter, $string);
    }









}