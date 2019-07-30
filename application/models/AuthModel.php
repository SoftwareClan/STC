<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthModel
 *
 * @author narendra
 */
class AuthModel extends CI_Model {

    private $client_service = "frontend-client";
    private $auth_key = "stchexaclan";

    /*
      | -------------------------------------------------------------------
      | Request To Authenticate client
      | -------------------------------------------------------------------

     */

    public function check_auth_client($client_service, $auth_key) {


        if ($client_service == $this->client_service && $auth_key == $this->auth_key) {
            return true;
        } else {
            return json_output(401, array('status' => 401, 'message' => 'auth_client not match '));
        }
    }

    /*
      | -------------------------------------------------------------------
      | Request to login
      | -------------------------------------------------------------------

     */

    public function login($uname, $upass) {


        try {
            $q = $this->db->where('username', $uname)->get('stc_firm')->result();

            if (count($q) != 1) {
                return array('status' => 401, 'message' => 'Username not found.');
            } else {
                $hashed_password = $q[0]->password;
                $id = $q[0]->id;

                if (hash_equals($hashed_password, crypt($upass, $hashed_password))) {

                    $last_login = date('Y-m-d H:i:s');
                    $token = crypt(substr(md5(rand()), 0, 7), 'stchexaclan');
                    $expired_at = date("Y-m-d H:i:s", strtotime('+6 hours'));
                    $this->db->trans_start();
                    $this->db->where('id', $id)->update('stc_firm', array('login_at' => $last_login, 'logstatus' => 1));
                    $this->db->insert('users_authentication', array('users_id' => $id, 'token' => $token, 'expired_at' => $expired_at, 'user_type' => 1));
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        return array('status' => 500, 'message' => 'Internal server error.');
                    } else {
                        $this->db->trans_commit();
                        return array('status' => 200, 'message' => 'Successfully login.', 'id' => $id, 'token' => $token);
                    }
                } else {
                    return array('status' => 401, 'message' => 'Wrong password.');
                }
            }
        } catch (Exception $e) {
            $this->show_error();
            return array('status' => 401, 'message' => 'db error');
        }
    }

    /*
      | -------------------------------------------------------------------
      | Request to login
      | -------------------------------------------------------------------

     */

    public function loginuser($uname, $upass) {

        try {
            $q = $this->db->where('u_number', $uname)->get('stc_users')->result();

            if (count($q) != 1) {
                return array('status' => 401, 'message' => 'Username not found.');
            } else {
                $hashed_password = $q[0]->mpin;
                $id = $q[0]->u_id;

                if (hash_equals($hashed_password, crypt($upass, $hashed_password))) {

                    $last_login = date('Y-m-d H:i:s');
                    $token = crypt(substr(md5(rand()), 0, 7), 'stchexaclan');
                    $expired_at = date("Y-m-d H:i:s", strtotime('+6 hours'));
                    $this->db->trans_start();
                    $this->db->where('u_id', $id)->update('stc_users', array('u_log_time' => $last_login));
                    $this->db->insert('users_authentication', array('users_id' => $id, 'token' => $token, 'expired_at' => $expired_at, 'user_type' => 2));
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        return array('status' => 500, 'message' => 'Internal server error.');
                    } else {
                        $this->db->trans_commit();
                        return array('status' => 200, 'message' => 'Successfully login.', 'id' => $id, 'token' => $token);
                    }
                } else {
                    return array('status' => 401, 'message' => 'Wrong password.');
                }
            }
        } catch (Exception $e) {
            $this->show_error();
            return array('status' => 401, 'message' => 'db error');
        }
    }

    /*
      | -------------------------------------------------------------------
      | Request to logout
      | -------------------------------------------------------------------

     */

    public function logout($users_id, $token) {
        $this->db->where('id', $users_id)->update('stc_firm', array('logstatus' => 0, 'logout_time' => date('Y-m-d H:i:s')));
        $this->db->where(array('users_id' => $users_id, 'user_type' => 1))->where('token', $token)->delete('users_authentication');
        return array('status' => 200, 'message' => 'Successfully logout.');
    }

    /*
      | -------------------------------------------------------------------
      | Request to logout
      | -------------------------------------------------------------------

     */

    public function logoutuser($users_id, $token) {
        $this->db->where('u_id', $users_id)->update('stc_users', array('log_status' => 0, 'logout_time' => date('Y-m-d H:i:s')));
        $this->db->where(array('users_id' => $users_id, 'user_type' => 2))->where('token', $token)->delete('users_authentication');
        return array('status' => 200, 'message' => 'Successfully logout.');
    }

    /*
      | -------------------------------------------------------------------
      | Request Authentication
      | -------------------------------------------------------------------

     */

    public function auth_token($users_id, $token, $user_type) {

        $q = $this->db->select('expired_at')->from('users_authentication')->where('users_id', $users_id)->where('token', $token)->get()->row();
        if ($q == "") {
            return json_output(401, array('status' => 401, 'message' => 'Unauthorized.'));
        } else {
            if ($q->expired_at < date('Y-m-d H:i:s')) {
                if ($user_type == "HQ") {
                    $this->logout($users_id, $token);
                } else if ($user_type == 'CA') {
                    $this->logoutuser($users_id, $token);
                }
                return json_output(401, array('status' => 401, 'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+6 hours'));
                $this->db->where('users_id', $users_id)->where('token', $token)->update('users_authentication', array('expired_at' => $expired_at, 'updated_at' => $updated_at));
                return array('status' => 200, 'message' => 'Authorized.');
            }
        }
    }

}
