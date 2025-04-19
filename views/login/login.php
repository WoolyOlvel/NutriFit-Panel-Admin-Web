<?php
session_start();

if (isset($_SESSION['remember_token'])) {
    // El token está presente, usuario autenticado
    $token = $_SESSION['remember_token'] = $_COOKIE['remember_token'];
} else {
    // No se encontró el token
    "<script>
            window.location.href = '../Error403/Error403.php';
    </script>";
}
?>


<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Iniciar Sesión | NutriFit Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Login NutriFit Planner" name="description" />
    <meta content="Login NutriFit" name="ASCRIB" />
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


</head>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" 
        src="https://connect.facebook.net/en_US/sdk.js"></script>

<script>
  window.fbAsyncInit = function () {
    FB.init({
      appId: '1584426825580399',
      cookie: true,
      xfbml: true,
      version: 'v18.0'
    });

    FB.AppEvents.logPageView();
  };
</script>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
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
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">¡Bienvenido De Nuevo!</h5>
                                            <p class="text-muted">Inicie Sesión Para Continuar Al Panel Administrativo NutriFit.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="" method="" id="login_form">

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Correo Electronico</label>
                                                    <input type="text" class="form-control" name="email" id="email" autocomplete="email" placeholder="Su correo electronico">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="../resetPassword/resetPassword.php" class="text-muted">Olvidó su contraseña?</a>
                                                    </div>
                                                    <label class="form-label" for="password-input">Contraseña</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" name="password" id="password-input" autocomplete="current-password" placeholder="Su contraseña">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>


                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" name="remember" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">Recuérdamelo</label>
                                                </div>



                                                <div class="mt-4">

                                                    <button class="btn btn-success w-100" type="submit">Iniciar Sesión</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title">Iniciar Sesión Con</h5>
                                                    </div>

                                                    <div>
                                                        <button onclick="loginWithFacebook()" class="btn btn-primary btn-icon waves-effect waves-light">
                                                            <i class="ri-facebook-fill fs-16"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>

                                                    </div>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">¿No tiene cuenta? <a href="../register/register.php" class="fw-semibold text-primary text-decoration-underline"> ¡Registrate Ahora!</a> </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
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
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> NutriFit Planner. Todos Los Derechos Reservados.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JAVASCRIPT -->
    <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../../assets/libs/node-waves/waves.min.js"></script>
    <script src="../../assets/libs/feather-icons/feather.min.js"></script>
    <script src="../../assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="../../assets/js/plugins.js"></script>

    <!-- password-addon init -->
    <script src="../../assets/js/pages/password-addon.init.js"></script>

    <script src="login.js"></script>
    <script src="token.js"></script>

    <script src="facebook.js"></script>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js"></script>

</body>

</html>