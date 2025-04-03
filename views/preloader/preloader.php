<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NutriFit Ingresando...</title>
    <link rel="stylesheet" href="../../css/preloader.css">
    <meta content="Dashboard NutriFit Planner" name="description" />
    <meta content="ASCRIB" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../../img/logo2.ico">
</head>

<body>
    <div id="ctn-preloader" class="ctn-preloader">
        <div class="animation-preloader">
            
            <svg xmlns="http://www.w3.org/2000/svg" height="128px" width="256px" viewBox="0 0 256 128" class="loader-infinity">
                    <g stroke-width="16" stroke-linecap="round" fill="none">
                        <g stroke="#000" class="track">
                            <path d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56"></path>
                            <path d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64"></path>
                        </g>
                        <g stroke="black" class="motion">
                            <path d="M8,64s0-56,60-56,60,112,120,112,60-56,60-56"></path>
                            <path d="M248,64s0-56-60-56-60,112-120,112S8,64,8,64"></path>
                        </g>
                    </g>
            </svg>
            
            <div class="txt-loading">
                <span data-text-preloader="N" class="letters-loading">
                    N
                </span>
                <span data-text-preloader="U" class="letters-loading">
                    U
                </span>
                <span data-text-preloader="T" class="letters-loading">
                    T
                </span>
                <span data-text-preloader="R" class="letters-loading">
                    R
                </span>
                <span data-text-preloader="I" class="letters-loading">
                    I
                <span data-text-preloader="F" class="letters-loading">
                    F
                </span>
                <span data-text-preloader="I" class="letters-loading">
                    I
                <span data-text-preloader="T" class="letters-loading">
                    T
                </span>

            </div>
            <p class="text-center">Cargando...</p>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Esta función se ejecutará después de 10 segundos
        function redirigirADashboard() {
            window.location.href = '../home/index.php';
        }

        // Espera 10 segundos antes de llamar a la función de redirección
        setTimeout(redirigirADashboard, 10000); // 10000 milisegundos = 10 segundos
    </script>

</body>

</html>