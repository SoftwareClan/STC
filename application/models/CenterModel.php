<?php

/**
 * Description of TargetModel
 *
 * @author narendra
 */
class CenterModel extends CI_Model {

    public function addFile($filename, $location) {
        $this->db->trans_start();
        $this->db->insert('tb_file', array('name' => $filename, 'location' => $location, 'upload_datetime' => current_date()));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $result = 0;
        } else {
            $result = $this->db->insert_id();
            $this->db->trans_commit();
        }
        $this->db->trans_complete();
        return $result;
    }

    public function getAllFile() {
        $resultData = $this->db->get('tb_file')->result();
        if (count($resultData) > 0) {
            return array('status' => 200, 'result' => array('code' => '200', 'message' => $resultData));
        } else {
            return array('status' => 200, 'result' => array('code' => '401', 'message' => 'No Data'));
        }
    }

    public function addCenterRecord($record) {
        $this->db->trans_start();
        foreach ($record as $r) {
            $insert_query = $this->db->insert_string('call_center', $r);

            $insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
            $this->db->query($insert_query);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {

            $this->db->trans_commit();
            return true;
        }
        $this->db->trans_complete();
    }

    public function updateCenterRecord($record, $where) {
        $this->db->trans_start();
        $counter = 0;
        foreach ($record as $r) {
            $insert_query = $this->db->update_string('call_center', $r, $where);
            $this->db->query($insert_query);
            if ($this->db->affected_rows() > 0) {
                $counter++;
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getCallCenterapi($where) {
        $resultData = $this->db->select(array("c_id", "name", "number", "source", "assign_date"))
                        ->where($where)->get('call_center')->result();
        if (count($resultData) > 0) {
            return array('status' => 200, 'result' => array('code' => '200', 'message' => $resultData));
        } else {
            return array('status' => 200, 'result' => array('code' => '401', 'message' => array()));
        }
    }

    public function getCallCenter($where) {
        $resultData = $this->db->select(array("call_center.*", "stc_users.u_name as uname"))->from('call_center')
                        ->join('stc_users', "call_center.user_ref=stc_users.u_id", "left")->where($where)->get()->result();
        if (count($resultData) > 0) {
            return array('status' => 200, 'result' => array('code' => '200', 'message' => $resultData));
        } else {
            return array('status' => 200, 'result' => array('code' => '401', 'message' => array()));
        }
    }

    public function deleteRecord($record, $where) {
        $this->db->trans_start();
        foreach ($record as $r) {
            $insert_query = $this->db->update_string('call_center', $r, $where);
            $this->db->query($insert_query);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('  status' => 200, 'result' => array('code' => '401', 'message' => 'Failed To Delete Record.'));
        } else {
            $this->db->trans_commit();
            return array('status' => 200, 'result' => array('code' => '200', 'message' => 'Success To Delete Record.'));
        }
    }

}
