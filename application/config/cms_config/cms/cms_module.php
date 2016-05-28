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
            'table_name'=>'cms_module'
        ),

        'extend_table' => array()
    ),
    "query" => "",
    "sort_key" => "id",
    "sort_direction" => "DESC",
    "enable_group_action" => "1",
    "visible_column" => Array (
            Array
                (
                    "name" => "id",
                    "table" => "cms_module",
                    "label" => "Module Id",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "module_name",
                    "table" => "cms_module",
                    "label" => freetext('module_name'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "description",
                    "table" => "cms_module",
                    "label" => freetext('description'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
        )

);


?>