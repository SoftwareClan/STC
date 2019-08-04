<div class="modal fade" id="call_tracker_Model" tabindex="-1" role="dialog" aria-labelledby="call_tracker_ModelLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">User Target List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table" id="call_tracker_list_table">
                                <thead>
                                    <tr>
                                        <th>Call Type</th>
                                        <th>Call Duration(sec)</th>
                                        <th>Call at</th>
                                        <th>Status</th>
                                        <th>Note</th>
                                        <th>Create at</th>
                                    </tr>
                                </thead>
                                <tbody id="call_tracker_list_tbody">

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
        $('#call_tracker_Model').on('show.bs.modal', function (e) {
            var update_value = $(e.relatedTarget).data('target_value');
            if (update_value !== 0) {
                var url = "<?= base_url("track_call_log") ?>";
                var data = {
                    "client_service": "frontend-client",
                    "auth_key": "stchexaclan",
                    "token": token,
                    "user_type": user_type,
                    "user_key": user_key,
                    "auth_client": auth_client,
                    "target_ref": update_value
                };

                load_table(url, data, 'call_tracker_list_tbody', 'call_tracker_list_table');
            }

        });

    });


</script>