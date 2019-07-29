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
            if (isset($this->session->auth)) {
                $auth_array = $this->session->auth;
                $token = $auth_array["token"];
                $auth_client = $auth_array["auth_client"];
                $client_service = $auth_array["client_service"];
                $auth_key = $auth_array["auth_key"];
                $user_type = $auth_array["user_type"];
                if ($user_type == "super_admin") {
                    return true;
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
                if (!is_null(base64_decode($this->input->post_get('token'))) && !is_null(base64_decode($this->input->post_get('user_key'))) && !is_null(base64_decode($this->input->post_get('auth_client'))) && !is_null(base64_decode($this->input->post_get('client_service'))) && !is_null(base64_decode($this->input->post_get('auth_key')))) {
                    $token = base64_decode($this->input->post_get("token"));
                    $auth_client = base64_decode($this->input->post_get("auth_client"));
                    $client_service = ($this->input->post_get("client_service"));
                    $auth_key = base64_decode($this->input->post_get("auth_key"));
                    $user_type = base64_decode($this->input->post_get("user_key"));
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
//                    json_output(401, 'bad request from auth');
                    return false;
                }
            }
        }
    }

    public function token_auth($auth_client, $token, $usertype) {
        if ($auth_client != null && $token != null) {
            $response = $this->AuthModel->auth_token($auth_client, $token, $usertype);
            if ($response['status'] == 200) {
                return true;
            }
        } else {
            return false;
//            json_output(401, 'bad request token_auth');
        }
    }

    public function login_user($username, $password) {
        return $this->AuthModel->loginuser($username, $password);
    }

    public function login_firm($username, $password) {
        return $this->AuthModel->login($username, $password);
    }

    public function request_auth($client_service, $auth_key) {


        if ($client_service != null && $auth_key != null) {
            $check_auth_client = $this->AuthModel->check_auth_client($client_service, $auth_key);
            if ($check_auth_client != true) {
                die($this->output->get_output());
            } else {
                return true;
            }
        } else {
            return false;
            //json_output(401, array("status" => 401, "message" => array($client_service, $auth_key)));
        }
    }

}
