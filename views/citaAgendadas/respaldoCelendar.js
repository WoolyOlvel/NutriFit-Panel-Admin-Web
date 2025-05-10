const BASE_URL = "http://127.0.0.1:8000";

document.addEventListener("DOMContentLoaded", function () {
  // Referencias a elementos DOM
  var calendarEl = document.getElementById("calendar");
  var eventModal = new bootstrap.Modal(document.getElementById("event-modal"));
  var modalTitle = document.getElementById("modal-title");
  var formEvent = document.getElementById("form-event");
  var btnDeleteEvent = document.getElementById("btn-delete-event");
  var btnSaveEvent = document.getElementById("btn-save-event");
  var upcomingEventList = document.getElementById("upcoming-event-list");

  // Variables para manejar estados
  var selectedEvent = null;
  var newEventData = null;
  var calendar;

  // ------------------------------------------------
  // UTILIDADES
  // ------------------------------------------------

  const util = {
    // Obtener token de autenticación
    getToken() {
      return (
        localStorage.getItem("remember_token") ||
        this.getCookie("remember_token")
      );
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
          confirmButtonText: "Aceptar",
        }).then(() => (window.location.href = "login.html"));
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
        confirmButtonText: "Aceptar",
      });
    },

    // Mostrar mensaje de éxito
    showSuccess(message) {
      Swal.fire({
        title: "¡Éxito!",
        text: message || "Operación completada con éxito",
        icon: "success",
        confirmButtonText: "Aceptar",
      });
    },

    // Verificar si un elemento existe en el DOM
    elementExists(id) {
      return document.getElementById(id) !== null;
    },

    // Establecer valor seguro en un elemento
    setElementValue(id, value) {
      const element = document.getElementById(id);
      if (element) {
        element.value = value !== undefined && value !== null ? value : "";
        return true;
      }
      return false;
    },

    // Establecer texto seguro en un elemento
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
  // CARGAR DATOS DEL CALENDARIO
  // ------------------------------------------------

  // Función para cargar todos los eventos (consultas + reservaciones)
  function fetchEvents() {
    return fetch(`${BASE_URL}/api/calendario/eventos`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "remember-token": token,
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error al cargar los eventos del calendario");
        }
        return response.json();
      })
      .catch((error) => {
        console.error("Error al cargar eventos del calendario:", error);
        util.showError(
          "No se pudieron cargar los eventos. Por favor intente más tarde."
        );
        return []; // Devolver array vacío para evitar errores en FullCalendar
      });
      
  }

  // Función para cargar próximos eventos (consultas + reservaciones)
  function fetchUpcomingEvents() {
    fetch(`${BASE_URL}/api/calendario/proximos-eventos`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "remember-token": token,
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error al cargar los próximos eventos");
        }
        return response.json();
      })
      .then((events) => {
        if (!upcomingEventList) {
          console.error(
            "No se encontró el elemento para la lista de eventos próximos"
          );
          return;
        }

        upcomingEventList.innerHTML = "";
        if (events && events.length > 0) {
          events.forEach(function (event) {
            upcomingEventList.innerHTML += renderUpcomingEvent(event);
          });
          // Añadir event listeners a los eventos próximos
          addUpcomingEventListeners();
        } else {
          upcomingEventList.innerHTML =
            '<div class="text-center">No hay citas próximas</div>';
        }
      })
      .catch((error) => {
        console.error("Error al cargar próximas citas:", error);
        if (upcomingEventList) {
          upcomingEventList.innerHTML =
            '<div class="text-center text-danger">Error al cargar las citas</div>';
        }
      });
  }

  // ------------------------------------------------
  // INICIALIZACIÓN DEL CALENDARIO
  // ------------------------------------------------

  // Inicializar el calendario
  function initCalendar() {
    if (!calendarEl) {
      console.error("No se encontró el elemento del calendario");
      return;
    }

    calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: "local",
      editable: true,
      droppable: false,
      selectable: true,
      navLinks: true,
      initialView: "dayGridMonth",
      themeSystem: "bootstrap5",
      headerToolbar: {
        left: "prev,next today",
        center: "title" ,
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
      },
      locale: "es",
      eventTimeFormat: {
        hour: "2-digit",
        minute: "2-digit",
        meridiem: "short",
      },
      events: fetchEvents,
      eventClick: function (info) {
        selectedEvent = info.event;
        showEventModal2(selectedEvent);
      },
      eventDrop: function (info) {
        // Actualizar la fecha cuando se arrastra un evento
        updateEventDate(info.event);
      },
      eventResize: function (info) {
        // Actualizar la fecha cuando se redimensiona un evento
        updateEventDate(info.event);
      },
    });

    calendar.render();
  }

  // Inicializar el calendario cuando el DOM está listo
  if (calendarEl) {
    initCalendar();
  } else {
    console.error(
      "No se pudo inicializar el calendario - elemento no encontrado"
    );
  }

  // Cargar la lista de próximos eventos
  if (upcomingEventList) {
    fetchUpcomingEvents();
  } else {
    console.error(
      "No se pudo cargar la lista de eventos próximos - elemento no encontrado"
    );
  }

  // ------------------------------------------------
  // GESTIÓN DE EVENTOS DEL MODAL
  // ------------------------------------------------

  window.editEvent = function (element) {
    // Change from details view to form view
    const eventDetails = document.querySelector(".event-details");
    const eventForm = document.querySelector(".event-form");

    if (eventDetails && eventForm) {
      // Hide details and show form
      eventDetails.style.display = "none";
      eventForm.style.display = "block";

      // Show all inputs that were hidden with the d-none class
      const hiddenInputs = eventForm.querySelectorAll(
        ".form-control.d-none, .input-group.d-none, .form-select.d-none"
      );
      hiddenInputs.forEach((input) => {
        input.classList.remove("d-none");
      });

      // Properly configure buttons
      const btnCloseEvent = document.getElementById("btn-close-event");
      const btnSaveEvent = document.getElementById("btn-save-event");

      if (btnCloseEvent) {
        btnCloseEvent.style.display = "inline-block";
        btnCloseEvent.textContent = "Regresar";
      }

      if (btnSaveEvent) {
        btnSaveEvent.style.display = "inline-block";
      }

      // Hide the edit button
      if (element) {
        element.style.display = "none";
      }

      // Change data-id attribute to indicate cancel action is available
      if (element && element.getAttribute("data-id") === "edit-event") {
        element.setAttribute("data-id", "cancel-event");
      }
    }
  };

  window.cancelEdit = function () {
    const eventDetails = document.querySelector(".event-details");
    const eventForm = document.querySelector(".event-form");

    if (eventDetails && eventForm) {
      // Show details and hide form
      eventDetails.style.display = "block";
      eventForm.style.display = "none";

      // Hide all inputs by adding back the d-none class
      const visibleInputs = eventForm.querySelectorAll(
        ".form-control:not(.d-none), .input-group:not(.d-none), .form-select:not(.d-none)"
      );
      visibleInputs.forEach((input) => {
        input.classList.add("d-none");
      });

      // Configure buttons
      const btnCloseEvent = document.getElementById("btn-close-event");
      const btnSaveEvent = document.getElementById("btn-save-event");

      if (btnCloseEvent) {
        btnCloseEvent.textContent = "Cerrar";
      }

      if (btnSaveEvent) {
        btnSaveEvent.style.display = "none";
      }

      // Show the edit button again
      const editButton = document.getElementById("edit-event-btn");
      if (editButton) {
        editButton.style.display = "inline-block";
        editButton.setAttribute("data-id", "edit-event");
      }
    }
  };
  window.closeEventModal = function () {
    // First check if we're in edit mode and need to cancel the edit
    const eventForm = document.querySelector(".event-form");
    if (eventForm && eventForm.style.display === "block") {
      window.cancelEdit();
    }

    // Then reset the form and close the modal
    const formEvent = document.getElementById("form-event");
    if (formEvent) {
      formEvent.reset();
    }

    // Close the modal
    const eventModalElement = document.getElementById("event-modal");
    if (eventModalElement) {
      const eventModal = bootstrap.Modal.getInstance(eventModalElement);
      if (eventModal) {
        eventModal.hide();
      }
    }
  };

  function showEventModal2(event) {
    const eventId = event.id;

    // Obtain complete event details
    fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "remember-token": token,
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error al cargar detalles del evento");
        }
        return response.json();
      })
      .then((data) => {
        // Configure data in the modal form
        const tipoEvento =
          data.type === "consulta" ? "Consulta" : "Reservación";
        if (modalTitle) {
          modalTitle.textContent = `Detalles de la ${tipoEvento}`;
        }

        // Hide form and show details first
        const eventForm = document.querySelector(".event-form");
        const eventDetails = document.querySelector(".event-details");
        if (eventForm && eventDetails) {
          eventForm.style.display = "none";
          eventDetails.style.display = "block";
        }

        // Reset edit button state
        const editButton = document.getElementById("edit-event-btn");
        if (editButton) {
          editButton.style.display = "inline-block";
          editButton.setAttribute("data-id", "edit-event");
        }

        // Configure buttons for view mode
        const btnCloseEvent = document.getElementById("btn-close-event");
        const btnSaveEvent = document.getElementById("btn-save-event");
        if (btnCloseEvent) {
          btnCloseEvent.textContent = "Cerrar";
          btnCloseEvent.style.display = "inline-block";
        }
        if (btnSaveEvent) {
          btnSaveEvent.style.display = "none";
        }

        // Set all form values (will be hidden initially)

        // Verify and set each field safely
        // ID of the event with format for API
        util.setElementValue("Reservacion_ID", data.id);

        // Patient personal data
        util.setElementValue("event-title", `${data.nombre_paciente || ''} ${data.apellidos || ''}`.trim());
        util.setElementValue("telefono", data.telefono);
        util.setElementValue("genero", data.genero);
        util.setElementValue("usuario", data.usuario);
        util.setElementValue("edad", data.edad);

        // Date and time
        if (util.elementExists("event-start-date")) {
          util.setElementValue(
            "event-start-date",
            formatDateForInput(data.fecha_consulta)
          );
        }

        if (util.elementExists("timepicker1")) {
          util.setElementValue("timepicker1", formatTime(data.fecha_consulta));
        }

        // Location
        util.setElementValue("event-location", data.nombre_consultorio);

        // Description
        if (util.elementExists("event-description")) {
          util.setElementValue("event-description", data.direccion_consultorio);
        }

        // Motivo consulta
        if (util.elementExists("motivo-consulta")) {
          util.setElementValue("motivo-consulta", data.motivo_consulta || "");
        }

        // Precio consulta
        if (util.elementExists("precio-consulta")) {
          util.setElementValue("precio-consulta", data.precio_cita || "");
        }

        // Proxima consulta
        if (util.elementExists("proxima-consulta")) {
          util.setElementValue(
            "proxima-consulta",
            formatDateForInput(data.fecha_proximaConsulta)
          );
        }

        // Nutriologo
        if (util.elementExists("nombre_nutriologo")) {
          util.setElementValue(
            "nombre_nutriologo",
            data.nombre_nutriologo || ""
          );
        }

        // Status
        if (util.elementExists("estado_proximaConsulta")) {
          const estado = data.estado_proximaConsulta || 4; // Usar 4 (En Espera) por defecto si no hay estado
          const estadoValue = getEstadoValue(estado);
          const selectElement = document.getElementById(
            "estado_proximaConsulta"
          );

          // Verificar que el select existe y tiene opciones
          if (selectElement && selectElement.options) {
            // Buscar la opción que coincide con el estadoValue
            for (let i = 0; i < selectElement.options.length; i++) {
              if (selectElement.options[i].value === estadoValue) {
                selectElement.selectedIndex = i;
                break;
              }
            }

            // Forzar la actualización visual (necesario en algunos navegadores)
            selectElement.dispatchEvent(new Event("change"));
          } else {
            console.error(
              "El elemento select no se encontró o no tiene opciones"
            );
          }
        }

        // Tags for quick view
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

        // Show modal
        if (eventModal) {
          eventModal.show();
        } else {
          console.error("No se encontró el modal de eventos");
        }
      })
      .catch((error) => {
        console.error("Error al cargar detalles del evento:", error);
        util.showError(
          "No se pudieron cargar los detalles de la cita. Por favor intente más tarde."
        );
      });
  }

  function getEstadoValue(estado) {
    // Asegurarnos de que estado es un número
    estado = parseInt(estado);

    // Mapear los valores numéricos a las clases CSS correspondientes
    const estadoMap = {
      0: "bg-danger-subtle", // Cancelado
      1: "bg-success-subtle", // En Progreso
      2: "bg-primary-subtle", // Proxima Consulta
      3: "bg-info-subtle", // Realizado
      4: "bg-warning-subtle", // En Espera
    };

    // Devolver el valor correspondiente o 'bg-warning-subtle' por defecto
    return estadoMap[estado] || "bg-warning-subtle";
  }

  function reinitializeFlatrpickr() {
    // Re-initialize flatpickr instances when the form is shown
    if (typeof flatpickr === "function") {
      flatpickr("#event-start-date", {
        enableTime: false,
        dateFormat: "F j, Y",
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
        dateFormat: "H:i",
      });

      flatpickr("#proxima-consulta", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
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
  function closeEventModal() {
    // Resetear el formulario
    const formEvent = document.getElementById("form-event");
    if (formEvent) {
      formEvent.reset();
    }

    // Cerrar el modal
    const eventModal = new bootstrap.Modal(
      document.getElementById("event-modal")
    );
    if (eventModal) {
      eventModal.hide();
    }
  }
  // Mostrar el modal con la información del evento
  function showEventModal(event) {
    const eventId = event.id;

    // Obtener detalles completos del evento
    fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "remember-token": token,
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error al cargar detalles del evento");
        }
        return response.json();
      })
      .then((data) => {
        // Configurar los datos en el formulario del modal
        const tipoEvento =
          data.type === "consulta" ? "Consulta" : "Reservación";
        if (modalTitle) {
          modalTitle.textContent = `Detalles de la ${tipoEvento}`;
        }

        // Verificar y establecer cada campo de manera segura
        // ID del evento con formato para API
        util.setElementValue("Reservacion_ID", data.id);

        // Datos personales del paciente
        util.setElementValue("event-title", `${data.nombre_paciente || ''} ${data.apellidos || ''}`.trim());
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

        // Ubicación
        util.setElementValue("event-location", data.nombre_consultorio);

        // Descripción
        if (util.elementExists("event-description")) {
          util.setElementValue("event-description", data.direccion_consultorio);
        }

        // Estado
        if (util.elementExists("event-category")) {
          const estadoValue = getEstadoValue(data.estado_proximaConsulta);
          util.setElementValue("event-category", estadoValue);
        }

        // Etiquetas para visualización rápida
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
          data.nombre_consultorio || "Sin asignar"
        );
        util.setElementText(
          "event-description-tag",
          data.direccion_consultorio || "Sin asignar"
        );

        // Mostrar modal
        if (eventModal) {
          eventModal.show();
        } else {
          console.error("No se encontró el modal de eventos");
        }
      })
      .catch((error) => {
        console.error("Error al cargar detalles del evento:", error);
        util.showError(
          "No se pudieron cargar los detalles de la cita. Por favor intente más tarde."
        );
      });
  }

  // Actualizar la fecha de un evento
  function updateEventDate(event) {
    const eventId = event.id;
    const newDate = event.start;

    // Enviar la actualización al servidor
    fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        "remember-token": token,
      },
      body: JSON.stringify({
        fecha_consulta: newDate.toISOString(),
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error al actualizar la fecha del evento");
        }
        return response.json();
      })
      .then((data) => {
        util.showSuccess("Fecha actualizada correctamente");
        // Recargar eventos próximos
        fetchUpcomingEvents();
      })
      .catch((error) => {
        console.error("Error al actualizar fecha:", error);
        util.showError(
          "No se pudo actualizar la fecha. Por favor intente más tarde."
        );
        // Revertir el cambio en el calendario
        calendar.refetchEvents();
      });
  }

  // Guardar cambios en un evento
  function saveEvent() {
    const eventId = document.getElementById("Reservacion_ID")?.value;
    if (!eventId) {
      util.showError("No se pudo identificar el evento");
      return false;
    }

    // Obtener valores de los campos (con manejo seguro)
    const fechaConsulta = document.getElementById("event-start-date")?.value;
    const estadoProximaConsulta =
      document.getElementById("event-category")?.value;
    const nombreConsultorio = document.getElementById("event-location")?.value;
    const direccionConsultorio =
      document.getElementById("event-description")?.value;

    // Validar datos mínimos
    if (!fechaConsulta) {
      util.showError("La fecha de consulta es obligatoria");
      return false;
    }

    // Mapear el valor del select al código de estado
    const estadoCode = getEstadoCode(estadoProximaConsulta);

    // Preparar datos para enviar
    const eventData = {
      fecha_consulta: fechaConsulta
        ? new Date(fechaConsulta).toISOString()
        : null,
      estado_proximaConsulta: estadoCode,
      nombre_consultorio: nombreConsultorio || "",
      direccion_consultorio: direccionConsultorio || "",
    };

    // Enviar actualización al servidor
    fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        "remember-token": token,
      },
      body: JSON.stringify(eventData),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error al actualizar el evento");
        }
        return response.json();
      })
      .then((data) => {
        util.showSuccess("Evento actualizado correctamente");
        if (eventModal) {
          eventModal.hide();
        }

        // Recargar eventos en el calendario y la lista
        if (calendar) {
          calendar.refetchEvents();
        }
        fetchUpcomingEvents();
      })
      .catch((error) => {
        console.error("Error al guardar evento:", error);
        util.showError(
          "No se pudo actualizar el evento. Por favor intente más tarde."
        );
      });

    return false; // Evitar submit del formulario
  }

  // ------------------------------------------------
  // FUNCIONES AUXILIARES
  // ------------------------------------------------

  // Renderizar un evento próximo en la lista lateral
  function renderUpcomingEvent(event) {
    if (!event || !event.start) {
      return ""; // Si el evento no tiene datos básicos, no renderizar
    }

    // Formateo de fechas similar al del asset
    const startDate = new Date(event.start);
    const endDate = event.end ? new Date(event.end) : null;

    // Formatear fecha como en el asset (día, mes abreviado, año)
    const formattedStartDate = formatDateLikeVelzon(startDate);
    let dateRangeText = formattedStartDate;

    // Si hay fecha de fin y es diferente a la de inicio, mostrar rango
    if (endDate && startDate.toDateString() !== endDate.toDateString()) {
      const formattedEndDate = formatDateLikeVelzon(endDate);
      dateRangeText += " to " + formattedEndDate;
    }

    // Formatear hora como en el asset
    const startTime = tConvert(getTime(startDate));
    let timeRangeText = startTime;

    if (endDate) {
      const endTime = tConvert(getTime(endDate));
      if (startTime !== endTime) {
        timeRangeText += " to " + endTime;
      } else {
        timeRangeText = "Full day event";
      }
    }

    // Determinar el color de clase basado en el tipo de evento o el estado
    const eventClass = getEventClass(
      event.type || event.estado_proximaConsulta
    );

    // Obtener descripción del evento (si existe)
    const description = event.description || "";

    return `
        <div class="card mb-3" data-id="${event.id}">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="flex-grow-1">
                        <i class="mdi mdi-checkbox-blank-circle me-2 text-${eventClass}"></i>
                        <span class="fw-medium">${dateRangeText}</span>
                    </div>
                    <div class="flex-shrink-0">
                        <small class="badge bg-primary-subtle text-primary ms-auto">${timeRangeText}</small>
                    </div>
                </div>
                <h6 class="card-title fs-16">${event.title + " " + event.subtitle|| "Sin título"}</h6>
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
                        )}">${getEstadoText(
                        event.estado_proximaConsulta
                      )}</span>
                    </div>`
                    : ""
                }
            </div>
        </div>
    `;
  }

  // Funciones auxiliares como en el asset
  function getTime(date) {
    if (date && date.getHours() != null) {
      return (
        date.getHours() + ":" + (date.getMinutes() ? date.getMinutes() : "0")
      );
    }
    return "";
  }

  function tConvert(time) {
    if (!time) return "";

    const timeParts = time.split(":");
    let hours = parseInt(timeParts[0]);
    const minutes = timeParts[1];
    const ampm = hours >= 12 ? "PM" : "AM";

    hours = hours % 12;
    hours = hours ? hours : 12; // La hora '0' debe ser '12'

    return hours + ":" + (minutes < 10 ? "0" + minutes : minutes) + " " + ampm;
  }

  function formatDateLikeVelzon(date) {
    if (!date || isNaN(date.getTime())) return "";

    // Formato: día mes año (ej: 15 Jan 2023)
    return date
      .toLocaleDateString("es-ES", {
        day: "numeric",
        month: "short",
        year: "numeric",
      })
      .split(" ")
      .join(" ");
  }

  // Determinar la clase de color según el tipo de evento
  function getEventClass(type) {
    // Si type es un número, asumimos que es un estado de consulta
    if (!isNaN(parseInt(type))) {
      const estado = parseInt(type);
      switch (estado) {
        case 0:
          return "danger";
        case 1:
          return "success";
        case 2:
          return "primary";
        case 3:
          return "info";
        case 4:
          return "warning";
        default:
          return "secondary";
      }
    }

    // Si es un string, usamos el tipo de evento
    switch (type) {
      case "consulta":
        return "primary";
      default:
        return "secondary";
    }
  }

  // Obtener clase CSS para el estado
  function getStatusClass(estado) {
    switch (parseInt(estado)) {
      case 0:
        return "bg-danger-subtle text-danger";
      case 1:
        return "bg-success-subtle text-success";
      case 2:
        return "bg-primary-subtle text-primary";
      case 3:
        return "bg-info-subtle text-info";
      case 4:
        return "bg-warning-subtle text-warning";
      default:
        return "bg-secondary-subtle text-secondary";
    }
  }

  // Obtener texto del estado según código
  function getEstadoText(estado) {
    switch (parseInt(estado)) {
      case 0:
        return "Cancelado";
      case 1:
        return "En Progreso";
      case 2:
        return "Próxima Consulta";
      case 3:
        return "Realizado";
      case 4:
        return "En Espera";
      default:
        return "Desconocido";
    }
  }

  // Obtener valor del select según estado
  function getEstadoValue(estado) {
    switch (parseInt(estado)) {
      case 0:
        return "bg-danger-subtle";
      case 1:
        return "bg-success-subtle";
      case 2:
        return "bg-primary-subtle";
      case 3:
        return "bg-info-subtle";
      case 4:
        return "bg-warning-subtle";
      default:
        return "bg-secondary-subtle";
    }
  }

  // Obtener código de estado según valor del select
  function getEstadoCode(estadoValue) {
    switch (estadoValue) {
      case "bg-danger-subtle":
        return 0;
      case "bg-success-subtle":
        return 1;
      case "bg-primary-subtle":
        return 2;
      case "bg-info-subtle":
        return 3;
      case "bg-warning-subtle":
        return 4;
      default:
        return 4; // Por defecto, "En Espera"
    }
    
  }

  // Añadir listeners a los eventos próximos
  function addUpcomingEventListeners() {
    const eventItems = document.querySelectorAll(".upcoming-event-item");
    if (!eventItems || eventItems.length === 0) {
      console.log("No se encontraron eventos próximos para añadir listeners");
      return;
    }

    eventItems.forEach((item) => {
      if (item) {
        item.addEventListener("click", function () {
          const eventId = this.getAttribute("data-id");
          if (!eventId) {
            console.error("Evento sin ID");
            return;
          }

          // Buscar el evento en el calendario
          if (calendar) {
            const calendarEvent = calendar.getEventById(eventId);
            if (calendarEvent) {
              selectedEvent = calendarEvent;
              showEventModal2(calendarEvent);
              return;
            }
          }

          // Si no está en el calendario visible, obtener detalles por API
          fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
              "remember-token": token,
            },
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error("Error al obtener detalles del evento");
              }
              return response.json();
            })
            .then((data) => {
              // Crear un evento temporal para mostrar en el modal
              const tempEvent = {
                id: eventId,
                title: `${data.nombre_paciente || ''} ${data.apellidos || ''}`.trim(),
                start: data.fecha_consulta,
                extendedProps: data,
              };
              showEventModal2(tempEvent);
            })
            .catch((error) => {
              console.error("Error al obtener detalles del evento:", error);
              util.showError("No se pudo cargar el evento");
            });
        });
      }
    });
  }

  // Formato de fecha para mostrar
  function formatDate(dateStr) {
    if (!dateStr) return "";
    try {
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return "";

      const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
      };

      // Extrae y formatea el día para que no tenga ceros iniciales
      const day = date.getDate();
      const month = date.toLocaleString("es-ES", { month: "long" });
      const year = date.getFullYear();

      return `${day} ${month}, ${year}`;
    } catch (e) {
      console.error("Error al formatear fecha:", e);
      return "";
    }
  }

  // Formato de hora para mostrar
  function formatTime(dateStr) {
    if (!dateStr) return "";
    try {
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return "";

      return date
        .toLocaleTimeString("es-MX", {
          hour: "numeric",
          minute: "2-digit",
          hour12: true,
        })
        .toUpperCase();
    } catch (e) {
      console.error("Error al formatear hora:", e);
      return "";
    }
  }

  // Formato de fecha para inputs
  function formatDateForInput(dateStr) {
    if (!dateStr) return "";
    try {
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return "";

      // Solo la parte de la fecha (YYYY-MM-DD)
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const day = String(date.getDate()).padStart(2, "0");
      return `${year}-${month}-${day}`;
    } catch (e) {
      console.error("Error al formatear fecha para input:", e);
      return "";
    }
  }

  function formatTimeForInput(dateStr) {
    if (!dateStr) return "";
    try {
      const date = new Date(dateStr);
      if (isNaN(date.getTime())) return "";

      // Formato de 12 horas con AM/PM
      let hours = date.getHours();
      const minutes = String(date.getMinutes()).padStart(2, "0");
      const ampm = hours >= 12 ? "PM" : "AM";
      hours = hours % 12;
      hours = hours ? hours : 12; // La hora '0' debe ser '12'
      return `${hours}:${minutes} ${ampm}`;
    } catch (e) {
      console.error("Error al formatear hora para input:", e);
      return "";
    }
  }

  function reinitializeFlatpickr() {
    if (typeof flatpickr === "function") {
      // Configuración para el campo de fecha (sin hora)
      flatpickr("#event-start-date", {
        enableTime: false, // Deshabilitar la selección de hora
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

      // Configuración para el campo de hora (solo hora)
      flatpickr("#timepicker1", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "h:i K", // Formato de 12 horas con AM/PM
        time_24hr: false, // Mostrar en formato 12 horas
      });
    }
  }

  // Obtener texto del estado según código
  function getEstadoText(estado) {
    switch (parseInt(estado)) {
      case 0:
        return "Cancelado";
      case 1:
        return "En Progreso";
      case 2:
        return "Próxima Consulta";
      case 3:
        return "Realizado";
      case 4:
        return "En Espera";
      default:
        return "Desconocido";
    }
  }

  // Obtener clase CSS para el estado
  function getStatusClass(estado) {
    switch (parseInt(estado)) {
      case 0:
        return "bg-danger-subtle";
      case 1:
        return "bg-success-subtle";
      case 2:
        return "bg-primary-subtle";
      case 3:
        return "bg-info-subtle";
      case 4:
        return "bg-warning-subtle";
      default:
        return "bg-secondary-subtle";
    }
  }

  // Obtener valor del select según estado
  function getEstadoValue(estado) {
    switch (parseInt(estado)) {
      case 0:
        return "bg-danger-subtle";
      case 1:
        return "bg-success-subtle";
      case 2:
        return "bg-primary-subtle";
      case 3:
        return "bg-info-subtle";
      case 4:
        return "bg-warning-subtle";
      default:
        return "bg-secondary-subtle";
    }
  }

  // Obtener código de estado según valor del select
  function getEstadoCode(estadoValue) {
    switch (estadoValue) {
      case "bg-danger-subtle":
        return 0;
      case "bg-success-subtle":
        return 1;
      case "bg-primary-subtle":
        return 2;
      case "bg-info-subtle":
        return 3;
      case "bg-warning-subtle":
        return 4;
      default:
        return 4; // Por defecto, "En Espera"
    }
  }

  // ------------------------------------------------
  // EVENT LISTENERS
  // ------------------------------------------------

  // Guardar evento al hacer clic en el botón
  if (btnSaveEvent) {
    btnSaveEvent.addEventListener("click", function (e) {
      e.preventDefault();
      saveEvent();
    });
  }

  // Cambiar estado del evento a cancelado
  if (btnDeleteEvent) {
    btnDeleteEvent.addEventListener("click", function (e) {
      e.preventDefault();
      if (!selectedEvent) return;

      Swal.fire({
        title: "¿Cancelar cita?",
        text: "¿Está seguro de que desea cancelar esta cita?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, cancelar",
        cancelButtonText: "No, volver",
      }).then((result) => {
        if (result.isConfirmed) {
          const eventId = document.getElementById("Reservacion_ID")?.value;
          if (!eventId) {
            util.showError("No se pudo identificar el evento");
            return;
          }

          // Enviar actualización al servidor (cambiar estado a cancelado = 0)
          fetch(`${BASE_URL}/api/calendario/evento/${eventId}`, {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
              "remember-token": token,
            },
            body: JSON.stringify({
              estado_proximaConsulta: 0, // 0 = Cancelado
            }),
          })
            .then((response) => {
              if (!response.ok) {
                throw new Error("Error al cancelar el evento");
              }
              return response.json();
            })
            .then((data) => {
              util.showSuccess("Cita cancelada correctamente");
              if (eventModal) {
                eventModal.hide();
              }

              // Recargar eventos en el calendario y la lista
              if (calendar) {
                calendar.refetchEvents();
              }
              fetchUpcomingEvents();
            })
            .catch((error) => {
              console.error("Error al cancelar evento:", error);
              util.showError(
                "No se pudo cancelar la cita. Por favor intente más tarde."
              );
            });
        }
      });
    });
  }

  // Evento para cuando se cierra el modal
  const eventModalElement = document.getElementById("event-modal");
  if (eventModalElement) {
    eventModalElement.addEventListener("hidden.bs.modal", function () {
      selectedEvent = null;
      if (formEvent) {
        formEvent.reset();
      }
    });
  }
  const btnCloseEvent = document.getElementById("btn-close-event");
  if (btnCloseEvent) {
    btnCloseEvent.addEventListener("click", function (e) {
      e.preventDefault();

      // Check if we're in edit mode
      const eventForm = document.querySelector(".event-form");
      if (eventForm && eventForm.style.display === "block") {
        // In edit mode, so cancel the edit
        window.cancelEdit();
      } else {
        // In view mode, so close the modal
        window.closeEventModal();
      }
    });
  }
  if (typeof window.editEvent === "function") {
    const originalEditEvent = window.editEvent;
    window.editEvent = function (element) {
      originalEditEvent(element);
      // Re-initialize date/time pickers
      reinitializeFlatrpickr();
    };
  }
});
