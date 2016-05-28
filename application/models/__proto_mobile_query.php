<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __proto_mobile_query extends REST_Model{

    function __construct(){
        parent::__construct();
        $this->pageSize = 10;

        // Force set default language
        // $this->lang = 'ch';
        // $this->alt_lang = 'en';

        // $this->uid = 0;
        // $this->pathConfig = array();
        // $this->keyx = '';
        // // $this->notification_message = array(
        // //     0=>array('head'=>'Hey there is new "','tail'=>'" ,Waiting for you to checkout.'),
        // //     1=>array('head'=>'Hello there. New "','tail'=>'" ,Ready for you to checkout.'),
        // //     2=>array('head'=>'Hi new "','tail'=>'" ,Let\'s have a look at it.'),
        // //     3=>array('head'=>'Yo!! Would you like to checkout new "','tail'=>'" ,Let me show you.'),
        // //     4=>array('head'=>'Hi there is "','tail'=>'" ,Let\'s go check it out.'),
        // //     5=>array('head'=>'Yeah!! New "','tail'=>'" ,Tap on this message to checkout.')
        // // );

        // //Modify 10/14/2013
        // $this->load->library("nusoap_lib");
        // $this->webservice_url = "http://116.246.12.67:8090/web/ws_member.asmx?WSDL";
        // $this->webservice_usercode = "BE";
        // $this->webservice_userpass = "123";


        //Setup default log options

        //TODO :: IMPLEMENT GAME LOG - READ AND WRITE
        // $this->load->model('__cms_log','log');
        // $this->log->insertLog($param);
        //TODO :: IMPLEMENT GAME LOG - READ AND WRITE
        
        

    }


    private function userLogWrite($uid,$action_type,$action,$object_type,$object_id,$result){
      // `id`, `actor`, `actor_id`, `action_type`, `module_id`, `cat_id`,
      // `subcat_id`, `action`, `object_type`, `object_id`, `result`, `ip`, `timestamp`
      
      
    }


    public function get_commonList($table,$search_index,$keyword='',$sort_index,$sort_direction,$custom_page_size='',$page=1,$debug=0){


      $this->pageSize = (!empty($custom_page_size))?$custom_page_size:$this->pageSize;
      
      if(!empty($sort_index)){
        $sort_direction = (!empty($sort_direction))?$sort_direction:"DESC";
        $this->db->order_by($sort_index,$sort_direction);
      }

      if(!empty($keyword)){
        $this->db->like($search_index,$keyword);
      }


      if($page > -1){
        $result = self::getResultWithPage($table,$page);
      }else{//page -1 means get all
        $result = $this->db->get($table);
      }

      $result = $result->result_array();
      $query = (empty($debug)?"":$this->db->last_query());
      $count = count($result);

      $state = true;  
      $code = '000';
      $msg = 'request complete : total item : '.$count.' < '.$query;
      $output['total_item'] = $count;//count($data);
      $output['list'] = $result;//$data;

      return self::response($state,$code,$msg,$output);



    }



     public function get_commonDetail($table,$id){

     
      $this->db->where('id',$id);
      $result = $this->db->get($table);

      $result = $result->result_array();
      $query = $this->db->last_query();
      $count = count($result);

      if($count < 1 ){
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete ';
        $output = array();
      }else{
        $state = true;  
        $code = '000';
        $msg = 'request complete : total item : '.$count.' < '.$query;
        $output = $result;//$data;
      }
      

      return self::response($state,$code,$msg,$output);



    }



     public function set_commonInsert($table,$options,$condition,$debug=0){
     
     if(!empty($condition)){
        $this->db->where($condition);
     }
      
      $options['create_date'] = self::getCurrentDateTimeForMySQL();

      $result = $this->db->insert($table,$options);
      
      $query = (empty($debug)?"":$this->db->last_query());


      if(!$result){
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete ';
        $output = array();
      }else{
        $state = true;  
        $code = '000';
        $msg = 'request complete '.$this->db->affected_rows().' < '.$query;
        $output = array();
      }
      

      return self::response($state,$code,$msg,$output);

    }


    public function set_commonUpdate($table,$options,$condition,$debug=0){
     
     if(empty($condition)){
        // $this->db->where($condition);
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete ';
        $output = array();

        return self::response($state,$code,$msg,$output);
     }

      $this->db->where($condition);
      
      $result = $this->db->update($table,$options);
      
      $query = (empty($debug)?"":$this->db->last_query());


      if(!$result){
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete ';
        $output = array();
      }else{
        $state = true;  
        $code = '000';
        $msg = 'request complete '.$this->db->affected_rows().' < '.$query;
        $output = array();
      }
      

      return self::response($state,$code,$msg,$output);

    }





     public function set_commonDelete($table,$condition,$debug=0){
     
     if(empty($condition)){
        // $this->db->where($condition);
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete ';
        $output = array();

        return self::response($state,$code,$msg,$output);
     }

      // $this->db->where();
      $result = $this->db->delete($table,$condition);
      
      $query = (empty($debug)?"":$this->db->last_query());


      if($this->db->affected_rows()<1){
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete ';
        $output = array();
      }else{
        $state = true;  
        $code = '000';
        $msg = 'request complete '.$this->db->affected_rows().' < '.$query;
        $output = array();
      }
      
      return self::response($state,$code,$msg,$output);

    }


    





    public function get_sso_register($options){
      //Check required field
        $requireField = array('fbid','user_email','user_firstname','user_lastname');
      
      if(!self::getRequireParameter($requireField,$options)){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , parameter is missing : "fbid" ,"email" ,"name" ,"lastname" ,"api_key" ';
          $output = array();
          return self::response($state,$code,$msg,$output);
      }

      if($options['api_key'] != self::getAPI_KEY()){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , invalid api_key ';
          $output = array();
          return self::response($state,$code,$msg,$output); 
      }

      //unset api key
      unset($options['api_key']);



      $this->db->insert('cms_users',$options);
      if($this->db->affected_rows()<1){
        //Generate new Token
        $state = false;  
        $code = '909';
        $msg = 'request couldn\'t be complete , user alreay existing';
        $output = array();
      
      }else{

        $state = true;  
        $code = '000';
        $msg = 'request complete , user register successful';
        $output = array();

      }

      return self::response($state,$code,$msg,$output);
    }



    public function get_sso_login($options){
      //userdigest -> md5(fbid+secret_key) + $fbid
      //Update if valid user digest
      //Return server digest
        //server_digest -> md5(day time int  + secret_key) + user_digest all 64 byte must always valid
      //Check required field
        $requireField = array('fbid','user_digest','facebook_token');

        if(!self::getRequireParameter($requireField,$options)){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , parameter is missing : "fbid","user_digest","facebook_token" ';
          $output = array();
          return self::response($state,$code,$msg,$output);
        }//end if

        //Check weather user exist or not 
        $this->db->where(array('fbid'=>$options['fbid']));
        $result = $this->db->get('cms_users');
        if($result->num_rows()<1){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , user doesn\'t exist -> please register user first ';
          $output = array();
          return self::response($state,$code,$msg,$output);
        }

        else if(!self::validateUserDigest($options['fbid'],$options['user_digest'])){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , invalid user digest -> request allowed only for autherized application ';
          $output = array();
          return self::response($state,$code,$msg,$output);

        }
        else{
          //Generate server digest
          $server_digest = self::generateServerDigest($options['user_digest']);

          //Stamp database 
          $this->db->where(array('fbid'=>$options['fbid']));
          $update = array(
            'last_degest_stamp'=>date('Y-m-d H:i:s',time()),
            'server_digest'=>$server_digest,
            'facebook_token'=>$options['facebook_token']
          );
          $result = $this->db->update('cms_users',$update);
          if(!$result){
              $state = false;  
              $code = '909';
              $msg = 'request couldn\'t be complete , unable to login';
              $output = array();
      
            }else{
              $state = true;  
              $code = '000';
              $msg = 'request complete , user login successful';
              $output = array('server_digest'=>$server_digest);

          }//end if result


          return self::response($state,$code,$msg,$output);


        }//end else if
    }//end function 





    public function get_sso_logout($options){
      //Update 
       $requireField = array('fbid');


        if(!self::getRequireParameter($requireField,$options)){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , parameter is missing : "fbid" ';
          $output = array();
          return self::response($state,$code,$msg,$output);
        }//end if


          $this->db->where(array('fbid'=>$options['fbid']));
          $update = array(
            'server_digest'=>'-1',
          );
         $result = $this->db->update('cms_users',$update);
          if(!$result){
              $state = false;  
              $code = '909';
              $msg = 'request couldn\'t be complete , there must be some mistake about user fbid';
              $output = array();
            }else{
              $state = true;  
              $code = '000';
              $msg = 'request complete , user logout successful';
              $output = array('server_digest'=>'-1');

          }//end if result
        return self::response($state,$code,$msg,$output);
    }



    public function simpleAction($data){

        if(!array_key_exists('game_config', $data)){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , unable to load game criteria';
          $output = array();
          return self::response($state,$code,$msg,$output);
        }
          $gameConfig = $data['game_config'];


        $param = $data['param'];
        $requireField = array('on','act','subject_id','server_digest');
        if(!self::getRequireParameter($requireField,$data['param'])){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , parameter is missing : "on","act","subject_id","server_digest" ';
          $output = array();
          return self::response($state,$code,$msg,$output);
        
        }else if(array_key_exists($param['on'], $gameConfig['on'] )){


          //TODO :: IMPLEMENT GAME LOG - READ AND WRITE
          // stop
          // $onObj = $gameConfig['on'][$param['on']];
          // // echo "<pre>";
          // // print_r($onObj);
          // // echo "</pre>";
          // // die('x');
          // $objectFound = false;
          // foreach ($onObj as $key => $value) {
          //   // echo "<pre>";print_r($value);echo "</pre>";

          //   if($param['act'] == $value['act']){
          //         $objectFound = true;
                    
          //           //DEBUG
          //             // var_dump($value);
          //             // die('x');
          //           //GAME POINT criteria

          //             // - read repeatable criteria
          //             if(is_array($value['subject_condition'])){
          //               //Query check log 
          //               $criteria = $value['subject_condition'];
          //               $criteria_limit = $criteria['x'];
                        
          //               switch ($criteria['condition']) {
          //                 case 'x_on_day':

          //                   break;

          //                 case 'x_on_week':
                              
          //                   break;

          //                 case 'x_on_month':
                              
          //                   break;

          //               }//end switch

          //             }else if ($value['subject_condition'] == 'unlimited') {
                        

          //             }

                      
          //           //END GAME POINT criteria
          //         // json_encode(array($obj,$param));
          //         //Parse subject id
          //                   // "subject_condition"=>array("condition"=>"x_on_day","x"=>3),
          //                   // "subject_key"=>"id",
          //                   // "subject_table"=>"tbt_infograph",
          //                   // "reward"=>array("point"=>$smallPoint),
          //                   // "message"=>$defaultMessage   


          //             //On update game action success -> stamp log
          //             $this->load->model('__cms_log','log');
          //             $this->log->insertLog($param)


          //   }

          // }//end for


          // if(!$objectFound){
          //   $state = false;  
          //   $code = '909';
          //   $msg = 'request couldn\'t be complete , action for subject you request doesn\'t exist';
          //   $output = array();
          //   return self::response($state,$code,$msg,$output);  
          // }

          // stop
          //TODO :: IMPLEMENT GAME LOG - READ AND WRITE

              
            



        }else{
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , subject you request doesn\'t exist';
          $output = array();
          return self::response($state,$code,$msg,$output);  
        }
        
        



    }



    public function syncGData($data){

        $requireField = array('param');
        if(!self::getRequireParameter($requireField,$data)){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , parameter is missing';
          $output = array();
          return self::response($state,$code,$msg,$output);
        }//end parameter checking

        $output = $playlist_id = $video_id = array();
        $target = $data['param'];
        $vod_list_id = -1;
        $insert_count = $update_count = 0;

        foreach ($target as $playlist_id => $value) {          
          //Get Playlist ID
          //Link playlist_id -> vod_list_id
            
            $result = $this->db->get_where('tbt_vod_list', array('playlist_id'=>$playlist_id));
            if($result->num_rows()<1){
              continue;//continue if playlist id not exist
            }else{
              $vod_list_id = $result->result_array();
              $vod_list_id = $vod_list_id[0]['id'];
            }

          //Target Playlist id -> $key
          foreach ($value as $video_id => $valuex) {
            //Get Video ID
              // array_push($output, array('playlist_id'=>$playlist_id,'video_id'=>$video_id,'data'=>$valuex));
              // array_push($output, array('data'=>$valuex));

            //Check vod existing
            $result = $this->db->get_where('tbt_vod', array('youtube_id'=>$video_id));
            if($result->num_rows()<1){
              //Insert if not exist
              $options = array(
                'vod_list_id' => $vod_list_id,
                'name' => $valuex['vod_title'],
                'caption' => '',
                'description' =>  $valuex['vod_title'],
                'video_url' => $valuex['vod_url'],
                'youtube_id' => $video_id,
                'cover_url' => $valuex['vod_cover_photo'],
                'video_source_type' => 'YOUTUBE',
                'view_count' => $valuex['vod_view_count'],
                'source' => '',
                'remark' => '',
                'is_enable' => 1,
                'delete_flag' => 0,
                'update_date' => date('Y-m-d H:i:s',time()),
                'create_date' => date('Y-m-d H:i:s',time()),
                'publish_date' => (empty($valuex['vod_upload']))?"":date('Y-m-d H:i:s',strtotime($valuex['vod_upload']))
              );

              $this->db->where(array('youtube_id'=>$video_id));
              $this->db->insert('tbt_vod',$options);
              $insert_count++;

            }else{
              //Update if exist
              $options = array(
                'vod_list_id' => $vod_list_id,
                'name' => $valuex['vod_title'],
                'description' =>  $valuex['vod_title'],
                'video_url' => $valuex['vod_url'],
                'cover_url' => $valuex['vod_cover_photo'],
                'view_count' => $valuex['vod_view_count'],
                'update_date' => date('Y-m-d H:i:s',time()),
                'publish_date' => (empty($valuex['vod_upload']))?"":date('Y-m-d H:i:s',strtotime($valuex['vod_upload']))
              );

              $this->db->where(array('youtube_id'=>$video_id));
              $this->db->update('tbt_vod',$options);
              $update_count++;

            }


          }//end inner for
        }//end outter for
        
         
              $state = true;  
              $code = '000';
              $msg = 'request complete , All g-data synced to database';
              $output = array('output'=>$output,'insert_count'=>$insert_count,'update_count'=>$update_count);

              return self::response($state,$code,$msg,$output);


    }









    public function syncFbData($data){

        $requireField = array('param');
        if(!self::getRequireParameter($requireField,$data)){
          $state = false;  
          $code = '909';
          $msg = 'request couldn\'t be complete , parameter is missing';
          $output = array();
          return self::response($state,$code,$msg,$output);
        }//end parameter checking


        $output = $fanpage_id = $fbc_id = array();
        $target = $data['param'];
        $vod_list_id = -1;
        $insert_count = $update_count = 0;

        foreach ($target as $fanpage_id => $value) {          
          
          foreach ($value as $fbc_id => $valuex) {
            
            //Check vod existing
            $result = $this->db->get_where('tbt_news', array('fbc_id'=>$fbc_id));
            if($result->num_rows()<1){
              //Insert if not exist
              $options = array(
                'title' => $valuex['fbc_title'],
                'fbc_id' => $fbc_id,
                'description' =>  $valuex['fbc_description'],
                'url' => $valuex['fbc_link'],
                'photo_url' => $valuex['fbc_photo'],                
                'publish_date' => (empty($valuex['fbc_publish']))?"":date('Y-m-d H:i:s',strtotime($valuex['fbc_publish'])),
                'create_date' => date('Y-m-d H:i:s',time()),
                'update_date' => date('Y-m-d H:i:s',time()),
                'is_enable' => 1,
                'is_on_slideshow' => 0,
                'delete_flag' => 0
              );

              $this->db->where(array('fbc_id'=>$fbc_id));
              $this->db->insert('tbt_news',$options);
              $insert_count++;

            }else{
              //Update if exist
              $options = array(
                'title' => $valuex['fbc_title'],
                'description' =>  $valuex['fbc_description'],
                'url' => $valuex['fbc_link'],
                'photo_url' => $valuex['fbc_photo'],                
                'publish_date' => (empty($valuex['fbc_publish']))?"":date('Y-m-d H:i:s',strtotime($valuex['fbc_publish'])),
                'update_date' => date('Y-m-d H:i:s',time())
              );

              $this->db->where(array('fbc_id'=>$fbc_id));
              $this->db->update('tbt_news',$options);
              $update_count++;

            }


          }//end inner for
        }//end outter for
        
         
              $state = true;  
              $code = '000';
              $msg = 'request complete , All fb-data synced to database';
              $output = array('output'=>$output,'insert_count'=>$insert_count,'update_count'=>$update_count);

              return self::response($state,$code,$msg,$output);


    }
    

























    






    private function onCommitAcction($fbid,$server_digest,$fb_token){
      //Apply this with any gamify action 
        //If invalid user digest -> request user to login
    }  


    private function validateUserDigest($fbid,$userdigest){
      return (self::generateUserDigest($fbid) == $userdigest);
    }

    private function generateUserDigest($fbid){
      return md5(self::getSECRET_KEY().$fbid).$fbid;
    }


    private function generateServerDigest($userdigest){
      date_default_timezone_set('Asia/Bangkok');
      return self::string_zip(  md5(date('Y-m-d',time()).self::getSECRET_KEY()) , $userdigest );
    }

    private function validateServerDigest($serverdigest,$userdigest){
      //md5(day time string  + secret_key)
      // date_default_timezone_set('Asia/Bangkok');
      $result = self::string_unzip($serverdigest);
      return ($result[0] == $userdigest);
    }

    private function string_zip($input1,$input2){
      $output = '';
      $len = strlen($input1);
      while($len--){
        $output .=$input1[$len];
        $output .=$input2[$len];
      }
      return $output;
    }

    private function string_unzip($input){
      $output = array();
      $len = strlen($input);

      while($len--){
        $output['output1'] .=$input[$len];
        $output['output2'] .=$input[$len-1];
        $len--;
      }
      return $output;
    }



    public function getAPI_KEY(){
      $result = $this->db->get('cms_mobile_api_config');
      $result = $result->result_array();

      return $result[0]['api_key'];
    }

    public function setAPI_KEY($key){
       $options = array('api_key'=>$key);
       $this->db->insert('cms_mobile_api_config',$options);
    }

    public function getSECRET_KEY(){
        $result = $this->db->get('cms_mobile_api_config');
        $result = $result->result_array();

        return $result[0]['secret_key'];
    }

    public function setSECRET_KEY($key){
        $options = array('secret_key'=>$key);
        $this->db->insert('cms_mobile_api_config',$options); 
    }

    public function getSALT(){
        $result = $this->db->get('cms_mobile_api_config');
        $result = $result->result_array();

        return $result[0]['salt'];
    }











}//end class





?>