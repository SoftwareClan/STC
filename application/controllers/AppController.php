<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppController
 *
 * @author narendra
 */
class AppController extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        if (!is_null($this->input->post_get("request_to"))) {
            $request = $this->input->post_get("request_to");
            switch ($request) {
                case "login": $this->login();
                    break;
                case "get_Target_By_User_Ref":$this->getTarget();
                    break;
                case "addlog":$this->addCallLog();
                    break;
            }
        }
    }

    function login() {
        if (!is_null($this->input->post_get("username")) && !is_null($this->input->post_get("password"))) {
            $username = $this->input->post_get("username");
            $password = $this->input->post_get("password");

            $this->load->model('AuthModel');
            $result = $this->AuthModel->loginuserapi($username, $password);
            json_output(200, $result);
        } else {
            json_output(401, array("message" => "Connection Problem"));
        }
    }

    function getTarget() {
        if (!is_null($this->input->post_get("user_ref"))) {
            $user_ref = $this->input->post_get("user_ref");
            $this->load->model('CenterModel');

            $where = array("user_ref" => $this->input->post_get("user_ref"), "status" => 1);
            $result = $this->CenterModel->getCallCenterapi($where);
            json_output(200, $result["result"]);
        } else {
            json_output(200, array("message" => "Connection Problem. required Some value"));
        }
    }

    function addCallLog() {
        if (!is_null($this->input->post_get("user_ref")) &&
                !is_null($this->input->post_get("target_ref")) &&
                !is_null($this->input->post_get("call_type")) &&
                !is_null($this->input->post_get("call_duration")) &&
                !is_null($this->input->post_get("call_datetime")) &&
                !is_null($this->input->post_get("custom_status")) &&
                !is_null($this->input->post_get("custom_note"))
        ) {

            $this->load->model('CallModel');
            if (!is_null($this->input->post_get('target_ref'))) {
                $this->CallModel->target_ref = $this->input->post_get('target_ref');
            }
            if (!is_null($this->input->post_get('call_type'))) {
                $this->CallModel->call_type = $this->input->post_get('call_type');
            }
            if (!is_null($this->input->post_get('call_duration'))) {
                $this->CallModel->call_duration = $this->input->post_get('call_duration');
            }
            if (!is_null($this->input->post_get('call_datetime'))) {
                $this->CallModel->call_datetime = $this->input->post_get('call_datetime');
            }
            if (!is_null($this->input->post_get('custom_status'))) {
                $this->CallModel->custom_status = $this->input->post_get('custom_status');
            }
            if (!is_null($this->input->post_get('custom_note'))) {
                $this->CallModel->note = $this->input->post_get('custom_note');
            }
            $this->CallModel->create_time = current_date();

            json_output(200, $this->CallModel->addCall()["result"]);
        }
    }

}
