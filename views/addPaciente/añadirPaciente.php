<?php
require_once("../html/session.php");
?>


<!doctype html>
<html lang="es" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Añadir Paciente | NutriFit Planner</title>

    <?php
    require_once("../html/head.php");
    ?>
    <!--datatable css-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Sweet Alert css-->
    <link href="../../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="../../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        require_once("../html/header.php");
        ?>
        <!-- ========== App Menu ========== -->
        <?php
        require_once("../html/menu.php");
        ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Añadir Paciente</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="./anadirPaciente.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Añadir Paciente</li>
                                    </ol>
                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="leadsList">
                                <div class="card-header border-0">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm-3">
                                            <div class="search-box">
                                                <input type="text"  id="searchInput" class="form-control search" placeholder="Buscar Paciente...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto ms-auto">
                                            <div class="hstack gap-2">
                                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Añadir Paciente</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="customerTable">
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive table-card">
                                                <table class="table align-middle" >
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="sort" data-sort="name">Nombre</th>
                                                            <th class="sort" data-sort="company_name">Apellidos</th>
                                                            <th class="sort" data-sort="leads_score">Correo</th>
                                                            <th class="sort" data-sort="phone">Telefono</th>
                                                            <th class="sort" data-sort="location">Usuario</th>
                                                            <th class="sort" data-sort="role">Rol</th>
                                                            <th class="sort" data-sort="tags">Enfermedad</th>
                                                            <th class="sort" data-sort="status">Status</th>
                                                            <th class="sort" data-sort="fecha_creacion">Creacion</th>
                                                            <th data-sort="action"></th>
                                                            <th data-sort="action"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        
                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Lo Sentimos! No Encontramos Lo Que Busca</h5>
                                                        <p class="text-muted mb-0">Hemos Buscado En Todo. Pero No Se Encontró Ninguna Coincidencia En Su Busqueda.</p>
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
                                            require_once("modalDelete.php");
                                            ?>
                                        <!--end modal -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end col-->
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php
        require_once("../html/footer.php");
        ?>
    </div>
    <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php
    require_once("modalAdd.php");
    ?>

    <?php
    require_once("../html/js.php");
    ?>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>

    <script src="../../assets/js/pages/job-list.init.js"></script>
    <!-- list.js min js -->
    <script src="../../assets/libs/list.js/list.min.js"></script>
    <!--list pagination js-->
    <script src="../../assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- titcket init js -->
    <script src="../../assets/js/pages/ticketlist.init.js"></script>
    <script src="../../assets/js/pages/crm-leads.init.js"></script>

    <script type="text/javascript" src="addPaciente.js"></script>

    <!-- Sweet Alerts js -->
    <script src="../../assets/libs/sweetalert2/sweetalert2.min.js"></script>
</body>