<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReminderModel
 *
 * @author narendra
 */
class ReminderModel extends CI_Model {

    public function create_reminder() {
        $this->db->trans_start();
        $this->db->insert('tb_reminder', $this);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => 200, 'data' => array('status' => 401, 'message' => 'Failed To Create.'));
        } else {
            $this->db->trans_commit();
            return array('status' => 200, 'data' => array('status' => 200, 'message' => 'Success To Create.'));
        }
        $this->db->trans_complete();
    }

    public function update_reminder($id) {
        $this->db->trans_start();
        $this->db->set($this);
        $this->db->where('id', $id);
        $this->db->update('tb_reminder');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => 200, 'data' => array('status' => 401, 'message' => 'Failed To Update.'));
        } else {
            $this->db->trans_commit();
            return array('status' => 200, 'data' => array('status' => 200, 'message' => 'Success To Update.'));
        }
        $this->db->trans_complete();
    }

    public function delete_reminder($id) {
        $this->db->trans_start();
        $this->db->set('delete_date_time', current_date());
        $this->db->set('v_status', 0);
        $this->db->where('id', $id);
        $this->db->update('tb_reminder');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => 200, 'data' => array('status' => 401, 'message' => 'Failed To delete.'));
        } else {
            $this->db->trans_commit();
            return array('status' => 200, 'data' => array('status' => 200, 'message' => 'Success To Delete.'));
        }
        $this->db->trans_complete();
    }

    public function get_reminder_by_id($id) {
        $this->db->where(array('id' => $id, 'v_status' => 1));
        $result = $this->db->get('tb_reminder')->result();
        if (count($result) > 0) {
            return array('status' => 200, 'data' => array('status' => 200, 'data' => $result));
        } else {
            return array('status' => 200, 'data' => array('status' => 401, 'data' => 'no data'));
        }
    }

    public function get_reminder_by_userid($where) {
        $result = $this->db->select(array("tb_reminder.*", 'stc_users.u_number', 'call_center.number'))
                        ->from('tb_reminder')
                        ->join('stc_users', 'on tb_reminder.user_ref=stc_users.u_id')
                        ->join('call_center', 'on tb_reminder.number_ref=call_center.c_id')
                        ->where($where)->get()->result();

        if (count($result) > 0) {
            return array('status' => 200, 'data' => array('status' => 200, 'data' => $result));
        } else {
            return array('status' => 200, 'data' => array('status' => 401, 'data' => 'no data'));
        }
    }

    public function get_reminder_by_userid_and_date($id, $date) {
        $this->db->where(array('mo_id' => $id, 'v_status' => 1, 'r_date' => $date));
        $result = $this->db->get('tb_reminder')->result();
        if (count($result) > 0) {
            return array('status' => 200, 'data' => array('status' => 200, 'data' => $result));
        } else {
            return array('status' => 200, 'data' => array('status' => 401, 'data' => 'no data'));
        }
    }

    public function get_all_reminder() {
        $result = $this->db->select(array("tb_reminder.*", 'stc_users.u_number', 'call_center.number'))
                        ->from('tb_reminder')
                        ->join('stc_users', 'on tb_reminder.user_ref=stc_users.u_id')
                        ->join('call_center', 'on tb_reminder.number_ref=call_center.c_id')->where('tb_reminder.v_status', 1)->get()->result();

        if (count($result) > 0) {
            return array('status' => 200, 'data' => array('status' => 200, 'data' => $result));
        } else {
            return array('status' => 200, 'data' => array('status' => 200, 'data' => 'no data'));
        }
    }

    public function webRequestGetReminder($where) {
        $result = $this->db->select(array("tb_reminder.*", 'stc_users.u_number', 'call_center.number'))
                        ->from('tb_reminder')
                        ->join('stc_users', 'on tb_reminder.user_ref=stc_users.u_id')
                        ->join('call_center', 'on tb_reminder.number_ref=call_center.c_id')
                        ->where($where)->get()->result();
        return $result;
    }

    public function getReportCounter() {
        return $this->db->query("select count(*) total,sum(case when mark_as_read=1 then 1 else 0 end) as 'read',
    sum(case when mark_as_read=0 then 1 else 0 end) as 'unread',
    sum(case when notify_status=1 then 1 else 0 end) as 'notify',
    sum(case when notify_status=0 then 1 else 0 end) as 'notnotify'
	from tb_reminder ")->result();
    }

}
