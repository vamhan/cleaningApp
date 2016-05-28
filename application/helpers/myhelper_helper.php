<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function init_controller() {
	/*$ci = & get_instance();

    $l = $ci->config->item('lang_uri_abbr');
	$seg1 = $ci->uri->segment(1);
	
	if ( empty($seg1) )
	{
		header('Location: '.base_url().'en' );
		die();
	}*/

	// $lang = $l[$seg1];
	// $thl = $ci->lang->load( $lang , $lang );
	date_default_timezone_set('Asia/Bangkok');
}

function t($line) {
    global $LANG;
    return ($t = $LANG->line($line)) ? $t : $line;
}

function pvq($a) {    
	$a = str_ireplace("'", "&#39;", $a);
	$a = str_ireplace("\"", "&#34;", $a);	
    return $a;
}

function pvsq($a) {    
	return $a = str_ireplace("'", "&#39;", $a);
}
     
function pvdq($a) {    
	return $a = str_ireplace("\"", "&#34;", $a);
}


function my_url($a='')
{	
	$ci = & get_instance();
	$ci->load->helper('url');
	$seg1 = $ci->uri->segment(1);
	//return site_url($seg1.'/'.$a);
	return site_url($a);
}

function freetext($text='', $replace='') {
	$ci = & get_instance();

	if ($ci->session->userdata('lang')) {
		$lang = $ci->session->userdata('lang');
	} else {
		$lang = $ci->default_lang;
	}

	$data = $ci->language[$lang];

	if (!empty($data[$text])) {

        $text = $data[$text];
        
        if (!empty($replace)) {
            foreach ($replace as $key => $value) {
                $text = str_replace('#'.$key, $value, $text);
            }
        }
        
		return $text;
	} else {
		return $text;
	}
}


function textClamp($text='',$limit=0){
  if($text=='' || $limit==0 || $limit < 3 )
    return $text;

    return '<span title="'.$text.'">'.((strlen($text)>$limit)?substr($text, 0,$limit-3).'...':$text).'</span>';
  
}


function reSAPDate($d){
    $date = $d;
    $year = substr($date, 0, 4);
    $month = substr($date, 4, 2);
    $day = substr($date, 6);
    return ($year . "-" . $month . "-" . $day);
}

function reDate($d){
 	$date = $d;
 	$a = explode(".", $date);
 	return ($a[2]) . "-" . $a[1] . "-" . $a[0];
}

function date_now($sec=0){//moved
	date_default_timezone_set('Asia/Bangkok');
    return date("Y-m-d H:i:s", time()+$sec); //return date("Y-m-d H:i:s");
}

function common_easyDateTimeFormat ($d) {
    // $stringDateTime = "0000-01-24 00:00:00";
    if(empty($d))
        return 'N/A';
    $date = substr($d, 0,10);
    $date = explode("-", $date);
        if(intval($date[0])==0)
            return 'N/A';
    return $date[2].".".$date[1].".".$date[0].substr($d, 10);
}

function common_easyDateFormat($d){
    // $stringDateTime = "0000-01-24 00:00:00";
    if(empty($d))
    	return 'N/A';
	$d = substr($d, 0,10);
	$d = explode("-", $d);
		if(intval($d[0])==0)
			return 'N/A';
	return $d[2].".".$d[1].".".$d[0];
}

function common_getCurrentDateTimeForMySQL($d=0){//moved
	date_default_timezone_set('Asia/Bangkok');
    return date("Y-m-d H:i:s", time()+$d); //return date("Y-m-d H:i:s");
}


function common_Date_th($d){

//$data =date("d/m/Y");
$cutArray = explode("-", $d);
$date = $cutArray[2];
$month = $cutArray[1];
$year = $cutArray[0];
//$year = $cutArray[2]+543;

  switch($month){ 
    case "01" : 
        //$stringmonth = "January";
        $stringmonth = "มกราคม"; 
         break;

    case "02" : 
        //$stringmonth = "February";
        $stringmonth = "กุมภาพันธุ์";
         break; 
    case "03" : 
        //$stringmonth = "March";
        $stringmonth = "มีนาคม"; 
         break;
    case "04" : 
        //$stringmonth = "April";
        $stringmonth = "เมษายน";
         break; 
    case "05" : 
        //$stringmonth = "May";
        $stringmonth = "พฤษภาคม";
         break; 
    case "06" : 
        //$stringmonth = "June";
        $stringmonth = "มิถุนายน"; 
    case "07" : 
        //$stringmonth = "July";
        $stringmonth = "กรกฏาคม";
         break; 
    case "08" : 
        //$stringmonth = "August";
        $stringmonth = "สิงหาคม";
         break; 
    case "09" : 
        //$stringmonth = "September";
        $stringmonth = "กันยายน";
         break; 
    case "10" : 
        //$stringmonth = "October";
        $stringmonth = "ตุลาคม";
         break; 
    case "11" : 
        //$stringmonth = "November"; 
        $stringmonth = "พฤศจิกายน";
         break;
    case "12" : 
        //$stringmonth = "December"; 
        $stringmonth = "ธันวาคม";
         break;
  }	
  //=== Jul 25, 2013
  //$d =$date." ".$stringmonth." ".$year;
  //$d =$stringmonth." ".$date.", ".$year;
  $d =$stringmonth." ".$year;
	return $d;
}

function wrap_html($m){
	return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >
</head>
<body>'.$m.'<body>
</html>';
}

function log_transaction ($action='',$table='', $id='',$result='',$action_type='transaction', $actor='user') {
    $ci = & get_instance();

    if (in_array($action, $ci->action[$action_type])) {

        $data['actor_id']   = $ci->session->userdata('id');

        if (strpos($action, 'login') === false && strpos($action, 'logout') === false ) {
            if ($ci->session->userdata('previous_module')) {
                $data['module_id']  = $ci->session->userdata('previous_module');
            }
            if ($ci->session->userdata('previous_cat')) {
                $data['cat_id']  = $ci->session->userdata('previous_cat');
            }
            if ($ci->session->userdata('previous_subcat')) {
                $data['subcat_id']  = $ci->session->userdata('previous_subcat');
            }
        }

        $data['ip']         = $ci->input->ip_address();

        $data['actor']       = $actor;
        $data['action_type'] = $action_type;
        $data['action']      = $action;
        $data['object_type'] = $table;
        $data['object_id']   = $id;
        $data['result']     = $result;


        $ci->log->insertLog($data);
    }
}

function image_thumb( $image_path, $height, $width ) {
    // Get the CodeIgniter super object
    $CI =& get_instance();

    $keypath = 'assets/';
    $image_path = $keypath.$image_path;
    $image_info = pathinfo($image_path);

    $thumb_path = $keypath.'thumb/';

    $image_thumb = $thumb_path . $image_info['filename'] . '_' . $height . '_' . $width . '.jpg';

    if ( !file_exists( $image_thumb ) ) {
        clearDiretoryCache();
        // LOAD LIBRARY
        $CI->load->library( 'image_lib' );

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        
        $CI->image_lib->initialize( $config );
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return dirname( $_SERVER['SCRIPT_NAME'] ) . '/' . $image_thumb;
}

function clearDiretoryCache () {
    $CI =& get_instance();

    $CI->load->config('setup');
    $CI->setup_item = $CI->config->item('setup');
    $limit = $CI->setup_item['project']['folder_upload_size'];

    $dir = "assets/thumb";
    $bytes = dirsize($dir);
    $mbytes = number_format($bytes / 1048576, 2);

    if ($mbytes >= $limit) {
        @$dh = opendir($dir);
        $size = 0;
        while ($file = @readdir($dh))
        {
            $path = $dir."/".$file;
            if (is_file($path)){
                unlink($path); // add file
            }
        }
        @closedir($dh);
    }
}

function dirsize($dir) {
    $CI =& get_instance();

    @$dh = opendir($dir);
    $size = 0;
    while ($file = @readdir($dh))
    {
        if ($file != "." and $file != "..") 
        {
          $path = $dir."/".$file;
          if (is_dir($path))
          {
            $size += dirsize($path); // recursive in sub-folders
          }
          elseif (is_file($path))
          {
            $size += filesize($path); // add file
          }
        }
    }
    @closedir($dh);
    return $size;
}

function defill($msg,$noise='0'){
    if(empty($msg))return $msg;
  $index = 0;
  while( $msg[$index]==$noise ){
   if($msg[$index]!=$noise)
    break;
   else
    $index++;
  }//
  return substr($msg, $index);
 }