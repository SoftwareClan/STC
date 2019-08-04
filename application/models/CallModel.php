<?php

/**
 * Description of CallModel
 *
 * @author narendra
 */
class CallModel extends CI_Model {

    public function addCall() {
        $this->db->trans_start();
        $this->db->insert('tb_call_log', $this);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => 200, "result" => array('code' => '401', 'message' => 'Failed To call log.'));
        } else {
            $this->db->trans_commit();
            return array('status' => 200, "result" => array('code' => '200', 'message' => 'Success To call log.'));
        }
        $this->db->trans_complete();
    }

    public function updateCenterRecord($cl_id) {
        $this->db->trans_start();
        $this->db->set($this);
        $this->db->where(array('status' => 1, 'cl_id' => $cl_id));
        $this->db->update('tb_call_log');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array('status' => 200, "result" => array('code' => '401', 'message' => 'Failed To Upload Record.'));
        } else {
            $this->db->trans_commit();
            return array('status' => 200, "result" => array('code' => '200', 'message' => 'Success To Upload Record.'));
        }
    }

    public function getCallLog($where) {
        $resultData = $this->db->select(array('cl_id', 'target_ref', 'call_type', 'call_duration', 'call_datetime', 'custom_status', 'note', 'create_time', 'update_time'))
                        ->where($where)
                        ->get('tb_call_log')->result();
        if (count($resultData) > 0) {
            return array('status' => 200, "result" => array('code' => '200', 'message' => $resultData));
        } else {
            return array('status' => 200, "result" => array('code' => '401', 'message' => 'No Data'));
        }
    }

    public function getCallLogByUserID($userid) {
        $resultData = $this->db->select(array('tb_call_log.cl_id', 'tb_call_log.target_ref',
                    'tb_call_log.call_type', 'tb_call_log.call_duration', 'tb_call_log.call_datetime',
                    'tb_call_log.custom_status', 'tb_call_log.note', 'tb_call_log.create_time',
                    'tb_call_log.update_time'))
                ->form("tb_target")
                ->join("tb_call_log", "on tb_target.t_id=tb_call_log.Target_ref")
                ->where("user_ref", $userid)
                ->result();
        if (count($resultData) > 0) {
            return array('status' => 200, "result" => array('code' => '200', 'message' => $resultData));
        } else {
            return array('status' => 200, "result" => array('code' => '401', 'message' => 'No Data'));
        }
    }

}
