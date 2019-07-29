<?php

/**
 *
 * @author narendra
 */
defined('BASEPATH') OR exit('No direct script access allowed');

interface STC_Model {

    public function insert_query();

    public function update_query($where);

    public function get_query($where);
}
