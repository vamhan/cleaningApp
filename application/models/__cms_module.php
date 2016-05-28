<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_module extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    public function listviewCfg($config, $page){
        
        $table = $config['table']['primary_table']['table_name'];
        $result = self::getModuleAll(false, $page);

            $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output['total_item'] = self::getResultTotalpage($table);
                $output['list'] = $result;
                $output['page'] = $page;
                $output['page_size'] = $this->pageSize;                 
             //echo self::getResultTotalpage($table)."|".$this->pageSize;

                $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);

        return self::response($state,$code,$msg,$output);
    }

    public function getModuleList () {

        $this->db->order_by('is_menu desc, is_main_menu desc, sequence_index asc');
        $query = $this->db->get('cms_module');

        $result = $query->result_array();

        return $result;
    }

    public function getMainModule () {

        $this->db->where('cms_module.is_main_menu', 1);
        $this->db->where('cms_module.url !=', '');
        $this->db->order_by('is_menu desc, is_main_menu desc, sequence_index asc');
        $query = $this->db->get('cms_module');

        $result = $query->result_array();

        return $result;
    }


    public function getModuleAll ($children_flag=true,$page=1) {

        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        $this->db->select('*');
        $this->db->from('cms_module');

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('module_name',$match);
        }

        $query = $this->db->get();
        $result = $query->result_array();

        $list = array();
        foreach ($result as $module) {  
            if ($children_flag) {
                $this->db->select('*');
                $this->db->from('cms_category');
                $this->db->where('module_id', $module['id']);
                $this->db->where('parent_id', '0');

                $query = $this->db->get();
                $children = $query->result();

                $module['children'] = $this->getCategoryChildren($children);
            }

            array_push($list, $module);
        }

        return $list;
    }

    public function getCategoryAll () {
        $this->db->select('cms_category.*, cms_module.module_name as module_name');
        $this->db->from('cms_category');
        $this->db->join('cms_module', 'cms_category.module_id = cms_module.id');

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function getCategoryChildren ($children_list) {

        if (empty($children_list)) {
            return 0;
        }

        foreach ($children_list as $category) {
            $this->db->select('*');
            $this->db->from('cms_category');
            $this->db->where('parent_id', $category->id);

            $query = $this->db->get();
            $children = $query->result();

            $category->children = $this->getCategoryChildren($children);
        }

        return $children_list;

    }

    public function getPageAll () {
        $this->db->where('page_type', 'front_end');
        $query = $this->db->get('cms_page');
        $front_page = $query->result();

        $this->db->where('page_type', 'back_end');
        $query = $this->db->get('cms_page');
        $back_page = $query->result();

        $result = array (
            'frontend' => $front_page,
            'backend'  => $back_page
        );
        
        return $result;
    }

    public function getNavigationGroup ($type='all') {

        $this->db->where('page_type', 'front_end');
        $this->db->order_by('priority');
        $query = $this->db->get('cms_page_group');
        $front_group_list = $query->result();

        if (!empty($front_group_list)) {
            foreach ($front_group_list as $group) {
                $this->db->select('p.*, s.priority');
                $this->db->from('cms_page_struct s');
                $this->db->join('cms_page p', 's.page_id = p.id');
                $this->db->where('s.group_id', $group->group_id);
                $this->db->order_by('s.priority');
                $query = $this->db->get();

                $group->pages = $query->result();
            }
        }   

        if ($type == 'frontend') { return $front_group_list; }

        $this->db->where('page_type', 'back_end');
        $this->db->order_by('priority');
        $query = $this->db->get('cms_page_group');
        $back_group_list = $query->result();

        if (!empty($back_group_list)) {
            foreach ($back_group_list as $group) {
                $this->db->select('p.*, s.priority');
                $this->db->from('cms_page_struct s');
                $this->db->join('cms_page p', 's.page_id = p.id');
                $this->db->where('s.group_id', $group->group_id);
                $this->db->order_by('s.priority');
                $query = $this->db->get();

                $group->pages = $query->result();
            }
        }   

        if ($type == 'backend') { return $back_group_list; }

        $group_list = array(
            'frontend' => $front_group_list,
            'backend'  => $back_group_list  
        );

        return $group_list;
    }

    function getModuleByTitle ($title) {
        $this->db->where('module_name', $title);
        $query = $this->db->get('cms_module');

        return $query->row_array();
    }

    public function insert ($p) {

        $data = array(
            'module_name' => $p['module_name'],
            'description' => $p['description']
        );

        $this->db->insert('cms_module', $data);
        $insert_id = $this->db->insert_id();

        log_transaction('create', 'cms_module', $insert_id, 'success');
    }

    public function update ($p) {

        $data = array(
            'module_name' => $p['module_name'],
            'description' => $p['description']
        );

        $this->db->where('id', $p['id']);
        $this->db->update('cms_module', $data);

        log_transaction('update', 'cms_module', $p['id'], 'success');
    }

    public function deleteModule($id) {

        $this->db->delete('cms_module', array('id' => $id));
        log_transaction('delete', 'cms_module', $id, 'success'); 
    }

    public function insertCategory($data) {

        $this->db->insert('cms_category', $data);
        $insert_id = $this->db->insert_id();

        log_transaction('create', 'cms_category', $insert_id, 'success');
    }

    public function updateCategory ($data, $where) {

        $this->db->where($where);
        $this->db->update('cms_category', $data);

        log_transaction('update', 'cms_category', $where['id'], 'success');
    }

    public function deleteCategoryOnly ($id) {

        $this->db->select('parent_id');
        $this->db->from('cms_category');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row();

        if (!empty($result)) {
            $parent_id = $result->parent_id;
            $this->updateCategory(array('parent_id' => $parent_id), array('parent_id' => $id));
            $this->db->delete('cms_group_permission', array('cat_id' => $id));
            $this->db->delete('cms_user_permission', array('cat_id' => $id));
            $this->db->delete('cms_category', array('id' => $id));
        }

        log_transaction('delete', 'cms_category', $id, 'success');
    }

    public function deleteCategoryAll ($id) {

        $this->db->select('id');
        $this->db->from('cms_category');
        $this->db->where('parent_id', $id);
        $children = $this->db->get()->result_array();
        foreach ($children as $child) {
            $this->db->delete('cms_group_permission', array('cat_id' => $child['id']));
            $this->db->delete('cms_user_permission', array('cat_id' => $child['id']));
            
            log_transaction('delete', 'cms_category', $child['id'], 'success');
        }

        $this->db->delete('cms_category', array('parent_id' => $id));

        $this->db->delete('cms_group_permission', array('cat_id' => $id));
        $this->db->delete('cms_user_permission', array('cat_id' => $id));
        $this->db->delete('cms_category', array('id' => $id));

        log_transaction('delete', 'cms_category', $id, 'success');
    }

    public function insertNavGroup ($data) {

        $this->db->select_max('priority');
        $query      = $this->db->get('cms_page_group');
        $select_max = $query->row();

        if (!empty($select_max)) {
            $data['priority'] = $select_max->priority+1;
        }

        $this->db->insert('cms_page_group', $data);
        $insert_id = $this->db->insert_id();

        log_transaction('create', 'cms_page_group', $insert_id, 'success');
    }

    public function updateNav ($type, $data) {

        $order = 1;


        $this->db->select('group_id');
        $this->db->where('page_type', $type);
        $query = $this->db->get('cms_page_group');
        $type_group = $query->result();

        if (!empty($type_group)) {
            foreach ($type_group as $value) {
                $this->db->delete('cms_page_struct', array('group_id' => $value->group_id));
            }
        }

        $this->db->delete('cms_page_group', array('page_type' => $type));

        foreach ($data as $group) {

            $group_data = array (
                'group_name' => $group->name,
                'url'        => $group->url,
                'page_type'  => $group->pageType,
                'priority'   => $order
            );

            $this->db->insert('cms_page_group', $group_data);
            $insert_id = $this->db->insert_id();

            if (!empty($group->children)) {
                $page_order = 1;
                foreach ($group->children as $page) {
                    $page_data = array (
                        'group_id' => $insert_id,
                        'page_id'  => $page->id,
                        'priority' => $page_order
                    );

                    $this->db->insert('cms_page_struct', $page_data);
                    $page_order++;
                }
            }

            $order++;
        }
    }

    public function deleteNavGroup ($id) {

        $this->db->delete('cms_page_struct', array('group_id' => $id));
        $this->db->delete('cms_page_group', array('group_id' => $id));
    }

    public function deleteNavPage ($id, $priority) {
        
        $this->db->delete('cms_page_struct', array('page_id' => $id, 'priority' => $priority));
    }
}
