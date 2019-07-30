<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon" data-toggle="modal" data-target="#userModel" data-update_value="0">
                    <i class="material-icons">person_add</i>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="userTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Log Status</th>
                            <th>login On</th>
                            <th>crate On</th>
                            <th>Update On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="user_table_body">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<?php
if (isset($this->session->auth)) {
    $session_data = $this->session->auth;
    $user_type = $session_data['user_type'];
    $user_key = $session_data["auth_client"];
    $token = $session_data['token'];
    $auth_client = $session_data['auth_client'];
}
?>


<script>

    var url = "<?= base_url("user_list") ?>";
    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>'
    $(document).ready(function () {
        var data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "auth_client": auth_client
        }

        load_table(url, data, 'user_table_body', 'userTable');

        /**
         *
         * @param {type} id
         * @returns {undefined}
         */
        $('#userModel').on('show.bs.modal', function (e) {
            var update_value = $(e.relatedTarget).data('update_value');
            if (update_value !== 0) {
                $('<input>').attr({
                    type: 'hidden',
                    id: 'update_value',
                    name: 'update_value',
                    value: update_value
                }).appendTo('#user_create_form');
                get_user_by_id(update_value);
            }

        });
        $('#userModel').on('hide.bs.modal', function (e) {
            $("#update_value").remove();
            $("#user_create_form").trigger("reset");

        });

    });

    function user_delete_by(value) {
        var url = "<?= base_url("user_delete_by") ?>";
        var data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "auth_client": auth_client,
            "id": value
        };

        var response = getAjax(url, data);
        response.done(function (success) {
            showNotification('top', 'right', 'add_alert', success["message"], 'success');
            var url_list = "<?= base_url("user_list") ?>";
            var data = {
                "client_service": "frontend-client",
                "auth_key": "stchexaclan",
                "token": token,
                "user_type": user_type,
                "user_key": user_key,
                "auth_client": auth_client
            };
            load_table(url_list, data, 'user_table_body', 'userTable');
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }

    function get_user_by_id(id) {
        var url = "<?= base_url("user_by_id") ?>";
        var data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "auth_client": auth_client,
            "id": id
        };
        var response = getAjax(url, data);
        response.done(function (object) {
            $("input[name='user_name']").val(object['u_name']);
            $("input[name='user_number']").val(object['u_number']);
            $("input[name='user_pass']").val(object['username']);
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }


</script>