<?php
require_once("../html/session.php");
?>
<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Pacientes | NutriFit Planner</title>


    <!-- Sweet Alert css-->
    <link href="../../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <?php
    require_once("../html/head.php")
    ?>


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        require_once("../html/header.php")
        ?>


        <!-- ========== App Menu ========== -->
        <?php
        require_once("../html/menu.php")
        ?>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Mis Pacientes</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="./misPacientes.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Lista</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">

                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="card" id="companyList">
                                <div class="card-header">
                                    <div class="row g-2">
                                        <div class="col-md-3">
                                            <div class="search-box">
                                                <input type="text" class="form-control search" id="searchInput" placeholder="Buscar Paciente...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-auto ms-auto">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="text-muted">Ordenar por: </span>
                                                <select class="form-control mb-0" data-choices data-choices-search-false id="ordenar-pacientes">
                                                    <!--<option value="Recientes">Recientes (Más nuevos primero)</option>-->
                                                    <!--<option value="Antiguos">Antiguos (Más antiguos primero)</option>--->
                                                    <option value="NombreAZ">Nombre (A-Z)</option>
                                                    <option value="NombreZA" selected >Nombre (Z-A)</option>
                                                    <option value="ApellidosAZ">Apellidos (A-Z)</option>
                                                    <option value="ApellidosZA">Apellidos (Z-A)</option>
                                                    <option value="Masculino">Género (Masculino primero)</option>
                                                    <option value="Femenino">Género (Femenino primero)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="customerTable">
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive table-card mb-3">
                                                <table class="table align-middle table-nowrap mb-0">
                                                    <thead class="table-light">
                                                        <tr>

                                                            <th class="sort" data-sort="name" scope="col">Nombre</th>
                                                            <th class="sort" data-sort="owner" scope="col">Apellidos</th>
                                                            <th class="sort" data-sort="industry_type" scope="col">Genero</th>
                                                            <th class="sort" data-sort="location" scope="col">Editar</th>
                                                            <th class="sort" data-sort="location" scope="col">Eliminar</th>
                                                            <th class="sort" data-sort="location" scope="col">Información</th>
                                                            <th class="sort" data-sort="location" scope="col">Historial</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">

                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Lo Sentimos! No Encontramos Ninguna Coincidencia De Su Busqueda.</h5>
                                                        <p class="text-muted mb-0">Hemos Buscado En Todo El Sistema y No Se Encontro Ninguna Coincidencia Para Su Busqueda.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-3">
                                                <div class="pagination-wrap hstack gap-2">
                                                    <a class="page-item pagination-prev disabled" href="#">
                                                        Anterior
                                                    </a>
                                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                                    <a class="page-item pagination-next" href="#">
                                                        Siguiente
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        require_once("modalPacientes.php")
                                        ?>
                                        <!--end add modal-->

                                        <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                    </div>
                                                    <div class="modal-body p-5 text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                                        <div class="mt-4 text-center">
                                                            <h4 class="fs-semibold">¿Está Seguro De Eliminar Este Paciente?</h4>
                                                            <p class="text-muted fs-14 mb-4 pt-1">No Podrá Recuperar La Información Del Paciente.</p>
                                                            <div class="hstack gap-2 justify-content-center remove">
                                                                <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                                    No, No Eliminar!</button>
                                                                <button class="btn btn-danger" id="delete-record">Sí, Eliminar Paciente!!</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end delete modal -->

                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3">
                            <div class="card" id="company-view-detail">
                                <div class="card-body text-center">
                                    <div class="position-relative d-inline-block">
                                        <div class="avatar-xl">
                                            <div class="avatar-title bg-light rounded-circle">
                                                <img src="../../assets/images/users/user-dummy-img.jpg " alt="" class="avatar-lg rounded-circle object-fit-cover">
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mt-3 mb-1">Nombre y Apellidos Del Paciente</h5>
                                    <p class="text-muted">Genero</p>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Informacion</h6>
                                    <p class="text-muted mb-4"></p>
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Correo Electronico</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Estado</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Ciudad</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Edad</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Telefono</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Enfermedad</td>
                                                    <td>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Rol</td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php
            require_once("../html/footer.php")
            ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php
    require_once("../html/js.php")
    ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

    <script src="../../assets/js/pages/job-list.init.js"></script>
    <!-- list.js min js -->
    <script src="../../assets/libs/list.js/list.min.js"></script>
    <!--list pagination js-->
    <script src="../../assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- titcket init js -->
    <script src="../../assets/js/pages/ticketlist.init.js"></script>
    <script src="../../assets/js/pages/crm-leads.init.js"></script>
    <!-- Modern colorpicker bundle -->
    <script src="../../assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="../../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <!-- init js -->
    <script src="../../assets/js/pages/form-pickers.init.js"></script>
    <!-- Sweet Alerts js -->
    <script src="../../assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="../../assets/js/pages/crm-companies.init.js"></script>
    <!-- JAVASCRIPT -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("[data-provider='flatpickr']", {
                enableTime: false,
                dateFormat: "d M, Y",
            });
        });
    </script>

    <script type="text/javascript" src="misPacientes.js"></script>

</body>

</html>