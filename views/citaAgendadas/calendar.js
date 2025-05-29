const BASE_URL = "https://nutrifitplanner.site";

document.addEventListener("DOMContentLoaded", function () {
  // Referencias DOM y variables de estado
  const elements = {
    calendar: document.getElementById("calendar"),
    eventModal: document.getElementById("event-modal")
      ? new bootstrap.Modal(document.getElementById("event-modal"))
      : null,
    modalTitle: document.getElementById("modal-title"),
    formEvent: document.getElementById("form-event"),
    btnDeleteEvent: document.getElementById("btn-delete-event"),
    btnSaveEvent: document.getElementById("btn-save-event"),
    btnCloseEvent: document.getElementById("btn-close-event"),
    upcomingEventList: document.getElementById("upcoming-event-list"),
  };

  let selectedEvent = null;
  let calendar;

  // ------------------------------------------------
  // UTILIDADES
  // ------------------------------------------------
  const util = {
    getToken() {
      return (
        localStorage.getItem("remember_token") ||
        this.getCookie("remember_token")
      );
    },

    getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      return parts.length === 2 ? parts.pop().split(";").shift() : null;
    },

    checkAuth() {
      const token = this.getToken();
      if (!token) {
        Swal.fire({
          title: "Error de sesión",
          text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
          icon: "error",
          confirmButtonText: "Aceptar",
        }).then(() => (window.location.href = "login.html"));
        return false;
      }
      return token;
    },

    showError(message) {
      Swal.fire({
        title: "Error",
        text: message || "Ha ocurrido un error",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    },

    showSuccess(message) {
      Swal.fire({
        title: "¡Éxito!",
        text: message || "Operación completada con éxito",
        icon: "success",
        confirmButtonText: "Aceptar",
      });
    },

    elementExists(id) {
      return document.getElementById(id) !== null;
    },

    setElementValue(id, value) {
      const element = document.getElementById(id);
      if (element) {
        element.value = value !== undefined && value !== null ? value : "";
        return true;
      }
      return false;
    },

    setElementText(id, text) {
      const element = document.getElementById(id);
      if (element) {
        element.textContent = text || "";
        return true;
      }
      return false;
    },
  };

  // Token de autenticación
  const token = util.getToken();
  if (!token) {
    util.showError("No hay sesión activa. Por favor inicie sesión nuevamente.");
    return;
  }

  // ------------------------------------------------
  // FUNCIONES API Y DATOS
  // ------------------------------------------------
  // Cargar eventos del calendario
  function fetchEvents() {
    return fetch(`${BASE_URL}/api/calendario/eventos`, {
      headers: { "Content-Type": "application/json", "remember-token": token },
    })
      .then((response) => {
        if (!response.ok) throw new Error("Error al cargar los eventos");
        return response.json();
      })
      .catch((error) => {
        console.error("Error al cargar eventos:", error);
        util.showError("No se pudieron cargar los eventos");
        return [];
      });
  }

  // Cargar próximos eventos
  function fetchUpcomingEvents() {
    if (!elements.upcomingEventList) return;

    fetch(`${BASE_URL}/api/calendario/proximos-eventos`, {
      headers: { "Content-Type": "application/json", "remember-token": token },
    })
      .then((response) => {
        if (!response.ok) throw new Error("Error al cargar próximos eventos");
        return response.json();
      })
      .then((events) => {
        elements.upcomingEventList.innerHTML = "";
        if (events && events.length > 0) {
          events.forEach((event) => {
            elements.upcomingEventList.innerHTML += renderUpcomingEvent(event);
          });
          addUpcomingEventListeners();
        } else {
          elements.upcomingEventList.innerHTML =
            '<div class="text-center">No hay citas próximas</div>';
        }
      })
      .catch((error) => {
        console.error("Error al cargar próximas citas:", error);
        if (elements.upcomingEventList) {
          elements.upcomingEventList.innerHTML =
            '<div class="text-center text-danger">Error al cargar las citas</div>';
        }
      });
  }

  // Obtener detalles de un evento
  function fetchEventDetails(eventId) {
    return fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
      headers: { "Content-Type": "application/json", "remember-token": token },
    }).then((response) => {
      if (!response.ok) throw new Error("Error al cargar detalles del evento");
      return response.json();
    });
  }

  // Actualizar un evento
async function updateEvent(eventId, data) {
    const realId = eventId.replace(/^[rc]_/, '');
    const endpoint = `${BASE_URL}/api/reservaciones/${realId}`;

    try {
        const response = await fetch(endpoint, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "remember-token": token
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || "Error en la solicitud");
        }

        return await response.json();
    } catch (error) {
        console.error("Error en updateEvent:", error);
        throw error;
    }
}


  function formatDateForMySQL(dateString) {
    if (!dateString) return null;

    try {
      const date = new Date(dateString);
      if (isNaN(date.getTime())) return null;

      // Formato: YYYY-MM-DD HH:MM:SS
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const day = String(date.getDate()).padStart(2, "0");
      const hours = String(date.getHours()).padStart(2, "0");
      const minutes = String(date.getMinutes()).padStart(2, "0");
      const seconds = String(date.getSeconds()).padStart(2, "0");

      return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    } catch (e) {
      console.error("Error al formatear fecha para MySQL:", e);
      return null;
    }
  }

  // ------------------------------------------------
  // INICIALIZACIÓN DEL CALENDARIO
  // ------------------------------------------------
  function initCalendar() {
    if (!elements.calendar) {
      console.error("No se encontró el elemento del calendario");
      return;
    }

    calendar = new FullCalendar.Calendar(elements.calendar, {
      timeZone: "local",
      editable: true,
      droppable: false,
      selectable: true,
      navLinks: true,
      initialView: "dayGridMonth",
      themeSystem: "bootstrap5",
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
      },
      locale: "es",
      eventTimeFormat: {
        hour: "2-digit",
        minute: "2-digit",
        meridiem: "short",
      },
      events: fetchEvents,
      eventClick: (info) => {
        selectedEvent = info.event;
        showEventDetails(selectedEvent);
      },
      eventDrop: (info) => updateEventDate(info.event),
      eventResize: (info) => updateEventDate(info.event),
      
    });

    calendar.render();
  }

  // ------------------------------------------------
  // GESTIÓN DE EVENTOS DEL MODAL
  // ------------------------------------------------
  // Mostrar detalles del evento
  function showEventDetails(event) {
    const eventId = event.id;

    fetchEventDetails(eventId)
      .then((data) => {
        // Configurar título según tipo de evento
        const tipoEvento =
          data.type === "consulta" ? "Consulta" : "Reservación";
        if (elements.modalTitle) {
          elements.modalTitle.textContent = `Detalles de la ${tipoEvento}`;
        }

        // Configurar vista inicial: mostrar detalles, ocultar formulario
        const eventForm = document.querySelector(".event-form");
        const eventDetails = document.querySelector(".event-details");
        if (eventForm && eventDetails) {
          eventForm.style.display = "none";
          eventDetails.style.display = "block";
        }

        // Configurar botones
        configureModalButtonsForViewMode();

        // Establecer valores del formulario
        setEventFormValues(data);

        // Mostrar el modal
        if (elements.eventModal) {
          elements.eventModal.show();
        }
      })
      .catch((error) => {
        console.error("Error al cargar detalles del evento:", error);
        util.showError("No se pudieron cargar los detalles de la cita");
      });
  }

  // Configurar botones del modal para modo vista
  function configureModalButtonsForViewMode() {
    const editButton = document.getElementById("edit-event-btn");
    if (editButton) {
      editButton.style.display = "inline-block";
      editButton.setAttribute("data-id", "edit-event");
    }

    if (elements.btnCloseEvent) {
      elements.btnCloseEvent.textContent = "Cerrar";
      elements.btnCloseEvent.style.display = "inline-block";
    }

    if (elements.btnSaveEvent) {
      elements.btnSaveEvent.style.display = "none";
    }
  }

  // Configurar botones del modal para modo edición
  function configureModalButtonsForEditMode() {
    const editButton = document.getElementById("edit-event-btn");
    if (editButton) {
      editButton.style.display = "none";
    }

    if (elements.btnCloseEvent) {
      elements.btnCloseEvent.textContent = "Regresar";
      elements.btnCloseEvent.style.display = "inline-block";
    }

    if (elements.btnSaveEvent) {
      elements.btnSaveEvent.style.display = "inline-block";
    }
  }

  // Establecer valores del formulario
  function setEventFormValues(data) {
    // ID del evento
    util.setElementValue("Reservacion_ID", data.id);

    // Datos personales
    util.setElementValue(
      "event-title",
      `${data.nombre_paciente || ""} ${data.apellidos || ""}`.trim()
    );
    util.setElementValue("telefono", data.telefono);
    util.setElementValue("genero", data.genero);
    util.setElementValue("usuario", data.usuario);
    util.setElementValue("edad", data.edad);

    // Fecha y hora
    if (util.elementExists("event-start-date")) {
      util.setElementValue(
        "event-start-date",
        formatDateForInput(data.fecha_consulta)
      );
    }
    if (util.elementExists("timepicker1")) {
      util.setElementValue("timepicker1", formatTime(data.fecha_consulta));
    }

    // Ubicación
    util.setElementValue("event-location", data.nombre_consultorio);
    if (util.elementExists("event-description")) {
      util.setElementValue("event-description", data.direccion_consultorio);
    }

    // Motivo y precio
    if (util.elementExists("motivo-consulta")) {
      util.setElementValue("motivo-consulta", data.motivo_consulta || "");
    }
    if (util.elementExists("precio-consulta")) {
      util.setElementValue("precio-consulta", data.precio_cita || "");
    }

    // Próxima consulta
    if (util.elementExists("proxima-consulta")) {
      util.setElementValue(
        "proxima-consulta",
        formatDateForInput(data.fecha_proximaConsulta)
      );
    }

    // Nutriólogo
    if (util.elementExists("nombre_nutriologo")) {
      util.setElementValue("nombre_nutriologo", data.nombre_nutriologo || "");
    }

    // Estado
    if (util.elementExists("estado_proximaConsulta")) {
      setEstadoSelect(data.estado_proximaConsulta || 4);
    }

    // Actualizar etiquetas para vista rápida
    util.setElementText(
      "event-start-date-tag",
      formatDate(data.fecha_consulta)
    );
    util.setElementText(
      "event-timepicker1-tag",
      formatTime(data.fecha_consulta)
    );
    util.setElementText("event-timepicker2-tag", "");
    util.setElementText(
      "event-location-tag",
      data.nombre_consultorio || "En Espera Asignación Por Nutriologo"
    );
    util.setElementText(
      "event-description-tag",
      data.direccion_consultorio || "En Espera Asignación Por Nutriologo"
    );
  }

  // Configurar select de estado
  function setEstadoSelect(estado) {
    const estadoValue = getEstadoValue(estado);
    const selectElement = document.getElementById("estado_proximaConsulta");

    if (selectElement && selectElement.options) {
      for (let i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].value === estadoValue) {
          selectElement.selectedIndex = i;
          break;
        }
      }
      selectElement.dispatchEvent(new Event("change"));
    }
  }

  // Actualizar la fecha de un evento (drag & drop)
  function updateEventDate(event) {
    const eventId = event.id;
    const newDate = event.start;

    updateEvent(eventId, { fecha_consulta: newDate.toISOString() })
      .then(() => {
        util.showSuccess("Fecha actualizada correctamente");
        fetchUpcomingEvents();
      })
      .catch((error) => {
        console.error("Error al actualizar fecha:", error);
        util.showError("No se pudo actualizar la fecha");
        calendar.refetchEvents();
      });
  }
  
  // Guardar cambios en un evento
async function saveEvent() {
    const eventId = document.getElementById("Reservacion_ID")?.value;
    if (!eventId) {
        util.showError("No se pudo identificar el evento");
        return false;
    }

    // Mapeo de estados
    const estadoMap = {
        "bg-danger-subtle": 0,
        "bg-success-subtle": 1,
        "bg-primary-subtle": 2,
        "bg-info-subtle": 3,
        "bg-warning-subtle": 4
    };

    // Obtener datos
    const estadoSelect = document.getElementById("estado_proximaConsulta");
    const estadoValue = estadoSelect?.value || "bg-warning-subtle";
    
    const formData = {
        nombre_consultorio: document.getElementById("event-location")?.value,
        direccion_consultorio: document.getElementById("event-description")?.value,
        fecha_proximaConsulta: document.getElementById("proxima-consulta")?.value,
        estado_proximaConsulta: estadoMap[estadoValue],
        origen: 'web',
        _token: document.querySelector('meta[name="csrf-token"]')?.content
    };

    // Validaciones
    if (formData.estado_proximaConsulta === 1) {
        if (!formData.nombre_consultorio || !formData.direccion_consultorio) {
            util.showError("Debe especificar consultorio y dirección para confirmar la cita");
            return false;
        }
    }

    // Configurar botón
    const btnSave = document.getElementById("btn-save-event");
    const originalText = btnSave.innerHTML;
    btnSave.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Procesando...';
    btnSave.disabled = true;

    try {
        const response = await updateEvent(eventId, formData);
        
        util.showSuccess("Reservación actualizada correctamente");
        elements.eventModal?.hide();
        calendar?.refetchEvents();
        fetchUpcomingEvents();
        
        return response;
    } catch (error) {
        console.error("Error al guardar:", error);
        util.showError(error.message || "Error al actualizar");
        throw error;
    } finally {
        btnSave.innerHTML = originalText;
        btnSave.disabled = false;
    }
}
  // Cancelar un evento
  function deleteEvent() {
    const eventId = document.getElementById("Reservacion_ID")?.value;
    if (!eventId) {
      util.showError("No se pudo identificar el evento");
      return;
    }

    Swal.fire({
      title: "¿Cancelar cita?",
      text: "¿Está seguro de que desea cancelar esta cita?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, cancelar",
      cancelButtonText: "No, volver",
    }).then((result) => {
      if (result.isConfirmed) {
        updateEvent(eventId, { estado_proximaConsulta: 0 })
          .then(() => {
            util.showSuccess("Cita cancelada correctamente");
            if (elements.eventModal) {
              elements.eventModal.hide();
            }
            if (calendar) {
              calendar.refetchEvents();
            }
            fetchUpcomingEvents();
          })
          .catch((error) => {
            console.error("Error al cancelar evento:", error);
            util.showError("No se pudo cancelar la cita");
          });
      }
    });
  }

  // ------------------------------------------------
  // FUNCIONES UI Y FORMATEO
  // ------------------------------------------------
  // Renderizar evento próximo
  function renderUpcomingEvent(event) {
    if (!event || !event.start) return "";

    const startDate = new Date(event.start);
    const endDate = event.end ? new Date(event.end) : null;
    const formattedStartDate = formatDateLikeVelzon(startDate);
    const startTime = tConvert(getTime(startDate));
    let timeRangeText = startTime;

    if (endDate) {
      const endTime = tConvert(getTime(endDate));
      timeRangeText =
        startTime !== endTime ? `${startTime} to ${endTime}` : "Full day event";
    }

    const eventClass = getEventClass(
      event.type || event.estado_proximaConsulta
    );
    const description = event.description || "";

    return `
      <div class="card mb-3" data-id="${event.id}">
        <div class="card-body">
          <div class="d-flex mb-3">
            <div class="flex-grow-1">
              <i class="mdi mdi-checkbox-blank-circle me-2 text-${eventClass}"></i>
              <span class="fw-medium">${formattedStartDate}</span>
            </div>
            <div class="flex-shrink-0">
              <small class="badge bg-primary-subtle text-primary ms-auto">${timeRangeText}</small>
            </div>
          </div>
          <h6 class="card-title fs-16">${
            event.title + " " || "Sin título"
          }</h6>
          <p class="text-muted text-truncate-two-lines mb-0">
            ${description}
            ${
              event.nombre_consultorio
                ? '<br><i class="fas fa-clinic-medical me-1"></i> ' +
                  event.nombre_consultorio
                : ""
            }
          </p>
          ${
            event.estado_proximaConsulta !== undefined
              ? `<div class="mt-2">
              <span style="color:black" class="badge ${getStatusClass(
                event.estado_proximaConsulta
              )}">
                ${getEstadoText(event.estado_proximaConsulta)}
              </span>
            </div>`
              : ""
          }
        </div>
      </div>
    `;
  }

  // Añadir listeners a los eventos próximos
  function addUpcomingEventListeners() {
    const eventCards = document.querySelectorAll(".card[data-id]");
    eventCards.forEach((card) => {
      card.addEventListener("click", function () {
        const eventId = this.getAttribute("data-id");
        if (!eventId) return;

        // Buscar en el calendario primero
        if (calendar) {
          const calendarEvent = calendar.getEventById(eventId);
          if (calendarEvent) {
            selectedEvent = calendarEvent;
            showEventDetails(calendarEvent);
            return;
          }
        }

        // Si no está en calendario, obtener por API
        fetchEventDetails(eventId)
          .then((data) => {
            const tempEvent = {
              id: eventId,
              title: `${data.nombre_paciente || ""} ${
                data.apellidos || ""
              }`.trim(),
              start: data.fecha_consulta,
              extendedProps: data,
            };
            showEventDetails(tempEvent);
          })
          .catch((error) => {
            console.error("Error al obtener detalles del evento:", error);
            util.showError("No se pudo cargar el evento");
          });
      });
    });
  }

  // Initializar Flatpickr
  function reinitializeFlatpickr() {
    if (typeof flatpickr === "function") {
      flatpickr("#event-start-date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: {
          firstDayOfWeek: 1,
          weekdays: {
            shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            longhand: [
              "Domingo",
              "Lunes",
              "Martes",
              "Miércoles",
              "Jueves",
              "Viernes",
              "Sábado",
            ],
          },
          months: {
            shorthand: [
              "Ene",
              "Feb",
              "Mar",
              "Abr",
              "May",
              "Jun",
              "Jul",
              "Ago",
              "Sep",
              "Oct",
              "Nov",
              "Dic",
            ],
            longhand: [
              "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agosto",
              "Septiembre",
              "Octubre",
              "Noviembre",
              "Diciembre",
            ],
          },
        },
      });

      flatpickr("#timepicker1", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K",
        time_24hr: false,
      });

      flatpickr("#proxima-consulta", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        minTime: "08:00",
        maxTime: "19:00",
        altInput: true,
        altFormat: "F j, Y H:i",
        disable: [
                function(date) {
                    // Deshabilitar sábados y domingos (0 = Domingo, 6 = Sábado)
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
              ],

        locale: {
          firstDayOfWeek: 1,
          weekdays: {
            shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            longhand: [
              "Domingo",
              "Lunes",
              "Martes",
              "Miércoles",
              "Jueves",
              "Viernes",
              "Sábado",
            ],
          },
          months: {
            shorthand: [
              "Ene",
              "Feb",
              "Mar",
              "Abr",
              "May",
              "Jun",
              "Jul",
              "Ago",
              "Sep",
              "Oct",
              "Nov",
              "Dic",
            ],
            longhand: [
              "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agosto",
              "Septiembre",
              "Octubre",
              "Noviembre",
              "Diciembre",
            ],
          },
        },
      });
    }
  }

  // ------------------------------------------------
  // FUNCIONES AUXILIARES DE FORMATEO
  // ------------------------------------------------
  function getTime(date) {
    if (!date || !date.getHours) return "";
    return `${date.getHours()}:${date.getMinutes() ? date.getMinutes() : "0"}`;
  }

  function tConvert(time) {
    if (!time) return "";
    const timeParts = time.split(":");
    let hours = parseInt(timeParts[0]);
    const minutes = timeParts[1];
    const ampm = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12;
    return `${hours}:${minutes < 10 ? "0" + minutes : minutes} ${ampm}`;
  }

  function formatDateLikeVelzon(date) {
    if (!date || isNaN(date.getTime())) return "";
    return date.toLocaleDateString("es-ES", {
      day: "numeric",
      month: "short",
      year: "numeric",
    });
  }

  function formatDate(dateStr) {
    if (!dateStr) return "";
    try {
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return "";
      const day = date.getDate();
      const month = date.toLocaleString("es-ES", { month: "long" });
      const year = date.getFullYear();
      return `${day} ${month}, ${year}`;
    } catch (e) {
      console.error("Error al formatear fecha:", e);
      return "";
    }
  }

  function formatTime(dateStr) {
      if (!dateStr) return "";
      try {
          // Parsear la fecha manteniendo la hora exacta
          const date = new Date(dateStr);
          if (isNaN(date.getTime())) return "";
          
          // Extraer componentes de hora manteniendo el tiempo UTC
          const hoursUTC = date.getUTCHours();
          const minutesUTC = date.getUTCMinutes();
          
          // Convertir a formato 12 horas
          const period = hoursUTC >= 12 ? 'PM' : 'AM';
          const hours12 = hoursUTC % 12 || 12;
          const minutesStr = minutesUTC.toString().padStart(2, '0');
          
          return `${hours12}:${minutesStr} ${period}`;
      } catch (e) {
          console.error("Error al formatear hora:", e);
          return "";
      }
  }

  function formatDateTimeForInput(dateStr) {
      if (!dateStr) return "";
      try {
          const date = new Date(dateStr);
          if (isNaN(date.getTime())) return "";
          
          // Usar los componentes UTC para evitar problemas de zona horaria
          const year = date.getUTCFullYear();
          const month = String(date.getUTCMonth() + 1).padStart(2, "0");
          const day = String(date.getUTCDate()).padStart(2, "0");
          const hours = String(date.getUTCHours()).padStart(2, "0");
          const minutes = String(date.getUTCMinutes()).padStart(2, "0");
          
          return `${year}-${month}-${day}T${hours}:${minutes}`;
      } catch (e) {
          console.error("Error al formatear fecha y hora para input:", e);
          return "";
      }
  }


  function formatDateForInput(dateStr) {
      if (!dateStr) return "";
      try {
          const date = new Date(dateStr);
          if (isNaN(date.getTime())) return "";
          
          // Usar componentes UTC para consistencia
          const year = date.getUTCFullYear();
          const month = String(date.getUTCMonth() + 1).padStart(2, "0");
          const day = String(date.getUTCDate()).padStart(2, "0");
          
          return `${year}-${month}-${day}`;
      } catch (e) {
          console.error("Error al formatear fecha para input:", e);
          return "";
      }
  }

  // ------------------------------------------------
  // MAPEOS DE ESTADO
  // ------------------------------------------------
  function getEventClass(type) {
    // Si es número (estado)
    if (!isNaN(parseInt(type))) {
      const estado = parseInt(type);
      const estadoClasses = ["danger", "success", "primary", "info", "warning"];
      return estadoClasses[estado] || "secondary";
    }

    // Si es string (tipo)
    return type === "consulta" ? "primary" : "success";
  }

  function getStatusClass(estado) {
    const estados = [
      "bg-danger-subtle text-danger",
      "bg-success-subtle text-success",
      "bg-primary-subtle text-primary",
      "bg-info-subtle text-info",
      "bg-warning-subtle text-warning",
    ];
    return estados[parseInt(estado)] || "bg-secondary-subtle text-secondary";
  }

  function getEstadoText(estado) {
    const estadoTexts = [
      "Cancelado",
      "En Progreso",
      "Próxima Consulta",
      "Realizado",
      "En Espera",
    ];
    return estadoTexts[parseInt(estado)] || "Desconocido";
  }

  function getEstadoValue(estado) {
    const estadoValues = [
      "bg-danger-subtle",
      "bg-success-subtle",
      "bg-primary-subtle",
      "bg-info-subtle",
      "bg-warning-subtle",
    ];
    return estadoValues[parseInt(estado)] || "bg-secondary-subtle";
  }

  function getEstadoCode(estadoValue) {
    const estadoMap = {
      "bg-danger-subtle": 0,
      "bg-success-subtle": 1,
      "bg-primary-subtle": 2,
      "bg-info-subtle": 3,
      "bg-warning-subtle": 4,
    };
    return estadoMap[estadoValue] || 4;
  }

  // ------------------------------------------------
  // FUNCIONES PÚBLICAS DE VENTANA
  // ------------------------------------------------
  // Función para editar evento
  window.editEvent = function (element) {
    const eventDetails = document.querySelector(".event-details");
    const eventForm = document.querySelector(".event-form");

    if (eventDetails && eventForm) {
      // Mostrar formulario y ocultar detalles
      eventDetails.style.display = "none";
      eventForm.style.display = "block";

      // Mostrar campos ocultos
      const hiddenInputs = eventForm.querySelectorAll(
        ".form-control.d-none, .input-group.d-none, .form-select.d-none"
      );
      hiddenInputs.forEach((input) => input.classList.remove("d-none"));

      // Configurar botones
      configureModalButtonsForEditMode();

      // Reinicializar datepickers
      reinitializeFlatpickr();
    }
  };

  // Función para cancelar edición
  window.cancelEdit = function () {
    const eventDetails = document.querySelector(".event-details");
    const eventForm = document.querySelector(".event-form");

    if (eventDetails && eventForm) {
      // Mostrar detalles y ocultar formulario
      eventDetails.style.display = "block";
      eventForm.style.display = "none";

      // Ocultar campos mostrados
      const visibleInputs = eventForm.querySelectorAll(
        ".form-control:not(.d-none), .input-group:not(.d-none), .form-select:not(.d-none)"
      );
      visibleInputs.forEach((input) => input.classList.add("d-none"));

      // Configurar botones
      configureModalButtonsForViewMode();
    }
  };

  // Función para cerrar modal
  window.closeEventModal = function () {
    // Si estamos en modo edición, cancelar primero
    const eventForm = document.querySelector(".event-form");
    if (eventForm && eventForm.style.display === "block") {
      window.cancelEdit();
    }

    // Resetear formulario y cerrar modal
    if (elements.formEvent) {
      elements.formEvent.reset();
    }

    if (elements.eventModal) {
      elements.eventModal.hide();
    }
  };

  // ------------------------------------------------
  // EVENT LISTENERS
  // ------------------------------------------------
  // Botón guardar
  if (elements.btnSaveEvent) {
    elements.btnSaveEvent.addEventListener("click", function (e) {
      e.preventDefault();
      saveEvent();
    });
  }

  // Botón eliminar/cancelar
  if (elements.btnDeleteEvent) {
    elements.btnDeleteEvent.addEventListener("click", function (e) {
      e.preventDefault();
      deleteEvent();
    });
  }

  // Botón cerrar
  if (elements.btnCloseEvent) {
    elements.btnCloseEvent.addEventListener("click", function (e) {
      e.preventDefault();
      const eventForm = document.querySelector(".event-form");
      if (eventForm && eventForm.style.display === "block") {
        window.cancelEdit();
      } else {
        window.closeEventModal();
      }
    });
  }

  // Cuando se cierra el modal
  if (elements.eventModal) {
    document
      .getElementById("event-modal")
      .addEventListener("hidden.bs.modal", function () {
        selectedEvent = null;
        if (elements.formEvent) {
          elements.formEvent.reset();
        }
      });
  }

  // ------------------------------------------------
  // INICIALIZACIÓN
  // ------------------------------------------------
  // Inicializar calendario
  if (elements.calendar) {
    initCalendar();
  } else {
    console.error(
      "No se pudo inicializar el calendario - elemento no encontrado"
    );
  }

  // Cargar próximos eventos
  if (elements.upcomingEventList) {
    fetchUpcomingEvents();
  } else {
    console.error(
      "No se pudo cargar la lista de eventos próximos - elemento no encontrado"
    );
  }
});