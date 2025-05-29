<?php
    
    require_once("../html/session.php");
?>

<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dashboard | NutriFit Planner</title>

    <?php
    require_once("../html/head.php")

    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">


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
                                <h4 class="mb-sm-0">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1"> <!--Aqui en el h4 class="fs-16 mb-1 El nombre y apellidos del user apartir de la tabla ajustes"-->
                                                <h4 class="fs-16 mb-1" id="welcome-message">  </h4>
                                                <p class="text-muted mb-0">¡Qué bueno verte por aquí! Estos son tus resúmenes más recientes.</p>
                                            </div>
                                            <div class="mt-3 mt-lg-0">
                                                <form action="javascript:void(0);">
                                                    <div class="row g-3 mb-0 align-items-center">
                                                        <!--end col-->
                                                        <div class="col-auto">
                                                            <a href="../misPacientes/misPacientes.php" type="button" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Añadir Plan Nutricional</a>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-pulse-line"></i></button>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
                                                </form>
                                            </div>
                                        </div><!-- end card header -->
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                                <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Total De Pacientes</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                            
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="">0</span>
                                                        </h4>
                                                        <a href="../misPacientes/misPacientes.php" class="text-decoration-underline ">Ver Pacientes</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0" style="margin-bottom: 2rem; margin-right: 2rem;">
                                                        <span class="bg-soft-success rounded fs-3">
                                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                            <lord-icon
                                                                src="https://cdn.lordicon.com/umvndfds.json"
                                                                trigger="loop"
                                                                delay="2000"
                                                                stroke="bold"
                                                                style="width:75px;height:75px">
                                                            </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Total De Citas</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-danger fs-14 mb-0">
                                                            <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                            
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="">0</span></h4>
                                                        <a href="../citaAgendadas/calendarioCitas.php" class="text-decoration-underline">Ver Citas</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0" style="margin-bottom: 2rem; margin-right: 2rem;">
                                                        <span class="bg-soft-success rounded fs-3">
                                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                            <lord-icon
                                                                src="https://cdn.lordicon.com/pyikvtsx.json"
                                                                trigger="loop"
                                                                delay="2000"
                                                                stroke="bold"
                                                                style="width:75px;height:75px">
                                                            </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Planes De Alimentacion</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0">
                                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                            
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="">0</span>
                                                        </h4>
                                                        <a href="../misPacientes/misPacientes.php" class="text-decoration-underline">Ver Plan Alimentación</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0" style="margin-bottom: 2rem; margin-right: 2rem;">
                                                        <span class="bg-soft-success rounded fs-3">
                                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                            <lord-icon
                                                                src="https://cdn.lordicon.com/uiirxzyt.json"
                                                                trigger="loop"
                                                                delay="2000"
                                                                stroke="bold"
                                                                style="width:75px;height:75px">
                                                            </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                    <div class="col-xl-3 col-md-6">
                                        <!-- card -->
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Chats Pendientes</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                      <!---  <h5 class="text-muted fs-14 mb-0">
                                                           
                                                        </h5>-->
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="">0</span>
                                                        </h4>
                                                        <a href="#" id="chat-link" class="text-decoration-underline">Ver Chats</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0" style="margin-bottom: 2rem; margin-right: 2rem;">
                                                        <span class="bg-soft-success rounded fs-3">
                                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                                            <lord-icon
                                                                src="https://cdn.lordicon.com/uhosdden.json"
                                                                trigger="loop"
                                                                delay="2000"
                                                                stroke="bold"
                                                                style="width:75px;height: 75px;">
                                                            </lord-icon>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header border-0 align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Resumen</h4>
                                                <div>
                                                    <button type="button" class="btn btn-soft-dark btn-sm">
                                                        Todos
                                                    </button>
                                                    <button type="button" class="btn btn-soft-dark btn-sm">
                                                        1M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-dark btn-sm">
                                                        6M
                                                    </button>
                                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                                        1Y
                                                    </button>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-header p-0 border-0 bg-light-subtle">
                                                <div class="row g-0 text-center">
                                                    <div class="col-4 col-lx-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="">0</span></h5>
                                                            <p class="text-muted mb-0">Pacientes</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-4 col-lx-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="">0</span></h5>
                                                            <p class="text-muted mb-0">Ganancias</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-4 col-lx-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="">0</span></h5>
                                                            <p class="text-muted mb-0">Pérdidas</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body p-0 pb-2">
                                                <div class="w-100">
                                                    <div id="customer_impression_charts" data-colors='["--vz-success", "--vz-info", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->

                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Pacientes Nuevos</h4>
                                                <div class="flex-shrink-0">
                                                
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                     
                                                </div>

                                                <div class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                                    <div class="col-sm">
                                                        <div class="text-muted">
                                                            Mostrando Los <span class="fw-semibold">5</span> De <span class="fw-semibold">5</span> Pacientes Más Recientes
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Pacientes SubSecuentes</h4>
                                             
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-centered table-hover align-middle table-nowrap mb-0" id="pacienteSubsecuente">
                                                        <tbody>

                                                        </tbody>
                                                    </table><!-- end table -->
                                                </div>

                                                <div class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                                    <div class="col-sm">
                                                        <div class="text-muted">
                                                            Mostrando  <span class="fw-semibold">Los Pacientes</span> Subsecuentes Recientes <span class="fw-semibold"></span> 
                                                        </div>
                                                    </div>
                                                   

                                                    
                                                </div>

                                            </div> <!-- .card-body-->
                                        </div> <!-- .card-->
                                    </div> <!-- .col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Porcentaje Por Rango De Edad</h4>
                                                <div class="flex-shrink-0"></div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div id="store-visits-source" 
                                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' 
                                                    class="apex-charts" 
                                                    dir="ltr"></div>
                                            </div>
                                        </div> <!-- .card-->
                                    </div> <!-- .col-->

                                    <div class="col-xl-6">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Porcentaje Por Enfermedad</h4>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div id="simple_pie_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div>
                                    <!-- end col -->

                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Pacientes Recientes Consultados</h4>
                                            
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0" id="consultaRecientes">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                
                                                                <th scope="col">Paciente</th>
                                                                <th scope="col">Consultorio</th>
                                                                <th scope="col">Pagado</th>
                                                                <th scope="col">Atendió</th>
                                                                <th scope="col">Tipo Consulta</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody><!-- end tbody -->
                                                    </table><!-- end table -->
                                                </div>
                                            </div>
                                        </div> <!-- .card-->
                                    </div> <!-- .col-->
                                </div> <!-- end row-->

                            </div> <!-- end .h-100-->

                        </div> <!-- end col -->

                        <div class="col-auto layout-rightside-col">
                            <div class="overlay"></div>
                            <div class="layout-rightside">
                                <div class="card h-100 rounded-0">
                                    <div class="card-body p-0">
                                        <div class="p-3">
                                            <h6 class="text-muted mb-0 text-uppercase">Actividades Recientes</h6>
                                        </div>
                                        <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                                            <div class="acitivity-timeline acitivity-main">
                                                <div class="acitivity-item d-flex">
                                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                        <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                            <i class="ri-shopping-cart-2-line"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-1 lh-base">Purchase by James Price</h6>
                                                        <p class="text-muted mb-1">Product noise evolve smartwatch </p>
                                                        <small class="mb-0 text-muted">02:14 PM Today</small>
                                                    </div>
                                                </div>
                                                <div class="acitivity-item py-3 d-flex">
                                                    <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                        <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                            <i class="ri-stack-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="mb-1 lh-base">Added new <span class="fw-semibold">style collection</span></h6>
                                                        <p class="text-muted mb-1">By Nesta Technologies</p>
                                                        <div class="d-inline-flex gap-2 border border-dashed p-2 mb-2">
                                                            <a href="apps-ecommerce-product-details.html" class="bg-light rounded p-1">
                                                                <img src="../../assets/images/products/img-8.png" alt="" class="img-fluid d-block" />
                                                            </a>
                                                            <a href="apps-ecommerce-product-details.html" class="bg-light rounded p-1">
                                                                <img src="../../assets/images/products/img-2.png" alt="" class="img-fluid d-block" />
                                                            </a>
                                                            <a href="apps-ecommerce-product-details.html" class="bg-light rounded p-1">
                                                                <img src="../../assets/images/products/img-10.png" alt="" class="img-fluid d-block" />
                                                            </a>
                                                        </div>
                                                        <p class="mb-0 text-muted"><small>9:47 PM Yesterday</small></p>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>

                                        <div class="p-3">
                                            <h6 class="text-muted mb-3 text-uppercase">Reviews De Tus Pacientes</h6>
                                            <!-- Swiper -->
                                            <div class="swiper vertical-swiper" style="height: 250px;">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <div class="card border border-dashed shadow-none">
                                                            <div class="card-body">
                                                                <div class="d-flex">
                                                                    <div class="flex-shrink-0 avatar-sm">
                                                                        <div class="avatar-title bg-light rounded">
                                                                            <img src="../../assets/images/companies/img-1.png" alt="" height="30">
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <div>
                                                                            <p class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                                " Great product and looks great, lots of
                                                                                features. "</p>
                                                                            <div class="fs-11 align-middle text-warning">
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-end mb-0 text-muted">
                                                                            - by <cite title="Source Title">Force
                                                                                Medicines</cite>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <div class="card border border-dashed shadow-none">
                                                            <div class="card-body">
                                                                <div class="d-flex">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="../../assets/images/users/avatar-3.jpg" alt="" class="avatar-sm rounded">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <div>
                                                                            <p class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                                " Amazing template, very easy to
                                                                                understand and manipulate. "</p>
                                                                            <div class="fs-11 align-middle text-warning">
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-fill"></i>
                                                                                <i class="ri-star-half-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-end mb-0 text-muted">
                                                                            - by <cite title="Source Title">Henry
                                                                                Baird</cite>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-3">
                                            <h6 class="text-muted mb-3 text-uppercase">Tú Calificación</h6>
                                            <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <div class="fs-16 align-middle text-warning">
                                                            <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i>
                                                            <i class="ri-star-fill"></i>
                                                            <i class="ri-star-half-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h6 class="mb-0">4.5 out of 5</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-muted">Total <span class="fw-medium">5.50k</span>
                                                    reviews</div>
                                            </div>

                                            <div class="mt-3">
                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0">5 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-1">
                                                            <div class="progress animated-progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 50.16%" aria-valuenow="50.16" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0 text-muted">2758</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0">4 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-1">
                                                            <div class="progress animated-progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 29.32%" aria-valuenow="29.32" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0 text-muted">1063</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0">3 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-1">
                                                            <div class="progress animated-progress progress-sm">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 18.12%" aria-valuenow="18.12" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0 text-muted">997</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0">2 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-1">
                                                            <div class="progress animated-progress progress-sm">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 4.98%" aria-valuenow="4.98" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0 text-muted">227</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end row -->

                                                <div class="row align-items-center g-2">
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0">1 star</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="p-1">
                                                            <div class="progress animated-progress progress-sm">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 7.42%" aria-valuenow="7.42" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="p-1">
                                                            <h6 class="mb-0 text-muted">408</h6>
                                                        </div>
                                                    </div>
                                                </div><!-- end row -->
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end .rightbar-->

                        </div> <!-- end col -->
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
    require_once("../html/js.php")
    ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- apexcharts -->
    <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- piecharts init -->
    
    <script src="index.js" type="text/javascript"></script>
       
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>

    <script src="../../assets/js/pages/apexcharts-pie.init.js"></script>

    <script src="../../assets/js/pages/dashboard-ecommerce.init.js"></script>

</body>

</html>