<?php
require_once("../html/session.php");
?>

<!doctype html>
<html lang="es" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <title>Consulta | NutriFit Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
    <?php
    require_once("../html/head.php");
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- One of the following themes -->
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/classic.min.css" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/monolith.min.css" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/nano.min.css" /> <!-- 'nano' theme -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                    <!--  TODO:ID DE Consulta -->
                    <input type="hidden" name="Consulta_ID" id="Consulta_ID" />
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Nueva Consulta</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="./generarConsulta.php">Menu</a></li>
                                        <li class="breadcrumb-item active">Consulta</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Formas De Pago</h4>
                                    <div class="flex-shrink-0">
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row align-items-center g-6">
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
                                                <select id="Paciente_ID" name="Paciente_ID" class="form-control form-select" aria-label="Seleccionar Paciente">
                                                    <option selected disabled>Seleccionar </option>

                                                </select>
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="apellidos" class="form-label">Apellidos:</label>
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos Del Paciente" readonly />
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
                                                    <input class="form-control" id="taginput-choices" name="taginput-choices" data-choices data-choices-text-unique-true type="text" readonly />
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="localidad" class="form-label">Estado:</label>
                                                <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad Paciente" readonly />
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="ciudad" class="form-label">ciudad:</label>
                                                <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ciudad Paciente" readonly />
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="edad" class="form-label">Edad:</label>
                                                <input type="text" class="form-control" name="edad" id="edad" placeholder="Edad Paciente" readonly />
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="fecha_nacimiento" class="form-label">Fecha De Nacimiento:</label>
                                                <input type="text" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Fecha Nacimiento Paciente" readonly />
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
                                                <label  class="form-label">Peso:</label>
                                                <div class="input-group">
                                                    <input for="peso" type="number" class="form-control" id="peso" name="peso" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon1">Kg</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label  class="form-label">Talla:</label>
                                                <div class="input-group">
                                                    <input for="talla" type="text" class="form-control" id="talla" name="talla" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon2">M</span> <!---->
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label  class="form-label">Medida Cintura:</label>
                                                <div class="input-group">
                                                    <input for="cintura" type="number" class="form-control" id="cintura" name="cintura" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon3">Cm</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label  class="form-label">Medida Cadera:</label>
                                                <div class="input-group">
                                                    <input for="cadera" type="number" class="form-control" id="cadera" name="cadera" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon4">Cm</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label  class="form-label">Grasa Corporal:</label>
                                                <div class="input-group">
                                                    <input for="gc" type="number" class="form-control" id="gc" name="gc" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon5">%</span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label  class="form-label">Edad Metabolica:</label>
                                                <div class="input-group">
                                                    <input for="em" type="number" class="form-control" id="em" name="em" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon6">años</span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label  class="form-label">Altura:</label>
                                                <div class="input-group">
                                                    <input for="altura" type="number" class="form-control" id="altura" name="altura" placeholder="Peso Del Paciente" aria-label="Username" aria-describedby="basic-addon1">
                                                    <span class="input-group-text" id="basic-addon7">m</span>
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
                                                <label for="Venta_Comentario" class="form-label text-muted text-uppercase fw-semibold">Detalles Del Diagnostico </label>
                                                <div class="ckeditor-classic">
                                                    <p>It will be as simple as occidental in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                                    <ul>
                                                        <li>Product Design, Figma (Software), Prototype</li>
                                                        <li>Four Dashboards : Ecommerce, Analytics, Project etc.</li>
                                                        <li>Create calendar, chat and email app pages.</li>
                                                        <li>Add authentication pages</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="Venta_Comentario" class="form-label text-muted text-uppercase fw-semibold">Resultados De La Evaluación </label>
                                                <div class="ckeditor-classic">
                                                    <p>It will be as simple as occidental in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                                    <ul>
                                                        <li>Product Design, Figma (Software), Prototype</li>
                                                        <li>Four Dashboards : Ecommerce, Analytics, Project etc.</li>
                                                        <li>Create calendar, chat and email app pages.</li>
                                                        <li>Add authentication pages</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="Venta_Comentario" class="form-label text-muted text-uppercase fw-semibold">Análisis Nutricional</label>
                                                <div class="ckeditor-classic">
                                                    <p>It will be as simple as occidental in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                                    <ul>
                                                        <li>Product Design, Figma (Software), Prototype</li>
                                                        <li>Four Dashboards : Ecommerce, Analytics, Project etc.</li>
                                                        <li>Create calendar, chat and email app pages.</li>
                                                        <li>Add authentication pages</li>
                                                    </ul>
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
                                                <label for="Venta_Comentario" class="form-label text-muted text-uppercase fw-semibold">Descripción</label>
                                                <div class="ckeditor-classic">
                                                    <p>It will be as simple as occidental in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth. For science, music, sport, etc, Europe uses the same vocabulary.</p>
                                                    <ul>
                                                        <li>Product Design, Figma (Software), Prototype</li>
                                                        <li>Four Dashboards : Ecommerce, Analytics, Project etc.</li>
                                                        <li>Create calendar, chat and email app pages.</li>
                                                        <li>Add authentication pages</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div>
                                            <label class="form-label mb-0">Próxima Consulta</label>

                                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Subir Plan Nutricional</h5>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <p class="text-muted">Añade El Plan Nutriconal Aquí.</p>
                                                <div class="dropzone">
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple="multiple">
                                                    </div>
                                                    <div class="dz-message needsclick" style="justify-content: center;
                                                    display: flex
                                                ;
                                                    flex-wrap: wrap;
                                                    flex-direction: column;
                                                    align-content: center;
                                                    align-items: center;">
                                                        <div class="mb-3">
                                                            <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                        </div>
                                                        <h5>Suelte los archivos aquí o haga clic para cargarlos.</h5>
                                                    </div>
                                                </div>

                                                <ul class="list-unstyled mb-0" id="dropzone-preview">
                                                    <li class="mt-2" id="dropzone-preview-list">
                                                        <!-- This is used as the file preview template -->
                                                        <div class="border rounded">
                                                            <div class="d-flex p-2">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar-sm bg-light rounded">
                                                                        <img src="#" alt="Project-Image" data-dz-thumbnail class="img-fluid rounded d-block" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="pt-1">
                                                                        <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                                        <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-3">
                                                                    <button data-dz-remove class="btn btn-sm btn-danger">Eliminar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <!-- end dropzon-preview -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hstack gap-2 justify-content-start d-print-none mt-4">
                                        <button type="submit" id="btnGuardar" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Finalizar Consulta</button>
                                        <a id="btnLimpiar" class="btn btn-danger"><i class="ri-delete-bin-5-fill align-bottom me-1"></i> Eliminar</a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
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
        document.querySelectorAll('.ckeditor-classic').forEach((el) => {
            ClassicEditor
                .create(el)
                .catch(error => {
                    console.error(error);
                });
        });
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
    <script type="text/javascript" src="config.js"></script>

</body>

</html>