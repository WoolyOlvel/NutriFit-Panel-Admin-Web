<?php
require_once("../html/session.php");
?>


<!doctype html>
<html lang="es" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Calendario | NutriFit Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
    <?php
    require_once("../html/head.php");
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- One of the following themes -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        require_once("../html/header.php");
        ?>


        <?php
        require_once("../html/menu.php");
        ?>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">


                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Calendario De Reservaciones</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="./calendarioCitas.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Reservaciones</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="card card-h-100">
                                        <div id="external-events">
                                            
                                        </div>
                                    </div>

                                    <div>
                                        <h5 class="mb-1">Reservaciones de Consultas</h5>
                                        <p class="text-muted">Visualiza las próximas citas</p>
                                        <div class="pe-2 me-n1 mb-3" data-simplebar style="height: 400px">
                                            <div id="upcoming-event-list"></div>
                                        </div>
                                    </div>


                                    <!--end card-->
                                </div> <!-- end col-->

                                <div class="col-xl-9">
                                    <div class="card card-h-100">
                                        <div class="card-body">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <!--end row-->

                            <div style='clear:both'></div>

                            <!-- Add New Event MODAL -->
                            <?php
                            require_once("modalCalendar.php");
                            ?>
                            <!-- end modal-->



                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php
        require_once("../html/footer.php");
        ?>
    </div>

    </div>
    <!-- END layout-wrapper -->

    <?php
    require_once("../html/js.php");
    ?>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function downloadFile() {
            // Puedes cambiar la URL a la que deseas realizar la descarga
            var downloadUrl = window.location.href;

            // Abre una nueva ventana o pestaña con la URL de descarga
            window.open(downloadUrl, '_blank');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("[data-provider='flatpickr']", {
                enableTime: true,
                dateFormat: "d.m.y H:i",
            });
        });
    </script>


    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
    <script src="../../assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <!-- calendar min js -->
    <script src="../../assets/libs/fullcalendar/index.global.min.js"></script>

    <!-- Calendar init -->
    <script src="../../assets/js/pages/calendar.init.js"></script>

    <script type="text/javascript" src="calendar.js"></script>



</body>

</html>