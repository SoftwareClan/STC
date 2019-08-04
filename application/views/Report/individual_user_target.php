<div class="modal fade" id="ind_user_target_Model" tabindex="-1" role="dialog" aria-labelledby="ind_user_target_ModelLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">User Target List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="ind_user_report_list_table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Source</th>
                                        <th>Status</th>
                                        <th>Assign at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ind_user_report_list_tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
<?php
if (isset($this->session->auth)) {
    $session_data = $this->session->auth;
    $user_type = $session_data['user_type'];
    $user_key = $session_data["auth_client"];
    $token = $session_data['token'];
    $auth_client = $session_data['auth_client'];
}
?>


    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>';

    $(document).ready(function () {

//        user_value
        $('#ind_user_target_Model').on('show.bs.modal', function (e) {
            var update_value = $(e.relatedTarget).data('user_value');
            if (update_value !== 0) {
                var url = "<?= base_url("ind_user_target_report") ?>";
                var data = {
                    "client_service": "frontend-client",
                    "auth_key": "stchexaclan",
                    "token": token,
                    "user_type": user_type,
                    "user_key": user_key,
                    "auth_client": auth_client,
                    "user_ref": update_value
                };

                load_table(url, data, 'ind_user_report_list_tbody', 'ind_user_report_list_table');
            }

        });

    });


</script>