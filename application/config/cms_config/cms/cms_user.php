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
            'table_name'=>'cms_users'
        ),

        'extend_table' => array(
            '1' => array(
                'table_name'=>'cms_user_group',
                'join'=>'LEFT',
                'on'=>'cms_users.group_id = cms_user_group.id'
            ),
            '2' => array(
                'table_name'=>'cms_user_department',
                'join'=>'LEFT',
                'on'=>'cms_users.department_id = cms_user_department.id'
            )
        )
    ),
    "query" => "",
    "sort_key" => "id",
    "sort_direction" => "DESC",
    "enable_group_action" => "1",
    "visible_column" => Array
        (
            Array
                (
                    "name" => "id",
                    "table" => "cms_users",
                    "label" => "Users Id",
                    "search_index" => "0",
                    "default_value" => "",
					"width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "user_login",
                    "table" => "cms_users",
                    "label" => freetext('username'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            /*,Array
                (
                    "name" => "user_firstname",
                    "table" => "cms_users",
                    "label" => freetext('firstname'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

            ,Array
                (
                    "name" => "user_lastname",
                    "table" => "cms_users",
                    "label" => freetext('lastname'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )*/
            ,Array
                (
                    "name" => "user_email",
                    "table" => "cms_users",
                    "label" => freetext('email'),
                    "search_index" => "1",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
            ,Array
                (
                    "name" => "dept_name",
                    "table" => "cms_user_department",
                    "label" => freetext('department'),
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
            ,Array
                (
                    "name" => "group_name",
                    "table" => "cms_user_group",
                    "label" => freetext('group'),
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )
            ,Array
                (
                    "name" => "is_enable",
                    "table" => "cms_users",
                    "label" => freetext('status'),
                    "search_index" => "0",
                    "default_value" => "",
                    "width" => "auto",
                    "order_index" => "0",
                )

        )

);


?>