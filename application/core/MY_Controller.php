<?php

/**
 * Description of My_controller
 *
 * @author narendra
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AuthModel');
    }

    public function auth() {
        if (uri_string() == "login") {
            return;
        } else {
            if (!is_null($this->input->post_get('token')) && !is_null($this->input->post_get('user_key')) && !is_null($this->input->post_get('user_type')) && !is_null($this->input->post_get('auth_client')) && !is_null($this->input->post_get('client_service')) && !is_null($this->input->post_get('auth_key'))) {
                $token = $this->input->post_get("token");
                $auth_client = $this->input->post_get("auth_client");
                $client_service = $this->input->post_get("client_service");
                $auth_key = $this->input->post_get("auth_key");
                $user_key = $this->input->post_get("user_key");
                $user_type = $this->input->post_get("user_type");
                if ($user_type == "super_admin") {
                    return;
                } else {
                    if ($this->request_auth($client_service, $auth_key)) {
                        if ($this->token_auth($auth_client, $token, $user_type)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                json_output(401, 'bad request from auth');
            }
        }
    }

    public function getUserDetails() {
        if (isset($this->session->auth)) {
            $auth_array = $this->session->auth;
            $user['token'] = $auth_array["token"];
            $user['auth_client'] = $auth_array["auth_client"];
            $user['client_service'] = $auth_array["client_service"];
            $user['auth_key'] = $auth_array["auth_key"];
            $user['user_type'] = $auth_array["user_type"];
            $this->load->model('FirmModel');
            $result = $this->FirmModel->get_query(array('id' => $auth_array["auth_client"], "status" => 1));
            if (count($result) > 0) {
                $user["name"] = $result[0]->name;
                $user["username"] = $result[0]->username;
                $user["contact"] = $result[0]->contact;
                $user["email"] = $result[0]->email;
                $user["no_of_users"] = $result[0]->no_of_users;
            }
            return $user;
        } else {
            return false;
        }
    }

    public function token_auth($auth_client, $token, $usertype) {
        if ($auth_client != null && $token != null) {
            $response = $this->AuthModel->auth_token($auth_client, $token, $usertype);
            if ($response['status'] == 200) {
                return true;
            }
        } else {
            json_output(401, 'bad request token_auth');
        }
    }

    public function login_user($username, $password) {
        return $this->AuthModel->loginuser($username, $password);
    }

    public function login_firm($username, $password) {
        return $this->AuthModel->login($username, $password);
    }

    public function request_auth($client_service, $auth_key) {
        $check_auth_client = $this->AuthModel->check_auth_client($client_service, $auth_key);
        if ($check_auth_client != true) {
            die($this->output->get_output());
        } else {
            return true;
        }
    }

}
