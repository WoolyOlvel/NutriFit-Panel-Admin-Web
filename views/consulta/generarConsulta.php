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

                    <!--  TODO:ID DE COMPRA -->
                    <input type="hidden" name="Venta_ID" id="Venta_ID" />

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
                                                <select id="Documento_ID" name="Documento_ID" class="form-select form-select" aria-label=".form-select-sm example">
                                                    <option selected disabled>Seleccionar </option>

                                                </select>
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="Pago_ID" class="form-label">Tipo De Pago:</label>
                                                <select id="Pago_ID" name="Pago_ID" class="form-select form-select" aria-label=".form-select-sm example">
                                                    <option selected disabled>Seleccionar </option>

                                                </select>
                                            </div>

                                            <div class="col-lg-4">
                                                <label for="Moneda_ID" class="form-label">Tipo De Moneda:</label>
                                                <select id="Moneda_ID" name="Moneda_ID" class="form-select form-select" aria-label=".form-select-sm example">
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
                                                <label for="Cliente_ID" class="form-label">Paciente:</label>
                                                <select id="Cliente_ID" name="Cliente_ID" class="form-select form-select" aria-label=".form-select-sm example">
                                                    <option selected disabled>Seleccionar </option>

                                                </select>
                                            </div>


                                            <div class="col-lg-4">
                                                <label for="Cliente_DNI" class="form-label">Cliente DNI:</label>
                                                <input type="text" class="form-control" name="Cliente_DNI" id="Cliente_DNI" placeholder="DNI Cliente" readonly />
                                            </div>


                                            <div class="col-lg-4">
                                                <label for="Cliente_DNI" class="form-label">Cliente Teléfono:</label>
                                                <input type="text" class="form-control" name="Cliente_Telefono" id="Cliente_Telefono" placeholder="Teléfono Cliente" readonly />

                                            </div>

                                            <div class="col-lg-6">
                                                <label for="Cliente_Direccion" class="form-label">Cliente Dirección:</label>
                                                <input type="text" class="form-control" name="Cliente_Direccion" id="Cliente_Direccion" placeholder="Dirección Cliente" readonly />

                                            </div>

                                            <div class="col-lg-6">
                                                <label for="Cliente_DNI" class="form-label">Cliente Correo:</label>
                                                <input type="text" class="form-control" name="Cliente_Correo" id="Cliente_Correo" placeholder="Correo Cliente" readonly />
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
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label mb-0">Próxima Consulta</label>
                                            
                                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time>
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
    <script src="../../assets/libs/@simonwep/pickr/pickr.min.js"></script>

    <!-- init js -->
    <script src="../../assets/js/pages/form-pickers.init.js"></script>
    <?php
    require_once("../html/js.php");
    ?>

    <script type="text/javascript" src="venta.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../../assets/js/pages/invoicedetails.js"></script>
    <!-- ckeditor -->
    <script src="../../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <!-- dropzone js -->
    <script src="../../assets/libs/dropzone/dropzone-min.js"></script>
    <!-- project-create init -->
    <script src="../../assets/js/pages/project-create.init.js"></script>



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

</body>

</html>