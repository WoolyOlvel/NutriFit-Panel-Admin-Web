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
                                                <input type="text" class="form-control search" placeholder="Buscar Paciente...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-auto ms-auto">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="text-muted">Ordenar por: </span>
                                                <select class="form-control mb-0" data-choices data-choices-search-false id="choices-single-default">
                                                    <option value="Owner">Recientes</option>
                                                    <option value="Company">Nombre</option>
                                                    <option value="location">Apellidos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="table-responsive table-card mb-3">
                                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
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
                                                    <tr>
                                                        
                                                        <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ001</a>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="../../assets/images/brands/dribbble.png" alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 name">Alcrya
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="owner">Lumina</td>
                                                        <td class="industry_type">Femenino</td>
                                                        <td>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                    <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                        <lord-icon
                                                                            src="https://cdn.lordicon.com/vwzukuhn.json"
                                                                            trigger="loop"
                                                                            delay="2000"
                                                                            stroke="bold"
                                                                            colors="primary:#ffffff,secondary:#3a3347,tertiary:#ffc738,quaternary:#ebe6ef"
                                                                            style="width:36px;height:36px">
                                                                        </lord-icon></a>
                                                            </li>
                                                        </td>
                                                        <td class="location">   <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                                                    <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
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

                                                        </td>

                                                      
                                                        <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                        
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                                    <a href="javascript:void(0);" class="view-item-btn"><script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                    <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                    <lord-icon
                                                                        src="https://cdn.lordicon.com/jpywfkmi.json"
                                                                        trigger="loop"
                                                                        delay="2000"
                                                                        stroke="bold"
                                                                        colors="primary:#000000,secondary:#f9c9c0,tertiary:#e4e4e4,quaternary:#f28ba8"
                                                                        style="width:36px;height:36px">
                                                                    </lord-icon></a>
                                                                </li>
                                                               
                                                            </ul>
                                                        </td>

                                                        <td>
                                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                    <a class="edit-item-btn" href="../Pacientes/index.php"><script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                                        <lord-icon
                                                                            src="https://cdn.lordicon.com/cvcslrjt.json"
                                                                            trigger="loop"
                                                                            delay="2000"
                                                                            stroke="bold"
                                                                            colors="primary:#000000,secondary:#66a1ee,tertiary:#ffc738,quaternary:#e4e4e4"
                                                                            style="width:36px;height: 36px;">
                                                                        </lord-icon></a>
                                                            </li>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                    </lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    <p class="text-muted mb-0">We've searched more than 150+ companies
                                                        We did not find any
                                                        companies for you search.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <div class="pagination-wrap hstack gap-2">
                                                <a class="page-item pagination-prev disabled" href="#">
                                                    Previous
                                                </a>
                                                <ul class="pagination listjs-pagination mb-0"></ul>
                                                <a class="page-item pagination-next" href="#">
                                                    Next
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-info-subtle p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" autocomplete="off">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="id-field" />
                                                        <div class="row g-3">
                                                            <div class="col-lg-12">
                                                                <div class="text-center">
                                                                    <div class="position-relative d-inline-block">
                                                                        <div class="position-absolute bottom-0 end-0">
                                                                            <label for="company-logo-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                                                                <div class="avatar-xs cursor-pointer">
                                                                                    <div class="avatar-title bg-light border rounded-circle text-muted">
                                                                                        <i class="ri-image-fill"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </label>
                                                                            <input class="form-control d-none" value="" id="company-logo-input" type="file" accept="image/png, image/gif, image/jpeg">
                                                                        </div>
                                                                        <div class="avatar-lg p-1">
                                                                            <div class="avatar-title bg-light rounded-circle">
                                                                                <img src="../../assets/images/users/multi-user.jpg" id="companylogo-img" class="avatar-md rounded-circle object-fit-cover" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="fs-13 mt-3">Company Logo</h5>
                                                                </div>
                                                                <div>
                                                                    <label for="companyname-field" class="form-label">Name</label>
                                                                    <input type="text" id="companyname-field" class="form-control" placeholder="Enter company name" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div>
                                                                    <label for="owner-field" class="form-label">Owner Name</label>
                                                                    <input type="text" id="owner-field" class="form-control" placeholder="Enter owner name" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div>
                                                                    <label for="industry_type-field" class="form-label">Industry Type</label>
                                                                    <select class="form-select" id="industry_type-field">
                                                                        <option value="">Select industry type</option>
                                                                        <option value="Computer Industry">Computer Industry</option>
                                                                        <option value="Chemical Industries">Chemical Industries</option>
                                                                        <option value="Health Services">Health Services</option>
                                                                        <option value="Telecommunications Services">Telecommunications Services</option>
                                                                        <option value="Textiles: Clothing, Footwear">Textiles: Clothing, Footwear</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div>
                                                                    <label for="star_value-field" class="form-label">Rating</label>
                                                                    <input type="text" id="star_value-field" class="form-control" placeholder="Enter rating" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div>
                                                                    <label for="location-field" class="form-label">Location</label>
                                                                    <input type="text" id="location-field" class="form-control" placeholder="Enter location" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div>
                                                                    <label for="employee-field" class="form-label">Employee</label>
                                                                    <input type="text" id="employee-field" class="form-control" placeholder="Enter employee" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div>
                                                                    <label for="website-field" class="form-label">Website</label>
                                                                    <input type="text" id="website-field" class="form-control" placeholder="Enter website" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div>
                                                                    <label for="contact_email-field" class="form-label">Contact Email</label>
                                                                    <input type="text" id="contact_email-field" class="form-control" placeholder="Enter contact email" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div>
                                                                    <label for="since-field" class="form-label">Since</label>
                                                                    <input type="text" id="since-field" class="form-control" placeholder="Enter since" required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success" id="add-btn">Add Company</button>
                                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                                                        <h4 class="fs-semibold">You are about to delete a company ?</h4>
                                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting your company will
                                                            remove all of your information from our database.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                                Close</button>
                                                            <button class="btn btn-danger" id="delete-record">Yes,
                                                                Delete It!!</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete modal -->

                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3">
                            <div class="card" id="company-view-detail">
                                <div class="card-body text-center">
                                    <div class="position-relative d-inline-block">
                                        <div class="avatar-md">
                                            <div class="avatar-title bg-light rounded-circle">
                                                <img src="../../assets/images/brands/mail_chimp.png" alt="" class="avatar-sm rounded-circle object-fit-cover">
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mt-3 mb-1">Syntyce Solution</h5>
                                    <p class="text-muted">Michael Morris</p>

                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-success-subtle text-success fs-15 rounded">
                                                <i class="ri-global-line"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                                <i class="ri-mail-line"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item avatar-xs">
                                            <a href="javascript:void(0);" class="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                                <i class="ri-question-answer-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Information</h6>
                                    <p class="text-muted mb-4">A company incurs fixed and variable costs such as the
                                        purchase of raw materials, salaries and overhead, as explained by
                                        AccountingTools, Inc. Business owners have the discretion to determine the
                                        actions.</p>
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Industry Type</td>
                                                    <td>Chemical Industries</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Location</td>
                                                    <td>Damascus, Syria</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Employee</td>
                                                    <td>10-50</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Rating</td>
                                                    <td>4.0 <i class="ri-star-fill text-warning align-bottom"></i></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Website</td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="link-primary text-decoration-underline">www.syntycesolution.com</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Contact Email</td>
                                                    <td>info@syntycesolution.com</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Since</td>
                                                    <td>1995</td>
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


    <!-- list.js min js -->
    <script src="../../assets/libs/list.js/list.min.js"></script>
    <script src="../../assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="../../assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="../../assets/js/pages/crm-companies.init.js"></script>
    <!-- JAVASCRIPT -->
    <?php
        require_once("../html/js.php")
    ?>

    

</body>

</html>