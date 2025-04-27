const BASE_URL = "http://127.0.0.1:8000";
let customerList = null;

// Función para inicializar todo cuando el DOM está listo
document.addEventListener("DOMContentLoaded", function () {
  cargarPacientes(); // Cargar pacientes al inicio

  // Inicializar búsqueda si existe el elemento
  if (document.getElementById("searchInput")) {
    inicializarBusqueda();
  }

  // Configurar eventos para los modales
  configurarEventosModal();

  // Inicializar formulario si existe
  const pacienteForm = document.getElementById("Paciente_form");
  if (pacienteForm) {
    pacienteForm.addEventListener("submit", handleFormSubmit);
  }

  // Inicializar modal de eliminar
  document
    .getElementById("delete-record")
    .addEventListener("click", function () {
      const pacienteId = this.getAttribute("data-id");
      if (pacienteId) {
        confirmarEliminarPaciente(pacienteId);
      }
      document.getElementById("deleteRecord-close").click(); // Cerrar modal
    });
});

// Función para configurar eventos de los modales
function configurarEventosModal() {
  // Evento para abrir modal de edición
  document.addEventListener("click", function (e) {
    const target = e.target.closest(".edit-item-btn");

    if (target) {
      const pacienteId = target.getAttribute("data-id");
      cargarPaciente(pacienteId);
    }
  });

  // Evento para abrir modal de vista detallada
  document.addEventListener("click", function (e) {
    const target = e.target.closest(".view-item-btn");
    if (target) {
      const pacienteId = target.getAttribute("data-id");
      mostrarDetallesPaciente(pacienteId);
    }
  });

  // Evento para el modal de eliminación
  document.addEventListener("click", function (e) {
    const target = e.target.closest(".remove-item-btn");
    if (target) {
      const pacienteId = target.getAttribute("data-id");
      const modal = new bootstrap.Modal(
        document.getElementById("deleteRecordModal")
      );

      // Actualizar el botón de confirmación en el modal
      const deleteBtn = document.getElementById("delete-record");
      deleteBtn.setAttribute("data-id", pacienteId);

      // Mostrar el modal
      modal.show();
    }
  });

 
  // Limpiar formulario al cerrar el modal
  const showModal = document.getElementById("showModal");
  if (showModal) {
    showModal.addEventListener("hidden.bs.modal", limpiarFormulario);
  }

  // Configurar botón para añadir nuevo paciente
  const addBtn = document.querySelector(".add-btn");
  if (addBtn) {
    addBtn.addEventListener("click", prepararNuevoFormulario);
  }
}

// Función para obtener cookies (igual que en addPaciente.js)
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}

// Función para limpiar el formulario
function limpiarFormulario() {
  const form = document.getElementById("Paciente_form");
  if (!form) return;

  form.reset();
  document.getElementById("Paciente_ID").value = "";

  // Restaurar imagen predeterminada
  const imgElement =
    document.getElementById("lead-img") ||
    document.getElementById("companylogo-img");
  if (imgElement) {
    imgElement.src = "../../assets/images/users/user-dummy-img.jpg";
  }

  // Limpiar tags de enfermedad si existe
  cargarTagsEnfermedad("");

  // Restaurar estado activo por defecto
  const statusElement = document.getElementById("ticket-status");
  if (statusElement) {
    statusElement.value = "1";
  }
}

// Función para preparar el formulario para un nuevo paciente
function prepararNuevoFormulario() {
  limpiarFormulario();

  const lblTitulo = document.getElementById("lblTitulo");
  if (lblTitulo) {
    lblTitulo.textContent = "Añadir Paciente";
  }

  const addBtn = document.getElementById("add-btn");
  if (addBtn) {
    addBtn.textContent = "Añadir Paciente";
    addBtn.value = "add";
  }
}

// Función para cargar tags de enfermedad (igual que en addPaciente.js)
function cargarTagsEnfermedad(enfermedadesString) {
  const tagsInput = document.getElementById("taginput-choices");
  if (!tagsInput) return;

  const enfermedades = enfermedadesString
    ? enfermedadesString
        .split(",")
        .map((e) => e.trim())
        .filter((e) => e)
    : [];

  const choicesContainer = tagsInput.closest(".choices");
  if (choicesContainer) {
    const newInput = document.createElement("input");
    newInput.id = "taginput-choices";
    newInput.name = "taginput-choices";
    newInput.className = "form-control";
    newInput.setAttribute("data-choices", "");
    newInput.setAttribute("data-choices-text-unique-true", "");
    newInput.type = "text";

    if (enfermedades.length > 0) {
      newInput.value = enfermedades.join(",");
    }

    choicesContainer.parentNode.replaceChild(newInput, choicesContainer);

    setTimeout(() => {
      if (window.Choices) {
        new Choices(newInput, {
          removeItemButton: true,
        });
      }
    }, 10);
  } else {
    tagsInput.value = enfermedades.join(",");

    if (window.Choices) {
      new Choices(tagsInput, {
        removeItemButton: true,
      });
    }
  }
}

// Función para manejar envío del formulario
async function handleFormSubmit(e) {
  e.preventDefault();

  // Obtener token almacenado en localStorage o cookies
  const token =
    localStorage.getItem("remember_token") || getCookie("remember_token");

  if (!token) {
    Swal.fire({
      title: "Error de sesión",
      text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar",
    }).then(() => {
      window.location.href = "login.html"; // Redirigir al login
    });
    return;
  }

  const formData = new FormData(this);
  const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
  if (fechaNacimientoInput && fechaNacimientoInput.value) {
    try {
      const fechaSeleccionada = flatpickr.parseDate(
        fechaNacimientoInput.value,
        "d M, Y"
      );
      const fechaFormateada = flatpickr.formatDate(fechaSeleccionada, "Y-m-d");
      formData.set("fecha_nacimiento", fechaFormateada);
    } catch (e) {
      console.error("Error al formatear la fecha:", e);
    }
  }

  // Obtener los tags de enfermedad del elemento Choices
  const tagsInput = document.getElementById("taginput-choices");
  let enfermedades = [];

  if (window.Choices && tagsInput._choices) {
    enfermedades = tagsInput._choices.store.activeItems.map(
      (item) => item.value
    );
  } else if (tagsInput.value) {
    enfermedades = tagsInput.value
      .split(",")
      .map((e) => e.trim())
      .filter((e) => e);
  }

  // Agregar enfermedades al FormData
  formData.set("enfermedad", enfermedades.join(","));

  // Asegurarse de que el estado se envíe correctamente
  const status = document.getElementById("ticket-status").value;
  formData.set("status", status === "1" ? 1 : 0);

  // Establecer imagen predeterminada si no se ha seleccionado ninguna
  const fileInput = document.getElementById("lead-image-input");
  const pacienteId = document.getElementById("Paciente_ID").value;

  if (
    fileInput &&
    fileInput.files.length === 0 &&
    (!pacienteId || pacienteId === "")
  ) {
    // Es un nuevo registro sin imagen, usar imagen predeterminada
    formData.append("imagen_predeterminada", true);
  }

  // Usar la ruta adecuada para la API de mis pacientes
  const url = `${BASE_URL}/api/misPacientes/guardar_editar`;

  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "remember-token": token,
      },
      body: formData,
    });

    const data = await response.json();

    if (response.ok) {
      // Usar SweetAlert para notificación de éxito
      Swal.fire({
        title: "¡Éxito!",
        text: data.message || "Operación completada con éxito",
        icon: "success",
        confirmButtonText: "Aceptar",
      });

      document.getElementById("close-modal").click(); // Cerrar modal
      cargarPacientes(); // Recargar la tabla de pacientes
    } else {
      // Mostrar errores con SweetAlert
      let errorMessage = "Error en la operación";
      if (data.errors) {
        errorMessage = Object.values(data.errors).join("\n");
      } else if (data.message) {
        errorMessage = data.message;
      }

      Swal.fire({
        title: "Error",
        text: errorMessage,
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    }
  } catch (error) {
    console.error("Error:", error);
    Swal.fire({
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor. Inténtelo más tarde.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  }
}

// Función para cargar datos de un paciente existente
function cargarPaciente(id) {
  const token =
    localStorage.getItem("remember_token") || getCookie("remember_token");

  if (!token) {
    Swal.fire({
      title: "Error de sesión",
      text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar",
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

  const formData = new FormData();
  formData.append("Paciente_ID", id);

  fetch(`${BASE_URL}/api/misPacientes/mostrar`, {
    method: "POST",
    headers: {
      Accept: "application/json",
      "remember-token": token,
    },
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const paciente = data.data;

        // Limpiar formulario antes de cargar nuevos datos
        limpiarFormulario();

        document.getElementById("Paciente_ID").value = paciente.Paciente_ID;
        document.getElementById("nombre").value = paciente.nombre;
        document.getElementById("apellidos").value = paciente.apellidos;
        document.getElementById("email").value = paciente.email;
        document.getElementById("telefono").value = paciente.telefono || "";
        document.getElementById("genero").value = paciente.genero || "";
        document.getElementById("usuario").value = paciente.usuario;

        // Cargar campos adicionales si existen
        if (document.getElementById("localidad")) {
          document.getElementById("localidad").value = paciente.localidad || "";
        }
        if (document.getElementById("ciudad")) {
          document.getElementById("ciudad").value = paciente.ciudad || "";
        }
        if (document.getElementById("edad")) {
          document.getElementById("edad").value = paciente.edad || "";
        }
        // Manejo especial para la fecha de nacimiento
        if (
          document.getElementById("fecha_nacimiento") &&
          paciente.fecha_nacimiento
        ) {
          // Obtener el objeto flatpickr de este input
          const fechaNacimientoInput =
            document.getElementById("fecha_nacimiento");
          const flatpickrInstance = fechaNacimientoInput._flatpickr;

          if (flatpickrInstance) {
            try {
              // Asegurarse de que la fecha esté en el formato correcto (YYYY-MM-DD)
              let fechaBD = paciente.fecha_nacimiento;

              // Crear un objeto Date a partir de la fecha de la BD
              // El formato "YYYY-MM-DD" es interpretado correctamente por el constructor Date
              const partesFecha = fechaBD.split("-");
              if (partesFecha.length === 3) {
                // Crear el objeto Date (año, mes-1, día)
                // Nota: los meses en JavaScript son 0-indexados (0=enero, 11=diciembre)
                const fechaObj = new Date(
                  parseInt(partesFecha[0]),
                  parseInt(partesFecha[1]) - 1,
                  parseInt(partesFecha[2])
                );

                // Verificar que la fecha es válida antes de establecerla
                if (!isNaN(fechaObj.getTime())) {
                  // Establecer la fecha en flatpickr
                  flatpickrInstance.setDate(fechaObj);
                  console.log("Fecha establecida:", fechaObj);
                } else {
                  console.error("Fecha inválida:", fechaBD);
                  fechaNacimientoInput.value = fechaBD;
                }
              } else {
                console.error("Formato de fecha incorrecto:", fechaBD);
                fechaNacimientoInput.value = fechaBD;
              }
            } catch (e) {
              console.error("Error al formatear la fecha:", e);
              fechaNacimientoInput.value = paciente.fecha_nacimiento;
            }
          } else {
            // Si no hay instancia de flatpickr, establecer el valor directamente
            fechaNacimientoInput.value = paciente.fecha_nacimiento;
          }
        }

        // Para los tags de enfermedad
        cargarTagsEnfermedad(paciente.enfermedad);

        document.getElementById("ticket-status").value = paciente.status
          ? "1"
          : "0";

        // Para la imagen - usar imagen predeterminada si no hay foto
        const imgElement =
          document.getElementById("lead-img") ||
          document.getElementById("companylogo-img");
        if (imgElement) {
          if (paciente.foto) {
            imgElement.src = paciente.foto;
          } else {
            imgElement.src = "../../assets/images/users/user-dummy-img.jpg";
          }
        }

        // Cambiar título del modal
        document.getElementById("lblTitulo").textContent = "Editar Paciente";

        // Cambiar texto del botón
        const addBtn = document.getElementById("add-btn");
        addBtn.textContent = "Actualizar Paciente";
        addBtn.value = "update";

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById("showModal"));
        modal.show();
      } else {
        Swal.fire({
          title: "Error",
          text: data.message || "Error al cargar el paciente",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error de conexión",
        text: "Error de conexión. Inténtelo más tarde.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

// Función para mostrar detalles del paciente en la vista detallada
function mostrarDetallesPaciente(pacienteId) {
  const token =
    localStorage.getItem("remember_token") || getCookie("remember_token");

  if (!token) {
    Swal.fire({
      title: "Error de sesión",
      text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar",
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

  const formData = new FormData();
  formData.append("Paciente_ID", pacienteId);

  fetch(`${BASE_URL}/api/misPacientes/mostrar`, {
    method: "POST",
    headers: {
      Accept: "application/json",
      "remember-token": token,
    },
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const paciente = data.data;

        // Actualizar la vista detallada con los datos del paciente
        // Asumiendo que tienes un modal o sección para mostrar detalles
        const detalleCard = document.getElementById("company-view-detail");

        if (detalleCard) {
          // Actualizar la imagen
          const avatarImg = detalleCard.querySelector(".avatar-sm");
          if (avatarImg) {
            avatarImg.src =
              paciente.foto || "../../assets/images/users/user-dummy-img.jpg";
          }

          // Actualizar el nombre y género
          const nombreElement = detalleCard.querySelector("h5.mt-3");
          if (nombreElement) {
            nombreElement.textContent = `${paciente.nombre} ${paciente.apellidos}`;
          }

          const generoElement = detalleCard.querySelector("p.text-muted");
          if (generoElement) {
            generoElement.textContent = paciente.genero || "";
          }

          // Actualizar la información de la tabla si existe
          const infoTable = detalleCard.querySelector("table.table-borderless");
          if (infoTable) {
            const filas = infoTable.querySelectorAll("tbody tr");

            // Actualizar campos basados en la estructura de la tabla
            if (filas[0])
              filas[0].querySelector("td:nth-child(2)").textContent =
                paciente.email || "";
            if (filas[1])
              filas[1].querySelector("td:nth-child(2)").textContent =
                paciente.localidad || "";
            if (filas[2])
              filas[2].querySelector("td:nth-child(2)").textContent =
                paciente.ciudad || "";
            if (filas[3])
              filas[3].querySelector("td:nth-child(2)").textContent =
                paciente.edad || "";
            if (filas[4])
              filas[4].querySelector("td:nth-child(2)").textContent =
                paciente.telefono || "";
            if (filas[5])
              filas[5].querySelector("td:nth-child(2)").textContent =
                paciente.enfermedad || "";
            if (filas[6])
              filas[6].querySelector("td:nth-child(2)").textContent =
                "Paciente";
          }

          // Mostrar el contenedor de detalles
          detalleCard.style.display = "block";
        }
      } else {
        Swal.fire({
          title: "Error",
          text: data.message || "Error al cargar detalles del paciente",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error de conexión",
        text: "Error de conexión. Inténtelo más tarde.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

// Función para mostrar el modal de confirmación de eliminación
function eliminarPaciente(id) {
  // Asignar ID al botón de eliminación en el modal
  document.getElementById("delete-record").setAttribute("data-id", id);

  // Mostrar el modal de confirmación
  const modal = new bootstrap.Modal(
    document.getElementById("deleteRecordModal")
  );
  modal.show();
}

// Función para confirmar y ejecutar la eliminación del paciente
function confirmarEliminarPaciente(id) {
  const token =
    localStorage.getItem("remember_token") || getCookie("remember_token");

  if (!token) {
    Swal.fire({
      title: "Error de sesión",
      text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar",
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

  const formData = new FormData();
  formData.append("Paciente_ID", id);

  fetch(`${BASE_URL}/api/misPacientes/eliminar`, {
    method: "POST",
    headers: {
      Accept: "application/json",
      "remember-token": token,
    },
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        Swal.fire({
          title: "¡Eliminado!",
          text: data.message || "Paciente eliminado correctamente",
          icon: "success",
          confirmButtonText: "Aceptar",
        });

        cargarPacientes(); // Actualizar la tabla
      } else {
        Swal.fire({
          title: "Error",
          text: data.message || "Error al eliminar el paciente",
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error de conexión",
        text: "Error de conexión. Inténtelo más tarde.",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    });
}

// Función para cargar la lista de pacientes desde el API
async function cargarPacientes() {
  const token =
    localStorage.getItem("remember_token") || getCookie("remember_token");

  if (!token) {
    Swal.fire({
      title: "Error de sesión",
      text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar",
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

  try {
    const response = await fetch(`${BASE_URL}/api/misPacientes/listar`, {
      method: "GET",
      headers: {
        Accept: "application/json",
        "remember-token": token,
      },
    });

    const data = await response.json();

    if (data.status === "success") {
      renderizarTabla(data.data);
      inicializarPaginacion();
    } else {
      console.error("Error al cargar pacientes:", data.message);
      Swal.fire({
        title: "Error",
        text: data.message || "Error al cargar la lista de pacientes",
        icon: "error",
        confirmButtonText: "Aceptar",
      });
    }
  } catch (error) {
    console.error("Error de conexión:", error);
    Swal.fire({
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor. Inténtelo más tarde.",
      icon: "error",
      confirmButtonText: "Aceptar",
    });
  }
}

// Función para renderizar la tabla con los datos de los pacientes
function renderizarTabla(pacientes) {
  const tbody = document.querySelector("#customerTable tbody");
  if (!tbody) {
    console.error("No se encontró el cuerpo de la tabla");
    return;
  }

  const noResultDiv = document.querySelector(".noresult");
  tbody.innerHTML = "";

  if (!pacientes || pacientes.length === 0) {
    console.log("No hay pacientes para mostrar");
    // Mostrar mensaje en la tabla cuando no hay datos
    tbody.innerHTML = `
      <tr>
        <td colspan="8" class="text-center">No hay pacientes registrados</td>
      </tr>
    `;
    if (noResultDiv) noResultDiv.style.display = "none";
    return;
  }

  pacientes.forEach((paciente) => {
    // Usar imagen predeterminada si no hay foto
    const imagenSrc =
      paciente.foto && paciente.foto !== "null"
        ? paciente.foto
        : "../../assets/images/users/user-dummy-img.jpg";

    // Crear la fila
    const tr = document.createElement("tr");
    tr.innerHTML = `
          <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#${
            paciente.Paciente_ID
          }</a></td>
          <td>
              <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                      <img src="${imagenSrc}" alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                  </div>
                  <div class="flex-grow-1 ms-2 name">${paciente.nombre}</div>
              </div>
          </td>
          <td class="owner">${paciente.apellidos}</td>
          <td class="industry_type">${paciente.genero || ""}</td>
          <td>
              <ul class="list-inline hstack gap-2 mb-0">
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                      <a class="edit-item-btn" href="javascript:void(0);" data-id="${
                        paciente.Paciente_ID
                      }">
                          <lord-icon
                              src="https://cdn.lordicon.com/vwzukuhn.json"
                              trigger="loop"
                              delay="2000"
                              stroke="bold"
                              colors="primary:#ffffff,secondary:#3a3347,tertiary:#ffc738,quaternary:#ebe6ef"
                              style="width:36px;height:36px">
                          </lord-icon>
                      </a>
                  </li>
              </ul>
          </td>
          <td>
              <ul class="list-inline hstack gap-2 mb-0">
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                      <a class="remove-item-btn" href="javascript:void(0);" data-id="${
                        paciente.Paciente_ID
                      }">
                          <lord-icon
                              src="https://cdn.lordicon.com/nhqwlgwt.json"
                              trigger="loop"
                              delay="2000"
                              stroke="bold"
                              colors="primary:#121331,secondary:#ee6d66,tertiary:#646e78,quaternary:#ebe6ef"
                              style="width:36px;height:36px">
                          </lord-icon>
                      </a>
                  </li>
              </ul>
          </td>
          <td>
              <ul class="list-inline hstack gap-2 mb-0">
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ver">
                      <a href="javascript:void(0);" class="view-item-btn" data-id="${
                        paciente.Paciente_ID
                      }">
                          <lord-icon
                              src="https://cdn.lordicon.com/jpywfkmi.json"
                              trigger="loop"
                              delay="2000"
                              stroke="bold"
                              colors="primary:#000000,secondary:#f9c9c0,tertiary:#e4e4e4,quaternary:#f28ba8"
                              style="width:36px;height:36px">
                          </lord-icon>
                      </a>
                  </li>
              </ul>
          </td>
          <td>
              <ul class="list-inline hstack gap-2 mb-0">
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Historial">
                      <a class="edit-item-btn" href="../infoPaciente/informacionConsulta.php?id=${
                        paciente.Paciente_ID
                      }">
                          <lord-icon
                              src="https://cdn.lordicon.com/cvcslrjt.json"
                              trigger="loop"
                              delay="2000"
                              stroke="bold"
                              colors="primary:#000000,secondary:#66a1ee,tertiary:#ffc738,quaternary:#e4e4e4"
                              style="width:36px;height: 36px;">
                          </lord-icon>
                      </a>
                  </li>
              </ul>
          </td>
      `;

    tbody.appendChild(tr);
  });

  setTimeout(inicializarPaginacion, 100);
}

// Función para inicializar la búsqueda
function inicializarBusqueda() {
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", function (e) {
      if (window.customerList) {
        window.customerList.search(e.target.value);
        verificarResultadosBusqueda();
      }
    });
  }
}

// Función para verificar si hay resultados de búsqueda
function verificarResultadosBusqueda() {
  const noResultDiv = document.querySelector(".noresult");
  const tbody = document.querySelector("#customerTable tbody");

  if (!window.customerList) return;

  // Verificar si hay elementos visibles
  const visibleItems = window.customerList.visibleItems.length;

  if (visibleItems === 0) {
    // Mostrar mensaje de no resultados
    if (noResultDiv) noResultDiv.style.display = "block";
    if (tbody) tbody.style.display = "none";
  } else {
    // Ocultar mensaje de no resultados
    if (noResultDiv) noResultDiv.style.display = "none";
    if (tbody) tbody.style.display = "";
  }
}

// Función para inicializar la paginación
function inicializarPaginacion() {
  // Espera un breve momento para asegurar que el DOM está listo
  setTimeout(() => {
    if (typeof List !== "undefined") {
      const options = {
        valueNames: ["name", "owner", "industry_type"],
        page: 10, // Número de elementos por página
        pagination: {
          innerWindow: 1,
          outerWindow: 1,
          left: 1,
          right: 1,
        },
      };

      // Eliminar instancia anterior si existe
      if (window.customerList) {
        window.customerList.destroy();
      }

      // Asegurarse de que la tabla existe y tiene datos
      const table = document.getElementById("customerTable");
      if (table && table.querySelector("tbody").children.length > 0) {
        try {
          window.customerList = new List("customerTable", options);

          // Inicializar la búsqueda
          inicializarBusqueda();
          // Configurar botones de navegación personalizados
          const paginationPrev = document.querySelector(".pagination-prev");
          const paginationNext = document.querySelector(".pagination-next");

          if (paginationPrev) {
            paginationPrev.addEventListener("click", function (e) {
              e.preventDefault();
              // Buscar el botón de página activo
              const activePage = document.querySelector(
                ".listjs-pagination .active"
              );
              if (activePage && activePage.previousElementSibling) {
                // Hacer clic en el botón de página anterior
                activePage.previousElementSibling.querySelector("a").click();
              }
              actualizarEstadoBotonesPaginacion();
            });
          }

          if (paginationNext) {
            paginationNext.addEventListener("click", function (e) {
              e.preventDefault();
              // Buscar el botón de página activo
              const activePage = document.querySelector(
                ".listjs-pagination .active"
              );
              if (activePage && activePage.nextElementSibling) {
                // Hacer clic en el botón de página siguiente
                activePage.nextElementSibling.querySelector("a").click();
              }
              actualizarEstadoBotonesPaginacion();
            });
          }

          // Añadir evento de actualización después de cada cambio de página
          window.customerList.on("updated", function () {
            verificarResultadosBusqueda();
            actualizarEstadoBotonesPaginacion();
          });
          verificarResultadosBusqueda();
          // Inicializar estado de botones
          actualizarEstadoBotonesPaginacion();
        } catch (error) {
          console.error("Error al inicializar List.js:", error);
        }
      } else {
        console.log("La tabla está vacía o no existe");
      }
    } else {
      console.error("List.js no está disponible");
    }
  }, 200); // Aumentado a 200ms para dar más tiempo
}

function actualizarEstadoBotonesPaginacion() {
  const paginationItems = document.querySelectorAll(".listjs-pagination li");
  if (!paginationItems || paginationItems.length === 0) {
    // Si no hay elementos de paginación, ocultar botones
    document.querySelector(".pagination-prev")?.classList.add("disabled");
    document.querySelector(".pagination-next")?.classList.add("disabled");
    return;
  }

  const activePage = document.querySelector(".listjs-pagination .active");
  const paginationPrev = document.querySelector(".pagination-prev");
  const paginationNext = document.querySelector(".pagination-next");

  if (paginationPrev) {
    // Deshabilitar "Anterior" si estamos en la primera página o no hay página activa
    if (!activePage || !activePage.previousElementSibling) {
      paginationPrev.classList.add("disabled");
    } else {
      paginationPrev.classList.remove("disabled");
    }
  }

  if (paginationNext) {
    // Deshabilitar "Siguiente" si estamos en la última página o no hay página activa
    if (!activePage || !activePage.nextElementSibling) {
      paginationNext.classList.add("disabled");
    } else {
      paginationNext.classList.remove("disabled");
    }
  }
}
