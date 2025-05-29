const BASE_URL = "https://nutrifitplanner.site";

// Función para inicializar el formulario
document.addEventListener("DOMContentLoaded", function () {
  CargarDesafios_(); // Cargar desafíos al inicio
  
  // Configuración para la subida de imagen
  document
    .getElementById("foto")
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
  const desafioForm = document.getElementById("NutriDesafios_form");
  
  if (desafioForm) {
    desafioForm.addEventListener("submit", handleFormSubmit);
  }
  
  // Inicializar modal de eliminar
  document.getElementById("delete-record").addEventListener("click", function() {
    const desafioId = this.getAttribute("data-id");
    if (desafioId) {
      confirmarEliminarDesafio(desafioId);
    }
    document.getElementById("deleteRecord-close").click(); // Cerrar modal
  });
  
  // Inicializar eventos para abrir nuevo formulario
  document.getElementById("showModal").addEventListener("hidden.bs.modal", limpiarFormulario);
  document.querySelector(".add-btn").addEventListener("click", prepararNuevoFormulario);
});

// Función para limpiar el formulario y restaurar valores predeterminados
function limpiarFormulario() {
  const form = document.getElementById("NutriDesafios_form");
  form.reset();
  document.getElementById("NutriDesafios_ID").value = "";
  document.getElementById("lead-img").src = "../../assets/images/users/user-dummy-img.jpg";
  
  // Restaurar estado activo por defecto - CORREGIDO: usar ticket-status
  document.getElementById("ticket-status").value = "1";
}

// Función para preparar el formulario para un nuevo desafío
function prepararNuevoFormulario() {
  limpiarFormulario();
  document.getElementById("lblTitulo").textContent = "Añadir Desafío";
  const addBtn = document.getElementById("add-btn");
  addBtn.textContent = "Añadir Desafío";
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

  // CORREGIDO: Asegurar que el status se envíe correctamente usando ticket-status
  const status = document.getElementById("ticket-status").value;
  formData.set("status", status); // Enviar como 'status' al backend

  // Asegurar que el ID se envíe correctamente para actualizaciones
  const desafioId = document.getElementById("NutriDesafios_ID").value;
  if (desafioId) {
    formData.set("id", desafioId);
  }

  // Usar la ruta guardar_editar para ambos casos (crear y actualizar)
  const url = `${BASE_URL}/api/nutridesafios/guardar_editar`;

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
      CargarDesafios_(); // Recargar la tabla de desafíos
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

// Función para cargar datos de un desafío existente
function cargarDesafio(id) {
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
  formData.append("NutriDesafios_ID", id);

  fetch(`${BASE_URL}/api/nutridesafios/mostrar`, {
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
        const desafio = data.data;

        // Limpiar formulario antes de cargar nuevos datos
        limpiarFormulario();

        document.getElementById("NutriDesafios_ID").value = desafio.NutriDesafios_ID;
        document.getElementById("nombre").value = desafio.nombre;
        document.getElementById("url").value = desafio.url;
        document.getElementById("tipo").value = desafio.tipo || "";
        
        // CORREGIDO: Usar ticket-status en lugar de status
        document.getElementById("ticket-status").value = desafio.status.toString();

        // Para la imagen - usar imagen predeterminada si no hay foto
        if (desafio.foto) {
          document.getElementById("lead-img").src = desafio.foto;
        } else {
          document.getElementById("lead-img").src = "../../assets/images/users/user-dummy-img.jpg";
        }

        // Cambiar título del modal
        document.getElementById("lblTitulo").textContent = "Editar Desafío";

        // Cambiar texto del botón
        const addBtn = document.getElementById("add-btn");
        addBtn.textContent = "Actualizar Desafío";
        addBtn.value = "update";

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById("showModal"));
        modal.show();
      } else {
        Swal.fire({
          title: "Error",
          text: data.message || "Error al cargar el desafío",
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
function eliminarDesafio(id) {
  // Asignar ID al botón de eliminación en el modal
  document.getElementById("delete-record").setAttribute("data-id", id);
  
  // Mostrar el modal de confirmación
  const modal = new bootstrap.Modal(document.getElementById("deleteRecordModal"));
  modal.show();
}

// Función para confirmar y ejecutar la eliminación del desafío
function confirmarEliminarDesafio(id) {
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
  formData.append("NutriDesafios_ID", id);

  fetch(`${BASE_URL}/api/nutridesafios/eliminar`, {
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
          text: data.message || "Desafío eliminado correctamente",
          icon: "success",
          confirmButtonText: "Aceptar"
        });
        
        CargarDesafios_(); // Actualizar la tabla
      } else {
        Swal.fire({
          title: "Error",
          text: data.message || "Error al eliminar el desafío",
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

// Función para cargar la lista de desafíos desde el API
async function CargarDesafios_() {
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
    const response = await fetch(`${BASE_URL}/api/nutridesafios/listar`, {
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
      console.error("Error al cargar desafíos:", data.message);
      Swal.fire({
        title: "Error",
        text: data.message || "Error al cargar la lista de desafíos",
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

// Función para renderizar la tabla con los datos de los desafíos
function renderizarTabla(desafios) {
  const tbody = document.querySelector("#customerTable tbody");
  const noResultDiv = document.querySelector('.noresult');
  tbody.innerHTML = "";

  if (!desafios || desafios.length === 0) {
    console.log("No hay desafíos para mostrar");
    // Mostrar mensaje en la tabla cuando no hay datos
    tbody.innerHTML = `
      <tr>
        <td colspan="8" class="text-center">No hay desafíos registrados</td>
      </tr>
    `;
    if (noResultDiv) noResultDiv.style.display = 'none';
    return;
  }

  desafios.forEach((desafio) => {
    // Usar imagen predeterminada si no hay foto
    const imagenSrc = desafio.foto && desafio.foto !== "null"
      ? desafio.foto
      : "../../assets/images/users/user-dummy-img.jpg";

    // Determinar el texto y color del badge de status
    let statusClass, statusText;
    switch(desafio.status) {
      case 0:
        statusClass = "bg-danger-subtle text-danger";
        statusText = "Inactivo";
        break;
      case 1:
        statusClass = "bg-success-subtle text-success";
        statusText = "Activo";
        break;
      case 2:
        statusClass = "bg-warning-subtle text-warning";
        statusText = "Próximamente";
        break;
      default:
        statusClass = "bg-secondary-subtle text-secondary";
        statusText = "Desconocido";
    }

    // Crear la fila - IMPORTANTE: usar NutriDesafios_ID en lugar de id
    const tr = document.createElement("tr");
    tr.innerHTML = `
          <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#${desafio.NutriDesafios_ID}</a></td>
          <td>
              <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                      <img src="${imagenSrc}" alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                  </div>
                  <div class="flex-grow-1 ms-2 name">${desafio.nombre}</div>
              </div>
          </td>
          <td class="company_name">${desafio.tipo}</td>
          <td class="leads_score"><a href="${desafio.url}" target="_blank">Ver enlace</a></td>
          <td class="status"><span class="badge ${statusClass} text-uppercase">${statusText}</span></td>
          <td class="fecha_creacion">${formatearFecha(desafio.fecha_creacion)}</td>
          <td>
              <ul class="list-inline hstack gap-2 mb-0">
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Editar">
                      <a class="edit-item-btn" href="javascript:void(0);" onclick="cargarDesafio(${desafio.NutriDesafios_ID})"> 
                        <lord-icon
                            src="https://cdn.lordicon.com/cbtlerlm.json"
                            trigger="loop"
                            delay="2000"
                            stroke="bold"
                            style="width:18px;height:18px">
                        </lord-icon>
                      </a>
                  </li>
                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Eliminar">
                      <a class="remove-item-btn" href="javascript:void(0);" onclick="eliminarDesafio(${desafio.NutriDesafios_ID})">
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
  }, 200);
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