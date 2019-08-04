<?php

/**
 * Description of CallController
 *
  $this->CallModel->cl_id = $this->input->post_get('cl_id');
  $this->CallModel->target_ref = $this->input->post_get('target_ref');
  $this->CallModel->call_type = $this->input->post_get('call_type');
  $this->CallModel->call_duration = $this->input->post_get('call_duration');
  $this->CallModel->call_datetime = $this->input->post_get('call_datetime');
  $this->CallModel->custom_status = $this->input->post_get('custom_status');
  $this->CallModel->note = $this->input->post_get('note');
  $this->CallModel->create_time = $this->input->post_get('create_time');
  $this->CallModel->delete_time = $this->input->post_get('delete_time');
  $this->CallModel->update_time = $this->input->post_get('update_time');
  $this->CallModel->status = $this->input->post_get('status');
 *
 * @author narendra
 */
class CallController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CallModel');
    }

    public function createCallLog() {
        if ($this->token_auth()) {
            if (is_null($this->input->post_get('target_ref'))) {
                $this->CallModel->target_ref = $this->input->post_get('target_ref');
            }
            if (is_null($this->input->post_get('call_type'))) {
                $this->CallModel->call_type = $this->input->post_get('call_type');
            }
            if (is_null($this->input->post_get('call_duration'))) {
                $this->CallModel->call_duration = $this->input->post_get('call_duration');
            }
            if (is_null($this->input->post_get('call_datetime'))) {
                $this->CallModel->call_datetime = $this->input->post_get('call_datetime');
            }
            if (is_null($this->input->post_get('custom_status'))) {
                $this->CallModel->custom_status = $this->input->post_get('custom_status');
            }
            if (is_null($this->input->post_get('note'))) {
                $this->CallModel->note = $this->input->post_get('note');
            }
            $this->CallModel->create_time = current_date();
            json_output(200, $this->CallModel->addCall());
        }
    }

    public function updateCallLog() {
        if ($this->token_auth()) {
            if (is_null($this->input->post_get('target_ref'))) {
                $this->CallModel->target_ref = $this->input->post_get('target_ref');
            }
            if (is_null($this->input->post_get('call_type'))) {
                $this->CallModel->call_type = $this->input->post_get('call_type');
            }
            if (is_null($this->input->post_get('call_duration'))) {
                $this->CallModel->call_duration = $this->input->post_get('call_duration');
            }
            if (is_null($this->input->post_get('call_datetime'))) {
                $this->CallModel->call_datetime = $this->input->post_get('call_datetime');
            }
            if (is_null($this->input->post_get('custom_status'))) {
                $this->CallModel->custom_status = $this->input->post_get('custom_status');
            }
            if (is_null($this->input->post_get('note'))) {
                $this->CallModel->note = $this->input->post_get('note');
            }
            $this->CallModel->update_time = current_date();
            if (is_null($this->input->post_get('cl_id'))) {
                $this->CallModel->cl_id = $this->input->post_get('cl_id');
                json_output(200, $this->CallModel->updateCenterRecord());
            } else {
                json_output(200, "Invalid Input Please Provide required Parameter");
            }
        }
    }

    public function getCallLog() {

        if (is_null($this->input->post_get('call_type'))) {
            $where = array("call_type" => $this->input->post_get('call_type'), "status" => 1);
            json_output(200, $this->CallModel->getCallLog($where));
        }

        if (is_null($this->input->post_get('target_ref'))) {
            $where = array("target_ref" => $this->input->post_get('target_ref'), "status" => 1);
            json_output(200, $this->CallModel->getCallLog($where));
        }

        if (is_null($this->input->post_get('start_date')) && is_null($this->input->post_get('end_date'))) {
            $where = array("call_datetime >=" => $this->input->post_get('start_date'), "call_datetime <=" => $this->input->post_get('end_date'), "status" => 1);
            json_output(200, $this->CallModel->getCallLog($where));
        }

        if (is_null($this->input->post_get('user_ref'))) {
            json_output(200, $this->CallModel->getCallLogByUserID($this->input->post_get('user_ref')));
        }

        if (is_null($this->input->post_get('All'))) {
            $where = array("status" => 1);
            json_output(200, $this->CallModel->getCallLog($where));
        }
    }

    public function callLogs_by_traget_ref() {
        if (!is_null($this->input->post_get('target_ref'))) {
            $where = array("target_ref" => $this->input->post_get('target_ref'), "status" => 1);
            $result = $this->CallModel->getCallLog($where);
            $resultData = $result["result"]["message"];
            $rows = "";
            if (count($resultData) > 0) {
                foreach ($resultData as $row) {
                    $status = "";
                    switch ($row->custom_status) {
                        case 1:$status = "Busy";
                            break;
                        case 2:$status = "Switch_off";
                            break;
                        case 3:$status = "Not_Received";
                            break;
                        case 4:$status = "wrong_number";
                            break;
                        case 5:$status = "Call_back";
                            break;
                        case 6:$status = "Intrested";
                            break;
                        case 7:$status = "Not_Intrested";
                            break;
                        default:
                            break;
                    }
                    $rows .= "<tr>"
                            . "<td>" . $row->call_type . "</td>"
                            . "<td>" . $row->call_duration . "</td>"
                            . "<td>" . $row->call_datetime . "</td>"
                            . "<td>" . $status . "</td>"
                            . "<td>" . $row->note . "</td>"
                            . "<td>" . $row->create_time . "</td>"
                            . "</tr>";
                }
            }
            $data_row["data_table"] = $rows;
            echo json_output(200, $data_row);
        }
    }

    public function getAllUserReport() {
        $resultData = $this->db->query("select distinct(s.u_name),s.u_id ,count(s.u_name) as 'total',
sum(case c.complete_status when 1 then 1 end) as 'Busy',
sum(case c.complete_status when 2 then 1 end) as 'Switch_off',
sum(case c.complete_status when 3 then 1 end) as 'Not_Received',
sum(case c.complete_status when 4 then 1 end) as 'wrong_number',
sum(case c.complete_status when 5 then 1 end) as 'Call_back',
sum(case c.complete_status when 6 then 1 end) as 'Intrested',
sum(case c.complete_status when 7 then 1 end) as 'Not_Intrested'
from stc_users s join call_center c on c.user_ref=s.u_id where s.status =1 group by s.u_id")->result();
        $rows = "";
        if (count($resultData) > 0) {
            foreach ($resultData as $row) {

                $rows .= "<tr>"
                        . "<td>" . $row->u_name . "</td>"
                        . "<td>" . $row->total . "</td>"
                        . "<td>" . $row->Busy . "</td>"
                        . "<td>" . $row->Switch_off . "</td>"
                        . "<td>" . $row->Not_Received . "</td>"
                        . "<td>" . $row->wrong_number . "</td>"
                        . "<td>" . $row->Call_back . "</td>"
                        . "<td>" . $row->Intrested . "</td>"
                        . "<td>" . $row->Not_Intrested . "</td>"
                        . '<td class="td-actions">
                           <button type="button" rel="tooltip" class="btn btn-info btn-simple" data-toggle="modal" data-target="#ind_user_target_Model" data-user_value="' . $row->u_id . '">
                                <i class="material-icons">view_module</i>
                           </button>
                            </td>' .
                        "</tr>";
            }
        }
        $data_row["data_table"] = $rows;
        echo json_output(200, $data_row);
    }

    function users_target_panel() {
        $data['page_title'] = "Users Target Report";
        $data['load_view'] = array('Report/individual_user_target', 'Report/target_call_record', 'Report/all_user_target_report',);
        $data['session'] = $this->getUserDetails();
        $this->load->view('dashboard', $data);
    }

}
