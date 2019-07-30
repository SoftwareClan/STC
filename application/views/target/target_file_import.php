
<style>
    label.error {
        color:red;

    }

    .form-control.error{
        color: red;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="targetFileModel" tabindex="-1" role="dialog" aria-labelledby="targetFileModelLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <form id="target_file_create_form" enctype="multipart/form-data" method="post" >
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Import Target List</h4>
                            </div>
                            <div class="card-body">

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">attach_file</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="filename" placeholder="Name">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group form-file-upload form-file-multiple">
                                    <input type="file" class="inputFileHidden" name="userfile" placeholder="File Name" accept=".xls, .xlsx">
                                    <div class="input-group">
                                        <input type="text" class="form-control inputFileVisible" placeholder="Single File">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-fab btn-round btn-primary">
                                                <i class="material-icons">attach_file</i>
                                            </button>
                                        </span>
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
    var url = "<?= base_url("user_list") ?>";

    var user_type = '<?= $user_type ?>';
    var token = '<?= $token ?>';
    var auth_client = '<?= $auth_client ?>';
    var user_key = '<?= $user_key ?>'
    $(document).ready(function () {
        $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function () {
            $(this).parent().parent().find('.inputFileHidden').trigger('click');
            $(this).parent().parent().addClass('is-focused');
        });

    });
</script>
