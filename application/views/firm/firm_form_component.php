
<style>
    label.error {
        color:red;

    }

    .form-control.error{
        color: red;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="firmModel" tabindex="-1" role="dialog" aria-labelledby="firmModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <form id="firm_create_form">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Create / Update Firm Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">account_balance</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="name" placeholder="Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">contact_mail</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="email" class="form-control" name="email" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">contact_phone</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="contact" placeholder="Contact">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">add_location</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="address" placeholder="Address">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">perm_identity</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="username" placeholder="username">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">lock</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="password" class="form-control" name="password" placeholder="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">lock</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="number" class="form-control" name="no_of_users" placeholder="No of Users">
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




    var url = "<?= base_url("firm_list") ?>";

    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>'

    $(document).ready(function () {

        $("#firm_create_form").validate({

            rules: {
                name: {
                    required: true,
                    letter_with_whitespace: true,
                },
                contact: {
                    required: true,
                    mobile_number: true,
                },
                username: {
                    required: true,
                    letter_with_underscore: true,
                },
                password: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                no_of_users: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please Enter Firm Name",
                    letter_with_whitespace: "Only letter and whitespace allowed"
                },
                contact: {
                    required: "Please Enter Number",
                    mobile_number: "Number Should be 10 Digit."
                },
                email: {
                    required: "Please Enter Email",
                    email: "Please Enter valid email"
                },
                username: {
                    required: "Please Enter Username",
                    letter_with_underscore: "Only letter and underscore allowed"
                },
                password: {
                    required: "Please Enter Password",
                },
                no_of_users: {
                    required: "Please Enter No Of Users",
                }

            },
            submitHandler: function (form) {

                var url = "<?= base_url() . "firm_changes" ?>";

                var data = getFormData(form, token, user_key, user_type);


                var request = getAjax(url, data);
                request.done(function (success) {
                    console.log(success);
                    $('#firmModel').modal('toggle');
                    showNotification('top', 'right', 'add_alert', success["message"], 'success');
                    var url_firm = "<?= base_url() ?>firm_list";

                    var auth_data = {
                        "client_service": "frontend-client",
                        "auth_key": "stchexaclan",
                        "auth_client": auth_client,
                        "token": token,
                        "user_type": user_type,
                        "user_key": user_key,
                    }

                    load_table(url, data, 'firm_list_tbody', 'firm_list_table');
                });
                request.fail(function (error) {
                    console.log(error);
                    $('#firmModel').modal('toggle');
                    showNotification('top', 'right', 'add_alert', error["message"], 'danger');
                });
            }


        })
    });
</script>
