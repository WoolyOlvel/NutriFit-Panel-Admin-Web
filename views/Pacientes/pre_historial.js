const BASE_URL = "http://127.0.0.1:8000";

// Variables globales para gestionar estado
let todasLasConsultas = []; // Almacena todas las consultas sin filtrar
let consultasFiltradas = []; // Almacena las consultas después de aplicar filtros
let paginaActual = 1;
let consultasPorPagina = 10; // Número de consultas que se muestran por página
let nombrePaciente = ''; // Para mostrar en el contador de resultados

document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del paciente de la URL
    const urlParams = new URLSearchParams(window.location.search);
    let pacienteId = urlParams.get('paciente_id');
    
    // Si no está en el formato estándar, intentar obtenerlo de otras formas comunes
    if (!pacienteId) {
        // Algunos sistemas pueden usar 'id' o 'pacienteId'
        pacienteId = urlParams.get('id') || urlParams.get('pacienteId');
        
        // Intentar extraer de una URL con formato /paciente/123
        if (!pacienteId) {
            const pathMatch = window.location.pathname.match(/\/paciente\/(\d+)/);
            if (pathMatch) {
                pacienteId = pathMatch[1];
            }
        }
    }
    
    if (pacienteId) {
        //console.log('ID del paciente encontrado:', pacienteId);
        cargarConsultasPaciente(pacienteId);
        
        // Configurar los eventos para búsqueda y filtrado
        configurarEventosBusquedaYFiltrado();
    } else {
        //console.error('No se proporcionó ID de paciente en la URL');
        mostrarErrorSinID();
    }
});

/**
 * Muestra un mensaje de error cuando no se proporciona ID de paciente
 */
function mostrarErrorSinID() {
    document.getElementById('contenedor-consultas').innerHTML = `
        <div class="col-12 text-center">
            <div class="alert alert-danger">
                <i class="ri-error-warning-line me-2"></i>
                No se encontró el ID del paciente. Por favor, seleccione un paciente desde la lista.
            </div>
            <a href="../misPacientes/misPacientes.php" class="btn btn-primary">
                <i class="ri-arrow-left-line me-1"></i> Volver a la lista de pacientes
            </a>
        </div>
    `;
}

/**
 * Configura los eventos para la búsqueda y filtrado
 */
function configurarEventosBusquedaYFiltrado() {
    // Configurar el buscador
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            paginaActual = 1; // Resetear a la primera página al buscar
            aplicarFiltrosYBusqueda();
            mostrarConsultas({ consultas: consultasFiltradas });

        });
    }
    
    // Configurar el selector de filtros
    const filterSelect = document.getElementById('filtrador');
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            paginaActual = 1; // Resetear a la primera página al cambiar filtro
            aplicarFiltrosYBusqueda();
             // Forzar actualización inmediata
             mostrarConsultas({ consultas: consultasFiltradas });
        });
    }
    
    // Configurar paginación
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('page-link')) {
            e.preventDefault();
            
            const pagina = e.target.textContent;
            
            if (pagina === 'Anterior') {
                if (paginaActual > 1) paginaActual--;
            } else if (pagina === 'Siguiente') {
                const totalPaginas = Math.ceil(consultasFiltradas.length / consultasPorPagina);
                if (paginaActual < totalPaginas) paginaActual++;
            } else {
                paginaActual = parseInt(pagina);
            }
            
            mostrarConsultas({ consultas: consultasFiltradas });
        }
    });
}

/**
 * Obtiene el token de autenticación del localStorage o cookies
 */
function getToken() {
    return localStorage.getItem("remember_token") || getCookie("remember_token");
}

/**
 * Obtiene un valor de cookie por su nombre
 */
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
}

/**
 * Carga las consultas del paciente desde la API
 */
function cargarConsultasPaciente(pacienteId) {
    // Mostrar un indicador de carga
    document.getElementById('contenedor-consultas').innerHTML = `
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-2">Cargando datos del paciente...</p>
        </div>
    `;

    // Obtener el token usando la función existente
    const token = getToken();
    
    //console.log('Intentando cargar datos del paciente ID:', pacienteId);
    //console.log('URL de la API:', `${BASE_URL}/api/pacientes/${pacienteId}/consultas`);
    
    fetch(`${BASE_URL}/api/pacientes/${pacienteId}/consultas`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'remember-token': token || ''
        }
    })
    .then(response => {
        //console.log('Respuesta de la API:', response.status);
        if (!response.ok) {
            return response.json().then(errorData => {
                throw new Error(`Error ${response.status}: ${errorData.message || 'Error desconocido'}`);
            });
        }
        return response.json();
    })
    .then(data => {
        //console.log('Datos recibidos de la API:', data);
        if (data.status === 'error') {
            throw new Error(data.message || 'Error desconocido en la respuesta');
        }
        
        // Guardar todas las consultas en la variable global
        todasLasConsultas = data.consultas;
        consultasFiltradas = [...todasLasConsultas];
        
        // Guardar el nombre del paciente si está disponible
        if (data.consultas.length > 0) {
            nombrePaciente = `${data.consultas[0].nombre_paciente} ${data.consultas[0].apellidos_paciente}`;
        }
        
        // Si no hay error, mostrar las consultas
        mostrarConsultas(data);
    })
    .catch(error => {
        //console.error('Error completo:', error);
        mostrarErrorCarga(error, pacienteId);
    });
}

/**
 * Muestra un error detallado cuando falla la carga de datos
 */
function mostrarErrorCarga(error, pacienteId) {
    document.getElementById('contenedor-consultas').innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger">
                <h5><i class="ri-error-warning-line me-2"></i>Error al cargar los datos</h5>
                <p>${error.message || 'Error de conexión con el servidor'}</p>
                <hr>
                <p class="mb-0">Posibles soluciones:</p>
                <ul>
                    <li>Verifica que el servidor Laravel esté funcionando</li>
                    <li>Comprueba que la ruta de la API esté correctamente definida</li>
                    <li>Verifica que los modelos tengan las relaciones correctas</li>
                    <li>Revisa los logs de Laravel para más información</li>
                </ul>
            </div>
            <div class="text-center mt-3">
                <button onclick="cargarConsultasPaciente('${pacienteId}')" class="btn btn-primary">
                    <i class="ri-refresh-line me-1"></i> Reintentar
                </button>
                <a href="../misPacientes/misPacientes.php" class="btn btn-outline-secondary ms-2">
                    <i class="ri-arrow-left-line me-1"></i> Volver a la lista de pacientes
                </a>
            </div>
        </div>
    `;
}

/**
 * Aplica los filtros y la búsqueda a las consultas
 */
function aplicarFiltrosYBusqueda() {
  const textoBusqueda =
    document.getElementById("search")?.value.toLowerCase() || "";
  const filtroSeleccionado =
    document.getElementById("filtrador")?.value || "Recientes";

  // 1. Filtrar por texto de búsqueda
  consultasFiltradas = todasLasConsultas.filter(consulta => {
    if (textoBusqueda === '') return true;
    
    const campos = [
        `${consulta.nombre_paciente} ${consulta.apellidos_paciente}`.toLowerCase(),
        consulta.consultorio?.toLowerCase() || '',
        consulta.tipo_consulta?.toLowerCase() || '',
        formatearFecha(consulta.fecha_consulta).toLowerCase(),
        consulta.tiempo_actualizacion?.toLowerCase() || '',
        consulta.id.toString()
    ];
    
    return campos.some(campo => campo.includes(textoBusqueda));
});

  // 2. Aplicar ordenamiento
  switch (filtroSeleccionado) {
    case "Consultorio (A-Z)":
      consultasFiltradas.sort((a, b) =>
        (a.consultorio || "").localeCompare(b.consultorio || "")
      );
      break;

    case "Tipo Consulta(Z-A)":
      consultasFiltradas.sort((a, b) => {
        // Extraer solo la parte después de "Consulta " para comparar
        const tipoA = (a.tipo_consulta || "").replace(/^Consulta\s*/i, "");
        const tipoB = (b.tipo_consulta || "").replace(/^Consulta\s*/i, "");
        return tipoB.localeCompare(tipoA); // Orden Z-A
      });
      break;

    case "Fecha Creacion":
      consultasFiltradas.sort(
        (a, b) => new Date(b.fecha_consulta) - new Date(a.fecha_consulta)
      );
      break;

    case "Recientes":
      consultasFiltradas.sort((a, b) => {
        const tiempoA = convertirTiempoANumero(a.tiempo_actualizacion);
        const tiempoB = convertirTiempoANumero(b.tiempo_actualizacion);
        return tiempoA - tiempoB; // menor tiempo transcurrido = más reciente
      });
      break;

    case "All":
    default:
      // Mantener orden original
      break;
  }
}

function convertirTiempoANumero(tiempo) {
  if (!tiempo) return Infinity; // Si no hay tiempo, lo mandamos al final

  // Ejemplos válidos: "21 minutes ago", "2 hours ago", "1 day ago", "45 seconds ago"
  const match = tiempo.match(
    /(\d+)\s*(second|minute|hour|day|month|year)s?\sago/i
  );
  if (!match) return Infinity;

  const cantidad = parseInt(match[1]);
  const unidad = match[2].toLowerCase();

  // Convertir todo a segundos para mayor precisión
  switch (unidad) {
    case "second":
      return cantidad;
    case "minute":
      return cantidad * 60;
    case "hour":
      return cantidad * 60 * 60;
    case "day":
      return cantidad * 60 * 60 * 24;
    case "month":
      return cantidad * 60 * 60 * 24 * 30;
    case "year":
      return cantidad * 60 * 60 * 24 * 365;
    default:
      return Infinity;
  }
}
  
/**
 * Muestra las consultas en la interfaz de usuario con paginación
 */
function mostrarConsultas(data) {
    const contenedorConsultas = document.getElementById('contenedor-consultas');
    
    // Limpiar el contenedor
    contenedorConsultas.innerHTML = '';
    
    // Si no hay consultas, mostrar mensaje
    if (data.consultas.length === 0) {
        contenedorConsultas.innerHTML = '<div class="col-12"><p class="text-center">No hay consultas registradas para este paciente.</p></div>';
        actualizarContadorResultados(0, 0, 0);
        actualizarPaginacion(1, 1);
        return;
    }
    
    // Calcular consultas para la página actual
    const inicio = (paginaActual - 1) * consultasPorPagina;
    const fin = Math.min(inicio + consultasPorPagina, data.consultas.length);
    const consultasPagina = data.consultas.slice(inicio, fin);
    
    // Crear tarjetas para cada consulta
    consultasPagina.forEach(consulta => {
        const tarjetaHTML = crearTarjetaConsulta(consulta);
        contenedorConsultas.innerHTML += tarjetaHTML;
    });
    
    // Actualizar contador de resultados y paginación
    actualizarContadorResultados(inicio + 1, fin, data.consultas.length);
    actualizarPaginacion(paginaActual, Math.ceil(data.consultas.length / consultasPorPagina));
    
    // Inicializar los íconos Feather después de cargar el contenido
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
}

/**
 * Actualiza el contador de resultados mostrados
 */
function actualizarContadorResultados(inicio, fin, total) {
    const contadorElement = document.getElementById('mostrando');
    if (contadorElement) {
        let textoConsulta = total === 1 ? 'consulta' : 'consultas';
        let pacienteInfo = nombrePaciente ? ` de ${nombrePaciente}` : '';
        
        contadorElement.innerHTML = `Mostrando <span class="fw-semibold">${inicio}</span> al <span class="fw-semibold">${fin}</span> de <span class="fw-semibold text-decoration-underline">${total}</span> ${textoConsulta}${pacienteInfo}`;
    }
}

/**
 * Actualiza los controles de paginación
 */
function actualizarPaginacion(paginaActual, totalPaginas) {
    const paginacionElement = document.querySelector('.pagination');
    if (!paginacionElement) return;
    
    let paginacionHTML = '';
    
    // Botón Anterior
    if (paginaActual === 1) {
        paginacionHTML += `<li class="page-item disabled"><a href="#" class="page-link">Anterior</a></li>`;
    } else {
        paginacionHTML += `<li class="page-item"><a href="#" class="page-link">Anterior</a></li>`;
    }
    
    // Números de página
    for (let i = 1; i <= totalPaginas; i++) {
        if (i === paginaActual) {
            paginacionHTML += `<li class="page-item active"><a href="#" class="page-link">${i}</a></li>`;
        } else {
            paginacionHTML += `<li class="page-item"><a href="#" class="page-link">${i}</a></li>`;
        }
    }
    
    // Botón Siguiente
    if (paginaActual === totalPaginas) {
        paginacionHTML += `<li class="page-item disabled"><a href="#" class="page-link">Siguiente</a></li>`;
    } else {
        paginacionHTML += `<li class="page-item"><a href="#" class="page-link">Siguiente</a></li>`;
    }
    
    paginacionElement.innerHTML = paginacionHTML;
}

/**
 * Crea el HTML para una tarjeta de consulta
 */
function crearTarjetaConsulta(consulta) {
    // Usar directamente la URL completa que viene del backend
    // Si no hay foto o es null, usar la imagen por defecto
    let rutaImagen = '../../assets/images/users/user-dummy-img.jpg'; // Imagen por defecto
    
    if (consulta.foto_paciente && consulta.foto_paciente !== "null" && consulta.foto_paciente !== 'user-dummy-img.jpg') {
        // Usar directamente la URL completa que viene del backend
        rutaImagen = consulta.foto_paciente;
    }
    
    return `
    <div class="col-xxl-3 col-sm-6 project-card">
        <div class="card card-height-100">
            <div class="card-body">
                <div class="d-flex flex-column h-100">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted mb-4">Actualizado ${consulta.tiempo_actualizacion}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 align-items-center">
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted p-1 mt-n2 py-0 text-decoration-none fs-15" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i data-feather="more-horizontal" class="icon-sm"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="../infoPaciente/informacionConsulta.php?consulta_id=${consulta.id}">
                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i>Ver
                                        </a>
                                        <a class="dropdown-item" href="./actualizarConsulta.php?consulta_id=${consulta.id}">
                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Editar
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mb-2">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-md p-1">
                                <span class="avatar-roundend-md">
                                    <img class="img-thumbnail rounded-avatar-md" name="foto" id="foto" alt="200x200" src="${rutaImagen}" onerror="this.src='../../assets/images/users/user-dummy-img.jpg'">
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fs-14">
                                <a href="../infoPaciente/informacionConsulta.php?consulta_id=${consulta.id}" class="text-body">
                                    ${consulta.nombre_paciente} ${consulta.apellidos_paciente}
                                </a>
                            </h5>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="flex-grow-1">
                            <p class="text-muted text-truncate-two-lines mb-3">Consultorio: ${consulta.consultorio}</p>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="flex-grow-1">
                            <p class="text-muted text-truncate-two-lines mb-3">Tipo Consulta: ${consulta.tipo_consulta}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-dashed py-2">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1"></div>
                    <div class="flex-shrink-0">
                        <div class="text-muted">
                            <i class="ri-calendar-event-fill me-1 align-bottom"></i> ${formatearFecha(consulta.fecha_consulta)}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

/**
 * Formatea una fecha en formato legible
 */
function formatearFecha(fechaStr) {
    const fecha = new Date(fechaStr);
    return fecha.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

/**
 * Función para editar una consulta (implementar según necesidades)
 */
function editarConsulta(consultaId) {
    // Redireccionar a la página de edición o abrir un modal
    //console.log('Editar consulta:', consultaId);
    window.location.href = `../editarConsulta/editarConsulta.php?consulta_id=${consultaId}`;
}