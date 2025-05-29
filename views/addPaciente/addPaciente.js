const BASE_URL = "https://nutrifitplanner.site";
let choicesInstance = null;

// Función para inicializar el formulario
document.addEventListener("DOMContentLoaded", function () {
  CargarPacientes_(); // Cargar pacientes al inicio
  const tagsInput = document.getElementById("taginput-choices");
  if (window.Choices && tagsInput) {
    choicesTags = new Choices(tagsInput, {
      removeItemButton: true,
    });
  }
  if (document.getElementById('searchInput')) {
    inicializarBusqueda();
  }
  
  // Configuración para la subida de imagen
  document
    .getElementById("lead-image-input")
    .addEventListener("change", function (e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("lead-img").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

  // Inicializar formulario
  const pacienteForm = document.getElementById("Paciente_form");
  
  pacienteForm.addEventListener("submit", handleFormSubmit);
  
  // Inicializar modal de eliminar
  document.getElementById("delete-record").addEventListener("click", function() {
    const pacienteId = this.getAttribute("data-id");
    if (pacienteId) {
      confirmarEliminarPaciente(pacienteId);
    }
    document.getElementById("deleteRecord-close").click(); // Cerrar modal
  });
  
  // Inicializar eventos para abrir nuevo formulario
  document.getElementById("showModal").addEventListener("hidden.bs.modal", limpiarFormulario);
  document.querySelector(".add-btn").addEventListener("click", prepararNuevoFormulario);
});

// Función para limpiar el formulario y restaurar valores predeterminados
function limpiarFormulario() {
  const form = document.getElementById("Paciente_form");
  form.reset();
  document.getElementById("Paciente_ID").value = "";
  document.getElementById("lead-img").src = "../../assets/images/users/user-dummy-img.jpg";
  
  // Limpiar tags de enfermedad si existe el plugin Choices
  const tagsInput = document.getElementById("taginput-choices");
  if (window.Choices && tagsInput && tagsInput.choices) {
    tagsInput.choices.removeActiveItems();
  } else if (tagsInput) {
    tagsInput.value = "";
  }
  
  // Restaurar estado activo por defecto
  document.getElementById("ticket-status").value = "1";
}

// Función para preparar el formulario para un nuevo paciente
function prepararNuevoFormulario() {
  limpiarFormulario();
  document.getElementById("lblTitulo").textContent = "Añadir Paciente";
  const addBtn = document.getElementById("add-btn");
  addBtn.textContent = "Añadir Paciente";
  addBtn.value = "add";
}

// Manejar envío del formulario
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
      confirmButtonText: "Aceptar"
    }).then(() => {
      window.location.href = "login.html"; // Redirigir al login
    });
    return;
  }

  const formData = new FormData(this);
  // Obtener los tags de enfermedad del elemento Choices
  const tagsInput = document.getElementById("taginput-choices");
  let enfermedades = [];
  
  if (window.Choices && tagsInput._choices) {
    // Si Choices está inicializado
    enfermedades = tagsInput._choices.store.activeItems.map(item => item.value);
  } else if (tagsInput.value) {
    // Si Choices no está inicializado (fallback)
    enfermedades = tagsInput.value.split(',').map(e => e.trim()).filter(e => e);
  }
  
  // Agregar enfermedades al FormData
  formData.set("enfermedad", enfermedades.join(','));


  // Asegurarse de que el estado se envíe correctamente
  const status = document.getElementById("ticket-status").value;
  formData.set("status", status === "1" ? 1 : 0);

  // Asegurarse de que el rol_id se envíe como número
  formData.set("rol_id", 2); // Siempre 2 para pacientes

  // Establecer imagen predeterminada si no se ha seleccionado ninguna
  const fileInput = document.getElementById("lead-image-input");
  const pacienteId = document.getElementById("Paciente_ID").value;
  
  if (fileInput && fileInput.files.length === 0 && (!pacienteId || pacienteId === "")) {
    // Es un nuevo registro sin imagen, usar imagen predeterminada
    formData.append("imagen_predeterminada", true);
  }

  // Usar la ruta guardar_editar para ambos casos (crear y actualizar)
  const url = `${BASE_URL}/api/pacientes/guardar_editar`;

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
        confirmButtonText: "Aceptar"
      });
      
      document.getElementById("close-modal").click(); // Cerrar modal
      CargarPacientes_(); // Recargar la tabla de pacientes
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
        confirmButtonText: "Aceptar"
      });
    }
  } catch (error) {
    console.error("Error:", error);
    Swal.fire({
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor. Inténtelo más tarde.",
      icon: "error",
      confirmButtonText: "Aceptar"
    });
  }
}

// Función para obtener cookies
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
  return null;
}


function cargarTagsEnfermedad(enfermedadesString) {
    // Obtener el elemento input original
    const tagsInput = document.getElementById("taginput-choices");
    
    // Verificar si el elemento existe
    if (!tagsInput) return;
    
    // Procesar las enfermedades
    const enfermedades = enfermedadesString ? 
      enfermedadesString.split(',').map(e => e.trim()).filter(e => e) : 
      [];
    
    // Vamos a eliminar completamente el contenedor de Choices si existe
    const choicesContainer = tagsInput.closest('.choices');
    if (choicesContainer) {
      // Crear un nuevo input que reemplazará toda la estructura
      const newInput = document.createElement("input");
      newInput.id = "taginput-choices";
      newInput.name = "taginput-choices";
      newInput.className = "form-control";
      newInput.setAttribute("data-choices", "");
      newInput.setAttribute("data-choices-text-unique-true", "");
      newInput.type = "text";
      
      // Establecer el valor antes de añadirlo al DOM
      if (enfermedades.length > 0) {
        newInput.value = enfermedades.join(',');
      }
      
      // Reemplazar completamente el contenedor de Choices
      choicesContainer.parentNode.replaceChild(newInput, choicesContainer);
      
      // Inicializar Choices después de agregar el elemento al DOM
      setTimeout(() => {
        if (window.Choices) {
          new Choices(newInput, {
            removeItemButton: true
          });
        }
      }, 10);
    } else {
      // Si no hay contenedor Choices, simplemente establecer el valor
      tagsInput.value = enfermedades.join(',');
      
      // Inicializar Choices
      if (window.Choices) {
        new Choices(tagsInput, {
          removeItemButton: true
        });
      }
    }
  }
  
  // Modificar la función limpiarFormulario para usar nuestra nueva función
  function limpiarFormulario() {
    const form = document.getElementById("Paciente_form");
    form.reset();
    document.getElementById("Paciente_ID").value = "";
    document.getElementById("lead-img").src = "../../assets/images/users/user-dummy-img.jpg";
    
    // Limpiar tags de enfermedad
    cargarTagsEnfermedad("");
    
    // Restaurar estado activo por defecto
    document.getElementById("ticket-status").value = "1";
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
      confirmButtonText: "Aceptar"
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

  const formData = new FormData();
  formData.append("Paciente_ID", id);

  fetch(`${BASE_URL}/api/pacientes/mostrar`, {
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
        document.getElementById("rol_id").value = paciente.rol_id;

        // Para los tags de enfermedad
        cargarTagsEnfermedad(paciente.enfermedad);

        document.getElementById("ticket-status").value = paciente.status
          ? "1"
          : "0";

        // Para la imagen - usar imagen predeterminada si no hay foto
        if (paciente.foto) {
          document.getElementById("lead-img").src = paciente.foto;
        } else {
          document.getElementById("lead-img").src = "../../assets/images/users/user-dummy-img.jpg";
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
          confirmButtonText: "Aceptar"
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error de conexión",
        text: "Error de conexión. Inténtelo más tarde.",
        icon: "error",
        confirmButtonText: "Aceptar"
      });
    });
}



// Función para mostrar el modal de confirmación de eliminación
function eliminarPaciente(id) {
  // Asignar ID al botón de eliminación en el modal
  document.getElementById("delete-record").setAttribute("data-id", id);
  
  // Mostrar el modal de confirmación
  const modal = new bootstrap.Modal(document.getElementById("deleteRecordModal"));
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
      confirmButtonText: "Aceptar"
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

    // Mostrar el modal inmediatamente con un estado de carga
    const modal = new bootstrap.Modal(document.getElementById("showModal"));
    modal.show();
    
    // Mostrar spinner de carga
    document.getElementById("lblTitulo").textContent = "Cargando...";
    const addBtn = document.getElementById("add-btn");
    addBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...';
    addBtn.disabled = true;

  const formData = new FormData();
  formData.append("Paciente_ID", id);

  fetch(`${BASE_URL}/api/pacientes/eliminar`, {
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
          confirmButtonText: "Aceptar"
        });
        
        CargarPacientes_(); // Actualizar la tabla
      } else {
        Swal.fire({
          title: "Error",
          text: data.message || "Error al eliminar el paciente",
          icon: "error",
          confirmButtonText: "Aceptar"
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      Swal.fire({
        title: "Error de conexión",
        text: "Error de conexión. Inténtelo más tarde.",
        icon: "error",
        confirmButtonText: "Aceptar"
      });
    });
}

// Función para cargar la lista de pacientes desde el API
async function CargarPacientes_() {
  const token =
    localStorage.getItem("remember_token") || getCookie("remember_token");

  if (!token) {
    Swal.fire({
      title: "Error de sesión",
      text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
      icon: "error",
      confirmButtonText: "Aceptar"
    }).then(() => {
      window.location.href = "login.html";
    });
    return;
  }

  try {
    const response = await fetch(`${BASE_URL}/api/pacientes/listar`, {
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
        confirmButtonText: "Aceptar"
      });
    }
  } catch (error) {
    console.error("Error de conexión:", error);
    Swal.fire({
      title: "Error de conexión",
      text: "No se pudo conectar con el servidor. Inténtelo más tarde.",
      icon: "error",
      confirmButtonText: "Aceptar"
    });
  }
}

// Función para renderizar la tabla con los datos de los pacientes
function renderizarTabla(pacientes) {
  const tbody = document.querySelector("#customerTable tbody");
  const noResultDiv = document.querySelector('.noresult');
  tbody.innerHTML = "";

  if (!pacientes || pacientes.length === 0) {
    console.log("No hay pacientes para mostrar");
    // Mostrar mensaje en la tabla cuando no hay datos
    tbody.innerHTML = `
      <tr>
        <td colspan="11" class="text-center">No hay pacientes registrados</td>
      </tr>
    `;
    if (noResultDiv) noResultDiv.style.display = 'none';
    return;
  }

  pacientes.forEach((paciente) => {
    // Usar imagen predeterminada si no hay foto
    const imagenSrc = paciente.foto && paciente.foto !== "null"
      ? paciente.foto
      : "../../assets/images/users/user-dummy-img.jpg";

    // Determinar el color del badge de status
    const statusClass = paciente.status
      ? "bg-success-subtle text-success"
      : "bg-danger-subtle text-danger";
    const statusText = paciente.status ? "Activo" : "Inactivo";

    // Procesar las enfermedades (separadas por comas)
    let enfermedadesBadges = "";
    if (paciente.enfermedad) {
      const enfermedades = paciente.enfermedad
        .split(",")
        .map((e) => e.trim())
        .filter((e) => e);
      if (enfermedades.length > 0) {
        enfermedadesBadges = enfermedades
          .map(
            (enfermedad) =>
              `<span class="badge bg-danger-subtle text-danger me-1">${enfermedad}</span>`
          )
          .join("");
      } else {
        enfermedadesBadges =
          '<span class="badge bg-danger-subtle text-danger">No especificada</span>';
      }
    } else {
      enfermedadesBadges =
        '<span class="badge bg-danger-subtle text-danger">No especificada</span>';
    }

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
          <td class="company_name">${paciente.apellidos}</td>
          <td class="leads_score">${paciente.email}</td>
          <td class="phone">${paciente.telefono || ""}</td>
          <td class="location">${paciente.usuario}</td>
          <td class="role">
              <span class="badge bg-primary-subtle text-primary">${
                paciente.rol_nombre || "Paciente"
              }</span>
          </td>
          <td class="tags">
              ${enfermedadesBadges}
          </td>
          <td class="status"><span class="badge ${statusClass} text-uppercase">${statusText}</span></td>
          <td class="fecha_creacion">${formatearFecha(paciente.created_at)}</td>
          <td>
              <ul class="list-inline hstack gap-2 mb-0">
                 
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                      <a class="edit-item-btn" href="javascript:void(0);" onclick="cargarPaciente(${
                        paciente.Paciente_ID
                      })"> <lord-icon
                              src="https://cdn.lordicon.com/cbtlerlm.json"
                              trigger="loop"
                              delay="2000"
                              stroke="bold"
                              style="width:18px;height:18px">
                          </lord-icon></a>
                  </li>
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                      <a class="remove-item-btn" href="javascript:void(0);" onclick="eliminarPaciente(${
                        paciente.Paciente_ID
                      })">
                          <lord-icon
                            src="https://cdn.lordicon.com/nhqwlgwt.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            colors="primary:#121331,secondary:#ee6d66,tertiary:#646e78,quaternary:#ebe6ef"
                            style="width:18px;height:18px">
                          </lord-icon>
                      </a>
                  </li>
              </ul>
          </td>
      `;

    tbody.appendChild(tr);
  });
  setTimeout(inicializarPaginacion, 50);
}

// Función para formatear la fecha a un formato legible
function formatearFecha(fechaStr) {
  if (!fechaStr) return "";

  try {
    const fecha = new Date(fechaStr);
    const opciones = { day: "2-digit", month: "short", year: "numeric" };
    return fecha.toLocaleDateString("es-ES", opciones);
  } catch (error) {
    console.error("Error al formatear fecha:", error);
    return fechaStr; // Devolver la fecha original si hay un error
  }
}

// Función para inicializar la búsqueda
function inicializarBusqueda() {
  const searchInput = document.getElementById('searchInput');
  const noResultDiv = document.querySelector('.noresult');
  
  if (searchInput) {
    searchInput.addEventListener('input', function(e) {
      if (window.customerList) {
        window.customerList.search(e.target.value);
        verificarResultadosBusqueda();
      }
    });
  }
}

// Función para verificar si hay resultados de búsqueda
function verificarResultadosBusqueda() {
  const noResultDiv = document.querySelector('.noresult');
  const tbody = document.querySelector('#customerTable tbody');
  
  if (!window.customerList) return;
  
  // Verificar si hay elementos visibles
  const visibleItems = window.customerList.visibleItems.length;
  
  if (visibleItems === 0) {
    // Mostrar mensaje de no resultados
    if (noResultDiv) noResultDiv.style.display = 'block';
    if (tbody) tbody.style.display = 'none';
  } else {
    // Ocultar mensaje de no resultados
    if (noResultDiv) noResultDiv.style.display = 'none';
    if (tbody) tbody.style.display = '';
  }
}



// Función para inicializar la paginación
function inicializarPaginacion() {
  // Espera un breve momento para asegurar que el DOM está listo
  setTimeout(() => {
    if (typeof List !== "undefined") {
      const options = {
        valueNames: [
          "name",
          "company_name", 
          "leads_score",
          "phone",
          "location",
          "role",
          "tags",
          "status",
          "fecha_creacion",
        ],
        page: 10, // Número de elementos por página
        pagination: {
          innerWindow: 1,
          outerWindow: 1,
          left: 1,
          right: 1
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
            paginationPrev.addEventListener("click", function(e) {
              e.preventDefault();
              // Buscar el botón de página activo
              const activePage = document.querySelector(".listjs-pagination .active");
              if (activePage && activePage.previousElementSibling) {
                // Hacer clic en el botón de página anterior
                activePage.previousElementSibling.querySelector("a").click();
              }
              actualizarEstadoBotonesPaginacion();
            });
          }

          if (paginationNext) {
            paginationNext.addEventListener("click", function(e) {
              e.preventDefault();
              // Buscar el botón de página activo
              const activePage = document.querySelector(".listjs-pagination .active");
              if (activePage && activePage.nextElementSibling) {
                // Hacer clic en el botón de página siguiente
                activePage.nextElementSibling.querySelector("a").click();
              }
              actualizarEstadoBotonesPaginacion();
            });
          }

          // Añadir evento de actualización después de cada cambio de página
          window.customerList.on('updated', function() {
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
// Función para verificar y actualizar el estado de los botones de paginación
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