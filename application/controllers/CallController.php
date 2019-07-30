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
        if ($this->auth()) {
            $this->load->model('CallModel');
        }
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

}
