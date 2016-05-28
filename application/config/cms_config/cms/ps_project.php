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
                    "label" => "ID",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "title",
                    "label" => "TITLE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "job_type_id",
                    "label" => "JOP TYPE",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "customer_id",
                    "label" => "CUSTOMER",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "ship_to_id",
                    "label" => "SHIP TO ",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "project_start",
                    "label" => "TYPE",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
            ,Array
                (
                    "name" => "project_end",
                    "label" => "TYPE",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
            ,Array
                (
                    "name" => "competitor_id",
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