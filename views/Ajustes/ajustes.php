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
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="position-relative mx-n4 mt-n4" style="margin-top: 1.2rem !important;">
                        <div class="profile-wid-bg profile-setting-img">
                            <img src="../../img/background2.jpg" class="profile-wid-img" alt="">
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
                                            <img src="../../img/perfilNutri.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1"><?php echo htmlspecialchars($_SESSION['nombre']); ?>  <?php echo htmlspecialchars($_SESSION['apellidos']); ?></h5>
                                        <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['rol_nombre']); ?></p>

                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Perfil Completado:</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                                        </div>
                                    </div>
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">30%</div>
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
                                            <a class="nav-link text-body" data-bs-toggle="tab" href="#changePassword" role="tab">
                                                <i class="far fa-user"></i>
                                                Cambiar Contraseña
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-body" data-bs-toggle="tab" href="#experience" role="tab">
                                                <i class="far fa-envelope"></i>
                                                Experiencia
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                            <form action="javascript:void(0);">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Nombre:</label>
                                                            <input type="text" class="form-control" id="firstnameInput" value="<?php echo htmlspecialchars($_SESSION['nombre'] ?? ''); ?>">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Apellidos:</label>
                                                            <input type="text" class="form-control" id="lastnameInput" value="<?php echo htmlspecialchars($_SESSION['apellidos']); ?>">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phonenumberInput" class="form-label">Número De Teléfono:</label>
                                                            <input type="text" class="form-control" id="phonenumberInput" placeholder="Su Numero De Telefóno">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="emailInput" class="form-label">Correo Electrónico:</label>
                                                            <input type="email" class="form-control" id="emailInput" value="<?php echo htmlspecialchars($_SESSION['email']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Edad:</label>
                                                            <input type="number" class="form-control" id="lastnameInput" placeholder="Su edad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Pacientes Tratados:</label>
                                                            <input type="number" class="form-control" id="lastnameInput" placeholder="Sus Pacientes">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Especialidad:</label>
                                                            <input type="text" class="form-control" id="lastnameInput" placeholder="Su Especialidad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="lastnameInput" class="form-label">Profesión:</label>
                                                            <input type="text" class="form-control" id="lastnameInput" placeholder="Su Profesión">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 pb-2">
                                                            <label for="exampleFormControlTextarea" class="form-label">Horario</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Su Horario" rows="3">Lunes a Viernes: 10:00AM-4:00PM, 6:00PM-8:00PM</textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-12">
                                                        <div class="mb-3 pb-2">
                                                            <label for="exampleFormControlTextarea" class="form-label">Describete:</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Su Descripción" rows="6">Holas</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Ciudad:</label>
                                                            <input type="text" class="form-control" id="firstnameInput" placeholder="Su Ciudad">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Estado:</label>
                                                            <input type="text" class="form-control" id="firstnameInput" placeholder="Su Estado">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="firstnameInput" class="form-label">Genero:</label>
                                                            <input type="text" class="form-control" id="firstnameInput" placeholder="Su Genero">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Fecha Nacimiento</label>
                                                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y">
                                                        </div>
                                                    </div>


                                                    <!--end col-->
                                                    <h4 class="card-title mb-0  me-2" style="padding-bottom: 0.8rem !important;">Formación Profesional</h4>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="designationInput" class="form-label">Universidad:</label>
                                                            <input type="text" class="form-control" id="designationInput" placeholder="Universidad Donde Se Graduo">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="websiteInput1" class="form-label">Diplomados:</label>
                                                            <input type="text" class="form-control" id="websiteInput1" placeholder="Diplomados Cursados" />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label for="cityInput" class="form-label">Especialización:</label>
                                                            <input type="text" class="form-control" id="cityInput" placeholder="Nombre De La Especialización Completa" />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="mb-3 pb-2">
                                                            <label for="exampleFormControlTextarea" class="form-label">Descripción De La Especialización</label>
                                                            <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Descripción" rows="4">Lupus</textarea>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-success">Actualizar</button>

                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                        <!--end tab-pane-->
                                        <div class="tab-pane" id="changePassword" role="tabpanel">
                                            <form action="javascript:void(0);">
                                                <div class="row g-2">

                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="newpasswordInput" class="form-label">Nueva Contraseña</label>
                                                            <input type="password" class="form-control" id="newpasswordInput" placeholder="Nueva Contraseña">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="confirmpasswordInput" class="form-label">Confirmar Contraseña</label>
                                                            <input type="password" class="form-control" id="confirmpasswordInput" placeholder="Confirmar Contraseña">
                                                        </div>
                                                    </div>

                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-success">Cambiar Contraseña</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>

                                        </div>
                                        <!--end tab-pane-->
                                        <div class="tab-pane" id="experience" role="tabpanel">
                                            <form>
                                                <div id="newlink">
                                                    <div id="1">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label for="jobTitle" class="form-label">Experiencia</label>
                                                                    <input type="text" class="form-control" id="jobTitle" placeholder="Cantidad Años Experiencia">
                                                                </div>
                                                            </div>
                                   
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label for="jobTitle" class="form-label">Enfermedades Tratadas:</label>
                                                                    <div class="live-preview">
                                                                        <div class="row align-items-center g-3">
                                                                            <div class="mb-3">
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
                                                            
                                                        </div>
                                                        <!--end row-->
                                                    </div>
                                                </div>
                                                <div id="newForm" style="display: none;">

                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2">
                                                        <button type="submit" class="btn btn-success">Actualizar</button>
                                                        
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </form>
                                        </div>
                                       
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
    <script src="../../assets/js/app.js"></script>
    <script type="text/javascript" src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script type="text/javascript" src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

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

    <script>
        document.querySelectorAll('.ckeditor-classic').forEach((el) => {
            ClassicEditor
                .create(el)
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

</body>

</html>