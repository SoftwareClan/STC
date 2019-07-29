<?php

/**
 * Description of FirmDashboardController
 *
 * @author narendra
 */
class FirmDashboardController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('FirmModel');
    }

}
