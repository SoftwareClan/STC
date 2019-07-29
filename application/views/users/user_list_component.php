<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon" data-toggle="modal" data-target="#userModel">
                    <i class="material-icons">person_add</i>
                </div>
            </div>
            <div class="card-body">
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Update On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="user_table">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var data = `<tr>
    <td>Narendra</td>
    <td>9920482779</td>
    <td>27 Jul 2019 08:21</td>
    <td class="td-actions">  <button type="button" rel="tooltip" class="btn btn-info btn-simple" data-toggle="modal" data-target="#userModel" data-user_id="1">
                    <i class="material-icons">person</i>
                </button>
                <button type="button" rel="tooltip" class="btn btn-success btn-simple">
                    <i class="material-icons">edit</i>
                </button>
                <button type="button" rel="tooltip" class="btn btn-danger btn-simple">
                    <i class="material-icons">close</i>
                </button></td>
                </tr>

     `;
        $.ajax({
            url: "<?= base_url() ?>test",
            method: "POST",
            data: {token: "John", auth_client: "Boston", client_service: "frontend-client", auth_key: "stchexaclan"},
            //$('#theForm').serialize()
        }).done(function (html) {
            $('#user_table').append(data);
            $('#myTable').DataTable();
        });

        $('#userModel').on('show.bs.modal', function (e) {
            var userId = $(e.relatedTarget).data('user_id');
            $('<input>').attr({
                type: 'hidden',
                id: 'user_id',
                name: 'user_id',
                value: userId
            }).appendTo('#user_create_form');
        });
        $('#userModel').on('hide.bs.modal', function (e) {
            console.log('close');
            $("#user_id").remove();
        });
    });


</script>