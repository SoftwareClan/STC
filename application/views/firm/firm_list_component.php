<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon" data-toggle="modal" data-target="#firmModel" data-update_value="0">
                    <i class="material-icons">person_add</i>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="firm_list_table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>No of Users</th>
                            <th>Login Status</th>
                            <th>Login at</th>
                            <th>Logout at</th>
                            <th>Create at</th>
                            <th>Update at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="firm_list_tbody">

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

    var url = "<?= base_url("firm_list") ?>";
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

        load_table(url, data, 'firm_list_tbody', 'firm_list_table');
        /**
         *
         * @param {type} id
         * @returns {undefined}
         */
        $('#firmModel').on('show.bs.modal', function (e) {
            var update_value = $(e.relatedTarget).data('update_value');
            if (update_value !== 0) {
                $('<input>').attr({
                    type: 'hidden',
                    id: 'update_value',
                    name: 'update_value',
                    value: update_value
                }).appendTo('#firm_create_form');
                get_firm_by_id(update_value);
            }

        });
        $('#firmModel').on('hide.bs.modal', function (e) {
            $("#user_id").remove();
            $("#firm_create_form").trigger("reset");

        });

    });

    function firm_delete_by(value) {
        var url = "<?= base_url("firm_delete_by") ?>";
        var data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "auth_client": auth_client,
            "id": value
        }

        var response = getAjax(url, data);
        response.done(function (success) {
            showNotification('top', 'right', 'add_alert', success["message"], 'success');
            var url_list = "<?= base_url("firm_list") ?>";
            var data = {
                "client_service": "frontend-client",
                "auth_key": "stchexaclan",
                "token": token,
                "user_type": user_type,
                "user_key": user_key,
                "auth_client": auth_client
            }
            load_table(url, data, 'firm_list_tbody', 'firm_list_table');
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }

    function get_firm_by_id(id) {
        var url = "<?= base_url("firm_by_id") ?>";
        var data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "auth_client": auth_client,
            "id": id
        }
        var response = getAjax(url, data);
        response.done(function (object) {
            $("input[name='name']").val(object['name']);
            $("input[name='contact']").val(object['contact']);
            $("input[name='username']").val(object['username']);
            $("input[name='address']").val(object['address']);
            $("input[name='password']").val(object['password']);
            $("input[name='email']").val(object['email']);
            $("input[name='no_of_users']").val(object['no_of_users']);
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }


</script>