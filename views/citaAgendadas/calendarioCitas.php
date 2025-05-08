<?php
require_once("../html/session.php");
?>

<!doctype html>
<html lang="es" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Consulta | NutriFit Planner</title>
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

                    <!--  TODO:ID DE COMPRA -->
                    <input type="hidden" name="Venta_ID" id="Venta_ID" />

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
                                        <h5 class="mb-1">Próximas Reservaciones</h5>
                                        <p class="text-muted">Sus Citas Para</p>
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
                            <div class="modal fade" id="event-modal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0">
                                        <div class="modal-header p-3 bg-info-subtle">
                                            <h5 class="modal-title" id="modal-title">Event</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                <div class="text-end">
                                                    <a href="#" class="btn btn-sm btn-soft-primary" id="edit-event-btn" data-id="edit-event" onclick="editEvent(this)" role="button">Edit</a>
                                                </div>
                                                <div class="event-details">
                                                    <div class="d-flex mb-2">
                                                        <div class="flex-grow-1 d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3">
                                                                <i class="ri-calendar-event-line text-muted fs-16"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="d-block fw-semibold mb-0" id="event-start-date-tag"></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="ri-time-line text-muted fs-16"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="d-block fw-semibold mb-0"><span id="event-timepicker1-tag"></span> - <span id="event-timepicker2-tag"></span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="ri-map-pin-line text-muted fs-16"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="d-block fw-semibold mb-0"> <span id="event-location-tag"></span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mb-3">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="ri-discuss-line text-muted fs-16"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <p class="d-block text-muted mb-0" id="event-description-tag"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row event-form">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Type</label>
                                                            <select class="form-select d-none" name="category" id="event-category" required>
                                                                <option value="bg-danger-subtle">Danger</option>
                                                                <option value="bg-success-subtle">Success</option>
                                                                <option value="bg-primary-subtle">Primary</option>
                                                                <option value="bg-info-subtle">Info</option>
                                                                <option value="bg-dark-subtle">Dark</option>
                                                                <option value="bg-warning-subtle">Warning</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a valid event category</div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Event Name</label>
                                                            <input class="form-control d-none" placeholder="Enter event name" type="text" name="title" id="event-title" required value="" />
                                                            <div class="invalid-feedback">Please provide a valid event name</div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label>Event Date</label>
                                                            <div class="input-group d-none">
                                                                <input type="text" id="event-start-date" class="form-control flatpickr flatpickr-input" placeholder="Select date" readonly required>
                                                                <span class="input-group-text"><i class="ri-calendar-event-line"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-12" id="event-time">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Start Time</label>
                                                                    <div class="input-group d-none">
                                                                        <input id="timepicker1" type="text" class="form-control flatpickr flatpickr-input" placeholder="Select start time" readonly>
                                                                        <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">End Time</label>
                                                                    <div class="input-group d-none">
                                                                        <input id="timepicker2" type="text" class="form-control flatpickr flatpickr-input" placeholder="Select end time" readonly>
                                                                        <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="event-location">Location</label>
                                                            <div>
                                                                <input type="text" class="form-control d-none" name="event-location" id="event-location" placeholder="Event location">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <input type="hidden" id="eventid" name="eventid" value="" />
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Description</label>
                                                            <textarea class="form-control d-none" id="event-description" placeholder="Enter a description" rows="3" spellcheck="false"></textarea>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-soft-danger" id="btn-delete-event"><i class="ri-close-line align-bottom"></i> Delete</button>
                                                    <button type="submit" class="btn btn-success" id="btn-save-event">Add Event</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> <!-- end modal-content-->
                                </div> <!-- end modal dialog-->
                            </div> <!-- end modal-->
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
    <!-- calendar min js -->
    <script src="../../assets/libs/fullcalendar/index.global.min.js"></script>

    <!-- Calendar init -->
    <script src="../../assets/js/pages/calendar.init.js"></script>
    <?php
    require_once("../html/js.php");
    ?>

    <script type="text/javascript" src="venta.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../../assets/js/pages/invoicedetails.js"></script>
    <!-- ckeditor -->
    <script src="../../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <!-- dropzone js -->
    <script src="../../assets/libs/dropzone/dropzone-min.js"></script>
    <!-- project-create init -->
    <script src="../../assets/js/pages/project-create.init.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function downloadFile() {
            // Puedes cambiar la URL a la que deseas realizar la descarga
            var downloadUrl = window.location.href;

            // Abre una nueva ventana o pestaña con la URL de descarga
            window.open(downloadUrl, '_blank');
        }
    </script>



    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>

</body>

</html>