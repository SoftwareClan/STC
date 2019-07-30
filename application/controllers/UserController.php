<?php

/**
 * Description of FirmDashboardController
 *
 * @author narendra
 */
class UserController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function index() {
//        $data['page_title'] = "User";
//        $data['load_view'] = array('users/user_list_component', 'users/user_form_component');
//        $data['session'] = $this->getUserDetails();
//        $this->load->view('dashboard', $data);
    }

    public function user() {
        $data['page_title'] = "User";
        $data['load_view'] = array('users/user_list_component', 'users/user_form_component');
        $data['session'] = $this->getUserDetails();
        $this->load->view('dashboard', $data);
    }

    public function user_changes() {
        if ($this->auth()) {
            $this->getinstance();

            if ($this->UserModel->u_id == 0) {
                $this->UserModel->status = 1;
                $this->UserModel->create_time = current_date();
                $this->UserModel->log_status = 0;
                $session = $this->getUserDetails();
                $this->UserModel->u_firm_id = $session["auth_client"];
                if ($this->UserModel->insert_query()) {
                    $response["message"] = "New User Create";
                    echo json_output(200, $response);
                } else {
                    $response["message"] = "Something went Wrong";
                    echo json_output(401, $response);
                }
            } else {
                $session = $this->getUserDetails();
                $this->UserModel->u_firm_id = $session["auth_client"];
                $this->UserModel->update_time = current_date();
                if ($this->UserModel->update_query(array('status' => 1, 'u_id' => $this->UserModel->u_id, 'u_firm_id' => $session["auth_client"]))) {
                    $response["message"] = "New User Update" . $this->db->last_query();
                    echo json_output(200, $response);
                } else {
                    $response["message"] = "Something went Wrong";
                    echo json_output(401, $response);
                }
            }
        }
    }

    public function user_list() {
        if ($this->auth()) {
            $session = $this->getUserDetails();
            $result = $this->UserModel->get_query(array('status' => 1, 'u_firm_id' => $session["auth_client"]));

            $rows = "";
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $log_status = $row->log_status == 1 ? "online" : "offline";
                    $rows .= "<tr>"
                            . "<td>" . $row->u_name . "</td>"
                            . "<td>" . $row->u_number . "</td>"
                            . "<td>" . $log_status . "</td>"
                            . "<td>" . timeago($row->u_log_time) . "</td>"
                            . "<td>" . timeago($row->create_time) . "</td>"
                            . "<td>" . timeago($row->update_time) . "</td>"
                            . '<td class="td-actions">
                           <button type="button" rel="tooltip" class="btn btn-info btn-simple" data-toggle="modal" data-target="#userModel" data-update_value="' . $row->u_id . '">
                                <i class="material-icons">edit</i>
                           </button>
                           <button type="button" rel="tooltip" class="btn btn-danger btn-simple" onclick="user_delete_by(' . $row->u_id . ')">
                                <i class="material-icons">close</i>
                            </button>
                            </td>' .
                            "</tr>";
                }
            }
            $data_row["data_table"] = $rows;
            echo json_output(200, $data_row);
        }
    }

    public function user_options() {
        if ($this->auth()) {
            $result = $this->UserModel->get_query(array('status' => 1));

            $rows = "<option selected disabled>Select User</option>";
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $rows .= "<option value='" . $row->u_id . "'>"
                            . $row->u_name . "</option>";
                }
            }
            $data_row["data_table"] = $rows;
            echo json_output(200, $data_row);
        }
    }

    public function user_by_id() {


        if ($this->auth()) {

            $this->getinstance();
            $result = $this->UserModel->get_query(array('status' => 1, 'u_id' => $this->UserModel->u_id));
            if (count($result) > 0) {
                $data['firm'] = $result[0];
                echo json_output(200, $result[0]);
            } else {
                $data['firm'] = "No User";
                echo json_output(401, $data);
            }
        }
    }

    public function user_delete_by() {
        if ($this->auth()) {


            $this->getinstance();
            $this->UserModel->status = 0;
            $this->UserModel->update_time = current_date();
            if ($this->UserModel->update_query(array('status' => 1, 'u_id' => $this->UserModel->u_id))) {
                $response["message"] = "User Delete";
                echo json_output(200, $response);
            } else {
                $response["message"] = "Something went Wrong";
                echo json_output(401, $response);
            }
        }
    }

    public function getinstance() {

        if (!is_null($this->input->post_get("update_value"))) {
            $this->UserModel->u_id = $this->input->post_get("update_value");
        } else {
            $this->UserModel->u_id = 0;
        }

        if (!is_null($this->input->post_get("id"))) {
            $this->UserModel->u_id = $this->input->post_get("id");
        }

        if (!is_null($this->input->post_get("user_name"))) {
            $this->UserModel->u_name = $this->input->post_get("user_name");
        }

        if (!is_null($this->input->post_get("user_number"))) {
            $this->UserModel->u_number = $this->input->post_get("user_number");
        }

        if (!is_null($this->input->post_get("user_pass"))) {
            $this->UserModel->mpin = crypt($this->input->post_get("user_pass"), 'stchexaclan');
        }
    }

}
