<!doctype html>
<html lang="es" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Estatura | NutriFit Planner</title>

    <?php
    require_once("../html/head.php")
    ?>
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        require_once("../html/header.php")
        ?>


        <!-- removeNotificationModal -->
        <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>¿Está Seguro De Eliminar Esta Estatura?</h4>
                                <p class="text-muted mx-4 mb-0">No Podrá Recuperar La Estatura</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Sí, Eliminar Estatura!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                                <h4 class="mb-sm-0">Utilidades - Estatura</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="../Estatura/estatura.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Estatura</li>
                                    </ol>
                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- end page title -->



                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header">

                                <h5 class="card-title mb-0">Estatura</h5>

                            </div>

                            <div class="card-body" style="display:flex; justify-content:flex-end;align-content:flex-end; flex-wrap:wrap; ">
                                <div class="row g-2">
                                    <div class="col-lg-auto">

                                        <div class="hstack gap-2">
                                            <!-- <button type="button" id="btnNuevo" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createboardModal"><i class="ri-add-line align-bottom me-1"></i> Añadir Categoria</button> -->
                                            <!-- <button type="button" id="btnNuevo" data-bs-toggle="modal" data-bs-target="#modalCategoria" class="btn btn-success btn-label waves-effect waves-light"><i style="margin-top:0.4rem" data-feather="plus-square" class="align-bottom me-1 label-icon align-middle fs-16 me-2"></i> <strong>Añadir Categoría</strong></button> -->
                                            <button type="button" id="btnNuevo" data-bs-toggle="modal" data-bs-target="#modalCategoria" class="btn btn-success btn-label waves-effect waves-light">
                                                <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                <lord-icon class="align-bottom me-1 label-icon align-middle fs-16 me-2"
                                                    src="https://cdn.lordicon.com/pdsourfn.json"
                                                    trigger="loop"
                                                    delay="2000"
                                                    style="width: 35px;
                                                                height: 35px;
                                                                margin-top: 0.1rem;
                                                                margin-bottom: 10rem;
                                                                display: flex;
                                                                flex-direction: column-reverse;
                                                                align-items: flex-start;
                                                                align-content: center;
                                                                flex-wrap: nowrap;
                                                                justify-content: flex-end;">
                                                </lord-icon>
                                                <strong style="margin-left: 0.5rem;">Añadir Estatura</strong>
                                            </button>

                                        </div>
                                    </div>


                                </div>



                                <!--end row-->
                            </div>

                            <!--end card-body-->


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha Creacion</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



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
        require_once("modal.php")
    ?>

    <?php
        require_once("../html/js.php")
    ?>

    <script type="text/javascript" src="modal.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="../../assets/js/pages/datatables.init.js"></script>


</body>

</html>