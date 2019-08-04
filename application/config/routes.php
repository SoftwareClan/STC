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
$route['firm_dashboard'] = "FirmController";


// user
$route['user_dashboard'] = "UserController";
$route["user"] = "UserController/user";
$route['user_changes'] = "UserController/user_changes";
$route['user_list'] = "UserController/user_list";
$route['user_by_id'] = "UserController/user_by_id";
$route['user_delete_by'] = "UserController/user_delete_by";
$route['user_options'] = "UserController/user_options";

$route["target"] = "targetController";
$route["target/manuallay"] = "targetController/manullay_create";
$route["target/list_by_type"] = "targetController/get_TargetList_By_type";
$route["target/by_id"] = "targetController/target_by_id";
$route["target/delete_by"] = "targetController/target_delete";
$route["assignTarget"] = "targetController/assignTo";
$route["target/import_target"] = "targetController/import";


$route["user_target_report"] = "CallController/getAllUserReport";
$route["ind_user_target_report"] = "targetController/target_by_u_id";
$route["target_report"] = "CallController/users_target_panel";
$route["track_call_log"] = "CallController/callLogs_by_traget_ref";
$route["reminder_report"] = "ReminderController/reminderReport";



$route["app_request"] = "AppController";
