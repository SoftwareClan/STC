
<style>
    label.error {
        color:red;

    }

    .form-control.error{
        color: red;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="userModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <form id="user_create_form">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Create / Update User Details</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="user_name"  placeholder="User name">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="user_number" placeholder="Number">
                                    </div>
                                    <div class="col">
                                        <input type="password" class="form-control" name="user_pass" placeholder="MPIN Password">
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
<script>
    $(document).ready(function () {

        $("#user_create_form").validate({

            rules: {
                user_name: {
                    required: true,
                    letter_with_whitespace: true,
                },
                user_number: {
                    required: true,
                    mobile_number: true,
                },
                user_pass: {
                    required: true,
                    mpin_password: true,
                },
            },
            messages: {
                user_name: {
                    required: "Please Enter User Name",
                    letter_with_whitespace: "Only letter and whitespace allowed"
                },
                user_number: {
                    required: "Please Enter Number",
                    mobile_number: "Number Should be 10 Digit."
                },
                user_pass: {
                    required: "Please Enter M-Pin",
                    mpin_password: "M-pin Should be 4 Digit."
                }
            },
            submitHandler: function (form) {
                $('#userModel').modal('toggle');



                console.log($('#user_create_form').serialize());

                showNotification('top', 'right', 'add_alert', 'New User Created Successfully', 'success');

            }


        })
    });



    function create_or_update() {
        $.ajax({
            url: "",
            data: "",
            success: function (response) {

            }

        });
    }


</script>
