<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// login request
$route['request_to_login'] = "welcome/request_to_login";

// firm request
$route['firm'] = "FirmController";
$route['firm_changes'] = "FirmController/firm_changes";
$route['firm_list'] = "FirmController/firm_list";
$route['firm_by_id'] = "FirmController/firm_by_id";
$route['firm_delete_by'] = "FirmController/firm_delete_by";


// firm dashboard
$route['firm_dashboard'] = "FirmDashboardController";
