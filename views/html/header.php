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

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Buscar..." autocomplete="off" id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index.html" class="btn btn-soft-secondary btn-sm rounded-pill">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="../../assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="../../assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="../../assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                            <img class="rounded-circle header-profile-user" src="../../img/perfilNutri.png" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php echo htmlspecialchars($_SESSION['rol_nombre']); ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Bienvenido <?php echo htmlspecialchars($primerNombre); ?>!</h6>
                        <a class="dropdown-item" href="#" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/cklbznjc.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style=" width: 30px;
                                        height: 30px;
                                        ">
                            </lord-icon>
                            <span style="margin-top: 0.4rem; margin-left:0.5rem" class="align-middle">Perfil</span>
                        </a>

                        <a class="dropdown-item" href="../../chat.php" style="display: flex;">
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
                        <a class="dropdown-item" href="#" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/opqmrqco.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span class="align-middle" style="margin-top: 0.4rem; margin-left:0.5rem">Ganancias : <b>$5971.67</b></span>
                        </a>

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

                        <a class="dropdown-item" href="../bloqPantalla/bloqueoPantalla.php" style="display: flex;">
                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                            <lord-icon
                                src="https://cdn.lordicon.com/umjzhslu.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width:30px;height:30px">
                            </lord-icon>
                            <span class="align-middle" style="margin-top: 0.4rem; margin-left:0.5rem">Bloquear Pantalla</span>
                        </a>

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