const BASE_URL = "http://127.0.0.1:8000";

// Utilidades
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

// Gestor de Pacientes
const pacienteManager = {
  async cargarPacientes() {
    const token = util.checkAuth();
    if (!token) return;

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
        this.renderizarTabla(data.data);
        this.inicializarPaginacion();
      } else {
        util.showError(data.message || "Error al cargar la lista de pacientes");
      }
    } catch (error) {
      console.error("Error de conexión:", error);
      util.showError(
        "No se pudo conectar con el servidor. Inténtelo más tarde."
      );
    }
  },

  // Cargar lista de pacientes
  // Función para ordenar pacientes
  ordenarPacientes(pacientes, criterio) {
    if (!pacientes || !Array.isArray(pacientes)) return pacientes;

    return [...pacientes].sort((a, b) => {
      // Validar que existan los valores a comparar
      const valA = a[criterio] || "";
      const valB = b[criterio] || "";

      switch (criterio) {
        case "Recientes":
          const dateC = new Date(a.fecha_creacion || 0);
          const dateD = new Date(b.fecha_creacion || 0);
          return criterio === "Recientes" ? dateC - dateD : dateD - dateC;
        case "Antiguos":
          // Asumiendo que tienes una propiedad fecha_creacion
          const dateA = new Date(a.fecha_creacion || 0);
          const dateB = new Date(b.fecha_creacion || 0);
          return criterio === "Antiguos" ? dateB - dateA : dateA - dateB;

        case "NombreAZ":
          return (a.nombre || "").localeCompare(b.nombre || "");
        case "NombreZA":
          return (b.nombre || "").localeCompare(a.nombre || "");
        case "ApellidosAZ":
          return (a.apellidos || "").localeCompare(b.apellidos || "");
        case "ApellidosZA":
          return (b.apellidos || "").localeCompare(a.apellidos || "");
        case "Masculino":
          return a.genero === "Masculino"
            ? -1
            : b.genero === "Masculino"
            ? 1
            : 0;
        case "Femenino":
          return a.genero === "Femenino" ? -1 : b.genero === "Femenino" ? 1 : 0;
            
        default:
          return 0;
      }
    });
  },
  // Inicializar el selector de ordenamiento
  inicializarOrdenamiento() {
    const selector = document.getElementById("ordenar-pacientes");
    if (!selector) return;

    selector.addEventListener("change", (e) => {
      const criterio = e.target.value;
      this.aplicarOrdenamiento(criterio);
    });
  },

  // Aplicar el ordenamiento seleccionado
  // Aplicar el ordenamiento seleccionado
  aplicarOrdenamiento(criterio) {
    if (!window.customerList) return;

    // Obtener los pacientes originales de la tabla (no de List.js)
    const tbody = document.querySelector("#customerTable tbody");
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll("tr"));
    const pacientes = rows.map((row) => {
      return {
        id: row.querySelector(".id a")?.textContent.replace("#", "") || "",
        nombre: row.querySelector(".name")?.textContent || "",
        apellidos: row.querySelector(".owner")?.textContent || "",
        genero: row.querySelector(".industry_type")?.textContent || "",
        imagen: row.querySelector(".image_src")?.src || "",
        // Agrega más propiedades si necesitas ordenar por otros campos
        elemento: row, // Guardamos la referencia al elemento para reconstruir
      };
    });

    // Ordenar los pacientes
    const pacientesOrdenados = this.ordenarPacientes(pacientes, criterio);

    // Limpiar la tabla
    tbody.innerHTML = "";

    // Reconstruir la tabla con el orden nuevo
    pacientesOrdenados.forEach((paciente) => {
      tbody.appendChild(paciente.elemento);
    });

    // Re-inicializar List.js para mantener la funcionalidad de búsqueda/paginación
    this.inicializarPaginacion();
  },

  // Renderizar tabla de pacientes
  renderizarTabla(pacientes) {
    const tbody = document.querySelector("#customerTable tbody");
    if (!tbody) return;

    const noResultDiv = document.querySelector(".noresult");
    tbody.innerHTML = "";

    if (!pacientes || pacientes.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="8" class="text-center">No hay pacientes registrados</td>
        </tr>
      `;
      if (noResultDiv) noResultDiv.style.display = "none";
      return;
    }

    pacientes.forEach((paciente) => {
      const imagenSrc =
        paciente.foto && paciente.foto !== "null"
          ? paciente.foto
          : "../../assets/images/users/user-dummy-img.jpg";

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
                <lord-icon src="https://cdn.lordicon.com/vwzukuhn.json" trigger="loop" delay="2000" stroke="bold"
                  colors="primary:#ffffff,secondary:#3a3347,tertiary:#ffc738,quaternary:#ebe6ef" style="width:36px;height:36px">
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
                <lord-icon src="https://cdn.lordicon.com/nhqwlgwt.json" trigger="loop" delay="2000" stroke="bold"
                  colors="primary:#121331,secondary:#ee6d66,tertiary:#646e78,quaternary:#ebe6ef" style="width:36px;height:36px">
                </lord-icon>
              </a>
            </li>
          </ul>
        </td>
        <td>
          <ul class="list-inline hstack gap-2 mb-0">
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Ver">
              <a href="javascript:void(0);" class="view-item-btn2" data-id="${
                paciente.Paciente_ID
              }">
                <lord-icon src="https://cdn.lordicon.com/jpywfkmi.json" trigger="loop" delay="2000" stroke="bold"
                  colors="primary:#000000,secondary:#f9c9c0,tertiary:#e4e4e4,quaternary:#f28ba8" style="width:36px;height:36px">
                </lord-icon>
              </a>
            </li>
          </ul>
        </td>
        <td>
          <ul class="list-inline hstack gap-2 mb-0">
            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Historial">
              <a class="historial-btn" href="../Pacientes/index.php?id=${
                paciente.Paciente_ID
              }">
                <lord-icon src="https://cdn.lordicon.com/cvcslrjt.json" trigger="loop" delay="2000" stroke="bold"
                  colors="primary:#000000,secondary:#66a1ee,tertiary:#ffc738,quaternary:#e4e4e4" style="width:36px;height:36px">
                </lord-icon>
              </a>
            </li>
          </ul>
        </td>
      `;
      tbody.appendChild(tr);
    });

    setTimeout(() => this.inicializarPaginacion(), 100);
  },

  // Mostrar detalles de un paciente
  async mostrarDetallesPaciente(pacienteId) {
    const token = util.checkAuth();
    if (!token) return;

    const formData = new FormData();
    formData.append("Paciente_ID", pacienteId);

    try {
      const response = await fetch(`${BASE_URL}/api/misPacientes/mostrar`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "remember-token": token,
        },
        body: formData,
      });

      const data = await response.json();

      if (data.status === "success") {
        const paciente = data.data;
        const detalleCard = document.getElementById("company-view-detail");

        if (detalleCard) {
          // Actualizar imagen
          const avatarImg = detalleCard.querySelector(".avatar-sm");
          if (avatarImg) {
            avatarImg.src =
              paciente.foto || "../../assets/images/users/user-dummy-img.jpg";
          }

          // Actualizar nombre y género
          const nombreElement = detalleCard.querySelector("h5.mt-3");
          if (nombreElement) {
            nombreElement.textContent = `${paciente.nombre} ${paciente.apellidos}`;
          }

          const generoElement = detalleCard.querySelector("p.text-muted");
          if (generoElement) {
            generoElement.textContent = paciente.genero || "";
          }

          // Actualizar tabla de información
          const infoTable = detalleCard.querySelector("table.table-borderless");
          if (infoTable) {
            const filas = infoTable.querySelectorAll("tbody tr");

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

          // Mostrar contenedor
          detalleCard.style.display = "block";
        }
      } else {
        util.showError(data.message || "Error al cargar detalles del paciente");
      }
    } catch (error) {
      console.error("Error:", error);
      util.showError("Error de conexión. Inténtelo más tarde.");
    }
  },

  // Cargar datos de un paciente para edición
  async cargarPaciente(id) {
    const token = util.checkAuth();
    if (!token) return;

    const formData = new FormData();
    formData.append("Paciente_ID", id);

    try {
      const response = await fetch(`${BASE_URL}/api/misPacientes/mostrar`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "remember-token": token,
        },
        body: formData,
      });

      const data = await response.json();

      if (data.status === "success") {
        const paciente = data.data;

        // Limpiar formulario
        formManager.limpiarFormulario();

        // Llenar campos básicos
        document.getElementById("Paciente_ID").value = paciente.Paciente_ID;
        document.getElementById("nombre").value = paciente.nombre;
        document.getElementById("apellidos").value = paciente.apellidos;
        document.getElementById("email").value = paciente.email;
        document.getElementById("telefono").value = paciente.telefono || "";
        document.getElementById("genero").value = paciente.genero || "";
        document.getElementById("usuario").value = paciente.usuario;

        // Campos adicionales si existen
        if (document.getElementById("localidad")) {
          document.getElementById("localidad").value = paciente.localidad || "";
        }
        if (document.getElementById("ciudad")) {
          document.getElementById("ciudad").value = paciente.ciudad || "";
        }
        if (document.getElementById("edad")) {
          document.getElementById("edad").value = paciente.edad || "";
        }

        // Fecha de nacimiento
        formManager.setFechaNacimiento(paciente.fecha_nacimiento);

        // Tags de enfermedad
        formManager.cargarTagsEnfermedad(paciente.enfermedad);

        // Estado
        document.getElementById("ticket-status").value = paciente.status
          ? "1"
          : "0";

        // Imagen
        const imgElement =
          document.getElementById("lead-img") ||
          document.getElementById("companylogo-img");
        if (imgElement) {
          imgElement.src =
            paciente.foto || "../../assets/images/users/user-dummy-img.jpg";
        }

        // Configurar formulario para edición
        document.getElementById("lblTitulo").textContent = "Editar Paciente";
        const addBtn = document.getElementById("add-btn");
        addBtn.textContent = "Actualizar Paciente";
        addBtn.value = "update";

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById("showModal"));
        modal.show();
      } else {
        util.showError(data.message || "Error al cargar el paciente");
      }
    } catch (error) {
      console.error("Error:", error);
      util.showError("Error de conexión. Inténtelo más tarde.");
    }
  },

  // Eliminar un paciente
  async eliminarPaciente(id) {
    // Asignar ID al botón de eliminación
    document.getElementById("delete-record").setAttribute("data-id", id);

    // Mostrar modal de confirmación
    const modal = new bootstrap.Modal(
      document.getElementById("deleteRecordModal")
    );
    modal.show();
  },

  // Confirmar y ejecutar eliminación
  async confirmarEliminarPaciente(id) {
    const token = util.checkAuth();
    if (!token) return;

    const formData = new FormData();
    formData.append("Paciente_ID", id);

    try {
      const response = await fetch(`${BASE_URL}/api/misPacientes/eliminar`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "remember-token": token,
        },
        body: formData,
      });

      const data = await response.json();

      if (data.status === "success") {
        util.showSuccess(data.message || "Paciente eliminado correctamente");
        this.cargarPacientes();
      } else {
        util.showError(data.message || "Error al eliminar el paciente");
      }
    } catch (error) {
      console.error("Error:", error);
      util.showError("Error de conexión. Inténtelo más tarde.");
    }
  },

  // Inicializar paginación
  inicializarPaginacion() {
    setTimeout(() => {
      if (typeof List === "undefined") {
        console.error("List.js no está disponible");
        return;
      }

      const table = document.getElementById("customerTable");
      if (!table || table.querySelector("tbody").children.length === 0) {
        console.log("La tabla está vacía o no existe");
        return;
      }

      try {
        // Opciones de paginación
        const options = {
          valueNames: ["name", "owner", "industry_type"],
          page: 10,
          pagination: {
            innerWindow: 1,
            outerWindow: 1,
            left: 1,
            right: 1,
          },
        };

        // Destruir instancia anterior si existe
        if (window.customerList) {
          window.customerList.destroy();
        }

        // Crear nueva instancia
        window.customerList = new List("customerTable", options);

        // Configurar búsqueda
        this.inicializarBusqueda();

        // Configurar botones de navegación
        this.configurarBotonesPaginacion();

        // Establecer eventos
        window.customerList.on("updated", () => {
          this.verificarResultadosBusqueda();
          this.actualizarEstadoBotonesPaginacion();
        });

        this.verificarResultadosBusqueda();
        this.actualizarEstadoBotonesPaginacion();
      } catch (error) {
        console.error("Error al inicializar List.js:", error);
      }
    }, 200);
  },

  // Configurar botones de paginación
  configurarBotonesPaginacion() {
    const paginationPrev = document.querySelector(".pagination-prev");
    const paginationNext = document.querySelector(".pagination-next");

    if (paginationPrev) {
      paginationPrev.addEventListener("click", (e) => {
        e.preventDefault();
        const activePage = document.querySelector(".listjs-pagination .active");
        if (activePage && activePage.previousElementSibling) {
          activePage.previousElementSibling.querySelector("a").click();
        }
        this.actualizarEstadoBotonesPaginacion();
      });
    }

    if (paginationNext) {
      paginationNext.addEventListener("click", (e) => {
        e.preventDefault();
        const activePage = document.querySelector(".listjs-pagination .active");
        if (activePage && activePage.nextElementSibling) {
          activePage.nextElementSibling.querySelector("a").click();
        }
        this.actualizarEstadoBotonesPaginacion();
      });
    }
  },

  // Actualizar estado de botones de paginación
  actualizarEstadoBotonesPaginacion() {
    const paginationItems = document.querySelectorAll(".listjs-pagination li");
    if (!paginationItems || paginationItems.length === 0) {
      document.querySelector(".pagination-prev")?.classList.add("disabled");
      document.querySelector(".pagination-next")?.classList.add("disabled");
      return;
    }

    const activePage = document.querySelector(".listjs-pagination .active");
    const paginationPrev = document.querySelector(".pagination-prev");
    const paginationNext = document.querySelector(".pagination-next");

    if (paginationPrev) {
      if (!activePage || !activePage.previousElementSibling) {
        paginationPrev.classList.add("disabled");
      } else {
        paginationPrev.classList.remove("disabled");
      }
    }

    if (paginationNext) {
      if (!activePage || !activePage.nextElementSibling) {
        paginationNext.classList.add("disabled");
      } else {
        paginationNext.classList.remove("disabled");
      }
    }
  },

  // Inicializar búsqueda
  inicializarBusqueda() {
    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
      searchInput.addEventListener("input", (e) => {
        if (window.customerList) {
          window.customerList.search(e.target.value);
          this.verificarResultadosBusqueda();
        }
      });
    }
  },

  // Verificar resultados de búsqueda
  verificarResultadosBusqueda() {
    const noResultDiv = document.querySelector(".noresult");
    const tbody = document.querySelector("#customerTable tbody");

    if (!window.customerList) return;

    const visibleItems = window.customerList.visibleItems.length;

    if (visibleItems === 0) {
      if (noResultDiv) noResultDiv.style.display = "block";
      if (tbody) tbody.style.display = "none";
    } else {
      if (noResultDiv) noResultDiv.style.display = "none";
      if (tbody) tbody.style.display = "";
    }
  },
};

// Gestor del formulario
const formManager = {
  // Limpiar formulario
  limpiarFormulario() {
    const form = document.getElementById("Paciente_form");
    if (!form) return;
    
    form.reset();
    document.getElementById("Paciente_ID").value = "";
    
    // Restaurar imagen predeterminada
    const imgElement = document.getElementById("lead-img") || document.getElementById("companylogo-img");
    if (imgElement) {
      imgElement.src = "../../assets/images/users/user-dummy-img.jpg";
    }
    
    // Limpiar tags de enfermedad
    this.cargarTagsEnfermedad("");
    
    // Restaurar estado activo por defecto
    const statusElement = document.getElementById("ticket-status");
    if (statusElement) {
      statusElement.value = "1";
    }
  },
  
  // Preparar formulario para nuevo paciente
  prepararNuevoFormulario() {
    this.limpiarFormulario();
    
    document.getElementById("lblTitulo").textContent = "Añadir Paciente";
    
    const addBtn = document.getElementById("add-btn");
    addBtn.textContent = "Añadir Paciente";
    addBtn.value = "add";
  },
  
  // Configurar campo de fecha de nacimiento
  setFechaNacimiento(fechaStr) {
    if (!fechaStr) return;
    
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    if (!fechaNacimientoInput) return;
    
    const flatpickrInstance = fechaNacimientoInput._flatpickr;
    
    if (flatpickrInstance) {
      try {
        const partesFecha = fechaStr.split("-");
        if (partesFecha.length === 3) {
          const fechaObj = new Date(
            parseInt(partesFecha[0]),
            parseInt(partesFecha[1]) - 1,
            parseInt(partesFecha[2])
          );
          
          if (!isNaN(fechaObj.getTime())) {
            flatpickrInstance.setDate(fechaObj);
          } else {
            fechaNacimientoInput.value = fechaStr;
          }
        } else {
          fechaNacimientoInput.value = fechaStr;
        }
      } catch (e) {
        console.error("Error al formatear la fecha:", e);
        fechaNacimientoInput.value = fechaStr;
      }
    } else {
      fechaNacimientoInput.value = fechaStr;
    }
  },
  
  // Cargar tags de enfermedad
  cargarTagsEnfermedad(enfermedadesString) {
    const tagsInput = document.getElementById("taginput-choices");
    if (!tagsInput) return;
    
    const enfermedades = enfermedadesString
      ? enfermedadesString.split(",").map(e => e.trim()).filter(e => e)
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
            removeItemButton: true
          });
        }
      }, 10);
    } else {
      tagsInput.value = enfermedades.join(",");
      
      if (window.Choices) {
        new Choices(tagsInput, {
          removeItemButton: true
        });
      }
    }
  },
  
  // Manejar envío del formulario
  async handleFormSubmit(e) {
    e.preventDefault();
    
    const token = util.checkAuth();
    if (!token) return;
    
    const formData = new FormData(this);
    
    // Formatear fecha de nacimiento
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    if (fechaNacimientoInput && fechaNacimientoInput.value) {
      try {
        const fechaSeleccionada = flatpickr.parseDate(fechaNacimientoInput.value, "d M, Y");
        const fechaFormateada = flatpickr.formatDate(fechaSeleccionada, "Y-m-d");
        formData.set("fecha_nacimiento", fechaFormateada);
      } catch (e) {
        console.error("Error al formatear la fecha:", e);
      }
    }
    
    // Obtener tags de enfermedad
    const tagsInput = document.getElementById("taginput-choices");
    let enfermedades = [];
    
    if (window.Choices && tagsInput._choices) {
      enfermedades = tagsInput._choices.store.activeItems.map(item => item.value);
    } else if (tagsInput.value) {
      enfermedades = tagsInput.value.split(",").map(e => e.trim()).filter(e => e);
    }
    
    formData.set("enfermedad", enfermedades.join(","));
    
    // Establecer estado
    const status = document.getElementById("ticket-status").value;
    formData.set("status", status === "1" ? 1 : 0);
    
    // Imagen predeterminada para nuevos registros
    const fileInput = document.getElementById("lead-image-input");
    const pacienteId = document.getElementById("Paciente_ID").value;
    
    if (fileInput && fileInput.files.length === 0 && (!pacienteId || pacienteId === "")) {
      formData.append("imagen_predeterminada", true);
    }
    
    try {
      const response = await fetch(`${BASE_URL}/api/misPacientes/guardar_editar`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "remember-token": token
        },
        body: formData
      });
      
      const data = await response.json();
      
      if (response.ok) {
        util.showSuccess(data.message || "Operación completada con éxito");
        document.getElementById("close-modal").click();
        pacienteManager.cargarPacientes();
      } else {
        let errorMessage = "Error en la operación";
        if (data.errors) {
          errorMessage = Object.values(data.errors).join("\n");
        } else if (data.message) {
          errorMessage = data.message;
        }
        
        util.showError(errorMessage);
      }
    } catch (error) {
      console.error("Error:", error);
      util.showError("No se pudo conectar con el servidor. Inténtelo más tarde.");
    }
  }
};

// Inicialización y eventos
document.addEventListener("DOMContentLoaded", function() {
  // Verificar si estamos volviendo desde la página de historial
  // SOLUCIÓN AL ERROR: Comprobar si venimos desde otra página
  const referrer = document.referrer;
  const isFromHistorial = referrer.includes("/Pacientes/index.php");

  // Cargar pacientes al inicio
  pacienteManager.cargarPacientes();
  // Cargar pacientes al inicio
  pacienteManager.cargarPacientes();

  // Inicializar ordenamiento
  pacienteManager.inicializarOrdenamiento();

  // Inicializar búsqueda
  if (document.getElementById("searchInput")) {
    pacienteManager.inicializarBusqueda();
  }

  // Eventos para los modales
  // Evento para editar paciente
  document.addEventListener("click", function (e) {
    const target = e.target.closest(".edit-item-btn");
    if (target) {
      const pacienteId = target.getAttribute("data-id");
      pacienteManager.cargarPaciente(pacienteId);
    }
  });

  // Evento para ver detalles
  document.addEventListener("click", function (e) {
    const target = e.target.closest(".view-item-btn2");
    if (target) {
      const pacienteId = target.getAttribute("data-id");
      pacienteManager.mostrarDetallesPaciente(pacienteId);
    }
  });

  // Evento para eliminar
  document.addEventListener("click", function (e) {
    const target = e.target.closest(".remove-item-btn");
    if (target) {
      const pacienteId = target.getAttribute("data-id");
      pacienteManager.eliminarPaciente(pacienteId);
    }
  });

  document.addEventListener("click", function (e) {
    // Verificar si el elemento o algún elemento padre tiene la clase 'view-item-btn'
    const viewButton = e.target.closest(".view-item-btn");

    if (viewButton) {
      // Obtener el ID del paciente del atributo data-id
      const pacienteId = viewButton.getAttribute("data-id");

      if (pacienteId) {
        // Redireccionar a la página de historial de consultas con el ID del paciente
        window.location.href = `../historial/historialConsultas.php?paciente_id=${pacienteId}`;
      } else {
        console.error("No se encontró el ID del paciente");
      }
    }
  });

  // Limpiar formulario al cerrar modal
  const showModal = document.getElementById("showModal");
  if (showModal) {
    showModal.addEventListener("hidden.bs.modal", () =>
      formManager.limpiarFormulario()
    );
  }

  // Botón para añadir nuevo paciente
  const addBtn = document.querySelector(".add-btn");
  if (addBtn) {
    addBtn.addEventListener("click", () =>
      formManager.prepararNuevoFormulario()
    );
  }

  // Configurar formulario
  const pacienteForm = document.getElementById("Paciente_form");
  if (pacienteForm) {
    pacienteForm.addEventListener("submit", formManager.handleFormSubmit);
  }

  // Botón de confirmación de eliminación
  document
    .getElementById("delete-record")
    .addEventListener("click", function () {
      const pacienteId = this.getAttribute("data-id");
      if (pacienteId) {
        pacienteManager.confirmarEliminarPaciente(pacienteId);
      }
      document.getElementById("deleteRecord-close").click();
    });
});