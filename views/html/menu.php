<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="../../img/LogoLight2.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="../../img/LogoLight2.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="../home/index.php" class="logo logo-light">
            <span class="logo-sm">
                <img src="../../img/LogoDark.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="../../img/LogoDark.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../home/index.php" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/sjfigfgw.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px;display:flex;">
                        </lord-icon> <span style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-dashboards">Dashboards</span>
                       
                    </a>

                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            
                            <li class="nav-item">
                                <a href="../home/index.php" class="nav-link" data-key="t-chat"> Dashboard </a>
                            </li>
                           
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/egzkfnoz.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px;display:flex;">
                        </lord-icon> <span  style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-apps">Pacientes</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            
                            <li class="nav-item">
                                <a href="../misPacientes/misPacientes.php" class="nav-link" data-key="t-chat"> Lista Pacientes </a>
                            </li>
                            <li class="nav-item">
                                <a href="../addPaciente/añadirPaciente.php" class="nav-link" data-key="t-email">
                                    Añadir Paciente
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../consulta/generarConsulta.php" class="nav-link" data-key="t-email">
                                    Generar Consulta
                                </a>
                            </li>
                        
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <script script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/pnlvdria.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px;display:flex;">
                        </lord-icon> <span style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-layouts">Citas</span> <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayouts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="../citaAgendadas/calendarioCitas.php" class="nav-link" data-key="t-vertical">Ver Citas Agendadas</a>
                            </li>
                           
                        </ul>
                    </div>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                                src="https://cdn.lordicon.com/ypjuppft.json"
                                trigger="loop"
                                delay="2000"
                                stroke="bold"
                                style="width: 30px;
                                       height: 30px;display:flex;">
                        </lord-icon>
                        </lord-icon><span style="margin-top: 0.4rem; margin-left:0.5rem"  data-key="t-authentication">Chats</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="../../chat.php" class="nav-link" data-key="t-detached">Chat</a>
                            </li>
                        
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/kbequzxu.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px;display:flex;">
                        </lord-icon><span style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-pages">Utilidades</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            
                            <li class="nav-item">
                                <a href="../talla/talla.php" class="nav-link" data-key="t-timeline"> Tallas </a>
                            </li>

                            <li class="nav-item">
                                        <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProfile" data-key="t-profile"> Unidades
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarProfile">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="../unidadMetrico/sistemaMetrico.php" class="nav-link" data-key="t-simple-page"> Sistemas Métricos </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="../unidadesCorporales/unidadCorporal.php" class="nav-link" data-key="t-settings"> Medidas Corporales </a>
                                                </li>
                                            </ul>
                                        </div>
                            </li>

                            <li class="nav-item">
                                <a href="../composicionCorporal/composicionCorporal.php" class="nav-link" data-key="t-pricing"> Composición Corporal </a>
                            </li>
                            <li class="nav-item">
                                <a href="../estatura/estatura.php" class="nav-link" data-key="t-privacy-policy">Estatura</a>
                            </li>
                            <li class="nav-item">
                                <a href="../divisas/divisas.php" class="nav-link" data-key="t-gallery"> Divisas </a>
                            </li>
                        
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/mhpmvwxb.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px;display:flex;">
                        </lord-icon><span style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-landing">Desafios NutriFit</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLanding">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="../nutriDesafiosAdd/nutriDesafios.php" class="nav-link" data-key="t-one-page"> Añadir Nuevos </a>
                            </li>
                            <li class="nav-item">
                                <a href="../listNutriDesafios/listNutriDesafios.php" class="nav-link" data-key="t-nft-landing"> Ver Lista </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                        <script src="https://cdn.lordicon.com/lordicon.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/gtmwvzrj.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:36px;height:36px;display:flex;">
                        </lord-icon>
                        <span style="margin-top: 0.4rem; margin-left:0.5rem" data-key="t-landing">Próximamente</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLanding">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-one-page"> IA. Merlin </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-nft-landing"> VideoLlamadas </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>