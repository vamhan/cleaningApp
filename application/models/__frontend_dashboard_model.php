<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __frontend_dashboard_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    function getStateAll () {

        $query = $this->db->get('tbm_project_state');
        return $query->result();

    }

    function getCompanyAll () {

        $this->db->order_by('name');
        $query = $this->db->get('tbt_company');
        return $query->result();

    }

    function getLoginUser () {

        $user_id = $this->session->userdata('id');
        $this->db->where('id', $user_id);
        $query = $this->db->get('cms_users');

        return $query->row();

    }

    function getUserAll ($array=false) {

        $this->db->order_by('user_firstname, user_lastname');
        $query = $this->db->get('cms_users');

        if ($array) {
            return $query->result_array();
        }

        return $query->result();

    }

    function getProject ($detail=false, $group_by='', $active=false, $card_flag=false, $where='') {

        $this->db->select('p.*, u.user_login, u.user_email, u.image as user_image, org.icon as org_icon, org.color as org_color');
        $this->db->from('tbt_project p');
        $this->db->join('cms_users u', 'p.owner_id = u.id');
        $this->db->join('tbm_organization org', 'u.organization_id = org.id');

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get();
        $project_data = $query->result();

        if (!empty($project_data)) {
            foreach ($project_data as $project) {
                
                $this->db->select('u.*, org.icon as org_icon, org.color as org_color');
                $this->db->from('tbt_project_participant p');
                $this->db->join('cms_users u', 'p.user_id = u.id');
                $this->db->join('tbm_organization org', 'u.organization_id = org.id');
                $this->db->where('p.project_id', $project->id);

                $query = $this->db->get();

                $project->participant_list = $query->result();
                $project->participant_list_id = array();
                if (!empty($project->participant_list)) {
                    foreach ($project->participant_list as $participant) {
                        array_push($project->participant_list_id, $participant->id);
                    }
                }
            }
        }

        if ($detail) {

            if (!empty($group_by)) {
                $project_group = array();
            }

            if (!empty($project_data)) {
                foreach ($project_data as $project) {

                    $this->db->select('id, project_id, name, description, DATE(assigned_date) as assigned_date, DATE(due_date) as due_date, DATE(create_date) as create_date, create_date as create_datetime, state_id ');
                    if ($card_flag) {
                        $project_group['project'] = $project;
                    }

                    $this->db->from('tbt_project_card');
                    $this->db->where('project_id', $project->id);

                    if ($active) {
                        $this->db->where('date(assigned_date) <= date(now())', null, false);
                        $this->db->order_by('state_id desc, assigned_date desc');
                        $this->db->limit('1');
                    } else {
                        $this->db->order_by('update_date', 'desc');
                    }

                    $query = $this->db->get();

                    $project->card_list = $query->result();

                    if (!empty($project->card_list)) {

                        if ($card_flag) {
                            $project_group['card_list'] = array();
                        }

                        foreach ($project->card_list as $card) {
                            $this->db->select('u.*, org.icon as org_icon, org.color as org_color');
                            $this->db->from('tbt_project_card_participant p');
                            $this->db->join('cms_users u', 'p.user_id = u.id');
                            $this->db->join('tbm_organization org', 'u.organization_id = org.id');
                            $this->db->where('p.project_card_id', $card->id);

                            $query = $this->db->get();

                            $card->participant_list = $query->result();

                            $card->participant_id_list = array();
                            if (!empty($card->participant_list)) {
                                foreach ($card->participant_list as $participant) {
                                    array_push($card->participant_id_list, $participant->id);
                                }
                            }

                            if (!empty($group_by)) {
                                if ($card_flag) {
                                    if (!array_key_exists($card->{$group_by}, $project_group['card_list'])) {
                                        $project_group['card_list'][$card->{$group_by}] = array();
                                    }

                                    array_push($project_group['card_list'][$card->{$group_by}], $card);
                                } else {
                                    if (!array_key_exists($card->{$group_by}, $project_group)) {
                                        $project_group[$card->{$group_by}] = array();
                                    }

                                    array_push($project_group[$card->{$group_by}], $project);
                                }
                            }
                        }
                    }
                }

                if (!empty($group_by)) {
                    if ($card_flag) {
                        function createDateSort($a, $b) {
                            return $a->create_datetime > $b->create_datetime;
                        }

                        usort($project_group['card_list'][1], "createDateSort");
                        ksort($project_group['card_list']);
                    } else {
                        ksort($project_group);
                    }
                    return $project_group;
                }
            }

        }

        return $project_data;
    }

    function getCard ($id, $checklist=false, $comment=false) {

        $this->db->select('id, project_id, name, description, DATE(assigned_date) as assigned_date, DATE(due_date) as due_date, DATE(create_date) as create_date, create_date as create_datetime, state_id, enable_mail_notify, mail_notify_user_email ');
        $this->db->where('id', $id);
        $query = $this->db->get('tbt_project_card');

        $card = $query->row_array();

        if (!empty($card)) {
            $this->db->from('tbt_project_card_participant cp');
            $this->db->join('cms_users u', 'cp.user_id = u.id');
            $this->db->where('cp.project_card_id', $card['id']);
            $participant_list = $this->db->get()->result_array();
            if (!empty($participant_list)) {

                $card['participant_id_list'] = array();
                $card['participant'] = '';
                $count = 0;
                foreach ($participant_list as $participant) {
                    if ($count > 0) {
                        $card['participant'] .= ',';
                    }
                    $card['participant'] .= $participant['user_firstname'].' '.$participant['user_lastname'];

                    array_push($card['participant_id_list'], $participant['id']);
                    $count++;
                }
            }

            if (!empty($card['mail_notify_user_email'])) {
                $mail_notify_user_email = explode(',', $card['mail_notify_user_email']);
                $this->db->from('cms_users');
                $this->db->where_in('user_email', $mail_notify_user_email);
                $email_list = $this->db->get()->result_array();

                if (!empty($email_list)) {

                    $card['email_list'] = '';
                    $count = 0;
                    foreach ($email_list as $email) {
                        if ($count > 0) {
                            $card['email_list'] .= ',';
                        }
                        $card['email_list'] .= $email['user_firstname'].' '.$email['user_lastname'];
                        $count++;
                    }
                }
            }

            if ($checklist) {
                $this->db->where('project_card_id', $card['id']);
                $query = $this->db->get('tbt_checklist');

                $card['checklist'] = $query->result_array();

                if ( !empty($card['checklist']) ) {
                    foreach ($card['checklist'] as $key => $checklist) {
                        $this->db->where('checklist_id', $checklist['id']);
                        $this->db->order_by('priority');
                        $query = $this->db->get('tbt_checklist_item');

                        $card['checklist'][$key]['items'] = $query->result_array();
                    }
                }
            }

            if ($comment) {
                $this->db->select('c.*, u.user_login, u.image');
                $this->db->from('tbt_comment c');
                $this->db->join('cms_users u', 'c.user_id = u.id');
                $this->db->where('c.project_card_id', $card['id']);
                $this->db->order_by('c.update_date desc');
                $query = $this->db->get();

                $comment_list = $query->result_array();
                if (!empty($comment_list)) {
                    foreach ($comment_list as $key => $comment) {
                        if (!empty($comment['image'])) { 
                            $comment_list[$key]['image'] = image_thumb('upload/user/'.$comment['image'], 35,35); 
                        }

                        $yesterday = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));

                        if ( date("Y-m-d", strtotime($comment['update_date'])) == date("Y-m-d") ) {
                            $comment_list[$key]['update_date'] = 'today';
                        } else if ( date("Y-m-d", strtotime($comment['update_date'])) == date("Y-m-d", $yesterday) ) {
                            $comment_list[$key]['update_date'] = 'yesterday';
                        } else {
                            $comment_list[$key]['update_date'] = date("M j", strtotime($comment['update_date']));
                        }

                        $comment_list[$key]['update_time'] = date("H:i", strtotime($comment['update_date']));
                    }
                }

                $card['comment'] = $comment_list;
            }

        }

        return $card;
    }

    function insertProject ($p) {

        $data = array(
            'name'        => $p['name'],
            'description' => $p['description'],
            'company_id'  => $p['company_id'],
            'owner_id'    => $p['owner_id']

        );
        $this->db->insert('tbt_project', $data);
        $project_id = $this->db->insert_id();

        $paricipant_list = $p['user_list'];
        if (!empty($paricipant_list)) {

            $paricipant_arr = explode(',', $paricipant_list);
            
            $this->db->where_in("CONCAT(user_firstname, ' ', user_lastname)", $paricipant_arr);
            $query = $this->db->get('cms_users');
            $paticipant_data = $query->result();

            echo "<pre>";
            print_r($paticipant_data);
            echo "</pre>";
            foreach ($paticipant_data as $participant) {
                $this->db->insert('tbt_project_participant', array('project_id' => $project_id, 'user_id' => $participant->id));
            }
        }
    }

    function insertCard($data, $paricipant_list, $email_list) {

        $this->db->insert('tbt_project_card', $data);
        $card_id = $this->db->insert_id();

        $paricipant_arr = explode(',', $paricipant_list);
        
        $this->db->where_in("CONCAT(user_firstname, ' ', user_lastname)", $paricipant_arr);
        $query = $this->db->get('cms_users');
        $paticipant_data = $query->result();

        foreach ($paticipant_data as $participant) {
            $this->db->insert('tbt_project_card_participant', array('project_card_id' => $card_id, 'user_id' => $participant->id));
        }

        if (!empty($email_list)) {
            $email_arr = explode(',', $email_list);
            
            $this->db->where_in("CONCAT(user_firstname, ' ', user_lastname)", $email_arr);
            $query = $this->db->get('cms_users');
            $result = $query->result();

            $email_data = '';
            $count      = 0;
            foreach ($result as $participant) {
                if ($count > 0) {
                    $email_data .= ',';
                }
                $email_data .= $participant->user_email;
                $count++;
            }

            $this->db->where('id', $card_id);
            $this->db->update('tbt_project_card', array('mail_notify_user_email' => $email_data));
        }
    }


    function editCard($card_id, $data, $paricipant_list, $email_list) {

        $this->db->where('id', $card_id);
        $this->db->update('tbt_project_card', $data);

        $this->db->delete('tbt_project_card_participant', array('project_card_id' => $card_id));

        $paricipant_arr = explode(',', $paricipant_list);
        $this->db->where_in("CONCAT(user_firstname, ' ', user_lastname)", $paricipant_arr);
        $query = $this->db->get('cms_users');
        $paticipant_data = $query->result();

        foreach ($paticipant_data as $participant) {
            $this->db->insert('tbt_project_card_participant', array('project_card_id' => $card_id, 'user_id' => $participant->id));
        }

        $this->db->where('id', $card_id);
        $this->db->update('tbt_project_card', array('mail_notify_user_email' => ''));
        if (!empty($email_list)) {
            $email_arr = explode(',', $email_list);
            
            $this->db->where_in("CONCAT(user_firstname, ' ', user_lastname)", $email_arr);
            $query = $this->db->get('cms_users');
            $result = $query->result();

            $email_data = '';
            $count      = 0;
            foreach ($result as $participant) {
                if ($count > 0) {
                    $email_data .= ',';
                }
                $email_data .= $participant->user_email;
                $count++;
            }

            $this->db->where('id', $card_id);
            $this->db->update('tbt_project_card', array('mail_notify_user_email' => $email_data));
        }
    }   

    function createChecklist($data) {
        
        $this->db->insert('tbt_checklist', $data);
        return $this->db->insert_id();
    }

    function deleteChecklist($id) {

        $this->db->delete('tbt_checklist', array('id' => intval($id)));
        $this->db->delete('tbt_checklist_item', array('checklist_id' => intval($id)));
    }

    function updateChecklistItem($id, $items) {

        $this->db->delete('tbt_checklist_item', array('checklist_id' => intval($id)));

        $priority = 1;
        foreach ($items as $item) {
            if (!empty($item->detail)) {
                $data = array(
                    'checklist_id' => $id,
                    'detail'       => $item->detail,
                    'priority'     => $priority
                );
                $this->db->insert('tbt_checklist_item', $data);
                $priority++;
            }
        }
    }

    function addComment($data) {

        if (!empty($data['comment'])) {
            $this->db->insert('tbt_comment', $data);
            $id = $this->db->insert_id();

            return $id;
        }
    }
}
