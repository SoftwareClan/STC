<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">bookmark</i>
                </div>
                <p class="card-category">Total Reminder</p>
                <h3 class="card-title"><?= is_numeric($counter[0]->total) ? $counter[0]->total : 0 ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">speaker_notes</i>
                </div>
                <p class="card-category">Read</p>
                <h3 class="card-title"><?= is_numeric($counter[0]->read) ? $counter[0]->total : 0 ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">speaker_notes_off</i>
                </div>
                <p class="card-category">Un-Read</p>
                <h3 class="card-title"><?= is_numeric($counter[0]->unread) ? $counter[0]->total : 0 ?>
                </h3>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">

            </div>
            <div class="panel-body">



                <table class="table bootstrap-datatable countries">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Message</th>
                            <th>User Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Read Status</th>
                            <th>Notify Status</th>
                            <th>Create at</th>
                            <th>Update at</th>
                            <th>Notify at</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $tableRow = "";
                        if (isset($reminder_list)) {
                            if (!is_array($reminder_list)) {
                                $tableRow .= "<tr><td span='6'>$reminder_list</td></tr>";
                            } else {
                                if (count($reminder_list) > 0) {
                                    foreach ($reminder_list as $user) {
                                        $readStatus = $user->mark_as_read == 1 ? 'Read' : 'Not Read';
                                        $notify_status = $user->notify_status == 1 ? 'Notify' : 'Not Notify';
                                        print_r($user);
                                        $tableRow .= "<tr>"
                                                . "<td>" . $user->number . "</td>"
                                                . "<td>" . $user->reminder_message . "</td>"
                                                . "<td>" . $user->u_name . "</td>"
                                                . "<td>" . $user->r_date . "</td>"
                                                . "<td>" . $user->r_time . "</td>"
                                                . "<td>" . $readStatus . "</td>"
                                                . "<td>" . $notify_status . "</td>"
                                                . "<td>" . $user->create_date_time . "</td>"
                                                . "<td>" . $user->update_date_time . "</td>"
                                                . "<td>" . $user->notify_date_time . "</td>"
                                                . "<td><a href='" . base_url() . "new_Reminder/" . $user->id . "'>Update</a></td>"
                                                . "</tr>";
                                    }
                                } else {
                                    $tableRow .= "<tr><td span='6'>No Data</td></tr>";
                                }
                            }
                        }
                        echo $tableRow;
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>