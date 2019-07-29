
<!doctype html>
<html lang="en">

    <head>
        <title>Hello, world!</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- Material Kit CSS -->
        <link href="<?= base_url() ?>assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />

        <script src="<?= base_url() ?>assets/js/core/jquery.min.js"></script>
        <style>
            label.error {
                color:red;

            }

            .form-control.error{
                color: red;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-rose">

                            <div class="card-icon" data-toggle="modal" data-target="#userModel">
                                <i class="material-icons">dashboard</i>
                            </div>
                            <h4 class="card-title">Dashboard Login</h4>
                        </div>
                        <form class="form" id="login_form" method="post">
                            <div class="card-body">

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">person</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="username" placeholder="Username">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="material-icons">lock_outline</i></div>
                                        </div>
                                        <div class="col">
                                            <input type="password" placeholder="Password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer justify-content-end ">
                                <button  class="btn btn-primary  btn-wd btn-lg">Get Started</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!--   Core JS Files   -->

        <script src="<?= base_url() ?>assets/js/customer_validation.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
        <script src="<?= base_url() ?>assets/js/core/bootstrap-material-design.min.js"></script>
        <script src="<?= base_url() ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="<?= base_url() ?>assets/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="<?= base_url() ?>assets/js/plugins/sweetalert2.js"></script>
        <!-- Forms Validations Plugin -->
        <script src="<?= base_url() ?>assets/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="<?= base_url() ?>assets/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="<?= base_url() ?>assets/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="<?= base_url() ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="<?= base_url() ?>assets/js/plugins/jquery.dataTables.min.js"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="<?= base_url() ?>assets/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="<?= base_url() ?>assets/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="<?= base_url() ?>assets/js/plugins/fullcalendar.min.js"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="<?= base_url() ?>assets/js/plugins/jquery-jvectormap.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="<?= base_url() ?>assets/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="<?= base_url() ?>assets/js/plugins/arrive.min.js"></script>
        <!--  Google Maps Plugin    -->
        <!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
        <!-- Chartist JS -->
        <script src="<?= base_url() ?>assets/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="<?= base_url() ?>assets/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="<?= base_url() ?>assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="<?= base_url() ?>assets/demo/demo.js"></script>
        <script>
            $(document).ready(function () {

                $("#login_form").validate({

                    rules: {
                        username: {
                            required: true,
//                            letter_with_underscore: true,
                        },
                        password: {
                            required: true,
                        }
                    },
                    messages: {
                        username: {
                            required: "Please Enter User Name",
                            letter_with_underscore: "Only letter and underscore( _ ) allowed"
                        },
                        password: {
                            required: "Please Enter password",
                        }
                    },
                    submitHandler: function (form) {
                        var url = "<?= base_url() . "request_to_login" ?>";
                        var data = getFormData(form, null, null, 'tu');

                        var request = getAjax(url, data);
                        request.done(function (success) {
                            //console.log(success);
                            window.location = "<?= base_url() ?>" + success;
                        });
                        request.fail(function (error) {
                            console.log(error);
                            showNotification('top', 'right', 'add_alert', 'Invalid Username and password', 'danger');
                        });
                    }
                })
            });


        </script>

    </body>

</html>