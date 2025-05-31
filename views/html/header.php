<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="../home/index.php" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="../../img/LogoLight2.png" alt="" height="60">
                        </span>
                        <span class="logo-lg">
                            <img src="../../img/LogoLight2.png" alt="" height="60">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="../../img/LogoDark.png" alt="" height="60">
                        </span>
                        <span class="logo-lg">
                            <img src="../../img/LogoDark.png" alt="" height="60">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                
            </div>

            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/ftkaasgv.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:75px;height:75px">
                        </lord-icon>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/orbvmzde.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px">
                        </lord-icon>
                    </button>
                </div>

                

                <style>
                    /* Estilos para el contenedor de notificaciones */
                .dropdown-menu-lg {
                max-height: 500px;  /* Altura máxima para todo el dropdown */
                overflow-y: auto;   /* Agrega scroll vertical cuando sea necesario */
                }

                /* Asegura que el contenido de las pestañas no se desborde */
                #notificationItemsTabContent .tab-pane {
                overflow: hidden;
                }

                /* Estilo para el contenedor de notificaciones con scrollbar */
                [data-simplebar] {
                max-height: 300px !important;  /* Fuerza la altura máxima */
                overflow-y: auto !important;   /* Asegura que haya scroll */
                }

                /* Para dispositivos móviles, reducimos un poco la altura */
                @media (max-width: 768px) {
                .dropdown-menu-lg {
                    max-height: 450px;
                }
                
                [data-simplebar] {
                    max-height: 250px !important;
                }
                }

                /* Mejora el estilo de los elementos de notificación para un mejor ajuste */
                .notification-item {
                padding: 0.5rem 1rem;
                width: 100%;
                box-sizing: border-box;
                }
                </style>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/uvbysunc.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px">
                        </lord-icon>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger" id="notification-badge-counter">0<span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown" id="notification-dropdown">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notificaciones </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-body fs-13" id="notification-badge">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" style="display: 
                                    flex;
                                    flex-wrap: nowrap;
                                    flex-direction: row;
                                    align-content: center;
                                    justify-content: space-evenly;
                                    align-items: center;" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                            Todos (<span class="noti-count">0</span>)
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                                            Mensajes (<span class="noti-count">0</span>)
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                                            Reservación (<span class="noti-count">0</span>)
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2" id="all-noti-tab-content">
                                    <!-- Contenido dinámico -->
                                </div>
                                <div class="my-3 text-center view-all">
                                    <button type="button" class="btn btn-soft-success waves-effect waves-light">Ver <i class="ri-arrow-right-line align-middle"></i></button>
                                </div>
                            </div>

                            <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2" id="messages-tab-content">
                                    <!-- Contenido dinámico -->
                                </div>
                                <div class="my-3 text-center view-all">
                                    <button type="button" class="btn btn-soft-success waves-effect waves-light">Ver Chats <i class="ri-arrow-right-line align-middle"></i></button>
                                </div>
                            </div>

                            <div class="tab-pane fade py-2 ps-2" id="alerts-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2" id="alerts-tab-content">
                                    <!-- Contenido dinámico -->
                                </div>
                                <div class="my-3 text-center view-all">
                                    <button type="button" class="btn btn-soft-success waves-effect waves-light">Ver Citas Agendadas<i class="ri-arrow-right-line align-middle"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" id="user-avatar" src="../../assets/images/users/user-dummy-img.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text" id="user-name">Cargando...</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text" id="user-role">Cargando rol...</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header" id="welcome-message2">Bienvenido!</h6>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Función para cargar los datos del usuario
                                function loadUserData() {
                                    fetch('https://nutrifitplanner.site/api/ajustes/', {
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'remember-token': '<?php echo $_COOKIE['remember_token'] ?? ''; ?>'
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Error al cargar datos');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Actualizar nombre y rol
                                            document.getElementById('user-name').textContent = data.user.nombre;
                                            document.getElementById('user-role').textContent = data.user.rol_nombre || 'Usuario';
                                            
                                            // Actualizar mensaje de bienvenida
                                            const primerNombre = data.user.nombre.split(' ')[0];
                                            document.getElementById('welcome-message2').textContent = `Bienvenido ${primerNombre}!`;
                                            
                                            // Actualizar avatar si existe en ajustes
                                            if (data.data && data.data.foto) {
                                                document.getElementById('user-avatar').src = data.data.foto;
                                            } else {
                                                // Usar imagen por defecto si no hay foto
                                                document.getElementById('user-avatar').src = "../../assets/images/users/user-dummy-img.jpg";
                                            }
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        // Mostrar valores por defecto en caso de error
                                        document.getElementById('user-name').textContent = 'Usuario';
                                        document.getElementById('user-role').textContent = 'Rol no disponible';
                                    });
                                }

                                // Cargar datos al iniciar
                                loadUserData();
                            });
                        </script>

                        <a class="dropdown-item" href="#" onclick="mostrarMantenimientoChat()" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/ypjuppft.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width: 30px;
                                       height: 30px;">
                            </lord-icon>
                            <span style="margin-top: 0.4rem; margin-left:0.5rem" class="align-middle">Mensajes</span>
                        </a>

                        <a class="dropdown-item" href="../ayuda/ayuda.php" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/jtuncxzi.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span style="margin-top: 0.4rem; margin-left:0.5rem" class="align-middle">Ayuda</span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" id="ganancias-item" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/opqmrqco.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span class="align-middle" style="margin-top: 0.4rem; margin-left:0.5rem">
                                Ganancias: <b id="ganancias-amount">Cargando...</b>
                            </span>
                        </a>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Función para cargar las ganancias desde el dashboard
                                function loadGanancias2() {
                                    fetch('https://nutrifitplanner.site/api/dashboard/', {
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'remember-token': '<?php echo $_COOKIE['remember_token'] ?? ''; ?>'
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Error al cargar datos del dashboard');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.grafica_resumen && data.grafica_resumen.total_ganancias !== undefined) {
                                            // Formatear el número como moneda
                                            const formattedAmount = new Intl.NumberFormat('es-MX', {
                                                style: 'currency',
                                                currency: 'MXN'
                                            }).format(data.grafica_resumen.total_ganancias);
                                            
                                            document.getElementById('ganancias-amount').textContent = formattedAmount;
                                        } else {
                                            document.getElementById('ganancias-amount').textContent = '$0.00';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al cargar ganancias:', error);
                                        document.getElementById('ganancias-amount').textContent = 'Error al cargar';
                                    });
                                }

                                // Cargar ganancias al iniciar
                                loadGanancias2();
                                
                                // Opcional: Recargar cada 5 minutos (300000 ms)
                                setInterval(loadGanancias, 300000);
                            });
                        </script>

                        <a class="dropdown-item" href="../Ajustes/ajustes.php" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/qzulvmbf.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span class="align-middle" style="margin-top: 0.4rem; margin-left:0.5rem">Ajustes</span>
                        </a>

                       <!--- <a class="dropdown-item" href="../bloqPantalla/bloqueoPantalla.php" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/umjzhslu.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span class="align-middle" style="margin-top: 0.4rem; margin-left:0.5rem">Bloquear Pantalla</span>
                        </a>-->

                        <a class="dropdown-item" href="#" id="logout-link" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/phvtdttk.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span class="align-middle" style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-logout">Cerrar Sesión</span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>