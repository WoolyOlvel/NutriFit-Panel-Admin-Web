<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Lista Pacientes | NutriFit Planner</title>

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
                                <h4 class="mb-sm-0">Lista De NutriDesafios</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="./listNutriDesafios.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Lista NutriDesafios</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="customerList">
                                <div class="card-header border-bottom-dashed">

                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title mb-0">NutriDesafios</h5>
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="card-body border-bottom-dashed border-bottom">
                                    <form>
                                        <div class="row g-3">
                                            <div class="col-xl-6">
                                                <div class="search-box">
                                                    <input type="text" class="form-control search" placeholder="Buscar NutriDesafio...">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xl-6">
                                                <div class="row g-3">
                                                
                                                    <!--end col-->
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <select class="form-control" data-plugin="choices" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                                                <option value="">Status</option>
                                                                <option value="all" selected>All</option>
                                                                <option value="Active">Active</option>
                                                                <option value="Block">Block</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    
                                                    <!--end col-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="table-responsive table-card mb-1">
                                            <table class="table align-middle" id="customerTable">
                                                <thead class="table-light text-muted">
                                                    <tr>
                                                        <th scope="col" style="width: 50px;">
                                                            
                                                        </th>

                                                        <th class="sort" data-sort="customer_name">NutriDesafio</th>
                                                        <th class="sort" data-sort="email">URL</th>
                                                        <th class="sort" data-sort="status">Status</th>
                                                        <th class="sort" data-sort="action">Editar</th>
                                                        <th class="sort" data-sort="action">Eliminar</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                        </th>
                                                        <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
                                                        <td class="customer_name">Crucigramas</td>
                                                        <td class="email">asfasfas</td>
                                                        <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">Active</span>
                                                        </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                    <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                            <lord-icon
                                                                                src="https://cdn.lordicon.com/vwzukuhn.json"
                                                                                trigger="loop"
                                                                                delay="1500"
                                                                                stroke="bold"
                                                                                state="in-reveal"
                                                                                style="width:36px;height:36px">
                                                                            </lord-icon>
                                                                    </a>
                                                                </li>
                                                             
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">

                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                            <lord-icon
                                                                                src="https://cdn.lordicon.com/nhqwlgwt.json"
                                                                                trigger="loop"
                                                                                delay="1000"
                                                                                stroke="bold"
                                                                                state="morph-trash-in"
                                                                                colors="primary:#ffffff,secondary:#c71f16,tertiary:#eeaa66,quaternary:#ebe6ef"
                                                                                style="width:36px;height:36px">
                                                                            </lord-icon>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                    </lord-icon>
                                                    <h5 class="mt-2">Lo siento, no se encontro ninguna coincidencia</h5>
                                                    <p class="text-muted mb-0">Hemos buscado entre más de 150 NutriDesafios.
                                                        No encontramos ninguno.
                                                        NutriDesafios de la busqueda.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
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
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field" />

                                                        <div class="mb-3" id="modal-id" style="display: none;">
                                                            <label for="id-field1" class="form-label">ID</label>
                                                            <input type="text" id="id-field1" class="form-control" placeholder="ID" readonly />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="customername-field" class="form-label">Nombre Del NutriDesafio</label>
                                                            <input type="text" id="customername-field" class="form-control" placeholder="Ingresa Nombre" required />
                                                            <div class="invalid-feedback">Introduzca el nombre del NutriDesafio.</div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email-field" class="form-label">URL</label>
                                                            <input type="text" id="email-field" class="form-control" placeholder="Ingresar URL" required />
                                                            <div class="invalid-feedback">Introduzca la URL del NutriDesafio</div>
                                                        </div>

                                                        <div>
                                                            <label for="status-field" class="form-label">Status</label>
                                                            <select class="form-control" data-choices data-choices-search-false name="status-field" id="status-field"  required>
                                                                <option value="">Status</option>
                                                                <option value="Active">Active</option>
                                                                <option value="Block">Block</option>
                                                                <option value="Próximamente">Próximamente</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success" id="add-btn">Add Customer</button>
                                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mt-2 text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                            <h4>¿Estas Seguro De Eliminar Este NutriDesafio?</h4>
                                                            <p class="text-muted mx-4 mb-0">No Se Podra Recuperar El NutriDesafio</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">No, Cerrar</button>
                                                        <button type="button" class="btn w-sm btn-danger " id="delete-record">Sí, Eliminar NutriDesafio!</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->
                                </div>
                            </div>

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
    
    <!-- JAVASCRIPT -->
         <!-- list.js min js -->
    <script src="../../assets/libs/list.js/list.min.js"></script>
    <script src="../../assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!--ecommerce-customer init js -->
    <script src="../../assets/js/pages/ecommerce-customer-list.init.js"></script>

    <!-- Sweet Alerts js -->
    <script src="../../assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <?php
        require_once("../html/js.php")
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    
</body>

</html>