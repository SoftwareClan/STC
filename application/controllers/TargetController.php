<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TargetController
 *
 * @author narendra
 */
class TargetController extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('CenterModel');
        $this->load->model('UserModel');

        $this->load->library('excel');
    }

    public function index() {
        $data['page_title'] = "Target";
        $data['load_view'] = array('target/target_list_component', 'target/user_assign_component', 'target/target_file_import', 'target/target_manually_form',);
        $data['session'] = $this->getUserDetails();
        $this->load->view('dashboard', $data);
    }

    public function manullay_create() {
        if ($this->auth()) {
            if (!is_null($this->input->post_get('up_name')) && !is_null($this->input->post_get('up_number')) && !is_null($this->input->post_get('up_source'))) {

                if (!is_null($this->input->post_get('update_value'))) {
                    $record = array(
                        array('name' => $this->input->post_get('up_name'),
                            'number' => $this->input->post_get('up_number'),
                            'source' => $this->input->post_get('up_source'),
                            'update_datetime' => current_date())
                    );
                    $where = array('c_id' => $this->input->post_get('update_value'), 'status' => 1);
                    if ($this->CenterModel->updateCenterRecord($record, $where)) {
                        json_output(200, array("message" => "Success To Update"));
                    } else {
                        json_output(401, array("message" => "Failed To Update"));
                    }
                } else {
                    $record = array(
                        array('file_ref' => 0,
                            'record_type' => 2,
                            'name' => $this->input->post_get('up_name'),
                            'number' => $this->input->post_get('up_number'),
                            'source' => $this->input->post_get('up_source'),
                            'create_datetime' => current_date())
                    );
                    if ($this->CenterModel->addCenterRecord($record)) {
                        json_output(200, array("message" => "Success To Created"));
                    } else {
                        json_output(401, array("message" => "Failed To Create"));
                    }
                }
            }
        }
    }

    function target_delete() {
        if ($this->auth()) {
            if (!is_null($this->input->post_get('id'))) {
                $record = array(
                    array('status' => 0, 'update_datetime' => current_date())
                );
                $where = array('c_id' => $this->input->post_get('id'), 'status' => 1);
                if ($this->CenterModel->updateCenterRecord($record, $where)) {
                    json_output(200, array("message" => "Success To Delete"));
                } else {
                    json_output(401, array("message" => "Failed To Delete"));
                }
            } else {
                json_output(401, array("message" => "invalid value"));
            }
        } else {
            json_output(401, array("message" => "Auth Faild"));
        }
    }

    function get_TargetList_By_type() {
        $data = array();
        if (is_null($this->input->post_get('type'))) {
            json_output(401, array("message" => "invalid parameter"));
        } else {
            $type = $this->input->post_get('type');
            switch ($type) {
                // not assign
                case 1:
                    $response = $this->CenterModel->getCallCenter(array('user_ref' => 0, 'call_center.status' => 1));
                    $data["data_table"] = $this->create_table_row($response["result"]["message"]);
                    break;
                // assign but not complete it was reassignable
                case 2:
                    $response = $this->CenterModel->getCallCenter(array('complete_status <' => 3, 'call_center.status' => 1));
                    $data["data_table"] = $this->create_table_row($response["result"]["message"]);
                    break;
            }
        }
        json_output(200, $data);
    }

    function create_table_row($data) {
        $rows = "";
        if (count($data) > 0) {
            foreach ($data as $row) {
                $log_status = $row->record_type == 1 ? "import" : "manually";
                if ($row->complete_status == "0") {
                    $status = "Pending";
                } else if ($row->complete_status == "1") {
                    $status = "Processing";
                } else {
                    $status = "Completed";
                }
                $rows .= "<tr>"
                        . "<th><input type='checkbox' name='checkboxlist' value=" . $row->c_id . " /></th>"
                        . "<td>" . $row->name . "</td>"
                        . "<td>" . $row->number . "</td>"
                        . "<td>" . $row->source . "</td>"
                        . "<td>" . $log_status . "</td>"
                        . "<td>" . $row->uname . "</td>"
                        . "<td>" . $status . "</td>"
                        . "<td>" . timeago($row->assign_date) . "</td>"
                        . "<td>" . timeago($row->create_datetime) . "</td>"
                        . "<td>" . timeago($row->update_datetime) . "</td>"
                        . '<td class="td-actions">
                           <button type="button" rel="tooltip" class="btn btn-info btn-simple" data-toggle="modal" data-target="#targetManuallyModel" data-update_value="' . $row->c_id . '">
                                <i class="material-icons">edit</i>
                           </button>
                           <button type="button" rel="tooltip" class="btn btn-danger btn-simple" onclick="target_delete_by(' . $row->c_id . ')">
                                <i class="material-icons">close</i>
                            </button>
                            </td>' .
                        "</tr>";
            }
        }
        return $rows;
    }

    function target_by_id() {
        if ($this->auth()) {
            if (!is_null($this->input->post_get("id"))) {
                $where = array("call_center.c_id" => $this->input->post_get("id"), "call_center.status" => 1);
                $result = $this->CenterModel->getCallCenter($where);
                if (count($result["result"]["message"]) > 0) {
                    json_output(200, $result["result"]["message"]);
                } else {
                    return 0;
                }
            } else {
                json_output(401, array("message" => "invalid parameter"));
            }
        } else {
            json_output(401, array("message" => "auth error"));
        }
    }

    function target_by_u_id() {
        if ($this->auth()) {
            if (!is_null($this->input->post_get("user_ref"))) {
                $where = array("call_center.user_ref" => $this->input->post_get("user_ref"), "call_center.status" => 1);
                $result = $this->CenterModel->getCallCenter($where);
                $resultData = $result["result"]["message"];
                $rows = "";
                if (count($resultData) > 0) {
                    foreach ($resultData as $row) {
                        $status = "";
                        switch ($row->complete_status) {
                            case 1:$status = "Busy";
                                break;
                            case 2:$status = "Switch_off";
                                break;
                            case 3:$status = "Not_Received";
                                break;
                            case 4:$status = "wrong_number";
                                break;
                            case 5:$status = "Call_back";
                                break;
                            case 6:$status = "Intrested";
                                break;
                            case 7:$status = "Not_Intrested";
                                break;
                            default:
                                break;
                        }
                        $rows .= "<tr>"
                                . "<td>" . $row->name . "</td>"
                                . "<td>" . $row->number . "</td>"
                                . "<td>" . $row->source . "</td>"
                                . "<td>" . $status . "</td>"
                                . "<td>" . $row->assign_date . "</td>"
                                . '<td class="td-actions">
                           <button type="button" rel="tooltip" class="btn btn-info btn-simple" data-toggle="modal" data-target="#call_tracker_Model" data-target_value="' . $row->c_id . '">
                                <i class="material-icons">view_module</i>
                           </button>
                            </td>' .
                                "</tr>";
                    }
                    $data_row["data_table"] = $rows;
                    echo json_output(200, $data_row);
                } else {
                    return 0;
                }
            } else {
                json_output(401, array("message" => "invalid parameter"));
            }
        } else {
            json_output(401, array("message" => "auth error"));
        }
    }

    function import() {
        if ($this->input->method() == "post") {
            if (isset($_FILES["userfile"]["name"]) && !is_null($this->input->post_get('filename'))) {
                $path = $_FILES["userfile"]["tmp_name"];
                $new_name = time() . $_FILES["userfile"]['name'];
                $result = $this->uploadFile($new_name);

                if ($result) {
                    $data = array();
                    $ref_id = $this->CenterModel->addFile($this->input->post_get('filename'), "uploads/" . $new_name);
                    if ($ref_id > 0) {
                        $object = PHPExcel_IOFactory::load($path);
                        foreach ($object->getWorksheetIterator() as $worksheet) {
                            $highestRow = $worksheet->getHighestRow();
                            $highestColumn = $worksheet->getHighestColumn();
                            for ($row = 2; $row <= $highestRow; $row++) {
                                $columnName = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                                $columnNumber = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                $columnSource = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                                $item = array(
                                    'file_ref' => $ref_id,
                                    'record_type' => 1,
                                    'name' => $columnName,
                                    'number' => $columnNumber,
                                    'source' => $columnSource,
                                    'create_datetime' => current_date()
                                );
                                array_push($data, $item);
                            }
                        }
                    } else {
                        echo 'faild to add file' . $result;
                    }
                    if (count($data) > 0) {
                        $affected_row = $this->CenterModel->addCenterRecord($data);
                        if ($affected_row) {
                            json_output(200, array("Total_Record" => "Upload Successfully", "file_ref" => $ref_id));
                        } else {
                            json_output(401, array("Total_Record" => "Faild To Upload", "file_ref" => 0));
                        }
                    } else {
                        json_output(401, array("Total_Record" => 'Faild To Upload Data.', "file_ref" => 0));
                    }
                } else {
                    json_output(401, array("Total_Record" => 'Server Error While File Uploading', "file_ref" => 0));
                }
            } else {
                json_output(401, array("Total_Record" => 'File Not Selected', "file_ref" => 0));
            }
        } else {
            json_output(401, array("Total_Record" => 'Aunthoried Request', "file_ref" => 0));
        }
    }

    public function uploadFile($new_name) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['file_name'] = $new_name;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            return $this->upload->display_errors();
        } else {
            return true;
        }
    }

    function assignTo() {
        if ($this->auth()) {
            if (!is_null($this->input->post_get('ids')) && !is_null($this->input->post_get('u_id'))) {
                $target_list = $this->input->post_get('ids');

                $user_id = $this->input->post_get('u_id');

                $count = 0;
                foreach ($target_list as $items) {
                    $record = array(
                        array(
                            'user_ref' => $user_id,
                            'assign_date' => current_date())
                    );
                    $where = array('c_id' => $items, 'status' => 1);
                    if ($this->CenterModel->updateCenterRecord($record, $where)) {
                        $count++;
                    }
                }
                if ($count == count($target_list)) {
                    json_output(200, array("message" => "Success To Assign"));
                } else {
                    json_output(401, array("message" => "Failed To Assign"));
                }
            }
        }
    }

}
