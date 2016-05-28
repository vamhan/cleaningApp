<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function ui_text_render($viewDetail,$content,$render_options = array()){
    
    $uiString = '';


    //Print blank form
    if(empty($content)){
        return blank_ui_text_render($viewDetail,$render_options);
    }


    if(empty($viewDetail))
        return $uiString;



    //Skip none label and invisible item
    if( empty($viewDetail['label']) || $viewDetail['visiblity'] == 'hidden'  )
        return $uiString;

        //Read visibility properties
        $attr = '';
        switch ($viewDetail['visiblity']) 
        {
            case 'readonly': $attr = 'readonly="readonly"'; break;
            case 'disable': $attr = 'disabled="disabled"'; break;
            default: break;
        }//end switch 


        $class = (array_key_exists('class', $render_options))?$render_options['class']:'';
// validation
        $viewDetail['default_value'] = (empty($content[$viewDetail['name']]))?$viewDetail['default_value']:$content[$viewDetail['name']];
        $uiString .='<div class="form-group '.$class.'">';
        $uiString .='<label>'.$viewDetail['label'].'</label>';
        $uiString .='<input type="text" class="form-control" name="'.$viewDetail['name'].'" placeholder="'.$viewDetail['placeholder'].'" value="'.$viewDetail['default_value'].'" style="width:'.$viewDetail['width'].'px;" '.$attr.' >';
        //TODO : Implememt data validation later 
            // data-parsley-type="email" data-parsley-required="true" data-parsley-ui-enabled="true" 

        $uiString .='</div>';

    return $uiString;

}//end function



function ui_dropdown_render($viewDetail,$content,$content_list,$render_options = array()){
    $uiString = '';


    $ci =& get_instance(); 
    $ci->load->database();
    $ci->load->model('__proto_content_list');
    $summoned_content_list = $ci->__proto_content_list->summon($content_list,'','');
    $summoned_content_list = $summoned_content_list->result_array();


    if(empty($summoned_content_list))
        return $uiString;
    // $uiString = 'Bare';



    //Print blank form
    if(empty($content)){
        return blank_ui_dropdown_render($viewDetail,$summoned_content_list,$render_options);
    }



    if(empty($viewDetail))
        return $uiString;


    //Skip none label and invisible item
    if( empty($viewDetail['label']) || $viewDetail['visiblity'] == 'hidden'  )
        return $uiString;

        //Read visibility properties
        $attr = '';
        switch ($viewDetail['visiblity']) 
        {
            case 'readonly': $attr = 'readonly="readonly"'; break;
            case 'disable': $attr = 'disabled="disabled"'; break;
            default: break;
        }//end switch 



        $class = (array_key_exists('class', $render_options))?$render_options['class']:'';
// validation
        $viewDetail['default_value'] = (empty($content[$viewDetail['name']]))?$viewDetail['default_value']:$content[$viewDetail['name']];
        
        $uiString .='<div class="form-group '.$class.'">';
        $uiString .='<label>'.$viewDetail['label'].'</label>';

        $uiString .='<select class="form-control" name="'.$viewDetail['name'].'">';
        $uiString .='<option value="">NONE</option>';
            foreach ($summoned_content_list as $key => $value) {
                    $selected = ($viewDetail['default_value'] == $value['id'])?"selected='selected'":"";
                    $uiString .='<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }
        $uiString .='</select>';

        //TODO : Implememt data validation later 
            // data-parsley-type="email" data-parsley-required="true" data-parsley-ui-enabled="true" 

        $uiString .='</div>';

    return $uiString;

}//end function






function blank_ui_text_render($viewDetail,$render_options = array()){

    $uiString = ''; 
        //Read visibility properties
        $attr = '';
        switch ($viewDetail['visiblity']) 
        {
            case 'normal':$attr ='';break;
            default: $attr = 'disabled="disabled"'; break;
        }//end switch 

        $class = (array_key_exists('class', $render_options))?$render_options['class']:'';

        $uiString .='<div class="form-group '.$class.'">';
        $uiString .='<label>'.$viewDetail['label'].'</label>';
        $uiString .='<input type="text" class="form-control" name="'.$viewDetail['name'].'" placeholder="'.$viewDetail['placeholder'].'" value="'.$viewDetail['default_value'].'" style="width:'.$viewDetail['width'].'px;" '.$attr.' >';
        
        $uiString .='</div>';

    return $uiString;
}



function blank_ui_dropdown_render($viewDetail,$summoned_content_list,$render_options = array()){

    $uiString = ''; 
    //Skip none label and invisible item
    if( empty($viewDetail['label']) || $viewDetail['visiblity'] == 'hidden'  )
        return $uiString;

        //Read visibility properties
        $attr = '';
        switch ($viewDetail['visiblity']) 
        {
            case 'normal':$attr ='';break;
            default: $attr = 'disabled="disabled"'; break;
            default: break;
        }//end switch 


// validation
        $class = (array_key_exists('class', $render_options))?$render_options['class']:'';
        
        $uiString .='<div class="form-group '.$class.'">';
        $uiString .='<label>'.$viewDetail['label'].'</label>';
        $uiString .='<select class="form-control" name="'.$viewDetail['name'].'" '.$attr.'>';
        $uiString .='<option value="">NONE</option>';
            foreach ($summoned_content_list as $key => $value) {
                    $uiString .='<option value="'.$value['id'].'">'.$value['name'].'</option>';
            }
        $uiString .='</select>';

        //TODO : Implememt data validation later 
            // data-parsley-type="email" data-parsley-required="true" data-parsley-ui-enabled="true" 

        $uiString .='</div>';

    return $uiString;
}//end function




