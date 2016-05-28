<?php //exit; 

/*SELECT A . * , B.module_name AS mod_name
FROM cms_category A
LEFT JOIN cms_module B ON A.mod_id = B.id
WHERE A.id =9
LIMIT 0 , 30*/

$conf = Array(
    "page_id" => "dashboard",
    "hash_key" => "",
    "table" => array(
        'primary_table' => array(
            'table_name'=>'tbt_project'
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
                    "table" => "tbt_project",
                    "label" => "ID",
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "name",
                    "table" => "tbt_project",
                    "label" => freetext('project_name'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "description",
                    "table" => "tbt_project",
                    "label" => freetext('description'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "state",
                    "table" => "tbt_project",
                    "label" => freetext('state'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
        )

);


?>