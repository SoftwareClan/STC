<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon" data-toggle="modal" data-target="#targetManuallyModel" data-update_value="0">
                    Manually Target<i class="material-icons">person_add</i>
                </div>
                <div class="card-icon" data-toggle="modal" data-target="#targetFileModel" data-update_value="0">
                    Target File<i class="material-icons">attach_file</i>
                </div>
                <div class="card-icon" onclick="assignToModel()" >
                    Assignment<i class="material-icons">transfer_within_a_station</i>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="targetTable">
                    <thead>
                        <tr>
                            <th><input type='checkbox' name="checkboxlist" value="0" id="checkAll"/>All</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Source</th>
                            <th>Record Type</th>
                            <th>Assign To</th>
                            <th>Completed Status</th>
                            <th>Assign On</th>
                            <th>Create On</th>
                            <th>Update On</th>
                            <th>
                                Action

                            </th>
                        </tr>
                    </thead>
                    <tbody id="target_table_body">

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

    var url = "<?= base_url("target/list_by_type") ?>";

    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>'




    $(document).ready(function () {



        $('#target_file_create_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url("target/import_target") ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    showNotification('top', 'right', 'add_alert', data["Total_Record"], 'success');
                    $('#target_file_create_form').trigger("reset");
                    $('#targetFileModel').modal('toggle');
                    var auth_data = {
                        "client_service": "frontend-client",
                        "auth_key": "stchexaclan",
                        "auth_client": auth_client,
                        "token": token,
                        "user_type": user_type,
                        "user_key": user_key,
                        "type": "1"
                    };

                    load_table(url, auth_data, 'target_table_body', 'targetTable');
                },
                error: function (error) {
                    showNotification('top', 'right', 'add_alert', data["Total_Record"], 'danger');
                    $('#target_file_create_form').trigger("reset");
                }
            });
        }
        );


        var auth_data = {
            "client_service": "frontend-client",
            "auth_key": "stchexaclan",
            "auth_client": auth_client,
            "token": token,
            "user_type": user_type,
            "user_key": user_key,
            "type": "1"
        };

        load_table(url, auth_data, 'target_table_body', 'targetTable');
        /**
         *
         * @param {type} id
         * @returns {undefined}
         */
        $('#targetManuallyModel').on('show.bs.modal', function (e) {
            var update_value = $(e.relatedTarget).data('update_value');
            if (update_value !== 0) {
                $('<input>').attr({
                    type: 'hidden',
                    id: 'update_value',
                    name: 'update_value',
                    value: update_value
                }).appendTo('#target_manually_create_form');
                get_target_by_id(update_value);
            }

        });

        $('#targetManuallyModel').on('hide.bs.modal', function (e) {
            $("#user_id").remove();
            $("#target_manually_create_form").trigger("reset");

        });

        $('#targetAssignToModel').on('show.bs.modal', function (e) {

            var auth_data = {
                "client_service": "frontend-client",
                "auth_key": "stchexaclan",
                "auth_client": auth_client,
                "token": token,
                "user_type": user_type,
                "user_key": user_key
            };


            var url = "<?= base_url("user_options") ?>";
            var response = getAjax(url, auth_data);
            response.done(function (success) {
                $('#uoption').empty();
                $('#uoption').html(success['data_table']);
            });
            response.fail(function (error) {
                showNotification('top', 'right', 'add_alert', error["message"], 'danger');
            });
        });


        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $('#assign').click(function () {
            var checkValues = $('input[name=checkboxlist]:checked').map(function ()
            {
                return $(this).val();
            }).get();

            if (checkValues.length === 0) {
                showNotification('top', 'right', 'add_alert', "Select Target", 'danger');

            } else {
                var user_id = $("#uoption").val();
                console.log(user_id);
                var url = "<?= base_url("assignTarget") ?>";
                var data = {
                    "client_service": "frontend-client",
                    "auth_key": "stchexaclan",
                    "token": token,
                    "user_type": user_type,
                    "user_key": user_key,
                    "auth_client": auth_client,
                    "u_id": user_id,
                    "ids": checkValues
                };
                var response = getAjax(url, data);
                response.done(function (success) {
                    $('#targetAssignToModel').modal('toggle');
                    showNotification('top', 'right', 'add_alert', success["message"], 'success');
                    var url_list = "<?= base_url("target/list_by_type") ?>";
                    var data = {
                        "client_service": "frontend-client",
                        "auth_key": "stchexaclan",
                        "token": token,
                        "user_type": user_type,
                        "user_key": user_key,
                        "auth_client": auth_client,
                        "type": "1"
                    }
                    load_table(url_list, data, 'target_table_body', 'targetTable');
                });
                response.fail(function (error) {
                    showNotification('top', 'right', 'add_alert', error["message"], 'danger');
                });
            }

        });
    });

    function assignToModel() {
        var checkValues = $('input[name=checkboxlist]:checked').map(function ()
        {
            return $(this).val();
        }).get();

        if (checkValues.length === 0) {
            showNotification('top', 'right', 'add_alert', "Select Target", 'danger');

        } else {
            $('#targetAssignToModel').modal('show');
        }

    }
    function target_delete_by(value) {
        var url = "<?= base_url("target/delete_by") ?>";
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
            var url_list = "<?= base_url("target/list_by_type") ?>";
            var data = {
                "client_service": "frontend-client",
                "auth_key": "stchexaclan",
                "token": token,
                "user_type": user_type,
                "user_key": user_key,
                "auth_client": auth_client,
                "type": "1"
            }
            load_table(url_list, data, 'target_table_body', 'targetTable');
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }

    function get_target_by_id(id) {
        var url = "<?= base_url("target/by_id") ?>";
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
            console.log(object[0]);
            $("input[name='up_name']").val(object[0]['name']);
            $("input[name='up_number']").val(object[0]['number']);
            $("input[name='up_source']").val(object[0]['source']);
        });
        response.fail(function (error) {
            showNotification('top', 'right', 'add_alert', error["message"], 'danger');
        });
    }




</script>