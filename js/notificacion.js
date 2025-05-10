
const util = {
  // Obtener token de autenticación
  getToken() {
    return localStorage.getItem("remember_token") || this.getCookie("remember_token");
  },
  
  // Obtener valor de una cookie
  getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    return parts.length === 2 ? parts.pop().split(";").shift() : null;
  },
  
  // Verificar autenticación y redirigir si no hay sesión
  checkAuth() {
    const token = this.getToken();
    if (!token) {
      Swal.fire({
        title: "Error de sesión",
        text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
        icon: "error",
        confirmButtonText: "Aceptar"
      }).then(() => window.location.href = "login.html");
      return false;
    }
    return token;
  },
  
  // Mostrar mensaje de error
  showError(message) {
    Swal.fire({
      title: "Error",
      text: message || "Ha ocurrido un error",
      icon: "error",
      confirmButtonText: "Aceptar"
    });
  },
  
  // Mostrar mensaje de éxito
  showSuccess(message) {
    Swal.fire({
      title: "¡Éxito!",
      text: message || "Operación completada con éxito",
      icon: "success",
      confirmButtonText: "Aceptar"
    });
  }
};

class Notificaciones {
  constructor() {
    this.badge = document.getElementById("notification-badge");
    this.badgeCounter = document.getElementById("notification-badge-counter");
    this.dropdown = document.getElementById("notification-dropdown");
    this.sound = new Audio("../sound/notificacion_reservacion.mp3");
    this.pollingInterval = 30000; // 30 segundos
    this.token = util.getToken();
    const BASE_URL = "http://127.0.0.1:8000";
    this.init();
  }

  init() {
    if (!util.checkAuth()) return;

    this.cargarNotificaciones();
    this.setupEventListeners();
    this.iniciarPolling();
  }

  cargarNotificaciones() {
    if (!util.checkAuth()) return;

    fetch(`${BASE_URL}/api/notificaciones`, {
      headers: {
        "remember-token": this.token,
      },
    })
      .then((response) => {
        if (response.status === 401) {
          util.showError(
            "Sesión expirada. Por favor inicie sesión nuevamente."
          );
          return;
        }
        if (!response.ok) throw new Error("Error al cargar notificaciones");
        return response.json();
      })
      .then((data) => {
        if (!data) return;
        console.log("Datos recibidos:", data); // Para depuración
        this.actualizarBadge(data.total);
        this.renderizarNotificaciones(data);
      })
      .catch((error) => {
        console.error("Error:", error);
        util.showError(error.message);
      });
  }

  actualizarBadge(count) {
    if (count > 0) {
      this.badge.textContent = count;
      this.badgeCounter.textContent = count;
      this.badge.style.display = "inline-block";
      this.badgeCounter.style.display = "inline-block";
    } else {
      this.badge.style.display = "none";
      this.badgeCounter.style.display = "none";
    }
  }

  renderizarNotificaciones(data) {
    // Eliminar mensajes vacíos existentes
    const defaultMessages = document.querySelectorAll(
      ".empty-notification-elem"
    );
    defaultMessages.forEach((el) => el.remove());

    // Renderizar notificaciones de reservaciones
    const reservacionesContainer =
      document.getElementById("alerts-tab-content");
    if (reservacionesContainer) {
      reservacionesContainer.innerHTML =
        data.reservaciones.length > 0
          ? this.generarHTMLNotificaciones(data.reservaciones, "reservacion")
          : '<div class="text-center py-3 empty-notification-elem">No hay reservaciones</div>';
    }

    // Renderizar notificaciones de chat
    const chatContainer = document.getElementById("messages-tab-content");
    if (chatContainer) {
      chatContainer.innerHTML =
        data.mensajes.length > 0
          ? this.generarHTMLNotificaciones(data.mensajes, "chat")
          : '<div class="text-center py-3 empty-notification-elem">No hay mensajes</div>';
    }

    // Renderizar todas las notificaciones juntas
    const allContainer = document.getElementById("all-noti-tab-content");
    if (allContainer) {
      if (data.total > 0) {
        // Solo si hay notificaciones, generamos el contenido
        const reservacionesHTML =
          data.reservaciones.length > 0
            ? this.generarHTMLNotificaciones(data.reservaciones, "reservacion")
            : "";
        const mensajesHTML =
          data.mensajes.length > 0
            ? this.generarHTMLNotificaciones(data.mensajes, "chat")
            : "";

        allContainer.innerHTML = reservacionesHTML + mensajesHTML;
      } else {
        // Si no hay notificaciones, mostramos el mensaje
        allContainer.innerHTML =
          '<div class="text-center py-3 empty-notification-elem">No hay notificaciones</div>';
      }
    }

    // Actualizar contadores en los tabs
    this.actualizarContadoresTabs(data);

    // Reiniciar SimpleBar en todos los contenedores
    this.reiniciarSimpleBar();
  }

    reiniciarSimpleBar() {
        // Seleccionar todos los contenedores que usan SimpleBar
        const containers = document.querySelectorAll('[data-simplebar]');
        
        containers.forEach(container => {
            // Si SimpleBar está disponible en el DOM
            if (typeof SimpleBar !== 'undefined') {
                // Verificar si ya tiene SimpleBar inicializado
                const existingInstance = container._simplebar;
                
                // Destruir la instancia existente si la hay
                if (existingInstance) {
                    existingInstance.unMount();
                }
                
                // Crear nueva instancia de SimpleBar
                new SimpleBar(container, {
                    autoHide: false
                });
            }
        });
    }

  // Añade este nuevo método para actualizar los contadores
  actualizarContadoresTabs(data) {
    const counts = {
      "all-noti-tab": data.total,
      "messages-tab": data.mensajes.length,
      "alerts-tab": data.reservaciones.length,
    };

    Object.entries(counts).forEach(([tabId, count]) => {
      // Selector más específico para los tabs
      const tab = document.querySelector(
        `#notificationItemsTab a[href="#${tabId}"] .noti-count`
      );
      if (tab) {
        tab.textContent = count;
      } else {
        console.error(`No se encontró el contador para ${tabId}`);
      }
    });
  }

  

  generarHTMLNotificaciones(notificaciones, tipo) {
    return notificaciones
      .map((notif) => {
        const fecha = new Date(notif.fecha_creacion).toLocaleString("es-MX", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });

        const icono =
          tipo === "reservacion" ? "bx bx-calendar-check" : "bx bx-chat";
        const color =
          tipo === "reservacion"
            ? "bg-info-subtle text-info"
            : "bg-warning-subtle text-warning";

        return `
                <div class="text-reset notification-item d-block dropdown-item position-relative" data-id="${
                  notif.Notificacion_ID
                }" data-type="${tipo}">
                    <div class="d-flex">
                        <div class="avatar-xs me-3 flex-shrink-0">
                            <span class="avatar-title ${color} rounded-circle fs-16">
                                <i class="${icono}"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <a href="${this.getLinkNotificacion(
                              notif,
                              tipo
                            )}" class="stretched-link">
                                <h6 class="mt-0 mb-2 lh-base">${notif.nombre} ${
          notif.apellidos
        }</h6>
                                <p class="mb-0">${notif.descripcion_mensaje}</p>
                            </a>
                            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span><i class="mdi mdi-clock-outline"></i> ${fecha}</span>
                            </p>
                        </div>
                        <div class="px-2 fs-15">
                            <div class="form-check notification-check">
                                <input class="form-check-input" type="checkbox" value="" id="notif-check-${
                                  notif.Notificacion_ID
                                }">
                                <label class="form-check-label" for="notif-check-${
                                  notif.Notificacion_ID
                                }"></label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
      })
      .join("");
  }

  getLinkNotificacion(notificacion, tipo) {
    if (tipo === "reservacion") {
      return "http://localhost/NutriFit/views/citaAgendadas/calendarioCitas.php";
    } else {
      return "#chat"; // Ajusta según tu implementación de chat
    }
  }

  setupEventListeners() {
    // Marcar como leída al hacer click
    this.dropdown.addEventListener("click", (e) => {
      const notifItem = e.target.closest(".notification-item");
      if (notifItem) {
        const notifId = notifItem.dataset.id;
        this.marcarComoLeida(notifId);
      }
    });

    // Ver todas las notificaciones
    document
      .querySelector(".view-all button")
      ?.addEventListener("click", () => {
        window.location.href = "#";
      });
  }

  marcarComoLeida(id) {
    if (!util.checkAuth()) return;

    fetch(`${BASE_URL}/api/notificaciones/marcar-leida/${id}`, {
      method: "POST",
      headers: {
        "remember-token": this.token,

        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (response.status === 401) {
          util.showError(
            "Sesión expirada. Por favor inicie sesión nuevamente."
          );
          return;
        }
        if (!response.ok) throw new Error("Error al marcar como leída");
        return response.json();
      })
      .catch((error) => {
        console.error("Error:", error);
        util.showError(error.message);
      });
  }

  // Nuevo método para manejar la reproducción del sonido
  async reproducirSonido() {
    try {
      // Reiniciar el sonido si ya estaba reproduciéndose
      this.sound.currentTime = 0;

      // Intentar reproducir
      await this.sound.play();
    } catch (error) {
      console.error("Error reproduciendo sonido:", error);

      // Solución para políticas de autoplay: requiere interacción del usuario
      document.addEventListener(
        "click",
        () => {
          this.sound
            .play()
            .catch((e) => console.error("Error después de interacción:", e));
        },
        { once: true }
      );
    }
  }

  iniciarPolling() {
    this.pollingTimer = setInterval(() => {
      if (!util.checkAuth()) {
        clearInterval(this.pollingTimer);
        return;
      }

      fetch(`${BASE_URL}/api/notificaciones/contar`, {
        headers: { "remember-token": this.token },
      })
        .then((response) => {
          if (response.status === 401) {
            clearInterval(this.pollingTimer);
            util.showError(
              "Sesión expirada. Por favor inicie sesión nuevamente."
            );
            return;
          }
          if (!response.ok) throw new Error("Error al contar notificaciones");
          return response.json();
        })
        .then((data) => {
          if (!data) return;
          const currentCount = parseInt(this.badge.textContent) || 0;
          if (data.total > currentCount) {
            this.reproducirSonido().then(() => {
              this.cargarNotificaciones();
            });
          } else if (data.total < currentCount) {
            this.cargarNotificaciones();
          }
        })
        .catch((error) => console.error("Error:", error));
    }, this.pollingInterval);
  }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('notification-dropdown')) {
        new Notificaciones();
        
    }
});
