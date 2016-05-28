<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model{

	function __construct(){
		
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');

        if(!isset($this->pageSize) || empty($this->pageSize)){
            $this->pageSize = PAGESIZE;
        }

	}//end constructor;


    public function getPositionChild ($children, $pos_id) {

        $pos_children = $this->__ps_project_query->getObj('tbm_position', array('parent_id' => $pos_id), true); 

        if (!empty($pos_children)) {
            foreach ($pos_children as $key => $pos_child) {
                if (!in_array($pos_child['id'], $children)) {
                    array_push($children, $pos_child['id']);
                }
                $children = $this->getPositionChild($children, $pos_child['id']);
            }

        }

        return $children;

    }

	protected function replaceNullWithString($msg){
        // if(empty($msg)){
        //     return "";
        // }
        return $msg;
    }

    protected function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
    }


    protected function response($status=false,$errorCode='909',$message='',$result=array()){//moved
        if( empty($message))
            $message = ($status)? "Request Success":"Request Fail ,Check the errorCode";
        return array(
            "status"=>$status,
            "errorCode"=>$errorCode,
            "message"=>$message,
            "result"=>$result
            );
    }


    protected function responseWithMessage($status=false,$errorCode='909',$message='',$result=array()){//moved
        
        //defind mode 
        /*
        0 successful 
        1 Authentication 
        2 Notification
        3 Shop Information 
        4 Community
        5 Event Promotion 
        6 Coupon 
        7 Super Card 
        8 Other 
        */


        if(empty($message)){
            $m = ''; 
            switch (intval($errorCode)) {
                case 001 : $m = array(
                            'en'=>'User Signed In Successful',
                            'ch'=>'网站会员认证成功'
                        );break;
                case 002 : $m = array(
                            'en'=>'User Signed Up Successful',
                            'ch'=>'注册成功'
                        );break;
                case 003 : $m = array(
                            'en'=>'VIP register successful, please contact customer service for your VIP number card at Touch Mall customer service counter.',
                            'ch'=>'VIP注册成功，请至正大乐城客服中心领取您的VIP卡。'
                        );break;

                case 004 : $m = array(
                            'en'=>'User feedback email been sent.',
                            // 'ch'=>'ภาษาจีน -> User feedback email been sent'
                            'ch'=>'用户反馈邮件已发送'
                            
                        );break;

                case 005 : $m = array(
                            'en'=>'User profile is now updated',
                            // 'ch'=>'ภาษาจีน -> User profile is now updated'
                            'ch'=>'用户配置文件现在已更新'
                        );break;

                case 006 : $m = array(
                            'en'=>'User Profile image updated',
                            // 'ch'=>'ภาษาจีน -> User Profile image updated'
                            'ch'=>'用户配置文件的图像更新'
                        );break;

                case 007 : $m = array(
                            'en'=>'Password recovery successful ,Please check your email',
                            'ch'=>'重置密码成功，请查询您的邮件'
                        );break;

                case 008 : $m = array(
                            'en'=>'Request completed , Your new topic created',
                            // 'ch'=>'ภาษาจีน -> Request completed , Your new topic created'
                            'ch'=>'请求完成后，你的新主题创建'
                            
                        );break;
                


            

                case 101 :  $m = array(
                            'en'=>'Please log in again before touching mall activation email links',
                            'ch'=>'再次登录之前请激活触摸商城电子邮件的链接。'
                            );break;
                 
                case 102 :  $m = array(
                            'en'=>'Your password or mobile phone number is invalid',
                            'ch'=>'无效的手机号码输入'
                            );break;

                case 103 : $m = array(
                            'en'=>'This number has been used for registerd, please try again with the new number',
                            'ch'=>'此号已被注册时使用的，用新的号码，请再试一次'
                            );break;

                case 104 : $m = array(
                            'en'=>'This email is already in use for registration, please use another mail to register',
                            'ch'=>'该邮箱已经被使用注册，请使用其他的邮箱注册。'
                            );break;

                case 106 : $m = array(
                            'en'=>'Couldn\'t update user profile , invalid input parameter',
                            // 'ch'=>'ภาษาจีน -> Couldn\'t update user profile , invalid input parameter'
                            'ch'=>'无法更新用户配置文件，无效的输入参数'
                            );break;

                case 107 : $m = array(
                            'en'=>'Couldn\'t update user profile images , invalid input parameter',
                            // 'ch'=>'ภาษาจีน -> Couldn\'t update user profile images , invalid input parameter'
                            'ch'=>'无法更新用户配置文件的图像，无效的输入参数'
                            );break;

                case 108 : $m = array(
                            'en'=>'Couldn\'t recover password , Invalid email address input',
                            'ch'=>'无效的邮箱地址'
                            );break;





                case 201 : $m = array(
                            'en'=>'User feedback email couldn\'t be sent.',
                            // 'ch'=>'ภาษาจีน -> User feedback email couldn\'t be sent.'
                            'ch'=>'用户反馈邮件无法发送。'
                            );break;





                case 301 : $m = array(
                            'en'=>'Request couldn\'t be complete , this account is not vip member.',
                            // 'ch'=>'ภาษาจีน -> Request couldn\'t be complete , this account is not vip member.'
                            'ch'=>'请求可能是不完整的，这个账户是不是VIP会员。'
                            );break;

                case 401 : $m = array(
                            'en'=>'Request couldn\'t be complete , unable to create new topic.',
                            // 'ch'=>'ภาษาจีน -> Request couldn\'t be complete , unable to create new topic.'
                            'ch'=>'请求可能是不完整的，无法创建新的课题。'
                            );break;

                case 402 : $m = array(
                            'en'=>'Request couldn\'t be complete , invalid user id.',
                            // 'ch'=>'ภาษาจีน -> Request couldn\'t be complete , invalid user id.'
                            'ch'=>'请求可能是不完整的，无效的用户ID。'
                            );break;

                default:
                    # code...
                    break;
            }

            return array(
            "status"=>$status,
            "errorCode"=>$errorCode,
            "message"=>$m[$this->lang],
            "result"=>$result
            );

        }else{
            return array(
            "status"=>$status,
            "errorCode"=>$errorCode,
            "message"=>$message,
            "result"=>$result
            );
        }
        
        
    }


    protected function getResultWithPage($tableName,$page){//moved
        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;
        
        // $match = $this->input->post('search');
        // if(!empty($match)){
        //     $this->db->like('page_title',$match);
        // }
        
        if(!empty($tableName)){
            return $this->db->get($tableName,$items,$offset);    
        }else{
            // $this->db->limit($items,$offset);
            return $this->db->get();
        }
        
    }//end function



     protected function getResultTotalpage($tableName, $where=null){//moved
       $this->db->select('COUNT(*) AS cnt');
       if (!empty($where)) {
            $this->db->where($where);
       }
       $result = $this->db->get($tableName);
       $result = $result->result_array();
       return intval($result[0]['cnt']);
    }//end function


    protected function joinedGetResultWithPage($page){//moved
        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        // return $this->db->get($tableName,$items,$offset);
        $this->db->limit($items, $offset);
        return $this->db->get();
    }//end function


      protected function customQSGetResultWithPage($QS,$page){//moved
        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        // return $this->db->get($tableName,$items,$offset);
        $this->db->limit($items, $offset);
        return $this->db->query($QS);
    }//end function



    protected function common_getImage($path,$filename,$ext_param=''){//assets/application/

        //On china server
        // return $this->config->base_url().'../sbm_web/getimg.php?src='.$path.$filename.$ext_param;
      return $this->config->base_url().'../getimg.php?src='.$path.$filename.$ext_param;
        // // return 'http://www.touchsuperbrandmall.com/getimg.php?src='.$path.$filename;

        // // $filePath = $path.str_replace(' ','-',strtolower($filename));
        // // if(file_exists($filePath))
        // //     return $this->config->base_url().$filePath;
        // // else
        // //     return $this->config->base_url().'assets/application/not_found.jpg';

        // //On thai server 
        // return $this->config->base_url().'../touchmall_web/getimg.php?src='.$path.$filename.$ext_param;
    }

    protected function common_getFile($path,$filename,$ext_param=''){//assets/application/

        //On china server
        // return $this->config->base_url().'../sbm_web/'.$path.$filename;//.$ext_param;
      return $this->config->base_url().'../'.$path.$filename;//.$ext_param;

        // // $path = '../touchmall_web/'.$path;

        // // $filePath = $path.str_replace(' ','-',strtolower($filename));
        // // if(file_exists($filePath))
        // //     return $this->config->base_url().$filePath;
        // // else
        // //     return $this->config->base_url().'assets/application/not_found.jpg';

        // //On thai server
        // return $this->config->base_url().'../touchmall_web/'.$path.$filename;//.$ext_param;
    }


    protected function getExpireDateInXMonth($month){//moved
        return date("Y-m-d H:i:s",time()+(2592000*$month));
    }


    protected function getCurrentDateTimeForMySQL(){//moved
        return date("Y-m-d H:i:s", time()); //return date("Y-m-d H:i:s");
    }


    protected function getIntIdFromPhoneNo($phoneNo){//moved
        $target = array(' ','-','+','_');
        $replaceWith = '';
        return intval(str_replace($target, $replaceWith , $phoneNo));
    }


    protected function getRequireParameter($requireField,$paramSet){
        foreach ($requireField as $key => $value) {
            if(empty($paramSet[$value]))return false;
        }
        return true;
    }


    protected function requireInt($requireField,$paramSet){
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


    protected function turnStringToArray( $delimiter,$string ){
        if(!isset($string)) return array();
        return explode($delimiter, $string);
    }

    protected function removeHTMLTagWithSpaceFixed($stringx){
        $stringx = utf8_decode(strip_tags($stringx));
        $stringx = str_replace("&nbsp;",'',$stringx);

        return $stringx;
    }

     protected function removeHTMLTag($stringx){
        $stringx = utf8_decode(strip_tags($stringx));
        return $stringx;
    }


    protected function isDuplicateOn($table,$column,$needle){
        $this->db->where($column,$needle);
        $result = $this->db->get($table);
        return ($result->num_rows()>0);
    }

    protected function trace($msg){
        print('<pre>');
        (is_array($msg))?print_r($msg):print($msg);
        print('</pre>');
    }

}



class REST_Model extends MY_Model {
	function __construct(){
		parent::__construct();

	}//end constructor;

    protected function getFieldSet ($fieldset, $table) {
        $needle = array();
        $lang = $this->session->userdata('lang');
        $table_fields = $this->db->list_fields($table);
        foreach ($fieldset as $field) {
            if (in_array($field.'_'.$lang, $table_fields)) {
                array_push($needle, $field.'_'.$lang);
            } else if (in_array($field, $table_fields)) {
                array_push($needle, $field);
            }
            
        }
        return $needle;
    }


    public function summon($table,$search_index,$keyword){
        if(!empty($keyword)){
            $this->db->where($search_index,$keyword);
        }
        return $this->db->get($table);
    }


    public function getFieldList($table){
        $fields = $this->db->list_fields($table);
        return $fields;
    }


    public function update($table,$options,$condition){
        if(!empty($condition)){
            $this->db->where($condition);
        }
        $this->db->update($table,$options);
        return $this->db->affected_rows();
    }


}