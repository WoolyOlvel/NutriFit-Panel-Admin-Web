<?php
require_once("../html/session.php");
?>

<style>
    .editable-field {
    background-color: #fffde7; /* Fondo amarillo claro */
    border: 1px solid #ffd600; /* Borde amarillo */
}
</style>
<!doctype html>
<html lang="es" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Consulta | NutriFit Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
    <?php
    require_once("../html/head.php");
    ?>

    <link href="../../assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css">
    <!--<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- One of the following themes -->
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/classic.min.css" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/monolith.min.css" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/nano.min.css" /> <!-- 'nano' theme -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                    <form id="formConsulta" method="POST" enctype="multipart/form-data">
                        <!--  TODO:ID DE Consulta -->
                        <input type="hidden" name="Consulta_ID" id="Consulta_ID" />
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Actualizar Consulta</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="./actualizarConsulta.php">Menu</a></li>
                                            <li class="breadcrumb-item active">Actualizar Consulta</li>
                                        </ol>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Informacion Consulta</h4>
                                        <div class="flex-shrink-0">
                                        </div>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="live-preview">
                                            <div class="row align-items-center g-6">
                                                <div class="col-lg-4">
                                                    <label for="Tipo_Consulta_ID" class="form-label">Tipo Consulta:</label>
                                                    <select id="Tipo_Consulta_ID" name="Tipo_Consulta_ID" class="form-control form-select" aria-label="Seleccionar Tipo Consulta">
                                                        <option selected disabled>Seleccionar </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="Documento_ID" class="form-label">Documento:</label>
                                                    <select id="Documento_ID" name="Documento_ID" class="form-control form-select" aria-label="Seleccionar Documento">
                                                        <option selected disabled>Seleccionar </option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="Pago_ID" class="form-label">Tipo De Pago:</label>
                                                    <select id="Pago_ID" name="Pago_ID" class="form-control form-select" aria-label="Seleccionar Pago">
                                                        <option selected disabled>Seleccionar </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="Divisa_ID" class="form-label">Tipo De Divisa:</label>
                                                    <select id="Divisa_ID" name="Divisa_ID" class="form-control form-select" aria-label="Seleccionar Divisa">
                                                        <option selected disabled>Seleccionar </option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Datos Paciente</h4>
                                        <div class="flex-shrink-0">
                                        </div>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="live-preview">
                                            <div class="row align-items-center g-3">
                                                <div class="col-lg-4">
                                                    <label for="Paciente_ID" class="form-label">Paciente:</label><!--Aquí debe mostrar los Nombres de los pacientes de acuerdo al Paciente_ID-->
                                                    <select id="Paciente_ID" name="Paciente_ID" class="form-control form-select js-example-basic-single" aria-label="Seleccionar Paciente">
                                                        <option selected disabled>Seleccionar </option>

                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="email" class="form-label">Correo Electronico:</label>
                                                    <input type="text" class="form-control" name="email" id="email" placeholder="Correo Electronico Del Paciente" readonly />

                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="telefono" class="form-label">Telefono:</label>
                                                    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Numero Telefonico Paciente" readonly />

                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="genero" class="form-label">Genero:</label>
                                                    <input type="text" class="form-control" name="genero" id="genero" placeholder="Genero Paciente" readonly />
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="usuario" class="form-label">Usuario:</label>
                                                    <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario Paciente" readonly />
                                                </div>

                                                <div class="col-lg-4">
                                                    <div>
                                                        <label for="website-field" class="form-label">Enfermedad</label>
                                                        <input class="form-control" id="taginput-choices" name="taginput-choices" disabled data-choices data-choices-text-unique-true type="text" readonly />
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="localidad" class="form-label">Estado:</label>
                                                    <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad Paciente" readonly />
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="ciudad" class="form-label">Ciudad:</label>
                                                    <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ciudad Paciente" readonly />
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="edad" class="form-label">Edad:</label>
                                                    <input type="text" class="form-control" name="edad" id="edad" placeholder="Edad Paciente" readonly />
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="fecha_nacimiento" class="form-label">Fecha De Nacimiento:</label>
                                                    <input type="text" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" disabled placeholder="Fecha Nacimiento Paciente" readonly />
                                                </div>

                                                <div class="col-lg-4">
                                                    <label for="user_id" class="form-label">Nutriologo:</label> <!--Aqui se debe obtener el user_id para saber con cual nutriologo esta enrolado, y obtener el nombre y apellidos-->
                                                    <input type="text" class="form-control" name="user_id" id="user_id" placeholder="Nutriologo Del Paciente" readonly />
                                                </div>
                                                <div class="card-header align-items-center d-flex">
                                                    <h4 class="card-title mb-0 flex-grow-1">Datos Adicionales Consulta</h4>
                                                    <div class="flex-shrink-0">
                                                    </div>
                                                </div><!-- end card header -->

                                                <div class="col-md-4">
                                                    <label class="form-label">Peso:</label>
                                                    <div class="input-group">
                                                        <input for="peso" type="number" step="any" class="form-control" id="peso" name="peso" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon1">Kg</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Talla:</label>
                                                    <div class="input-group">
                                                        <input for="talla" type="text" class="form-control" id="talla" name="talla" placeholder="Talla Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon2">M</span> <!---->
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Medida Cintura:</label>
                                                    <div class="input-group">
                                                        <input for="cintura" type="number" step="any" class="form-control" id="cintura" name="cintura" placeholder="Medida Cintura Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon3">Cm</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Medida Cadera:</label>
                                                    <div class="input-group">
                                                        <input for="cadera" type="number" step="any" class="form-control" id="cadera" name="cadera" placeholder="Medida Cadera Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon4">Cm</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Grasa Corporal:</label>
                                                    <div class="input-group">
                                                        <input for="gc" type="number" step="any" class="form-control" id="gc" name="gc" placeholder="Grasa Corporal Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon5">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Masa Muscular:</label>
                                                    <div class="input-group">
                                                        <input for="mm" type="number" step="any" class="form-control" id="mm" name="mm" placeholder="Masa Corporal Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon5">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Edad Metabolica:</label>
                                                    <div class="input-group">
                                                        <input for="em" type="number" step="any" class="form-control" id="em" name="em" placeholder="Edad Metabolica Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon6">años</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Altura:</label>
                                                    <div class="input-group">
                                                        <input for="altura" type="number" step="any" class="form-control" id="altura" name="altura" placeholder="Altura Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon7">m</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Proteina:</label>
                                                    <div class="input-group">
                                                        <input for="proteina" type="number" step="any" class="form-control" id="proteina" name="proteina" placeholder="Porcentaje De Proteina Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon8">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Edad Corporal:</label>
                                                    <div class="input-group">
                                                        <input for="ec" type="number" step="any" class="form-control" id="ec" name="ec" placeholder="Edad Corporal Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon9">años</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Masa Esquelética:</label>
                                                    <div class="input-group">
                                                        <input for="me" type="number" step="any" class="form-control" id="me" name="me" placeholder="Masa Esquelética Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon10">Kg</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Grasa Vísceral:</label>
                                                    <div class="input-group">
                                                        <input for="gv" type="number" step="any" class="form-control" id="gv" name="gv" placeholder="Grasa Vísceral Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon11">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Pérdida De Grasa:</label>
                                                    <div class="input-group">
                                                        <input for="pg" type="number" step="any" class="form-control" id="pg" name="pg" placeholder="Pérdida De Grasa Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon12">Kg</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Grasa Subcutanea:</label>
                                                    <div class="input-group">
                                                        <input for="gs" type="number" step="any" class="form-control" id="gs" name="gs" placeholder="Grasa Subcutanea Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon13">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Músculo Esquelético:</label>
                                                    <div class="input-group">
                                                        <input for="meq" type="number" step="any" class="form-control" id="meq" name="meq" placeholder="Músculo Esquelético Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon14">%</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">BMR:</label>
                                                    <div class="input-group">
                                                        <input for="bmr" type="number" step="any" class="form-control" id="bmr" name="bmr" placeholder="BMR Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon15">Kcal</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Agua Corporal:</label>
                                                    <div class="input-group">
                                                        <input for="ac" type="number" step="any" class="form-control" id="ac" name="ac" placeholder="Agua Corporal Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon16">%</span>
                                                    </div>
                                                </div>

                 
                                                <div class="col-md-4">
                                                    <label class="form-label">IMC:</label>
                                                    <div class="input-group">
                                                        <input for="imc" type="number" step="any" class="form-control" id="imc" name="imc" placeholder="IMC Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                        <span class="input-group-text" id="basic-addon17">%</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Diagnostico</h4>
                                        <div class="flex-shrink-0">
                                        </div>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="live-preview">
                                            <div class="row align-items-center g-3">
                                                <div class="mb-3">
                                                    <label for="detalles_diagnostico" class="form-label text-muted text-uppercase fw-semibold">Detalles Del Diagnostico </label>
                                                    <div class="ckeditor-classic" id="detalles_diagnostico">

                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="resultados_evaluacion" class="form-label text-muted text-uppercase fw-semibold">Resultados De La Evaluación </label>
                                                    <div class="ckeditor-classic" id="resultados_evaluacion">

                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="analisis_nutricional" class="form-label text-muted text-uppercase fw-semibold">Análisis Nutricional</label>
                                                    <div class="ckeditor-classic" id="analisis_nutricional">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Objetivo</h4>
                                        <div class="flex-shrink-0">
                                        </div>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="live-preview">
                                            <div class="row align-items-center g-3">
                                                <div class="mb-3">
                                                    <label for="objetivo_descripcion" class="form-label text-muted text-uppercase fw-semibold">Descripción</label>
                                                    <div class="ckeditor-classic" id="objetivo_descripcion">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row align-items-center g-3">
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label mb-0">Próxima Consulta</label>

                                                    <input type="text" class="form-control" id="proxima_consulta" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                    <label for="nombre_consultorio" class="form-label">Consultorio Nutricional:</label>
                                                    <input type="text" class="form-control" name="nombre_consultorio" id="nombre_consultorio" placeholder="Nombre Del Consultorio Nutricional"  />
                                            </div>

                                            <div class="col-lg-12">
                                                    <label for="direccion_consultorio" class="form-label">Direccion Consultorio Nutricional:</label>
                                                    <input type="text" class="form-control" name="direccion_consultorio" id="direccion_consultorio" placeholder="Direccion Del Consultorio Nutricional" />
                                            </div>
                                        </div>

                                        <!-- Parte del formulario para subir plan nutricional -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title mb-0">Subir Plan Nutricional</h4>
                                                    </div><!-- end card header -->

                                                    <div class="card-body">
                                                        <p class="text-muted">Añade El Plan Nutricional Aquí. Solo Se Permite Archivos .doc, .docx, .pdf</p>

                                                        <div class="dropzone" id="myDropzone">
                                                            <input type="hidden" name="plan_nutricional" id="plan_nutricional">
                                                            <div class="fallback">
                                                                <input name="plan_nutricional_path" type="file" accept=".pdf,.doc,.docx">
                                                            </div>
                                                            <div class="dz-message needsclick">
                                                                <div class="mb-3">
                                                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                                </div>
                                                                <h4>Suelte los archivos aquí o haga clic para cargarlos.</h4>
                                                            </div>
                                                        </div>

                                                        <!-- Contenedor para previsualizaciones -->
                                                        <ul class="list-unstyled mb-0" id="dropzone-preview">
                                                            <li class="mt-2" id="dropzone-preview-list">
                                                                <!-- Plantilla será insertada por Dropzone -->
                                                            </li>
                                                        </ul>
                                                        <!-- end dropzon-preview -->
                                                    </div>
                                                    <!-- end card body -->
                                                </div>
                                                <!-- end card -->
                                            </div> <!-- end col -->
                                        </div>

                                        <div class="hstack gap-2 justify-content-start d-print-none mt-4">
                                            <button type="submit" id="btnGuardar" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Actualizar Consulta</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        require_once("../html/footer.php");
        ?>
    </div>

    </div>
    <!-- END layout-wrapper -->

    <!-- Modern colorpicker bundle -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script src="../../assets/libs/@simonwep/pickr/pickr.min.js"></script>

    <!-- init js -->
    <script src="../../assets/js/pages/form-pickers.init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="../../assets/js/pages/invoicedetails.js"></script>
    <!-- ckeditor -->
    <script src="../../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="../../assets/js/pages/job-list.init.js"></script>
    <!-- list.js min js -->
    <script src="../../assets/libs/list.js/list.min.js"></script>
    <!--list pagination js-->
    <script src="../../assets/libs/list.pagination.js/list.pagination.min.js"></script>

    <!-- dropzone js -->
    <script src="../../assets/libs/dropzone/dropzone-min.js"></script>
    <!--<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>-->


    <!-- project-create init -->
    <script src="../../assets/js/pages/project-create.init.js"></script>
    <?php
    require_once("../html/js.php");
    ?>

    <script>
        function downloadFile() {
            // Puedes cambiar la URL a la que deseas realizar la descarga
            var downloadUrl = window.location.href;

            // Abre una nueva ventana o pestaña con la URL de descarga
            window.open(downloadUrl, '_blank');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("[data-provider='flatpickr']", {
                enableTime: true,
                dateFormat: "d.m.y H:i",
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../../assets/js/pages/select2.init.js"></script>
    <script type="text/javascript" src="actualizarConsulta.js"></script>

</body>

</html>