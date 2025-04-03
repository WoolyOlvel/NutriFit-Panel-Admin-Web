<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Registro | NutriFit Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Register NutriFit Planner" name="description" />
    <meta content="Register NutriFit" name="ASCRIB" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../img/logo2.ico">

    <!-- Layout config Js -->
    <script src="../../assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="../../assets/css/custom.min.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden m-0">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="#" class="d-block">
                                                    <img src="../../img/logolight.png" alt="" height="100">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" Convierte cada consulta en una experiencia personalizada con NutriFit Planner. "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" Tu herramienta esencial para personalizar planes nutricionales y mejorar la salud de tus pacientes "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" NutriFit Planner. Nutrición Basado En La Evidencia "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Únete A NutriFit Planner</h5>
                                            <p class="text-muted">Únete Ahora y Disfruta De Los Beneficios.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="needs-validation" novalidate action="index.html">



                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Nombre <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="username" placeholder="Su Nombre" required>
                                                    <div class="invalid-feedback">
                                                        Por Favor Ingrese Su Nombre
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="username" placeholder="Sus Apellidos" required>
                                                    <div class="invalid-feedback">
                                                        Por Favor Ingrese Sus Apellidos
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="useremail" placeholder="Su Correo Electrónico" required>
                                                    <div class="invalid-feedback">
                                                        Por Favor Ingrese Un Correo Electrónico
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Usuario <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="username" placeholder="Su Usuario" required>
                                                    <div class="invalid-feedback">
                                                        Por Favor Ingrese Un Usuario
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Contraseña</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Su Contraseña" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Ingrese Una Contraseña
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">Al Unirme Acepto NutriFit Planner Sus <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Términos y Condiciones</a></p>
                                                </div>

                                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                    <h5 class="fs-13">La contraseña debe contener:</h5>
                                                    <p id="pass-length" class="invalid fs-12 mb-2">Minimo <b>8 Caracteres</b></p>
                                                    <p id="pass-lower" class="invalid fs-12 mb-2">En <b>Letras</b> Minúsculas (a-z)</p>
                                                    <p id="pass-upper" class="invalid fs-12 mb-2">Al Menos <b>Una Letra</b> Mayúscula (A-Z)</p>
                                                    <p id="pass-number" class="invalid fs-12 mb-0">Al Menos <b>Un Número</b> (0-9)</p>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Unirme</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title text-muted">Únete Con</h5>
                                                    </div>

                                                    <div>
                                                        <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">¿Ya te has Unido? <a href="../login/login.php" class="fw-semibold text-primary text-decoration-underline"> Inicia Sesion Ahora</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0" style="font-weight: bold; color:white;">&copy;
                                <script>document.write(new Date().getFullYear())</script> NutriFit Planner. Todos Los Derechos Reservados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <script src="../../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../../assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="../../assets/js/plugins.js"></script>

    <!-- validation init -->
    <script src="../../assets/js/pages/form-validation.init.js"></script>
    <!-- password create init -->
    <script src="../../assets/js/pages/passowrd-create.init.js"></script>
</body>

</html>