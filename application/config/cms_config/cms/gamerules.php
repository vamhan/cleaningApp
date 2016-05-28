<?php //exit; 

// /*SELECT A . * , B.module_name AS mod_name
// FROM cms_category A
// LEFT JOIN cms_module B ON A.mod_id = B.id
// WHERE A.id =9
// LIMIT 0 , 30*/

// // on 
// //     vod
// //     info graph
// //     motion graph
// //     assure_right
// //     fanpage
// // act
// //     view
// //     play
// //     like
// //     share 

// // condition 
// //     unlimit
// //     x time a day 
// //     //x time a week 
// // points 
// //     x points
// // message 
// //     x message 

$smallPoint = 10;
$midPoint = 20;
$largePoint = 50;

$defaultMessage = array("positive"=>"You got point for view on subject","negative"=>"You reach limit to get point on acting to subject");
$rules = Array(
   "on"=> array(
                "vod"=>array(
                    array(
                        "act"=>"play",
                        "subject_condition"=>"unlimited",
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_vod",
                        "reward"=>array("point"=>$smallPoint),
                        "message"=>$defaultMessage
                    )
                ),

                "infograph"=>array(
                    array(
                        "act"=>"view",
                        "subject_condition"=>array("condition"=>"x_on_day","x"=>3),
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_infograph",
                        "reward"=>array("point"=>$smallPoint),
                        "message"=>$defaultMessage
                    )
                ),

                "motiongraph"=>array(
                    array(
                        "act"=>"view",
                        "subject_condition"=>array("condition"=>"x_on_day","x"=>3),
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_motiongraph",
                        "reward"=>array("point"=>$smallPoint),
                        "message"=>$defaultMessage
                    )
                ),


                "infograph"=>array(
                    array(
                        "act"=>"share",
                        "subject_condition"=>"unlimited",
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_infograph",
                        "reward"=>array("point"=>$midPoint),
                        "message"=>$defaultMessage
                    )
                ),

                "motiongraph"=>array(
                    array(
                        "act"=>"share",
                        "subject_condition"=>"unlimited",
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_motiongraph",
                        "reward"=>array("point"=>$midPoint),
                        "message"=>$defaultMessage
                    )
                ),



                "assureright"=>array(
                    array(
                        "act"=>"view",
                        "subject_condition"=>array("condition"=>"x_on_day","x"=>1),
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_insured_right",
                        "reward"=>array("point"=>$midPoint),
                        "message"=>$defaultMessage
                    )
                ),

                "assureright"=>array(
                    array(
                        "act"=>"share",
                        "subject_condition"=>"unlimited",
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_insured_right",
                        "reward"=>array("point"=>$midPoint),
                        "message"=>$defaultMessage
                    )
                ),



                 "fanpage"=>array(
                    array(
                        "act"=>"view",
                        "subject_condition"=>array("condition"=>"x_on_day","x"=>1),
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_fanpage_content",
                        "reward"=>array("point"=>$midPoint),
                        "message"=>$defaultMessage
                    )
                ),

                "fanpage"=>array(
                    array(
                        "act"=>"share",
                        "subject_condition"=>"unlimited",
                        "subject_key"=>"id",
                        "subject_table"=>"tbt_fanpage_content",
                        "reward"=>array("point"=>$midPoint),
                        "message"=>$defaultMessage
                    )
                )
    )
);


?>