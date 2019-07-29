<?php

/**
 * Description of FirmController
 *
 * @author narendra
 */
class FirmController extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('FirmModel');
    }

    public function index() {
        $data['page_title'] = "Firm";
        $data['load_view'] = array('firm/firm_list_component', 'firm/firm_form_component');
        $this->load->view('dashboard', $data);
    }

    public function firm_changes() {
        if (!$this->auth()) {
            redirect('welcome');
        } else {
            $this->getinstance();

            if ($this->FirmModel->id == 0) {
                $this->FirmModel->status = 1;
                $this->FirmModel->create_at = current_date();
                $this->FirmModel->logstatus = 0;
                if ($this->FirmModel->insert_query()) {
                    $response["message"] = "New Firm Create";
                    echo json_output(200, $response);
                } else {
                    $response["message"] = "Something went Wrong";
                    echo json_output(401, $response);
                }
            } else {
                $this->FirmModel->update_at = current_date();
                if ($this->FirmModel->update_query(array('status' => 1, 'id' => $this->FirmModel->id))) {
                    $response["message"] = "New Firm Update";
                    echo json_output(200, $response);
                } else {
                    $response["message"] = "Something went Wrong";
                    echo json_output(401, $response);
                }
            }
        }
    }

    public function firm_list() {
        if (!$this->auth()) {
            //redirect('welcome');
            echo "firm lsit";
        } else {
            $result = $this->FirmModel->get_query(array('status' => 1));

            $rows = "";
            if (count($result) > 0) {
                foreach ($result as $row) {
                    $log_status = $row->logstatus == 1 ? "online" : "offline";
                    $rows .= "<tr>"
                            . "<td>" . $row->name . "</td>"
                            . "<td>" . $row->contact . "</td>"
                            . "<td>" . $row->email . "</td>"
                            . "<td>" . $row->address . "</td>"
                            . "<td>" . $row->username . "</td>"
                            . "<td>" . $row->no_of_users . "</td>"
                            . "<td>" . $log_status . "</td>"
                            . "<td>" . $row->login_at . "</td>"
                            . "<td>" . $row->logout_at . "</td>"
                            . "<td>" . timeago($row->create_at) . "</td>"
                            . "<td>" . timeago($row->update_at) . "</td>"
                            . '<td class="td-actions">
                           <button type="button" rel="tooltip" class="btn btn-info btn-simple" data-toggle="modal" data-target="#firmModel" data-update_value="' . base64_encode($row->id) . '">
                                <i class="material-icons">edit</i>
                           </button>
                           <button type="button" rel="tooltip" class="btn btn-danger btn-simple" onclick="firm_delete_by(' . $row->id . ')">
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

    public function firm_by_id() {
        if (!$this->auth()) {
            redirect('welcome');
        } else {
            $this->getinstance();
            $result = $this->FirmModel->get_query(array('status' => 1, 'id' => $this->FirmModel->id));
            if (count($result) > 0) {
                $data['firm'] = $result[0];
                echo json_output(200, $result[0]);
            } else {
                $data['firm'] = "No Firm";
                echo json_output(401, $data);
            }
        }
    }

    public function firm_delete_by() {
        if (!$this->auth()) {
            redirect('welcome');
        } else {
            $this->getinstance();
            $this->FirmModel->status = 0;
            $this->FirmModel->update_at = current_date();
            if ($this->FirmModel->update_query(array('status' => 1, 'id' => $this->FirmModel->id))) {
                $response["message"] = "Firm Delete";
                echo json_output(200, $response);
            } else {
                $response["message"] = "Something went Wrong";
                echo json_output(401, $response);
            }
        }
    }

    public function getinstance() {

        if (!is_null($this->input->post_get("update_value"))) {
            $this->FirmModel->id = base64_decode($this->input->post_get("update_value"));
        } else {
            $this->FirmModel->id = 0;
        }

        if (!is_null($this->input->post_get("id"))) {
            $this->FirmModel->id = base64_decode($this->input->post_get("id"));
        }

        if (!is_null($this->input->post_get("name"))) {
            $this->FirmModel->name = base64_decode($this->input->post_get("name"));
        }

        if (!is_null($this->input->post_get("contact"))) {
            $this->FirmModel->contact = base64_decode($this->input->post_get("contact"));
        }

        if (!is_null($this->input->post_get("email"))) {
            $this->FirmModel->email = base64_decode($this->input->post_get("email"));
        }

        if (!is_null($this->input->post_get("address"))) {
            $this->FirmModel->address = base64_decode($this->input->post_get("address"));
        }

        if (!is_null($this->input->post_get("username"))) {
            $this->FirmModel->username = base64_decode($this->input->post_get("username"));
        }

        if (!is_null($this->input->post_get("password"))) {
            $this->FirmModel->password = crypt(base64_decode($this->input->post_get("password")), 'stchexaclan');
        }

        if (!is_null($this->input->post_get("no_of_users"))) {
            $this->FirmModel->no_of_users = base64_decode($this->input->post_get("no_of_users"));
        }
    }

}
