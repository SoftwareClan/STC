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
    $token = $session_data['token'];
    $auth_client = $session_data['auth_client'];
}
?>

    var url = "<?= base_url() ?>firm_list";
    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';


    $(document).ready(function () {


        var data = {
            "client_service": encypt("frontend-client"),
            "auth_key": encypt("auth_client"),
            "token": token,
            "user_type": user_type,
            "auth_client": auth_client
        }
        load_table(url, data);

        $('#firmModel').on('show.bs.modal', function (e) {
            var update_value = $(e.relatedTarget).data('update_value');
            if (update_value !== 0) {
                $('<input>').attr({
                    type: 'hidden',
                    id: 'update_value',
                    name: 'update_value',
                    value: dencypt(update_value)
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
        var url = "<?= base_url() ?>firm_delete_by";
        var data = {
            "update_value": encypt(value),
            "client_service": encypt("frontend-client"),
            "auth_key": encypt("auth_client"),
            "token": token,
            "user_type": user_type,
            "auth_client": auth_client
        }

        var response = getAjax(url, data);
        response.done(function (success) {
            showNotification('top', 'right', 'add_alert', success["message"], 'success');
            var url_list = "<?= base_url() ?>firm_list";
            load_table(url_list);
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }

    function get_firm_by_id(id) {
        var url = "<?= base_url() ?>firm_by_id";
        var data = {
            "update_value": encypt(id),
            "client_service": encypt("frontend-client"),
            "auth_key": encypt("auth_client"),
            "token": token,
            "user_type": user_type,
            "auth_client": auth_client
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