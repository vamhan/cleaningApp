<?php //exit; 

/*SELECT A . * , B.module_name AS mod_name
FROM cms_category A
LEFT JOIN cms_module B ON A.mod_id = B.id
WHERE A.id =9
LIMIT 0 , 30*/

$conf = Array(
    "page_id" => "CMS",
    "mod_id" => "CMS",
    "hash_key" => "",
    "table" => array(
        'primary_table' => array(
            'table_name'=>'tbm_keyuser_modules'
        ),

        'extend_table' => array()
    ),
    "query" => "",
    "sort_key" => "module_id",
    "sort_direction" => "DESC",
    "enable_group_action" => "1",
    "visible_column" => Array ()
);


?>