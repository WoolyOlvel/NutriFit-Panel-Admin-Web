<?php
require_once("../html/session.php");
?>


<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar-size="lg" data-sidebar="dark" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Chat | NutriFit Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Chat NutriFit Planner" name="description" />
    <meta content="ASCRIB" name="author" />
    <?php
    require_once("../html/head.php");
    ?>
    <!-- glightbox css -->
    <link rel="stylesheet" href="../../assets/libs/glightbox/css/glightbox.min.css">>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        .sk-chase {
            width: 40px;
            height: 40px;
            position: relative;
            animation: sk-chase 2.5s infinite linear both;
        }

        .sk-chase-dot {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            animation: sk-chase-dot 2.0s infinite ease-in-out both;
        }

        .sk-chase-dot:before {
            content: '';
            display: block;
            width: 25%;
            height: 25%;
            background-color: #9fa1a5;
            border-radius: 100%;
            animation: sk-chase-dot-before 2.0s infinite ease-in-out both;
        }

        .sk-chase-dot:nth-child(1) {
            animation-delay: -1.1s;
        }

        .sk-chase-dot:nth-child(2) {
            animation-delay: -1.0s;
        }

        .sk-chase-dot:nth-child(3) {
            animation-delay: -0.9s;
        }

        .sk-chase-dot:nth-child(4) {
            animation-delay: -0.8s;
        }

        .sk-chase-dot:nth-child(5) {
            animation-delay: -0.7s;
        }

        .sk-chase-dot:nth-child(6) {
            animation-delay: -0.6s;
        }

        .sk-chase-dot:nth-child(1):before {
            animation-delay: -1.1s;
        }

        .sk-chase-dot:nth-child(2):before {
            animation-delay: -1.0s;
        }

        .sk-chase-dot:nth-child(3):before {
            animation-delay: -0.9s;
        }

        .sk-chase-dot:nth-child(4):before {
            animation-delay: -0.8s;
        }

        .sk-chase-dot:nth-child(5):before {
            animation-delay: -0.7s;
        }

        .sk-chase-dot:nth-child(6):before {
            animation-delay: -0.6s;
        }

        @keyframes sk-chase {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes sk-chase-dot {

            80%,
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes sk-chase-dot-before {
            50% {
                transform: scale(0.4);
            }

            100%,
            0% {
                transform: scale(1.0);
            }
        }


        a.fg-emoji-picker-close-button {
            background-color: #dedede;
        }

        .fg-emoji-picker {
            /* position: fixed; */
            position: absolute;
            z-index: 999;
            width: 300px;
            min-height: 360px;
            background-color: white;
            box-shadow: 0px 2px 13px -2px rgba(0, 0, 0, 0.1803921568627451);
            border-radius: 4px;
            overflow: hidden;
        }

        .fg-emoji-picker .fg-emoji-picker-all-categories {
            height: 301px;
            overflow-y: auto;
            padding: 0 15px 15px 15px;
        }

        .fg-emoji-picker .fg-emoji-picker-container-title {
            color: black;
            margin: 10px 0;
        }

        .fg-emoji-picker * {
            margin: 0;
            padding: 0;
            text-decoration: none;
            color: #666;
            font-family: sans-serif;
        }

        .fg-emoji-picker ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .fg-emoji-picker .fg-emoji-picker-category {
            margin-top: 1px;
            padding-top: 15px;
        }

        .fg-emoji-picker-categories svg {
            width: 17px;
            height: 17px;
        }

        .fg-emoji-picker-grid {
            display: flex;
            flex-wrap: wrap;
        }

        .fg-emoji-picker-grid>li {
            cursor: pointer;
            flex: 0 0 calc(100% / 5);
            max-width: calc(100% / 5);
            height: 48px;
            min-width: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all .2s ease;
            background-color: white;
        }

        .fg-emoji-picker-grid>li:hover {
            background-color: #99c9ef;
        }

        .fg-emoji-picker-grid>li:hover a {
            -webkit-transform: scale(1.2);
            -ms-transform: scale(1.2);
            -moz-transform: scale(1.2);
            transform: scale(1.2);
        }

        .fg-emoji-picker-grid>li>a {
            display: block;
            font-size: 25px;
            margin: 0;
            padding: 25px 0px;
            line-height: 0;
            -webkit-transition: all .3s ease;
            -moz-transition: all .3s ease;
            -ms-transition: all .3s ease;
            transition: all .3s ease;
        }

        /* FILTERS */
        .fg-emoji-picker-categories {
            /*padding: 0 15px;*/
            background: #ececec;
        }

        .fg-emoji-picker-categories ul {
            display: flex;
            flex-wrap: wrap;
        }

        .fg-emoji-picker-categories li {
            flex: 1;
        }

        .fg-emoji-picker-categories li.active {
            background-color: #99c9ef;
        }

        .fg-emoji-picker-categories a {
            padding: 12px 7px;
            display: flex;
            text-align: center;
            justify-content: center;
            align-items: center;
            transition: all .2s ease;
        }

        .fg-emoji-picker-categories a:hover {
            background-color: #99c9ef;
        }

        .fg-emoji-picker-search {
            position: relative;
            height: 25px;
        }

        .fg-emoji-picker-search input {
            position: absolute;
            width: 85%;
            left: 0;
            top: 0;
            border: none;
            padding: 5px 30px 5px 15px;
            outline: none;
            background-color: #dedede;
            font-size: 12px;
            color: #616161;
        }

        .fg-emoji-picker-search svg {
            width: 15px;
            height: 15px;
            position: absolute;
            right: 7px;
            top: 5px;
            fill: #333333;
            pointer-events: none;
        }


        /* FOOTER */
        .fg-emoji-picker-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            height: 50px;
            padding: 0 15px 15px 15px;
        }

        .fg-emoji-picker-footer-icon {
            font-size: 30px;
            margin-right: 8px;
        }


    </style>



</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        require_once("../html/header.php");
        ?>
        <!-- ========== App Menu ========== -->
        <?php
        require_once("../html/menu.php");
        ?>

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n6 p-1">
                        <div class="chat-leftsidebar">
                            <div class="px-4 pt-4 mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-4">Chats</h5>
                                    </div>
                                    <div class="flex-shrink-0">

                                    </div>
                                </div>
                                <div class="search-box">
                                    <input type="text" class="form-control bg-light border-light" placeholder="Buscar...">
                                    <i class="ri-search-2-line search-icon"></i>
                                </div>
                            </div> <!-- .p-4 -->

                            <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#chats" role="tab">
                                        Chats
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab">
                                        Pacientes
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="chats" role="tabpanel">
                                    <div class="chat-room-list pt-3" data-simplebar>
                                        <div class="d-flex align-items-center px-4 mb-2">
                                            <div class="flex-grow-1">
                                                <h4 class="mb-0 fs-11 text-muted text-uppercase">Mensajes</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="Nuevo Mensaje">

                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-soft-success btn-sm shadow-none">
                                                        <i class="ri-add-line align-bottom"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="chat-message-list">

                                            <ul class="list-unstyled chat-list chat-user-list" id="userList">

                                            </ul>
                                        </div>

                                        <!-- End chat-message-list -->
                                    </div>
                                </div>
                                <div class="tab-pane" id="contacts" role="tabpanel">
                                    <div class="chat-room-list pt-3" data-simplebar>
                                        <div class="sort-contact">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end tab contact -->
                        </div>
                        <!-- end chat leftsidebar -->
                        <!-- Start User chat -->
                        <div class="user-chat w-100 overflow-hidden">

                            <div class="chat-content d-lg-flex">
                                <!-- start chat conversation section -->
                                <div class="w-100 overflow-hidden position-relative">
                                    <!-- conversation user -->
                                    <div class="position-relative">


                                        <div class="position-relative" id="users-chat">
                                            <div class="p-3 user-chat-topbar">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-4 col-8">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                                <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i class="ri-arrow-left-s-line align-bottom"></i></a>
                                                            </div>
                                                            <div class="flex-grow-1 overflow-hidden">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                                        <img src="../../assets/images/perfil_prueba.png" class="rounded-circle avatar-xs" alt="">
                                                                        <span class="user-status"></span>
                                                                    </div>
                                                                    <div class="flex-grow-1 overflow-hidden">
                                                                        <h5 class="text-truncate mb-0 fs-16"><a class="text-reset username" data-bs-toggle="offcanvas" href="#userProfileCanvasExample" aria-controls="userProfileCanvasExample">Alcrya Lumina</a></h5>
                                                                        <p class="text-truncate text-muted fs-14 mb-0 userStatus"><small>En Linea</small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 col-4">
                                                        <ul class="list-inline user-chat-nav text-end mb-0">
                                                            <li class="list-inline-item m-0">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-ghost-secondary btn-icon" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i data-feather="search" class="icon-sm"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
                                                                        <div class="p-2">
                                                                            <div class="search-box">
                                                                                <input type="text" class="form-control bg-light border-light" placeholder="Buscar..." onkeyup="searchMessages()" id="searchMessage">
                                                                                <i class="ri-search-2-line search-icon"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li class="list-inline-item d-none d-lg-inline-block m-0">
                                                                <button type="button" class="btn btn-ghost-secondary btn-icon" data-bs-toggle="offcanvas" data-bs-target="#userProfileCanvasExample" aria-controls="userProfileCanvasExample">
                                                                    <i data-feather="info" class="icon-sm"></i>
                                                                </button>
                                                            </li>

                                                            <li class="list-inline-item m-0">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-ghost-secondary btn-icon" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i data-feather="more-vertical" class="icon-sm"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <a class="dropdown-item d-block d-lg-none user-profile-show" href="#"><i class="ri-user-2-fill align-bottom text-muted me-2"></i> Ver Perfil</a>

                                                                        <a class="dropdown-item" href="#"><i class="ri-delete-bin-5-line align-bottom text-muted me-2"></i> Eliminar Chat</a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end chat user head -->
                                            <div class="chat-conversation p-3 p-lg-4 " id="chat-conversation" data-simplebar>
                                                <div id="elmLoader">
                                                    <div class="spinner-border text-primary avatar-sm" role="status">
                                                        <span class="visually-hidden">Cargando...</span>
                                                    </div>
                                                </div>
                                                <ul class="list-unstyled chat-conversation-list" id="users-conversation">

                                                </ul>
                                                <!-- end chat-conversation-list -->
                                            </div>
                                            <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show " id="copyClipBoard" role="alert">
                                                Mensaje Copiado
                                            </div>
                                        </div>

                                        <div class="position-relative" id="channel-chat">
                                           
                                            <!-- end chat user head -->
                                            <div class="chat-conversation p-3 p-lg-4" id="chat-conversation" data-simplebar>
                                                <ul class="list-unstyled chat-conversation-list" id="channel-conversation">
                                                </ul>
                                                <!-- end chat-conversation-list -->

                                            </div>
                                          
                                        </div>

                                        <!-- end chat-conversation -->

                                        <div class="chat-input-section p-3 p-lg-4" >

                                            <form id="chatinput-form" enctype="multipart/form-data">
                                                <div class="row g-0 align-items-center">
                                                    <div class="col-auto">
                                                        <div class="chat-input-links me-2">
                                                            <div class="links-list-item">
                                                                <button type="button" class="btn btn-link text-decoration-none emoji-btn" id="emoji-btn">
                                                                    <i class="bx bx-smile align-middle"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="chat-input-feedback">
                                                            Por favor ingrese un mensaje
                                                        </div>
                                                        <input type="text" class="form-control chat-input bg-light border-light" id="chat-input" placeholder="Escribe tu mensaje..." autocomplete="off">
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="chat-input-links ms-2">
                                                            <div class="links-list-item">
                                                                <button type="submit" class="btn btn-success chat-send waves-effect waves-light">
                                                                    <i class="ri-send-plane-2-fill align-bottom"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                        <div class="replyCard">
                                            <div class="card mb-0">
                                                <div class="card-body py-3">
                                                    <div class="replymessage-block mb-0 d-flex align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h5 class="conversation-name"></h5>
                                                            <p class="mb-0"></p>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <button type="button" id="close_toggle" class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                                                <i class="bx bx-x align-middle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end chat-wrapper -->

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

    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="userProfileCanvasExample">
        <!--end offcanvas-header-->
        <div class="offcanvas-body profile-offcanvas p-0">
            <div class="team-cover">
                <img src="../../assets/images/background2.jpg" alt="" class="img-fluid" />
            </div>
            <div class="p-1 pb-4 pt-0">
                <div class="team-settings">
                    <div class="row g-0">
                        <div class="col">
                            <div class="btn nav-btn">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="user-chat-nav d-flex">

                            </div>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="p-3 text-center">
                <img src="../../assets/images/perfil_prueba.png" alt="" class="avatar-lg img-thumbnail rounded-circle mx-auto profile-img">
                <div class="mt-3">
                    <h5 class="fs-16 mb-1"><a href="javascript:void(0);" class="link-primary username">Alcrya Lumina</a></h5>
                    <p class="text-muted"><i class="ri-checkbox-blank-circle-fill me-1 align-bottom text-success"></i>En Linea</p>
                </div>
            </div>

            <div class="border-top border-top-dashed p-3">
                <h5 class="fs-15 mb-3">Datos Personales</h5>
                <div class="mb-3">
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Número De Telefóno</p>
                    <h6>+(52) 9961025841</h6>
                </div>
                <div class="mb-3">
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Correo Electrónico</p>
                    <h6>LyrcaLumina@hotmail.com</h6>
                </div>
                <div>
                    <p class="text-muted text-uppercase fw-medium fs-12 mb-1">Residente</p>
                    <h6 class="mb-0">Mérida, Yucatan</h6>
                </div>
            </div>


        </div>
        <!--end offcanvas-body-->
    </div>
    <!--end offcanvas-->


    <?php
    require_once("../html/js.php");
    ?>

    <!-- Carga primero las dependencias necesarias -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="../../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../../assets/libs/@simonwep/pickr/pickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
    
    <!-- Carga solo UNA versión de GLightbox (elimina el duplicado) -->
    <script src="../../assets/libs/glightbox/js/glightbox.min.js"></script>

    <!-- fgEmojiPicker -->
    <script src="../../assets/libs/fg-emoji-picker/fgEmojiPicker.js"></script>

    <!-- Inicialización de componentes después de cargar todo -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar GLightbox
            const lightbox = GLightbox({
                selector: '.popup-img',
                title: false
            });

            // Verificar que los elementos del chat existen antes de inicializar
            if (document.getElementById('chat-conversation') && document.getElementById('userList')) {
                // Cargar chat.init.js dinámicamente para asegurar el orden
                const chatScript = document.createElement('script');
                chatScript.src = "../../assets/js/pages/chat.init.js";
                chatScript.onload = function() {
                    console.log('Chat inicializado correctamente');
                    // Asegurar que el input section esté visible
                    document.querySelector('.chat-input-section').style.display = 'block';
                };
                document.body.appendChild(chatScript);
            } else {
                console.error('Elementos esenciales del chat no encontrados');
            }
        });
    </script>

    <script>
        // Verificador de carga
        window.addEventListener('load', function() {
            console.log('Elementos cargados:');
            console.log('Chat conversation:', document.getElementById('chat-conversation'));
            console.log('User list:', document.getElementById('userList'));
            console.log('Chat input:', document.getElementById('chat-input'));

        });
    </script>


    <script src="mensajeria.js"></script>

</body>

</html>