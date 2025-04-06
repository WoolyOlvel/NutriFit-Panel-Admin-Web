<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Project List | Velzon - Admin & Dashboard Template</title>
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
                                <h4 class="mb-sm-0">Historial Del Paciente</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="../Pacientes/index.php">Pacientes</a></li>
                                        <li class="breadcrumb-item active">Historial</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row g-4 mb-3">
                        
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end gap-2">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control" placeholder="Buscar...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>

                                <select class="form-control w-md" data-choices data-choices-search-false>
                                    <option value="All">Todos</option>
                                    <option value="Nombre">Nombre (A-Z)</option>
                                    <option value="Nombre" selected>Nombre(Z-A)</option>
                                    <option value="Por Fecha">Fecha</option>
                                    <option value="Recientes" selected>Recientes</option>
                                    
                                   
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3 col-sm-6 project-card">
                            <div class="card card-height-100">
                                <div class="card-body">
                                    <div class="d-flex flex-column h-100">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-4">Updated 3hrs ago</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="d-flex gap-1 align-items-center">
                                                    
                                                    <div class="dropdown">
                                                        <button class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <i data-feather="more-horizontal" class="icon-sm"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="../infoPaciente/informacionConsulta.php"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                Ver</a>
                                                            <a class="dropdown-item" href="apps-projects-create.html"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                Editar</a>
                                                            <div class="dropdown-divider"></div>
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title bg-warning-subtle rounded p-2">
                                                        <img src="../../assets/images/brands/slack.png" alt="" class="img-fluid p-1">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1 fs-14"><a href="../infoPaciente/informacionConsulta.php" class="text-body">Slack brand logo design</a></h5>
                                                <p class="text-muted text-truncate-two-lines mb-3">Create a Brand logo
                                                    design for a velzon admin.</p>
                                            </div>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="d-flex mb-2">
                                                <div class="flex-grow-1">
                                                    <div>Tasks</div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div><i class="ri-list-check align-bottom me-1 text-muted"></i>
                                                        18/42</div>
                                                </div>
                                            </div>
                                            <div class="progress progress-sm animated-progress">
                                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" style="width: 34%;">
                                                </div><!-- /.progress-bar -->
                                            </div><!-- /.progress -->
                                        </div>
                                    </div>

                                </div>
                                <!-- end card body -->
                                <div class="card-footer bg-transparent border-top-dashed py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="text-muted">
                                                <i class="ri-calendar-event-fill me-1 align-bottom"></i> 10 Jul, 2021
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- end card footer -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->

                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0 text-muted">Mostrando <span class="fw-semibold">1</span> al <span class="fw-semibold">4</span> de <span class="fw-semibold text-decoration-underline">4</span> entradas</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <ul class="pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                <li class="page-item disabled">
                                    <a href="#" class="page-link">Anterior</a>
                                </li>
                                <li class="page-item active">
                                    <a href="#" class="page-link">1</a>
                                </li>
                                <li class="page-item ">
                                    <a href="#" class="page-link">2</a>
                                </li>
                                
                                <li class="page-item">
                                    <a href="#" class="page-link">Siguiente</a>
                                </li>
                            </ul>
                        </div><!-- end col -->
                    </div><!-- end row -->
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

    <!-- removeProjectModal -->
    <div id="removeProjectModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Project ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-project">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

   

   

    <?php
    require_once("../html/js.php")
    ?>

    <!-- project list init -->
    <script src="../../assets/js/pages/project-list.init.js"></script>

</body>

</html>