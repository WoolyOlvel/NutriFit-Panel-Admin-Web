<?php
require_once("../html/session.php");
?>

<style>
    /* Agrega esto a tu archivo CSS */
.skeleton {
  background-color: #e0e0e0;
  border-radius: 4px;
  position: relative;
  overflow: hidden;
}

.skeleton::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.skeleton-text {
  width: 100%;
  height: 1em;
  margin-bottom: 0.5em;
}

.skeleton-text:last-child {
  margin-bottom: 0;
  width: 80%;
}

.skeleton-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

.skeleton-rect {
  width: 100%;
  height: 150px;
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
</style>

<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Historial Paciente | NutriFit Planner</title>

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

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-6">Historial Paciente</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="./informacionConsulta.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Paciente</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mt-n4 mx-n4">
                                <div class="bg-success-subtle">
                                    <div class="card-body pb-0 px-4">
                                        <div class="row mb-3">
                                            <div class="col-md">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-md-auto">
                                                        <div class="avatar-md">
                                                            <div class="avatar-title bg-white rounded-circle"><!--Obtener de la tabla consulta el Paciente_ID y acceder a la tabla paciente y obtener la foto (que es una url) en caso que sea null mostrar el user-dummy-img.jpg apartir de la consulta.js-->
                                                                <img name="foto" id="foto" src="../../assets/images/users/user-dummy-img.jpg" alt="" class="img-thumbnail rounded-circle avatar-md">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div>
                                                            <h4 class="fw-bold" id="nombre_paciente"></h4><!--Obtener de la tabla consulta el nombre_paciente y apellidos del paciente de acuerdo a la consulta_id, y acceder a la tabla paciente apartir del Paciente_ID y obtener la edad y ponerlo luego del "," 24 años (por ejemplo)-->
                                                            <div class="hstack gap-3 flex-wrap">
                                                                <div id="localidad"><i class="ri-building-line align-bottom me-1"></i> </div><!--Obtener de la tabla consulta la localidad y concatenar la ciudad a base de la consulta_id-->
                                                                <div class="vr"></div>
                                                                <div id="fecha_creacion">Creado El: <span class="fw-medium"></span></div><!--Obtener de la tabla consulta la fecha_creacion de la consulta apartir de la consulta_id-->
                                                                <div class="vr"></div>
                                                                <div id="updated_at">Ultima Actualización : <span class="fw-medium"></span></div><!--Obtener de la tabla consulta el updated_at (esto lo mostrara como hace 34 minutos o hace un 1 dia) apartir de la consulta _id-->
                                                                <div class="vr"></div>
                                                                <div name="status" class="badge rounded-pill bg-success fs-12"></div><!--Obtener de la tabla consulta el Paciente_ID apartir de eso acceder a la tabla paciente y obtener el status (1 es activo y 0 inactivo, cuando es activo mostrar el bg-success en 0 bg-danger-->
                                                                <div id="genero" class="badge rounded-pill bg-secondary fs-12"></div><!--Obtener el Paciente_ID apartir de la consulta_id y acceder a la tabla paciente y obtener el genero, si es femenino bg-secondary masculino poner bg-primary-->
                                                                <div id="fecha_nacimiento" class="badge rounded-pill bg-dark fs-12"></div><!--Obtener de la tabla consulta la fecha_nacimiento apartir de la consulta_id y deL Paciente_ID (la fecha_nacimiento debe ser formateada y mostrarlo asi:6 De Mayo Del 2003, antes de fecha_nacimiento concatenar en js el Fecha De Nacimiento: fecha_nacimiento -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link text-body active fw-semibold" data-bs-toggle="tab" href="#project-overview" role="tab">
                                                    Detalles Historial Paciente
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- end card body -->
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tab-content text-muted">
                                <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="text-muted">
                                                        <h5 class="mb-4 text-uppercase">Diagnostico</h5>
                                                        <h6 class="mb-3 text-uppercase">Detalles Del Diagnostico:</h6>
                                                        <div class="ckeditor-classic" id="detalles_diagnostico">

                                                        </div>
                                                       

                                                        </ul>

                                                        <h6 class="mb-3 text-uppercase">Resultados De La Evaluación:</h6>
                                                        <div class="ckeditor-classic" id="resultados_evaluacion">

                                                        </div>

                                                        <h6 class="mb-3 text-uppercase">Analisis Nutricional:</h6>
                                                        <div class="ckeditor-classic" id="analisis_nutricional">

                                                        </div>

                                                        <div class="flex-shrink-0">
                                                        </div>

                                                        <h5 class="mb-4 text-uppercase">Objetivo</h5>
                                                        <h6 class="mb-3 text-uppercase">Descripcion Del Objetivo:</h6>
                                                        <div class="ckeditor-classic" id="objetivo_descripcion">

                                                        </div>


                                                        <div class="pt-3 border-top border-top-dashed mt-4">
                                                            <div class="row gy-3">
                                                                <div>
                                                                    <h3 class="btn btn-link link-success p-0">Evaluación Antropométrica</h3>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Peso:</p>
                                                                        <div id="peso" class="badge bg-dark-subtle text-body badge-border  fs-11"></div><!--Obtener de la tabla consulta el peso (asi: 55 Kg, Kg debe ser cocatenado en js) apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Talla:</p>
                                                                        <div id="talla" class="badge bg-dark-subtle text-body badge-border fs-11"></div><!--Obtener de la tabla consulta la talla apartir de la consulta_id-->
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Medida Cintura:</p>
                                                                        <div id="cintura" class="badge bg-dark-subtle text-body badge-border  fs-11"></div><!--Obtener de la tabla consulta la cintura (asi:95 Cm, Cm debe ser cocatenado en js) apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Medida Cadera:</p>
                                                                        <div id="cadera" class="badge bg-dark-subtle text-body badge-border fs-11"></div><!--Obtener de la tabla consulta la cadera  (asi:95 Cm, Cm debe ser cocatenado en js)  apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Grasa Corporal:</p>
                                                                        <div id="gc" class="badge bg-dark-subtle text-body badge-border fs-11"></div><!--Obtener de la tabla consulta la gc  (asi:95 %, % debe ser cocatenado en js)  apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Masa Muscular:</p>
                                                                        <div id="mm" class="badge bg-dark-subtle text-body badge-border fs-11"></div><!--Obtener de la tabla consulta la mm  (asi:95 %, % debe ser cocatenado en js)  apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Edad Metabolica:</p>
                                                                        <div id="em" class="badge bg-dark-subtle text-body badge-border fs-11"></div><!--Obtener de la tabla consulta la em  (asi:95 años, años debe ser cocatenado en js)  apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Altura:</p>
                                                                        <div id="altura" class="badge bg-dark-subtle text-body badge-border fs-11"></div><!--Obtener de la tabla consulta la altura  (asi:1.60 m, m debe ser cocatenado en js)  apartir de la consulta_id-->
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <h3 class="btn btn-link link-success p-0">Información Adicional</h3>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Tipo De Consulta :</p>
                                                                        <div id="Tipo_Consulta_ID" class="badge bg-primary fs-11"></div> <!--Obtener de la tabla consulta el Tipo_Consulta_ID y acceder a la table tipo_consulta y obtener el Nombre -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Tipo De Pago :</p>
                                                                        <div id="Pago_ID" class="badge bg-primary fs-11"></div> <!--Obtener de la tabla consulta el Pago_ID y acceder a la tabla pago y obtener el nombre -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Tipo De Divisa :</p>
                                                                        <div id="Divisa_ID" class="badge bg-primary fs-11"></div> <!--Obtener de la tabla consulta el Divisa_ID y acceder a la tabla divisas y obtener el nombre -->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Total Pagado :</p>
                                                                        <div id="total_pago" class="badge bg-success fs-11"></div> <!--Obtener de la tabla consulta el total_pago (concatenar el "$" antes del total_pago)-->
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Atendido En Consultorio:</p>
                                                                        <h5 id="nombre_consultorio" class="fs-14 mb-0" style="text-align:justify;"></h5><!--Obtener de la tabla consulta la nombre_consultorio-->
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Proxima Consulta :</p>
                                                                        <h5 id="proxima_consulta" class="fs-14 mb-0"></h5><!--Obtener de la tabla consulta la proxima_consulta se debe mostrar asi: Mayo, 6, 2025, 11:30 AM-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-6">
                                                                    <div>
                                                                        <p class="mb-2 text-uppercase fw-medium">Estado Consulta :</p>
                                                                        <div id="estado_proximaConsulta" class="badge bg-warning fs-11"></div><!--obtener de la tabla consulta el estado_proximaConsulta (0 = Cancelado poner el bg-danger, 1 = En Progreso poner el bg-success, 2 = ProximaConsulta  poner el bg-warning, 3 = Realizado (terminado) poner el bg-dark) apartir de la consulta_id--->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                            </div>
                                            <!-- end card -->


                                            <!-- end card -->
                                        </div>
                                        <!-- ene col -->
                                        <div class="col-xl-3 col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-4">Patologías Registradas</h5><!--Obtener de la tabla consulta la enferemedad apartir de la consulta_id y mostrarlo en este caso con los badge -->
                                                    <div class="d-flex flex-wrap gap-2 fs-16">
                                                        <div id="enfermedad" class="badge fw-15 bg-danger-subtle text-danger"></div>

                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                            </div>

                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-4">Nutriologo Asignado</h5><!--Obtener de la tabla consulta la nombre_nutriologo apartir de la consulta_id y mostrarlo en este caso con los badge -->
                                                    <div class="d-flex flex-wrap gap-2 fs-16">
                                                        <div id="nombre_nutriologo" class="badge fw-15 bg-success-subtle text-success"></div>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                            </div>
                                            <!-- end card -->
                                            <div class="card">
                                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                                    <h4 class="card-title mb-0 flex-grow-1">Plan Alimenticio</h4> <!--En esta seccion obtener de la tabla consulta el plan_nutricional_path y mostrar el nombre del o los archivos, en caso que sea mayor a un archivo, solo mostrar un englobado y poder descargar todos los archivos en .zip (en caso que sea  mas de un archivo, sino normal) con el boton descargar y apartir del consulta_id -->
                                                </div>
                                                <div class="card-body">
                                                    <div class="vstack gap-2">
                                                        <div class="border rounded border-dashed p-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar-sm">
                                                                        <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                                            <i class="ri-folder-zip-line"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block"></a></h5>
                                                                    <div></div>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-2">
                                                                    <div class="d-flex gap-1">
                                                                        <button  id="plan_nutricional_path" name="descargar"  type="button" class="btn btn-icon text-muted btn-sm fs-18"><i class="ri-download-2-line"></i></button>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-icon text-muted btn-sm fs-18 dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end tab pane -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
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

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

    <!-- list.js min js -->
    <script src="../../assets/libs/list.js/list.min.js"></script>
    <?php
    require_once("../html/js.php")
    ?>
    <!-- En el head de tu HTML -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script src="../../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <script type="text/javascript" src="historial.js"></script>

</body>

</html>