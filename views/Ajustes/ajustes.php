<?php

require_once("../html/session.php");
?>

<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Ajustes | NutriFit Planner</title>
    <?php
    require_once("../html/head.php")
    ?>
    <link href="../../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="position-relative mx-n4 mt-n4" style="margin-top: 1.2rem !important;">
                        <div class="profile-wid-bg profile-setting-img"> <!--el foto_portada.png sera la foto portada default (ya que cuando las cuentas no tendran una foto portada luego la cambian)-->
                            <img src="../../img/foto_portada.png" id="foto_portada" class="profile-wid-img" alt="">
                            <div class="overlay-content">
                                <div class="text-end p-3">
                                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                        <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                            <i class="ri-image-edit-line align-bottom me-1"></i> Cambiar Fondo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card mt-n5">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                                <!--La foto de nutriologo por defualt es user-dummy-img.jpg-->
                                            <img src="../../assets/images/users/user-dummy-img.jpg" id="foto" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div> <!--En este de id="nombre_nutriologo" hay que concatenar el apellido_nutriologo ya no se mostrara por session-->
                                        <h5 class="fs-16 mb-1" id="nombreCompleto_nutriologo"></h5>
                                        <p class="text-muted mb-0" id="rol_nombre"></p> <!--Obtener el rol_id en la tabla ajustes y acceder a la tabla rol y buscar nombre-->

                                    </div>
                                </div>
                            </div>
                            <style>
                                .animated-progress {
                                    transition: width 0.5s ease-in-out;
                                }

                                .progress-label .label {
                                    position: absolute;
                                    right: 10px;
                                    color: white;
                                    font-weight: bold;
                                    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);
                                }
                            </style>
                            <!--end card-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Perfil Completado:</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                          
                                        </div>
                                    </div>
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar bg-danger" id="profileProgressBar" role="progressbar" 
                                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="label" id="progressPercentage">0%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end card-->
                        </div>
                        <!--end col-->
                        <div class="col-xxl-9">
                            <div class="card mt-xxl-n5">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                                <i class="fas fa-home"></i>
                                                Datos Personales
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-body" data-bs-toggle="tab" href="#experience" role="tab">
                                                <i class="far fa-envelope"></i>
                                                Experiencia
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-body" data-bs-toggle="tab" href="#changePassword" role="tab">
                                                <i class="far fa-user"></i>
                                                Cambiar Contraseña
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form method="POST" id="Ajustes_Form" enctype="multipart/form-data" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="nombre_nutriologo" class="form-label">Nombre:</label>
                                                            <input type="text" class="form-control" id="nombre_nutriologo" value="">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="apellido_nutriologo" class="form-label">Apellidos:</label>
                                                            <input type="text" class="form-control" id="apellido_nutriologo" value="">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="telefono" class="form-label">Número De Teléfono:</label>
                                                            <input type="text" class="form-control" id="telefono" placeholder="Su Numero De Telefóno">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Correo Electrónico:</label>
                                                            <input type="email" class="form-control" id="email" value="">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="edad" class="form-label">Edad:</label>
                                                            <input type="number" class="form-control" id="edad" placeholder="Su edad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="pacientes_tratados" class="form-label">Pacientes Tratados:</label>
                                                            <input type="number" class="form-control" id="pacientes_tratados" placeholder="Sus Pacientes">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="especialidad" class="form-label">Especialidad:</label>
                                                            <input type="text" class="form-control" id="especialidad" placeholder="Su Especialidad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="profesion" class="form-label">Profesión:</label>
                                                            <input type="text" class="form-control" id="profesion" placeholder="Su Profesión">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 pb-2">
                                                            <label for="horario_antencion" class="form-label">Horario</label>
                                                            <textarea class="form-control" id="horario_antencion" placeholder="Su Horario" rows="8"></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="mb-3 pb-2">
                                                            <label for="descripcion_nutriologo" class="form-label">Describete:</label>
                                                            <textarea class="form-control" id="descripcion_nutriologo" placeholder="Su Descripción" rows="20"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="ciudad" class="form-label">Ciudad:</label>
                                                            <input type="text" class="form-control" id="ciudad" placeholder="Su Ciudad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado:</label>
                                                            <input type="text" class="form-control" id="estado" placeholder="Su Ciudad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="industry_type-field" class="form-label">Genero</label>
                                                            <select class="form-select" id="genero" name="genero">
                                                                <option value="" disabled selected>Seleccione Un Genero</option>
                                                                <option value="Femenino">Femenino</option>
                                                                <option value="Masculino">Masculino</option>
                                                                <option value="Otros">Otros</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Fecha Nacimiento</label>
                                                            <input type="text" id="fecha_nacimiento" class="form-control" data-provider="flatpickr" data-date-format="d M, Y">
                                                        </div>
                                                    </div>


                                                    <!--end col-->
                                                    <h4 class="card-title mb-0  me-2" style="padding-bottom: 0.8rem !important;">Formación Profesional</h4>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="universidad" class="form-label">Universidad:</label>
                                                            <input type="text" class="form-control" id="universidad" placeholder="Universidad Donde Se Graduo">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="displomados" class="form-label">Diplomados:</label>
                                                            <input type="text" class="form-control" id="displomados" placeholder="Diplomados Cursados" />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="especializacion" class="form-label">Especialización:</label>
                                                            <input type="text" class="form-control" id="especializacion" placeholder="Nombre De La Especialización Completa" />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 pb-2">
                                                            <label for="descripcion_especialziacion" class="form-label">Descripción De La Especialización</label>
                                                            <textarea class="form-control" id="descripcion_especialziacion" placeholder="Descripción" rows="4">Lupus</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div>
                                                            <div class="mb-3 pb-2">

                                                                <label for="industry_type-field" class="form-label">Disponibilidad de Citas</label>
                                                                <select class="form-select" id="disponibilidad" name="disponibilidad">
                                                                    <option value="" disabled selected>Seleccione Una Disponibilidad</option>
                                                                    <option value="Disponibles">Disponibles</option>
                                                                    <option value="Pocos Cupos">Pocos Cupos</option>
                                                                    <option value="No Disponible">No Disponible</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div>
                                                            <div class="mb-3 pb-2">

                                                                <label for="industry_type-field" class="form-label">Modalidad de Atención</label>
                                                                <select class="form-select" id="modalidad" name="modalidad">
                                                                    <option value="" disabled selected>Seleccione Una Modalidad</option>
                                                                    <option value="Presencial">Presencial</option>
                                                                    <option value="Virtual">Virtual</option>
                                                                    <option value="Llamadas">Llamadas Telefonicas</option>
                                                                    <option value="Chat">Chat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-success">Guardar</button>

                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                        <!--end tab-pane-->
                                        <div class="tab-pane" id="changePassword" role="tabpanel">
                                            <form method="POST" id="Ajustes_Form3" enctype="multipart/form-data" autocomplete="off">
                                                <div class="row g-2">
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="password" class="form-label">Nueva Contraseña</label>
                                                            <input type="password" class="form-control" id="password" name="password" 
                                                                placeholder="Nueva Contraseña" minlength="8" required>
                                                            <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation"
                                                                placeholder="Confirmar Contraseña" minlength="8" required>
                                                            <div class="invalid-feedback">Las contraseñas deben coincidir</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="text-end">
                                                            <button type="submit" id="btnGuardar" class="btn btn-success">Cambiar Contraseña</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="experience" role="tabpanel">
                                            <form method="POST" id="Ajustes_Form_2" enctype="multipart/form-data" autocomplete="off"> 
                                                <div id="newlink">
                                                    <div id="1">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label for="experiencia" class="form-label">Experiencia</label>
                                                                    <input type="text" class="form-control" id="experiencia" placeholder="Cantidad Años Experiencia">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label for="jobTitle" class="form-label">Enfermedades Tratadas:</label>
                                                                    <div class="live-preview">
                                                                        <div class="row align-items-center g-3">
                                                                            <div class="mb-3">                                                                                
                                                                                <textarea id="enfermedades_tratadas"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                </div>
                                                <div id="newForm" style="display: none;">

                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-success">Actualizar</button>

                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </form>
                                        </div>

                                        <!--end tab-pane-->


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->

            <?php
            require_once("../html/footer.php")
            ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!-- JAVASCRIPT -->
    <!-- profile-setting init js -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../../assets/js/pages/profile-setting.init.js"></script>
    <!-- Modern colorpicker bundle -->
    <script src="../../assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="../../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <!-- init js -->
    <script src="../../assets/js/pages/form-pickers.init.js"></script>
    <!-- App js -->
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <?php
    require_once("../html/js.php")
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("[data-provider='flatpickr']", {
                enableTime: false,
                dateFormat: "d M, Y",
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="ajustes.js"></script>
</body>

</html>