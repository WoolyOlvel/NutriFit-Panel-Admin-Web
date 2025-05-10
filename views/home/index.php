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
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">¡Hola! Bienvenido,  <?php echo htmlspecialchars($_SESSION['nombre']); ?></h4>
                                                <p class="text-muted mb-0">¡Encantados de tenerte! Aquí están tus resúmenes. </p>
                                            </div>
                                            <div class="mt-3 mt-lg-0">
                                                <form action="javascript:void(0);">
                                                    <div class="row g-3 mb-0 align-items-center">
                                                        <!--end col-->
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i>
                                                                Añadir Plan Nutricional</button>
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
                                                            +10 %
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="35">0</span>
                                                        </h4>
                                                        <a href="" class="text-decoration-underline ">Ver Pacientes</a>
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
                                                            +3.57 %
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="50">0</span></h4>
                                                        <a href="" class="text-decoration-underline">Ver Citas</a>
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
                                                            +29.08 %
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="20">0</span>
                                                        </h4>
                                                        <a href="" class="text-decoration-underline">Ver Plan Alimentación</a>
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
                                                        <h5 class="text-muted fs-14 mb-0">
                                                            +2.00 %
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="10">0</span>
                                                        </h4>
                                                        <a href="" class="text-decoration-underline">Ver Chats</a>
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
                                                            <h5 class="mb-1"><span class="counter-value" data-target="7585">0</span></h5>
                                                            <p class="text-muted mb-0">Pacientes</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-4 col-lx-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1">$<span class="counter-value" data-target="22.89">0</span>k</h5>
                                                            <p class="text-muted mb-0">Ganancias</p>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-4 col-lx-3">
                                                        <div class="p-3 border border-dashed border-start-0">
                                                            <h5 class="mb-1"><span class="counter-value" data-target="367">0</span></h5>
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
                                                    <div class="dropdown card-header-dropdown">
                                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="fw-semibold text-uppercase fs-12">Sort by:
                                                            </span><span class="text-muted">Today<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Today</a>
                                                            <a class="dropdown-item" href="#">Yesterday</a>
                                                            <a class="dropdown-item" href="#">Last 7 Days</a>
                                                            <a class="dropdown-item" href="#">Last 30 Days</a>
                                                            <a class="dropdown-item" href="#">This Month</a>
                                                            <a class="dropdown-item" href="#">Last Month</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                            <img src="../../assets/images/products/img-1.png" alt="" class="img-fluid d-block" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-product-details.html" class="text-reset">Branded
                                                                                    T-Shirts</a></h5>
                                                                            <span class="text-muted">24 Apr 2021</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$29.00</h5>
                                                                    <span class="text-muted">Price</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">62</h5>
                                                                    <span class="text-muted">Orders</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">510</h5>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$1,798</h5>
                                                                    <span class="text-muted">Amount</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                            <img src="../../assets/images/products/img-2.png" alt="" class="img-fluid d-block" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-14 my-1"><a href="apps-ecommerce-product-details.html" class="text-reset">Bentwood
                                                                                    Chair</a></h5>
                                                                            <span class="text-muted">19 Mar 2021</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-13 my-1 fw-normal">$85.20</h5>
                                                                    <span class="text-muted">Price</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">35</h5>
                                                                    <span class="text-muted">Orders</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal"><span class="badge bg-danger-subtle text-danger">Out of
                                                                            stock</span> </h5>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$2982</h5>
                                                                    <span class="text-muted">Amount</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                            <img src="../../assets/images/products/img-3.png" alt="" class="img-fluid d-block" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-product-details.html" class="text-reset">Borosil Paper
                                                                                    Cup</a></h5>
                                                                            <span class="text-muted">01 Mar 2021</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$14.00</h5>
                                                                    <span class="text-muted">Price</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">80</h5>
                                                                    <span class="text-muted">Orders</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">749</h5>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$1120</h5>
                                                                    <span class="text-muted">Amount</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                            <img src="../../assets/images/products/img-4.png" alt="" class="img-fluid d-block" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-product-details.html" class="text-reset">One Seater
                                                                                    Sofa</a></h5>
                                                                            <span class="text-muted">11 Feb 2021</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$127.50</h5>
                                                                    <span class="text-muted">Price</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">56</h5>
                                                                    <span class="text-muted">Orders</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal"><span class="badge bg-danger-subtle text-danger">Out of
                                                                            stock</span></h5>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$7140</h5>
                                                                    <span class="text-muted">Amount</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                            <img src="../../assets/images/products/img-5.png" alt="" class="img-fluid d-block" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-product-details.html" class="text-reset">Stillbird
                                                                                    Helmet</a></h5>
                                                                            <span class="text-muted">17 Jan 2021</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$54</h5>
                                                                    <span class="text-muted">Price</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">74</h5>
                                                                    <span class="text-muted">Orders</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">805</h5>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-14 my-1 fw-normal">$3996</h5>
                                                                    <span class="text-muted">Amount</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                                    <div class="col-sm">
                                                        <div class="text-muted">
                                                            Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">25</span> Results
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-auto  mt-3 mt-sm-0">
                                                        <ul class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                                                            <li class="page-item disabled">
                                                                <a href="#" class="page-link">←</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a href="#" class="page-link">1</a>
                                                            </li>
                                                            <li class="page-item active">
                                                                <a href="#" class="page-link">2</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a href="#" class="page-link">3</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a href="#" class="page-link">→</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="card card-height-100">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Pacientes SubSecuentes</h4>
                                                <div class="flex-shrink-0">
                                                    <div class="dropdown card-header-dropdown">
                                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Download Report</a>
                                                            <a class="dropdown-item" href="#">Export</a>
                                                            <a class="dropdown-item" href="#">Import</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/companies/img-1.png" alt="" class="avatar-sm p-2" />
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-seller-details.html" class="text-reset">iTest Factory</a>
                                                                            </h5>
                                                                            <span class="text-muted">Oliver Tyler</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">Bags and Wallets</span>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0">8547</p>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">$541200</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-13 fw-semibold mb-0">32%<i class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                                    </h5>
                                                                </td>
                                                            </tr><!-- end -->
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/companies/img-2.png" alt="" class="avatar-sm p-2" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-seller-details.html" class="text-reset">Digitech
                                                                                    Galaxy</a></h5>
                                                                            <span class="text-muted">John Roberts</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">Watches</span>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0">895</p>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">$75030</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-13 fw-semibold mb-0">79%<i class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                                    </h5>
                                                                </td>
                                                            </tr><!-- end -->
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/companies/img-3.png" alt="" class="avatar-sm p-2" />
                                                                        </div>
                                                                        <div class="flex-gow-1">
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-seller-details.html" class="text-reset">Nesta
                                                                                    Technologies</a></h5>
                                                                            <span class="text-muted">Harley
                                                                                Fuller</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">Bike Accessories</span>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0">3470</p>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">$45600</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-13 fw-semibold mb-0">90%<i class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                                    </h5>
                                                                </td>
                                                            </tr><!-- end -->
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/companies/img-8.png" alt="" class="avatar-sm p-2" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-seller-details.html" class="text-reset">Zoetic
                                                                                    Fashion</a></h5>
                                                                            <span class="text-muted">James Bowen</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">Clothes</span>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0">5488</p>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">$29456</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-13 fw-semibold mb-0">40%<i class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                                    </h5>
                                                                </td>
                                                            </tr><!-- end -->
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/companies/img-5.png" alt="" class="avatar-sm p-2" />
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="fs-13 my-1"><a href="apps-ecommerce-seller-details.html" class="text-reset">Meta4Systems</a>
                                                                            </h5>
                                                                            <span class="text-muted">Zoe Dennis</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">Furniture</span>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0">4100</p>
                                                                    <span class="text-muted">Stock</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-muted">$11260</span>
                                                                </td>
                                                                <td>
                                                                    <h5 class="fs-13 fw-semibold mb-0">57%<i class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                                    </h5>
                                                                </td>
                                                            </tr><!-- end -->
                                                        </tbody>
                                                    </table><!-- end table -->
                                                </div>

                                                <div class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                                    <div class="col-sm">
                                                        <div class="text-muted">
                                                            Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">25</span> Results
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-auto  mt-3 mt-sm-0">
                                                        <ul class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                                                            <li class="page-item disabled">
                                                                <a href="#" class="page-link">←</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a href="#" class="page-link">1</a>
                                                            </li>
                                                            <li class="page-item active">
                                                                <a href="#" class="page-link">2</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a href="#" class="page-link">3</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a href="#" class="page-link">→</a>
                                                            </li>
                                                        </ul>
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
                                                <div class="flex-shrink-0">
                                                    <div class="dropdown card-header-dropdown">
                                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted">Obtener<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Descargar Reporte</a>
                                                            <a class="dropdown-item" href="#">Exportar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div id="store-visits-source" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div> <!-- .card-->
                                    </div> <!-- .col-->

                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Porcentaje Por Enfermedad</h4>
                                                <div class="flex-shrink-0">
                                                    <div class="dropdown card-header-dropdown">
                                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted">Obtener<i class="mdi mdi-chevron-down ms-1"></i></span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Descargar Reporte</a>
                                                            <a class="dropdown-item" href="#">Exportar</a>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <h4 class="card-title mb-0 flex-grow-1">Pacientes Recientes</h4>
                                                <div class="flex-shrink-0">
                                                    <button type="button" class="btn btn-soft-info btn-sm">
                                                        <i class="ri-file-list-3-line align-middle"></i> Descargar Reporte
                                                    </button>
                                                </div>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Paciente</th>
                                                                <th scope="col">Motivo</th>
                                                                <th scope="col">Pagado</th>
                                                                <th scope="col">Atendió</th>
                                                                <th scope="col">Metodo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2112</a>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/users/avatar-1.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                        </div>
                                                                        <div class="flex-grow-1">Alex Smith</div>
                                                                    </div>
                                                                </td>
                                                                <td>Clothes</td>
                                                                <td>
                                                                    <span class="text-success">$109.00</span>
                                                                </td>
                                                                <td>Zoetic Fashion</td>
                                                                <td>
                                                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                                                </td>

                                                            </tr><!-- end tr -->
                                                            <tr>
                                                                <td>
                                                                    <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2111</a>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                        </div>
                                                                        <div class="flex-grow-1">Jansh Brown</div>
                                                                    </div>
                                                                </td>
                                                                <td>Kitchen Storage</td>
                                                                <td>
                                                                    <span class="text-success">$149.00</span>
                                                                </td>
                                                                <td>Micro Design</td>
                                                                <td>
                                                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                                </td>

                                                            </tr><!-- end tr -->
                                                            <tr>
                                                                <td>
                                                                    <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2109</a>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/users/avatar-3.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                        </div>
                                                                        <div class="flex-grow-1">Ayaan Bowen</div>
                                                                    </div>
                                                                </td>
                                                                <td>Bike Accessories</td>
                                                                <td>
                                                                    <span class="text-success">$215.00</span>
                                                                </td>
                                                                <td>Nesta Technologies</td>
                                                                <td>
                                                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                                                </td>
                                                            </tr><!-- end tr -->
                                                            <tr>
                                                                <td>
                                                                    <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2108</a>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/users/avatar-4.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                        </div>
                                                                        <div class="flex-grow-1">Prezy Mark</div>
                                                                    </div>
                                                                </td>
                                                                <td>Furniture</td>
                                                                <td>
                                                                    <span class="text-success">$199.00</span>
                                                                </td>
                                                                <td>Syntyce Solutions</td>
                                                                <td>
                                                                    <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                                                </td>

                                                            </tr><!-- end tr -->
                                                            <tr>
                                                                <td>
                                                                    <a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2107</a>
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-2">
                                                                            <img src="../../assets/images/users/avatar-6.jpg" alt="" class="avatar-xs rounded-circle" />
                                                                        </div>
                                                                        <div class="flex-grow-1">Vihan Hudda</div>
                                                                    </div>
                                                                </td>
                                                                <td>Bags and Wallets</td>
                                                                <td>
                                                                    <span class="text-success">$330.00</span>
                                                                </td>
                                                                <td>iTest Factory</td>
                                                                <td>
                                                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                                                </td>

                                                            </tr><!-- end tr -->
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

    <!-- apexcharts -->
    <script src="../../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- piecharts init -->
    <script src="../../assets/js/pages/apexcharts-pie.init.js"></script>
    

</body>

</html>