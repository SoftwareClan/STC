
<style>
    label.error {
        color:red;

    }

    .form-control.error{
        color: red;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="targetManuallyModel" tabindex="-1" role="dialog" aria-labelledby="targetFileModelLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <form id="target_manually_create_form" enctype="multipart/form-data" method="post" >
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Create / Update User Details</h4>
                            </div>
                            <div class="card-body">

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">person</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="up_name" placeholder="Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">local_phone</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="up_number" placeholder="Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">file_copy</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="up_source" placeholder="Source Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row w-100 justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
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
    var url = "<?= base_url("target/list_by_type") ?>";

    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>'
    $(document).ready(function () {


        $("#target_manually_create_form").validate({

            rules: {
                up_name: {
                    required: true,
                    letter_with_whitespace: true
                },
                up_number: {
                    required: true,
                    mobile_number: true,
                },
                up_source: {
                    required: true,
                },
            },
            messages: {
                up_name: {
                    required: "Please Enter User Name",
                    letter_with_whitespace: "Only letter and whitespace allowed"
                },
                up_number: {
                    required: "Please Enter Number",
                    mobile_number: "Number Should be 10 Digit."
                },
                up_source: {
                    required: "Please Enter M-Pin",
                }
            },
            submitHandler: function (form) {

                var url = "<?= base_url("target/manuallay") ?>";

                var data = getFormData(form, token, user_key, user_type);


                var request = getAjax(url, data);
                request.done(function (success) {
                    console.log(success);
                    $('#targetManuallyModel').modal('toggle');
                    showNotification('top', 'right', 'add_alert', success["message"], 'success');
                    var url_firm = "<?= base_url("target/list_by_type") ?>";

                    var auth_data = {
                        "client_service": "frontend-client",
                        "auth_key": "stchexaclan",
                        "auth_client": auth_client,
                        "token": token,
                        "user_type": user_type,
                        "user_key": user_key,
                        "type": "1"
                    }

                    load_table(url_firm, auth_data, 'target_table_body', 'targetTable');
                });
                request.fail(function (error) {
                    console.log(error);
                    $('#targetManuallyModel').modal('toggle');
                    showNotification('top', 'right', 'add_alert', error["message"], 'danger');
                });

            }


        })
    });
</script>
