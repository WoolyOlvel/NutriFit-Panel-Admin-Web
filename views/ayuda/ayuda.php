<?php
require_once("../html/session.php");
?>

<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Ayuda | NutriFit Planner</title>
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

        <?php
        require_once("../html/menu.php")
        ?>
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card rounded-0 bg-success-subtle mx-n4 mt-n4 border-top" style="padding-top: 1.2rem;">
                                <div class="px-4">
                                    <div class="row">
                                        <div class="col-xxl-5 align-self-center">
                                            <div class="py-4">
                                                <h4 class="display-6 coming-soon-text">Ayuda y Preguntas Frecuentes</h4>
                                                <p class="text-success fs-15 mt-3">Si no puede encontrar respuesta a su pregunta en nuestras Preguntas Frecuentes, siempre puede contactarnos o enviarnos un correo electrónico.
                                                    ¡Le responderemos en breve!</p>
                                                <div class="hstack flex-wrap gap-2">
                                                    <a href="mailto:ascrib_store@outlook.com" class="btn btn-primary btn-label rounded-pill">
                                                        <i class="ri-mail-line label-icon align-middle rounded-pill fs-16 me-2"></i> Correo Electrónico
                                                    </a>

                                                    <a href="tel:+529961018215" class="btn btn-info btn-label rounded-pill">
                                                        <i class="ri-phone-line label-icon align-middle rounded-pill fs-16 me-2"></i> Llamar +52 9961018215
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 ms-auto">
                                            <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">
                                                <img src="../../assets/images/faq-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                            <div class="row justify-content-evenly mb-4">
                                <!-- Preguntas Generales -->
                                <div class="col-lg-4">
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0 me-1">
                                                <i class="ri-question-line fs-24 align-middle text-success me-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-14 mb-0">Preguntas Generales</h5>
                                            </div>
                                        </div>

                                        <div class="accordion accordion-border-box" id="genques-accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="genques-headingOne">
                                                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseOne" aria-expanded="true" aria-controls="genques-collapseOne">
                                                        ¿Qué es NutriFit Planner?
                                                    </button>
                                                </h2>
                                                <div id="genques-collapseOne" class="accordion-collapse collapse show" aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion">
                                                    <div class="accordion-body">
                                                        NutriFit Planner es una herramienta web diseñada para que nutriólogos gestionen los planes alimenticios, historial clínico y progresos de sus pacientes de manera rápida y eficiente.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="genques-headingTwo">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseTwo" aria-expanded="false" aria-controls="genques-collapseTwo">
                                                        ¿Cómo puedo registrar un nuevo paciente?
                                                    </button>
                                                </h2>
                                                <div id="genques-collapseTwo" class="accordion-collapse collapse" aria-labelledby="genques-headingTwo" data-bs-parent="#genques-accordion">
                                                    <div class="accordion-body">
                                                        Puedes registrar un nuevo paciente desde el panel lateral, seleccionando "Pacientes" y luego haciendo clic en "Añadir Paciente". Ahí deberás llenar sus datos personales y clínicos.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="genques-headingThree">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseThree" aria-expanded="false" aria-controls="genques-collapseThree">
                                                        ¿Puedo exportar los planes alimenticios?
                                                    </button>
                                                </h2>
                                                <div id="genques-collapseThree" class="accordion-collapse collapse" aria-labelledby="genques-headingThree" data-bs-parent="#genques-accordion">
                                                    <div class="accordion-body">
                                                        No, no se pueden exportar. Solamente es posible subir los planes alimenticios a cada paciente desde la sección de “Generar Consulta” y seleccionar un paciente.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="genques-headingFour">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseFour" aria-expanded="false" aria-controls="genques-collapseFour">
                                                        ¿NutriFit Planner tiene app móvil?
                                                    </button>
                                                </h2>
                                                <div id="genques-collapseFour" class="accordion-collapse collapse" aria-labelledby="genques-headingFour" data-bs-parent="#genques-accordion">
                                                    <div class="accordion-body">
                                                        Sí, habrá una app móvil orientada al paciente, actualmente en versión beta. Su lanzamiento está previsto para mayo..
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cuenta del Nutriólogo -->
                                <div class="col-lg-4">
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0 me-1">
                                                <i class="ri-user-settings-line fs-24 align-middle text-success me-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-14 mb-0">Gestión de Cuenta</h5>
                                            </div>
                                        </div>

                                        <div class="accordion accordion-border-box" id="manageaccount-accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="manageaccount-headingOne">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseOne" aria-expanded="false" aria-controls="manageaccount-collapseOne">
                                                        ¿Cómo cambio mi contraseña?
                                                    </button>
                                                </h2>
                                                <div id="manageaccount-collapseOne" class="accordion-collapse collapse" aria-labelledby="manageaccount-headingOne" data-bs-parent="#manageaccount-accordion">
                                                    <div class="accordion-body">
                                                        En el menú de configuración, selecciona “Ajustes” y luego “Cambiar contraseña”. Asegúrate de usar una contraseña segura que combines letras, números y símbolos.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="manageaccount-headingTwo">
                                                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseTwo" aria-expanded="true" aria-controls="manageaccount-collapseTwo">
                                                        ¿Puedo actualizar mis datos personales?
                                                    </button>
                                                </h2>
                                                <div id="manageaccount-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="manageaccount-headingTwo" data-bs-parent="#manageaccount-accordion">
                                                    <div class="accordion-body">
                                                        Sí, desde el perfil puedes editar tu nombre, correo electrónico y datos de contacto. Solo debes guardar los cambios al finalizar.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="manageaccount-headingThree">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseThree" aria-expanded="false" aria-controls="manageaccount-collapseThree">
                                                        ¿Cómo elimino mi cuenta?
                                                    </button>
                                                </h2>
                                                <div id="manageaccount-collapseThree" class="accordion-collapse collapse" aria-labelledby="manageaccount-headingThree" data-bs-parent="#manageaccount-accordion">
                                                    <div class="accordion-body">
                                                        Si deseas eliminar tu cuenta, contáctanos desde el formulario de soporte (Enviar Correo Electrónico). Recuerda que esta acción es irreversible y se perderá toda tu información.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="manageaccount-headingFour">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseFour" aria-expanded="false" aria-controls="manageaccount-collapseFour">
                                                        ¿Cómo configuro mis notificaciones?
                                                    </button>
                                                </h2>
                                                <div id="manageaccount-collapseFour" class="accordion-collapse collapse" aria-labelledby="manageaccount-headingFour" data-bs-parent="#manageaccount-accordion">
                                                    <div class="accordion-body">
                                                        Actualmente, la configuración de notificaciones no está disponible en la plataforma.
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- Privacidad y Seguridad -->
                                <div class="col-lg-4">
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-shrink-0 me-1">
                                                <i class="ri-shield-keyhole-line fs-24 align-middle text-success me-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="fs-14 mb-0">Privacidad y Seguridad</h5>
                                            </div>
                                        </div>

                                        <div class="accordion accordion-border-box" id="privacy-accordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="privacy-headingOne">
                                                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseOne" aria-expanded="true" aria-controls="privacy-collapseOne">
                                                        ¿Mi información está protegida?
                                                    </button>
                                                </h2>
                                                <div id="privacy-collapseOne" class="accordion-collapse collapse show" aria-labelledby="privacy-headingOne" data-bs-parent="#privacy-accordion">
                                                    <div class="accordion-body">
                                                        Sí, utilizamos protocolos de seguridad y cifrado para garantizar que tus datos y los de tus pacientes estén protegidos en todo momento.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="privacy-headingTwo">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseTwo" aria-expanded="false" aria-controls="privacy-collapseTwo">
                                                        ¿Cumplen con normativas de privacidad?
                                                    </button>
                                                </h2>
                                                <div id="privacy-collapseTwo" class="accordion-collapse collapse" aria-labelledby="privacy-headingTwo" data-bs-parent="#privacy-accordion">
                                                    <div class="accordion-body">
                                                        Sí, NutriFit Planner cumple con los estándares de privacidad de datos requeridos para el manejo de información confidencial en el ámbito de la salud.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="privacy-headingThree">
                                                    <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy-collapseThree" aria-expanded="false" aria-controls="privacy-collapseThree">
                                                        ¿Quién tiene acceso a mis datos?
                                                    </button>
                                                </h2>
                                                <div id="privacy-collapseThree" class="accordion-collapse collapse" aria-labelledby="privacy-headingThree" data-bs-parent="#privacy-accordion">
                                                    <div class="accordion-body">
                                                        Solo tú como profesional tienes acceso a los datos de tus pacientes. NutriFit Planner no comparte ni comercializa información con terceros.
                                                    </div>
                                                </div>
                                            </div>
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
    <?php
    require_once("../html/js.php")
    ?>


</body>

</html>