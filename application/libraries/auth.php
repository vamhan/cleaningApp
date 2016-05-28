<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth{


	/*
		+ Public token encode - decode
		  encode > [hash(api+secret)]+api
		  decode > split api+then query secret -> hash - > compare
		+ Private token encode - decode 
		  encode > permute -> [timestamp + userID + serverNonce]
		  decode > split (reverse_permute -> [timestamp+userID+ serverNonce])
	*/

	function __construct($header,$config){
		
			$this->header = $header;
			$this->config = $config;
		//Define
			// strlen(api_key)=> 32
			// strlen(api_secret)=> 32
				//encoded -> public token len -> 64
			// strlen(server_nonce)=>32
			// strlen(timestamp)=> 16
			// strlen(uid)=>16
				//encoded -> private token len -> 64

		//Define - token expire period 
			$day = 86400; //60*60*24
			$hour = 3600;
			$min = 60;
			//Set expire peroid;
			$expirePeriod = $day*3;

		$this->serverNonce = md5('BNZ_CGC_2013'); //len -> 32
		$this->expireDate = self::turn16(time()+$expirePeriod);
	}





	public function requirePublicToken($uid){
		if(array_key_exists('public_token', $this->header) && isset($this->header['uid']) && !empty($this->header['uid'])){	
			// if public token existing check is it correct or not
			return self::isAutherizedPublicToken($this->header['public_token'],$this->header['uid']);
		}else{
			return self::response(false,'909','public token and uid are required', array('private_token'=>''));
		}
	}



	public function requirePrivateToken(){
		if(array_key_exists('private_token', $this->header)){		
			return self::isAutherizedPrivateToken($this->header['private_token']);
		}else{
			return self::response(false,'909','private token is required', array());
		}

	}




	public function isAutherizedPublicToken($publicToken,$uid){
		if(strlen($publicToken) < 64 )
			return self::response(false,'909','invalid publicToken : lenght', array('private_token'=>''));
			
		$mixed = substr($publicToken,0,-32);
		$api_key = substr($publicToken,32);
		
		if(array_key_exists($api_key, $this->config)){
			$secret = $this->config[$api_key];
			if( md5($api_key.$secret) != $mixed ){
				return self::response(false,'909','invalid public_token', array('private_token'=>''));
			}
			return self::response(true,'000','valid public_token', array('private_token'=>self::generatePrivateToken($uid)));
		}else{
			return self::response(false,'909','invalid public_token', array('private_token'=>''));
		} 
			
	}



	public function isAutherizedPrivateToken($token){
		
		if(empty($token))
			return self::response(false,'500','invalid private_token_key : empty token string', array('autherize'=> false));
		if(strlen($token)<64)
			return self::response(false,'501','invalid private_token_key', array('autherize'=> false));
				
		$extractedToken = self::extractPrivateToken($token);

		if( intval($extractedToken['expireDate'])<time() )
			return self::response(false,'502','invalid private_token_key : token Expire', array('autherize'=> false));

		if( $extractedToken['serverNonce'] != $this->serverNonce )
			return self::response(false,'503','invalid private_token_key : serverNonce mis match', array('autherize'=> false));


		return self::response(true,'000','autherized', array('autherize'=> true));
		
	}
































    private function response($status=false,$errorCode='909',$message='',$result=array()){
        if( empty($message))
            $message = ($status)? "Request Success":"Request Fail ,Check the errorCode";

        return array(
            "status"=>$status,
            "errorCode"=>$errorCode,
            "message"=>$message,
            "result"=>$result
            );
    }


    public function generatePublicToken(){
    	// [hash(api+secret)]+api
		$token = md5('a65db266447240573431aa411a3c785e'.$this->config['a65db266447240573431aa411a3c785e']).'a65db266447240573431aa411a3c785e'; 	
		return self::response(true,'000','sample_token', array('public_token'=> $token));
    }

	private function generatePrivateToken($uid){
		$unpermute = $this->expireDate.self::turn16($uid).$this->serverNonce;
		return self::permuteEncode($unpermute); //array(self::permuteEncode($unpermute) , self::permuteDecode(self::permuteEncode($unpermute)));
	}

	private function extractPrivateToken($token){
		//First 16 char-sequence is expiredate
		$token = self::permuteDecode($token);

		$expireDate = substr($token,0,16);
		$token = substr($token,16);
		$expireDate = self::teardown($expireDate);

		//Second 16 char-sequence is uid
		$uid = substr($token, 0,16);
		$token = substr($token,16);
		$uid = self::teardown($uid);

		//Last 32 char-secuqence is server_nonce
		// $serverNonce = $token;
		return array(
			'expireDate'=>$expireDate,
			'uid'=>$uid,
			'serverNonce'=>$token
			);

	}

	private function permuteEncode($unPermuteString){
		// encode > permute -> [timestamp + userID + serverNonce] -> len 64
		$output = array();
		$stringOut = '';
		$cnt =0;
		$temp = '';

		while(strlen($unPermuteString)>0){
			//Chopping then push to array each 4 sequence character
				// array_push($output,  substr($unPermuteString, 0,4));
				if($cnt++%2==0){
					$temp = substr($unPermuteString, 0,4);
				}else{
					$stringOut.=substr($unPermuteString, 0,4);
					$stringOut.=$temp;
				}
				$unPermuteString = substr($unPermuteString, 4);
		}
			
		return $stringOut;
		
	} 

	private function permuteDecode($permutedString){
		// decode > split (reverse_permute -> [timestamp+userID+ serverNonce]) -> len 64
		$output = array();
		$stringOut = '';
		$cnt =0;
		$temp = '';
		
		while(strlen($permutedString)>0){
			//Chopping then push to array each 4 sequence character
				// array_push($output,  substr($permutedString, 0,4));
				if($cnt++%2==0){
					$temp = substr($permutedString, 0,4);
				}else{
					$stringOut.=substr($permutedString, 0,4);
					$stringOut.=$temp;
				}
				$permutedString = substr($permutedString, 4);
		}
			
		return $stringOut;

	}


	private function turn16($string){ //fill zero in front of target object
		$zero = "0000000000000000";
		$len = strlen($string);
        //$diff = $lenght;

		if($len<16){
			$zero = substr($zero,$len-16);
			return $zero.$string;

		}else if(strlen($string)>16){
			$string = substr($string,$len-16);
			return $string;
		}else{
			return $string;
		}
	}

    private function turn32($string){//fill zero in front of target object
        if(strlen($string)!=16)
            $string = self::turn16($string);

        return $string.$string;
    }

    private function teardown($string){//remove all zero on target front
        return substr($string , self::zeroEndPos($string));
    }

    private function zeroEndPos($string){//get last index of zero (zero which stand in a row) -> must loop anyway
        $i=0;
        while($i< strlen($string)){
            if($string[$i++] == '0'){
                continue;
            }else{
                return $i-1; break;
            }
        }
    }






}