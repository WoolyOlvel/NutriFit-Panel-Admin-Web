// notificaciones.js - Versión autocontenida y aislada
(function() {
    'use strict';

    class NotificacionesManager {
        constructor(config = {}) {
            // Configuración con valores por defecto
            this.config = {
                baseUrl: config.baseUrl || 'http://127.0.0.1:8000',
                soundPath: config.soundPath || 'http://'+window.location.hostname+'/NutriFit/sound/notificacion_reservacion.mp3',
                pollingInterval: config.pollingInterval || 30000,
                token: config.token || this.getToken(),
                authCheck: config.authCheck || (() => !!this.config.token) // Corregido para usar config.token
            
            };

            // Depuración del token
            console.debug('Token inicial:', this.config.token);
            if (!this.config.token) {
                console.warn('No se encontró token inicial. Fuentes verificadas:',
                    {
                        localStorage: localStorage.getItem('remember_token'),
                        cookie: this.getCookie('remember_token'),
                        util: (typeof util !== 'undefined' ? 'Disponible' : 'No disponible')
                    });
            }

            // Elementos del DOM
            this.elements = {
                badge: document.getElementById('notification-badge'),
                badgeCounter: document.getElementById('notification-badge-counter'),
                dropdown: document.getElementById('notification-dropdown'),
                containers: {
                    all: document.getElementById('all-noti-tab-content'),
                    messages: document.getElementById('messages-tab-content'),
                    alerts: document.getElementById('alerts-tab-content')
                },
                tabs: {
                    all: document.querySelector('#notificationItemsTab a[href="#all-noti-tab"] .noti-count'),
                    messages: document.querySelector('#notificationItemsTab a[href="#messages-tab"] .noti-count'),
                    alerts: document.querySelector('#notificationItemsTab a[href="#alerts-tab"] .noti-count')
                }
            };

            // Estado y recursos
            this.sound = new Audio();
            this.sound.preload = 'auto';
            this.sound.src = this.config.soundPath;
            
            // Verifica errores de carga
            this.sound.addEventListener('error', () => {
                console.error('Error cargando el sonido:', {
                    code: this.sound.error.code,
                    message: this.getAudioErrorDescription(this.sound.error.code)
                });
            });
            this.pollingTimer = null;
            this.initialized = false;
            this.audioPermissionGranted = false;
            this.initializeAudioPermission();
            // Inicialización segura
            this.safeInitialize();
       
        }

        initializeAudioPermission() {
            // Intenta reproducir y pausar inmediatamente para "desbloquear" el audio
            const unlockAudio = () => {
                const testSound = new Audio();
                testSound.volume = 0;
                testSound.src = 'data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YU...'; // Sonido silencioso
                testSound.play()
                    .then(() => {
                        this.audioPermissionGranted = true;
                        testSound.pause();
                    })
                    .catch(e => console.debug('No se pudo obtener permiso de audio inicial:', e));
            };

            // Intenta en el evento de carga
            document.addEventListener('DOMContentLoaded', unlockAudio);
            
            // También intenta con el primer click del usuario
            document.addEventListener('click', () => {
                if (!this.audioPermissionGranted) {
                    unlockAudio();
                }
            }, { once: true });
        }


        getAudioErrorDescription(code) {
            const errors = {
                1: 'MEDIA_ERR_ABORTED - El usuario canceló la carga',
                2: 'MEDIA_ERR_NETWORK - Error de red',
                3: 'MEDIA_ERR_DECODE - Error al decodificar el archivo',
                4: 'MEDIA_ERR_SRC_NOT_SUPPORTED - Formato no soportado'
            };
            return errors[code] || `Código de error desconocido: ${code}`;
        }

        // Métodos principales
        safeInitialize() {
            try {
                if (!this.checkRequirements()) return;
                
                this.initialized = true;
                this.loadNotifications();
                this.setupEventListeners();
                this.startPolling();
                
                console.log('NotificacionesManager inicializado correctamente');
            } catch (error) {
                console.error('Error inicializando NotificacionesManager:', error);
            }
        }

        checkRequirements() {
            // Verificar elementos del DOM
            const domElementsFound = this.elements.badge && this.elements.badgeCounter && this.elements.dropdown;
            if (!domElementsFound) {
                console.warn('Elementos del DOM para notificaciones no encontrados:', {
                    badge: !!this.elements.badge,
                    badgeCounter: !!this.elements.badgeCounter,
                    dropdown: !!this.elements.dropdown
                });
                return false;
            }

            // Verificar autenticación
            const isAuthenticated = this.config.authCheck();
            if (!isAuthenticated) {
                console.warn('No hay token de autenticación válido. Token actual:', this.config.token);
                console.warn('Sugerencias:',
                    '1. Verifica que el usuario esté autenticado',
                    '2. Comprueba que el token se guarde correctamente al iniciar sesión',
                    '3. Revisa los nombres de las cookies/tokens (debe ser "remember_token")');
                return false;
            }

            return true;
        }

        // Sistema de autenticación autocontenido
        getToken() {
            // 1. Verificar token en config (si se pasó explícitamente)
            if (this.config && this.config.token) {
                return this.config.token;
            }
            
            // 2. Intentar con localStorage
            const localStorageToken = localStorage.getItem('remember_token');
            if (localStorageToken) {
                console.debug('Token encontrado en localStorage');
                return localStorageToken;
            }
            
            // 3. Intentar con cookies
            const cookieToken = this.getCookie('remember_token');
            if (cookieToken) {
                console.debug('Token encontrado en cookies');
                return cookieToken;
            }
            
            // 4. Intentar con util si existe (para compatibilidad)
            if (typeof util !== 'undefined' && typeof util.getToken === 'function') {
                console.debug('Obteniendo token mediante util.getToken()');
                return util.getToken();
            }
            
            console.warn('No se pudo encontrar token en ninguna fuente');
            return null;
        }

        getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            return parts.length === 2 ? parts.pop().split(';').shift() : null;
        }

        // Métodos de notificaciones
        loadNotifications() {
            fetch(`${this.config.baseUrl}/api/notificaciones`, {
                headers: { 'remember-token': this.config.token }
            })
            .then(response => this.handleResponse(response))
            .then(data => this.updateUI(data))
            .catch(error => this.handleError(error));
        }

        handleResponse(response) {
            if (response.status === 401) {
                this.showAuthError();
                throw new Error('Unauthorized');
            }
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        }

        updateUI(data) {
            if (!data) return;
            
            this.updateBadge(data.total);
            this.renderNotifications(data);
            this.resetSimpleBar();
        }

        updateBadge(count) {
            if (count > 0) {
                this.elements.badge.textContent = count;
                this.elements.badgeCounter.textContent = count;
                this.elements.badge.style.display = "inline-block";
                this.elements.badgeCounter.style.display = "inline-block";
            } else {
                this.elements.badge.style.display = "none";
                this.elements.badgeCounter.style.display = "none";
            }
        }

        renderNotifications(data) {
            // Eliminar mensajes vacíos existentes
            const defaultMessages = document.querySelectorAll('.empty-notification-elem');
            defaultMessages.forEach(el => el.remove());

            // Renderizar notificaciones de reservaciones
            if (this.elements.containers.alerts) {
                this.elements.containers.alerts.innerHTML = 
                    data.reservaciones.length > 0
                        ? this.generateNotificationHTML(data.reservaciones, 'reservacion')
                        : '<div class="text-center py-3 empty-notification-elem">No hay reservaciones</div>';
            }

            // Renderizar notificaciones de chat
            if (this.elements.containers.messages) {
                this.elements.containers.messages.innerHTML = 
                    data.mensajes.length > 0
                        ? this.generateNotificationHTML(data.mensajes, 'chat')
                        : '<div class="text-center py-3 empty-notification-elem">No hay mensajes</div>';
            }

            // Renderizar todas las notificaciones juntas
            if (this.elements.containers.all) {
                if (data.total > 0) {
                    const reservacionesHTML = data.reservaciones.length > 0
                        ? this.generateNotificationHTML(data.reservaciones, 'reservacion')
                        : "";
                    const mensajesHTML = data.mensajes.length > 0
                        ? this.generateNotificationHTML(data.mensajes, 'chat')
                        : "";

                    this.elements.containers.all.innerHTML = reservacionesHTML + mensajesHTML;
                } else {
                    this.elements.containers.all.innerHTML = 
                        '<div class="text-center py-3 empty-notification-elem">No hay notificaciones</div>';
                }
            }

            // Actualizar contadores en los tabs
            this.updateTabCounters(data);
        }

        generateNotificationHTML(notifications, type) {
            return notifications.map(notif => {
                const fecha = new Date(notif.fecha_creacion).toLocaleString('es-MX', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const icon = type === 'reservacion' ? 'bx bx-calendar-check' : 'bx bx-chat';
                const color = type === 'reservacion' 
                    ? 'bg-info-subtle text-info' 
                    : 'bg-warning-subtle text-warning';

                return `
                    <div class="text-reset notification-item d-block dropdown-item position-relative" 
                         data-id="${notif.Notificacion_ID}" data-type="${type}">
                        <div class="d-flex">
                            <div class="avatar-xs me-3 flex-shrink-0">
                                <span class="avatar-title ${color} rounded-circle fs-16">
                                    <i class="${icon}"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <a href="${this.getNotificationLink(notif, type)}" class="stretched-link">
                                    <h6 class="mt-0 mb-2 lh-base">${notif.nombre} ${notif.apellidos}</h6>
                                    <p class="mb-0">${notif.descripcion_mensaje}</p>
                                </a>
                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                    <span><i class="mdi mdi-clock-outline"></i> ${fecha}</span>
                                </p>
                            </div>
                            <div class="px-2 fs-15">
                                <div class="form-check notification-check">
                                    <input class="form-check-input" type="checkbox" value="" 
                                           id="notif-check-${notif.Notificacion_ID}">
                                    <label class="form-check-label" for="notif-check-${notif.Notificacion_ID}"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        getNotificationLink(notification, type) {
            if (type === 'reservacion') {
                return 'http://localhost/NutriFit/views/citaAgendadas/calendarioCitas.php';
            }
            return '#chat';
        }

        updateTabCounters(data) {
            if (this.elements.tabs.all) this.elements.tabs.all.textContent = data.total;
            if (this.elements.tabs.messages) this.elements.tabs.messages.textContent = data.mensajes.length;
            if (this.elements.tabs.alerts) this.elements.tabs.alerts.textContent = data.reservaciones.length;
        }

        resetSimpleBar() {
            const containers = document.querySelectorAll('[data-simplebar]');
            
            containers.forEach(container => {
                if (typeof SimpleBar !== 'undefined') {
                    const existingInstance = container._simplebar;
                    
                    if (existingInstance) {
                        existingInstance.unMount();
                    }
                    
                    new SimpleBar(container, { autoHide: false });
                }
            });
        }

        setupEventListeners() {
            // Marcar como leída al hacer click
            this.elements.dropdown.addEventListener('click', (e) => {
                const notifItem = e.target.closest('.notification-item');
                if (notifItem) {
                    const notifId = notifItem.dataset.id;
                    this.markAsRead(notifId);
                }
            });

            // Ver todas las notificaciones
            document.querySelector('.view-all button')?.addEventListener('click', () => {
                window.location.href = '#';
            });
        }

        markAsRead(id) {
            fetch(`${this.config.baseUrl}/api/notificaciones/marcar-leida/${id}`, {
                method: 'POST',
                headers: {
                    'remember-token': this.config.token,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => this.handleResponse(response))
            .catch(error => this.handleError(error));
        }

        async playSound() {
            try {
                // Verifica si el sonido está cargado correctamente
                if (!this.sound || !this.sound.src) {
                    throw new Error('El elemento de audio no está configurado correctamente');
                }

                // Verifica si el navegador soporta el formato
                if (this.sound.error) {
                    throw new Error(`Error en el audio: ${this.sound.error.message}`);
                }

                this.sound.currentTime = 0;
                this.sound.volume = 0.7;
                
                // Intenta reproducir
                const promise = this.sound.play();
                
                if (promise !== undefined) {
                    await promise.catch(async error => {
                        console.warn('Autoplay bloqueado:', error);
                        await this.handlePlaybackError();
                    });
                }
            } catch (error) {
                console.error('Error en playSound:', error);
                this.showSoundErrorToast();
            }
        }

        async handlePlaybackError() {
            // Muestra toast para interacción
            const toast = this.createSoundPermissionToast();
            document.body.appendChild(toast);
            
            try {
                // Espera interacción del usuario
                await this.waitForUserInteraction();
                await this.sound.play();
            } catch (finalError) {
                console.error('Error final:', finalError);
                throw finalError;
            } finally {
                toast.remove();
            }
        }



        createSoundPermissionToast() {
            const toast = document.createElement('div');
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.backgroundColor = '#333';
            toast.style.color = 'white';
            toast.style.padding = '15px';
            toast.style.borderRadius = '5px';
            toast.style.zIndex = '9999';
            toast.style.boxShadow = '0 2px 10px rgba(0,0,0,0.2)';
            toast.innerHTML = `
                <p>Por favor, haz clic en cualquier parte para permitir sonidos de notificaciones</p>
                <small>Este sitio necesita tu permiso para reproducir sonidos</small>
            `;
            return toast;
        }

        waitForUserInteraction() {
            return new Promise(resolve => {
                const handler = () => {
                    document.removeEventListener('click', handler);
                    document.removeEventListener('keydown', handler);
                    resolve();
                };
                
                document.addEventListener('click', handler, { once: true });
                document.addEventListener('keydown', handler, { once: true });
            });
        }


        startPolling() {
            this.pollingTimer = setInterval(() => {
                if (!this.config.authCheck()) {
                    clearInterval(this.pollingTimer);
                    return;
                }

                fetch(`${this.config.baseUrl}/api/notificaciones/contar`, {
                    headers: { 'remember-token': this.config.token }
                })
                .then(response => this.handleResponse(response))
                .then(data => {
                    if (!data) return;
                    const currentCount = parseInt(this.elements.badge.textContent) || 0;
                    
                    if (data.total > currentCount) {
                        // Solo reproducir sonido si hay nuevas notificaciones
                        if (data.total > currentCount) {
                            this.playSound().catch(e => console.error('Error al reproducir sonido:', e));
                        }
                        this.loadNotifications();
                    } else if (data.total < currentCount) {
                        this.loadNotifications();
                    }
                })
                .catch(error => console.error('Error:', error));
            }, this.config.pollingInterval);
        }

        removeEventListeners() {
            // Implementar si es necesario limpiar event listeners
        }

        // Sistema de manejo de errores autocontenido
        handleError(error) {
            console.error('Error en NotificacionesManager:', error);
            this.showMessage('Error: ' + (error.message || 'Ocurrió un error'));
        }

        showAuthError() {
            this.showMessage('Sesión expirada. Por favor inicie sesión nuevamente.');
        }

        showMessage(message) {
            // Implementación simple que no depende de util
            console.warn(message);
            
            // Intenta usar Swal si está disponible, si no usa alert
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: message,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                alert(message);
            }
        }

        // Limpieza
        destroy() {
            if (this.pollingTimer) clearInterval(this.pollingTimer);
            this.removeEventListeners();
            this.initialized = false;
        }
    }

    // Inicialización segura cuando el DOM está listo
    document.addEventListener('DOMContentLoaded', () => {
        // Solo inicializar si existe el contenedor
        if (document.getElementById('notification-dropdown')) {
            try {
                // Opcional: pasar configuración personalizada
                window.notificacionesManager = new NotificacionesManager({
                    //baseUrl: 'http://127.0.0.1:8000',
                    //remember_token: this.getCookie('remember_token') || localStorage.getItem('remember_token')
                });
            } catch (error) {
                console.error('Error al crear NotificacionesManager:', error);
            }
        }
    });

})();