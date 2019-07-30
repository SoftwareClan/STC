
<style>
    label.error {
        color:red;

    }

    .form-control.error{
        color: red;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="targetAssignToModel" tabindex="-1" role="dialog" aria-labelledby="targetAssignToModelLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 top:22px">
                    <div class="card">
                        <form id="target_manually_create_form"  method="post" >
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Assign To</h4>
                            </div>
                            <div class="card-body">

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">person</i></div>
                                        </div>
                                        <div class="col">
                                            <select id="uoption"  class="form-control" name="user_id"  placeholder="Select Users">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row w-100 justify-content-end">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="assign" class="btn btn-primary">Assign</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
