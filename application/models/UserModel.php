<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModel
 *
 * @author narendra
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'STC_Model.php';

class UserModel extends CI_Model implements STC_Model {

    public function get_query($where) {
        return $this->db->where($where)->get('stc_users')->result();
    }

    public function insert_query() {
        $this->db->trans_start();
        $this->db->insert('stc_users', $this);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        $this->db->trans_complete();
    }

    public function update_query($where) {
        $this->db->trans_start();
        $this->db->set($this)->where($where)->update('stc_users');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        $this->db->trans_complete();
    }

}
