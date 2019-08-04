<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReminderController
 *
 * @author narendra
 */
class ReminderController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ReminderModel');
    }

    function createReminder() {

        if (!is_null($this->input->get_post('number_ref'))) {
            $this->ReminderModel->number_ref = $this->input->get_post('number_ref');
        }

        if (!is_null($this->input->get_post('user_ref'))) {
            $this->ReminderModel->user_ref = $this->input->get_post('user_ref');
            $this->ReminderModel->create_op_user = $this->input->get_post('user_ref');
        }

        if (!is_null($this->input->get_post('reminder_message'))) {
            $this->ReminderModel->reminder_message = $this->input->get_post('reminder_message');
        }

        if (!is_null($this->input->get_post('r_date'))) {
            $this->ReminderModel->r_date = $this->input->get_post('r_date');
        }


        if (!is_null($this->input->get_post('r_time'))) {
            $this->ReminderModel->r_time = $this->input->get_post('r_time');
        }

        if (!is_null($this->input->get_post('r_timestamp'))) {
            $this->ReminderModel->r_timestamp = $this->input->get_post('r_timestamp');
        }

        $this->ReminderModel->create_date_time = current_date();

        $response = $this->ReminderModel->create_reminder();
        json_output($response['status'], $response);
    }

    function updateReminder() {
        if (!is_null($this->input->get_post('number_ref'))) {
            $this->ReminderModel->number_ref = $this->input->get_post('number_ref');
        }

        if (!is_null($this->input->get_post('user_ref'))) {
            $this->ReminderModel->user_ref = $this->input->get_post('user_ref');
            $this->ReminderModel->update_op_user = $this->input->get_post('user_ref');
        }

        if (!is_null($this->input->get_post('reminder_message'))) {
            $this->ReminderModel->reminder_message = $this->input->get_post('reminder_message');
        }

        if (!is_null($this->input->get_post('r_date'))) {
            $this->ReminderModel->r_date = $this->input->get_post('r_date');
        }

        if (!is_null($this->input->get_post('r_time'))) {
            $this->ReminderModel->r_time = $this->input->get_post('r_time');
        }

        if (!is_null($this->input->get_post('r_timestamp'))) {
            $this->ReminderModel->r_timestamp = $this->input->get_post('r_timestamp');
        }

        if (!is_null($this->input->get_post('mark_as_read'))) {
            $this->ReminderModel->mark_as_read = $this->input->get_post('mark_as_read');
        }

        if (!is_null($this->input->get_post('notify_status'))) {
            $this->ReminderModel->notify_status = $this->input->get_post('notify_status');
        }

        if (!is_null($this->input->get_post('notify_date_time'))) {
            $this->ReminderModel->notify_date_time = $this->input->get_post('notify_date_time');
        }

        if (!is_null($this->input->get_post('v_status'))) {
            $this->ReminderModel->v_status = $this->input->get_post('v_status');
        }

        if (!is_null($this->input->get_post('r_id'))) {
            $this->ReminderModel->id = $this->input->get_post('r_id');
        }

        $this->ReminderModel->update_date_time = current_date();

        $response = $this->ReminderModel->update_reminder($id);
        json_output($response['status'], $response);
    }

    function getReminder() {
        $response = $this->ReminderModel->get_all_reminder();
        json_output($response['status'], $response);
    }

    function getReminderByID($id) {
        $response = $this->ReminderModel->get_all_reminder($id);
        json_output($response['status'], $response);
    }

    function getReminderByUserID() {
        $id = $this->input->get_post('user_ref');
        $response = $this->ReminderModel->get_all_reminder($id);
        json_output($response['status'], $response);
    }

    function getReminderByUserIDandDate($id, $date) {
        $response = $this->ReminderModel->get_reminder_by_userid_and_date($id, $date);
        json_output($response['status'], $response);
    }

    function reminderReport() {
        $data['counter'] = $this->ReminderModel->getReportCounter();
        $data['reminder_list'] = $this->getReminderByDate();

        $data['page_title'] = "Reminder Report";
        $data['load_view'] = array('Report/all_reminder');
        $data['session'] = $this->getUserDetails();
        $this->load->view('dashboard', $data);
    }

    function getReminderByDate() {
        $where = array('v_status' => 1);
        return $this->ReminderModel->webRequestGetReminder($where);
    }

    function updateReminder1() {
        if (!is_null($this->input->get_post('number_ref'))) {
            $this->ReminderModel->number_ref = $this->input->get_post('number_ref');
        }

        if (!is_null($this->input->get_post('user_ref'))) {
            $this->ReminderModel->user_ref = $this->input->get_post('user_ref');
            $this->ReminderModel->update_op_user = $this->input->get_post('user_ref');
        }

        if (!is_null($this->input->get_post('reminder_message'))) {
            $this->ReminderModel->reminder_message = $this->input->get_post('reminder_message');
        }

        if (!is_null($this->input->get_post('r_date'))) {
            $this->ReminderModel->r_date = $this->input->get_post('r_date');
        }

        if (!is_null($this->input->get_post('r_time'))) {
            $this->ReminderModel->r_time = $this->input->get_post('r_time');
        }

        if (!is_null($this->input->get_post('r_timestamp'))) {
            $this->ReminderModel->r_timestamp = $this->input->get_post('r_timestamp');
        }

        if (!is_null($this->input->get_post('mark_as_read'))) {
            $this->ReminderModel->mark_as_read = $this->input->get_post('mark_as_read');
        }

        if (!is_null($this->input->get_post('notify_status'))) {
            $this->ReminderModel->notify_status = $this->input->get_post('notify_status');
        }

        if (!is_null($this->input->get_post('notify_date_time'))) {
            $this->ReminderModel->notify_date_time = $this->input->get_post('notify_date_time');
        }

        if (!is_null($this->input->get_post('v_status'))) {
            $this->ReminderModel->v_status = $this->input->get_post('v_status');
        }

        if (!is_null($this->input->get_post('r_id'))) {


            $this->ReminderModel->update_date_time = current_date();

            $response = $this->ReminderModel->update_reminder($this->input->get_post('r_id'));
            if ($response["data"]["status"] == 200) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 2;
        }
    }

    function reminder_form($id) {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'reminder_message',
                'label' => 'reminder_message',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide .',
                )
            ),
            array(
                'field' => 'r_date',
                'label' => 'r_date',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                )
            ),
            array(
                'field' => 'r_time',
                'label' => 'r_time',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide .',
                )
            ),
            array(
                'field' => 'mark_as_read',
                'label' => 'mark_as_read',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide .',
                )
            )
            ,
            array(
                'field' => 'notify_status',
                'label' => 'notify_status',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide .',
                )
            )
        );

        $response = $this->ReminderModel->get_reminder_by_id($id);
        $data['reminder_data'] = $response['data']['data'];
        $data['reminder_id'] = $id;
        $this->load->view("templet/header");

        if ($this->input->method() == "post") {

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                //echo validation_errors();
                $this->load->view("reminder_form");
            } else {
                if ($this->updateReminder1() == 1) {
                    redirect("reminder_list");
                } else {
                    redirect("reminder_list");
                }
            }
        }

        $this->load->view("reminder_form", $data);
        $this->load->view("templet/footer");
    }

    function reminderlist() {
        $this->load->view("templet/header");
        $this->load->model('UserModel');
        $response = $this->UserModel->getAllUser();
        $data['user_list'] = $response['result']['message'];

        if (!is_null($this->input->post_get('user_id'))) {
            $userid = $this->input->post_get('user_id');
            if ($userid > 0) {
                $where = array('tb_reminder.user_ref' => $userid, 'tb_reminder.v_status' => 1);
                $data['reminder_list'] = $this->ReminderModel->get_reminder_by_userid($where)["data"]["data"];
            } else {
                $where = array('tb_reminder.v_status' => 1);
                $data['reminder_list'] = $this->ReminderModel->get_reminder_by_userid($where)["data"]["data"];
            }
        } else {
            $data['reminder_list'] = $this->ReminderModel->get_all_reminder()["data"]["data"];
        }

        $this->load->view("reminder_list", $data);
        $this->load->view("templet/footer");
    }

}
