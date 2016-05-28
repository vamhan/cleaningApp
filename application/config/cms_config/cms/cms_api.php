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
                    "label" => "API",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "name",
                    "label" => "METHOD",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "description",
                    "label" => "DESCRIPTION",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )


            ,Array
                (
                    "name" => "table",
                    "label" => "LINKED TABLE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "is_ready_to_use",
                    "label" => "API READY",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
                

            ,Array
                (
                    "name" => "create_date",
                    "label" => "CREATE_DATE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            

        )

);


?>