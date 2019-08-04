<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon">
                    User Report<i class="material-icons">report</i>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="user_report_list_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Target Assign</th>
                            <th>Busy</th>
                            <th>Switch off</th>
                            <th>Not Received</th>
                            <th>Wrong number</th>
                            <th>Call back</th>
                            <th>Interested</th>
                            <th>Not Interested</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="user_report_list_tbody">

                    </tbody>
                </table>

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

    var url = "<?= base_url("user_target_report") ?>";
    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>';

    $(document).ready(function () {


        var data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "auth_client": auth_client
        };

        load_table(url, data, 'user_report_list_tbody', 'user_report_list_table');

    });


</script>