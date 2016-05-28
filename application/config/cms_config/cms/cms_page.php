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
        array(
            'type'=>'primary_table',
            'select'=> '*',
            'table_name'=>'cms_category',
            'join'=>'',            
            'on'=>''
        ),

        array(
            'type'=>'extend_table',
            'select'=>array(
                    array('col'=>'module_name','alias'=>'mod_name')
                ),
            'table_name'=>'cms_module',
            'join'=>'LEFT',
            'on'=>'cms_category.mod_id = cms_module.id'
        )
    ),
    "query" => "",
    "sort_key" => "create_date",
    "sort_direction" => "DESC",
    "enable_group_action" => "1",
    "visible_column" => Array
        (
            Array
                (
                    "name" => "id",
                    "label" => "PAGE ID",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "page_title",
                    "label" => "TITLE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "table",
                    "label" => "MAIN TABLE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "mod_id",
                    "label" => "MODULE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "cat_id",
                    "label" => "CATEGORY",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "page_type",
                    "label" => "TYPE",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            /*,Array
                (
                    "name" => "create_date",
                    "label" => "CREATE_DATE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )*/

            

        )

);


?>