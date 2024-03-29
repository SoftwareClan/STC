<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('login');
    }

    public function request_to_login() {
        $client_service = $this->input->post_get("client_service");
        $auth_key = $this->input->post_get("auth_key");

        if ($this->request_auth($client_service, $auth_key)) {

            if (!is_null($this->input->post_get('username')) && !is_null($this->input->post_get('password'))) {
                $username = $this->input->post_get('username');
                $password = $this->input->post_get('password');
                if ($username == "admin" && $password == "admin123") {
                    $token = crypt(substr(md5(rand()), 0, 7), 'stchexaclan');
                    $auth_array["token"] = $token;
                    $auth_array["auth_client"] = 'super_admin';
                    $auth_array["client_service"] = "frontend-client";
                    $auth_array["auth_key"] = "stchexaclan";
                    $auth_array["user_type"] = "SA";
                    $this->session->set_userdata("auth", $auth_array);
                } else {
                    if (!is_null($this->input->post_get('user_type'))) {
                        if ($this->input->post_get('user_type') == "HQ") {

                            $response = $this->login_firm($username, $password);

                            if ($response['status'] == 200) {
                                $auth_array["token"] = $response["token"];
                                $auth_array["auth_client"] = $response["id"];
                                $auth_array["client_service"] = "frontend-client";
                                $auth_array["auth_key"] = "stchexaclan";
                                $auth_array["user_type"] = "HQ";
                                $this->session->set_userdata("auth", $auth_array);
                                json_output($response["status"], "firm");
                            } else {
                                json_output($response["status"], $response["message"]);
                            }
                        } else {
                            $response = $this->login_user($username, $password);
                            if ($response['status'] == 200) {
                                $auth_array["token"] = $response["token"];
                                $auth_array["auth_client"] = $response["id"];
                                $auth_array["client_service"] = "frontend-client";
                                $auth_array["auth_key"] = "stchexaclan";
                                $auth_array["user_type"] = "CA";
                                json_output($response["status"], $auth_array);
                            } else {
                                json_output($response["status"], $response["message"]);
                            }
                        }
                    } else {
                        echo json_output(401, "Invalid Username and Password");
                    }
                }
            }
        }
    }

}
