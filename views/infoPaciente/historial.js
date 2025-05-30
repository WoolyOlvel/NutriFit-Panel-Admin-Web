// Archivo: historialPaciente.js
const BASE_URL = "https://nutrifitplanner.site";

document.addEventListener('DOMContentLoaded', function() {
    // Obtener ID de consulta de la URL
    const consultaId = obtenerIdConsultaDeURL();
    
    if (!consultaId) {
        util.showError("No se pudo identificar la consulta");
        return;
    }
    
    // Cargar datos de la consulta
    cargarDatosConsulta(consultaId);
    
    
    // Agregar eventos a los botones de descarga
    document.addEventListener('click', function(e) {
        // Delegación de eventos para botones de descarga
        if (e.target.closest('#plan_nutricional_path')) {
            const button = e.target.closest('#plan_nutricional_path');
            const ruta = button.getAttribute('data-ruta');
            if (ruta) {
                descargarDocumento(ruta);
            } else {
                util.showError("Ruta del documento no especificada");
            }
        }
        
        // Para botones de descargar todos
        if (e.target.closest('.download-all-btn' || e.target.classList.contains('download-all-btn'))) {

            e.preventDefault();
            e.stopPropagation();
            const button = e.target.closest('.download-all-btn');
            const consultaId = button.getAttribute('data-consulta-id');
            if (consultaId) {
                descargarTodosDocumentos(consultaId);
            } else {
                util.showError("ID de consulta no especificado");
            }
        }
    });
});

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
        }).then(() => window.location.href = "../../index.php");
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
    },
    
    // Verificar si un elemento existe
    checkElement(id) {
        const element = document.getElementById(id);
        if (!element) {
            console.warn(`Elemento con ID '${id}' no encontrado`);
            return false;
        }
        return element;
    }
};

function obtenerIdConsultaDeURL() {
    const urlParams = new URLSearchParams(window.location.search);
    let consultaId = urlParams.get('consulta_id');
    
    // Si no está en el formato estándar, intentar obtenerlo de otras formas
    if (!consultaId) {
      consultaId = urlParams.get('id') || urlParams.get('consultaId');
      
      // Intentar extraer de una URL con formato /consulta/123
      if (!consultaId) {
        const pathMatch = window.location.pathname.match(/\/consulta\/(\d+)/);
        if (pathMatch) {
          consultaId = pathMatch[1];
        }
      }
    }
    
    return consultaId;
}

// Función para cargar los datos de la consulta
function cargarDatosConsulta(consultaId) {
    const token = util.checkAuth();
    if (!token) return;
    
    // Mostrar indicador de carga
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';
    document.body.appendChild(loadingOverlay);
    
    // Realizar petición al backend
    fetch(`${BASE_URL}/api/historial-paciente/consulta/${consultaId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'remember-token': token
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener los datos de la consulta');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            mostrarDatosConsulta(data.data);
        } else {
            throw new Error(data.message || 'Error al procesar los datos');
        }
    })
    .catch(error => {
        util.showError(error.message);
    })
    .finally(() => {
        // Ocultar indicador de carga
        if (document.body.contains(loadingOverlay)) {
            document.body.removeChild(loadingOverlay);
        }
    });
}

// Función para mostrar los datos en el frontend
function mostrarDatosConsulta(datos) {
    try {
        // Información del paciente
        mostrarDatosPaciente(datos.paciente, datos.consulta);
        
        // Información del diagnóstico
        mostrarDiagnostico(datos.diagnostico);
        
        // Información antropométrica
        mostrarDatosAntropometricos(datos.antropometria);
        
        // Información adicional
        mostrarInformacionAdicional(datos.consulta);
        
        // Información de patologías
        mostrarPatologias(datos.enfermedad);
        
        // Información del nutriólogo
        mostrarNutriologo(datos.consulta.nombre_nutriologo);
        
        // Información del plan alimenticio
        mostrarPlanAlimenticio(datos.documentos, datos.multiple_documentos, datos.consulta_id);
        
    } catch (error) {
        console.error("Error al mostrar los datos:", error);
        util.showError("Error al mostrar los datos de la consulta");
    }
}

// Mostrar datos del paciente
function mostrarDatosPaciente(paciente, consulta) {
    // Foto del paciente
    const fotoElement = document.getElementById('foto');
    if (fotoElement) {
        fotoElement.src = paciente.foto && paciente.foto.includes('http') 
            ? paciente.foto 
            : paciente.foto ? `../../assets/images/users/${paciente.foto}` : "../../assets/images/users/default-user.png";
    }
    
    // Nombre y edad
    const nombrePacienteElement = document.getElementById('nombre_paciente');
    if (nombrePacienteElement) {
        nombrePacienteElement.textContent = `${paciente.nombre || ''} ${paciente.apellidos || ''}, ${paciente.edad || ''}${paciente.edad ? ' años' : ''}`;
    }
    
    // Localidad y ciudad
    const localidadElement = document.getElementById('localidad');
    if (localidadElement) {
        localidadElement.innerHTML = `<i class="ri-building-line align-bottom me-1"></i> ${consulta.localidad || 'No especificada'}, ${consulta.ciudad || 'No especificada'}`;
    }
    
    // Fecha de creación
    const fechaCreacionElement = document.getElementById('fecha_creacion');
    if (fechaCreacionElement && consulta.fecha_creacion) {
        fechaCreacionElement.innerHTML = `Creado El: <span class="fw-medium">${formatearFecha(consulta.fecha_creacion)}</span>`;
    }
    
    // Última actualización
    const updatedAtElement = document.getElementById('updated_at');
    if (updatedAtElement && consulta.updated_at) {
        updatedAtElement.innerHTML = `Ultima Actualización: <span class="fw-medium">${consulta.updated_at}</span>`;
    }
    
    // Status del paciente
    const statusElement = document.querySelector('div[name="status"]');
    if (statusElement) {
        if (paciente.status === 1) {
            statusElement.className = 'badge rounded-pill bg-success fs-12';
            statusElement.textContent = 'Activo';
        } else {
            statusElement.className = 'badge rounded-pill bg-danger fs-12';
            statusElement.textContent = 'Inactivo';
        }
    }
    
    // Género
    const generoElement = document.getElementById('genero');
    if (generoElement && paciente.genero) {
        const esFemenino = paciente.genero === 'Femenino';
        generoElement.className = `badge rounded-pill ${esFemenino ? 'bg-secondary' : 'bg-primary'} fs-12`;
        generoElement.textContent = paciente.genero;
    }
    
    // Fecha de nacimiento - Corregido para manejar correctamente la zona horaria
    const fechaNacimientoElement = document.getElementById('fecha_nacimiento');
    if (fechaNacimientoElement && paciente.fecha_nacimiento) {
        // Crear la fecha con la fecha UTC exacta
        const fechaStr = paciente.fecha_nacimiento.split('T')[0]; // Solo tomar la parte de la fecha
        const [year, month, day] = fechaStr.split('-').map(Number);
        
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const fechaFormateada = `${day} De ${meses[month-1]} Del ${year}`;
        fechaNacimientoElement.textContent = `Fecha De Nacimiento: ${fechaFormateada}`;
    }
}

// Mostrar diagnóstico con CKEditor corregido
function mostrarDiagnostico(diagnostico) {
    if (!diagnostico) return;
    
    // Mostrar contenido como HTML simple en lugar de usar CKEditor
    mostrarContenidoHTML('detalles_diagnostico', diagnostico.detalles_diagnostico);
    mostrarContenidoHTML('resultados_evaluacion', diagnostico.resultados_evaluacion);
    mostrarContenidoHTML('analisis_nutricional', diagnostico.analisis_nutricional);
    mostrarContenidoHTML('objetivo_descripcion', diagnostico.objetivo_descripcion);
}

// Función para mostrar contenido como HTML sin usar CKEditor
function mostrarContenidoHTML(elementId, contenido) {
    const element = document.getElementById(elementId);
    if (!element) {
        console.warn(`Elemento con ID '${elementId}' no encontrado`);
        return;
    }
    
    // Mostrar el contenido como HTML
    element.innerHTML = contenido || '<em>No hay información disponible</em>';
    element.classList.add('ck-content'); // Agregar clase para estilos consistentes
}

// Inicializar CKEditor en modo solo lectura (si es necesario usarlo)
function inicializarCKEditorsReadOnly(elementId, contenido) {
    const element = document.getElementById(elementId);
    if (!element) {
        console.warn(`Elemento con ID '${elementId}' no encontrado`);
        return;
    }
    
    // Verificar si ClassicEditor está disponible
    if (typeof ClassicEditor === 'undefined') {
        // Si CKEditor no está disponible, mostrar el contenido como HTML simple
        element.innerHTML = contenido || '<em>No hay información disponible</em>';
        return;
    }
    
    // Inicializar CKEditor en modo solo lectura
    ClassicEditor
        .create(element, {
            toolbar: [], // Sin barra de herramientas
            isReadOnly: true // Configurar como solo lectura durante la creación
        })
        .then(editor => {
            // Establecer el contenido
            editor.setData(contenido || '<em>No hay información disponible</em>');
            
            // Opcional: guardar referencia al editor para uso posterior
            window.editors = window.editors || {};
            window.editors[elementId] = editor;
        })
        .catch(error => {
            console.error(`Error al inicializar CKEditor para '${elementId}':`, error);
            // En caso de error, mostrar el contenido como HTML simple
            element.innerHTML = contenido || '<em>No hay información disponible</em>';
        });
}

// Mostrar datos antropométricos
function mostrarDatosAntropometricos(antropometria) {
    if (!antropometria) return;
    
    // Peso
    const pesoElement = document.getElementById('peso');
    if (pesoElement) {
        pesoElement.textContent = antropometria.peso ? `${antropometria.peso} Kg` : 'No disponible';
    }
    
    // Talla
    const tallaElement = document.getElementById('talla');
    if (tallaElement) {
        tallaElement.textContent = antropometria.talla || 'No disponible';
    }
    
    // Cintura
    const cinturaElement = document.getElementById('cintura');
    if (cinturaElement) {
        cinturaElement.textContent = antropometria.cintura ? `${antropometria.cintura} Cm` : 'No disponible';
    }
    
    // Cadera
    const caderaElement = document.getElementById('cadera');
    if (caderaElement) {
        caderaElement.textContent = antropometria.cadera ? `${antropometria.cadera} Cm` : 'No disponible';
    }
    
    // Grasa corporal
    const gcElement = document.getElementById('gc');
    if (gcElement) {
        gcElement.textContent = antropometria.gc ? `${antropometria.gc} %` : 'No disponible';
    }
    
    // Masa muscular
    const mmElement = document.getElementById('mm');
    if (mmElement) {
        mmElement.textContent = antropometria.mm ? `${antropometria.mm} %` : 'No disponible';
    }
    
    // Edad metabólica
    const emElement = document.getElementById('em');
    if (emElement) {
        emElement.textContent = antropometria.em ? `${antropometria.em} años` : 'No disponible';
    }
    
    // Altura
    const alturaElement = document.getElementById('altura');
    if (alturaElement) {
        alturaElement.textContent = antropometria.altura ? `${antropometria.altura} m` : 'No disponible';
    }

    const proteinaElement = document.getElementById('proteina');
    if (proteinaElement) {
        proteinaElement.textContent = antropometria.proteina ? `${antropometria.proteina} %` : 'No disponible';
    }

    const ecElement = document.getElementById('ec');
    if (ecElement) {
        ecElement.textContent = antropometria.ec ? `${antropometria.ec} años` : 'No disponible';
    }

    const meElement = document.getElementById('me');
    if (meElement) {
        meElement.textContent = antropometria.me ? `${antropometria.me} Kg` : 'No disponible';
    }

    const gvElement = document.getElementById('gv');
    if (gvElement) {
        gvElement.textContent = antropometria.gv ? `${antropometria.gv} %` : 'No disponible';
    }
       
    const pgElement = document.getElementById('pg');
    if (pgElement) {
        pgElement.textContent = antropometria.pg ? `${antropometria.pg} Kg` : 'No disponible';
    }

    const gsElement = document.getElementById('gs');
    if (gsElement) {
        gsElement.textContent = antropometria.gs ? `${antropometria.gs} %` : 'No disponible';
    }

    const meqElement = document.getElementById('meq');
    if (meqElement) {
        meqElement.textContent = antropometria.meq ? `${antropometria.meq} %` : 'No disponible';
    }
        
    const bmrElement = document.getElementById('bmr');
    if (bmrElement) {
        bmrElement.textContent = antropometria.bmr ? `${antropometria.bmr} kcal` : 'No disponible';
    }

    const acElement = document.getElementById('ac');
    if (acElement) {
        acElement.textContent = antropometria.ac ? `${antropometria.ac} %` : 'No disponible';
    }

    const imcElement = document.getElementById('imc');
    if (imcElement) {
        imcElement.textContent = antropometria.imc ? `${antropometria.imc} %` : 'No disponible';
    }
}

// Mostrar información adicional
function mostrarInformacionAdicional(consulta) {
    if (!consulta) return;
    
    // Tipo de consulta
    const tipoConsultaElement = document.getElementById('Tipo_Consulta_ID');
    if (tipoConsultaElement) {
        tipoConsultaElement.textContent = consulta.tipo_consulta || 'No especificado';
    }
    
    // Tipo de pago
    const tipopagoElement = document.getElementById('Pago_ID');
    if (tipopagoElement) {
        tipopagoElement.textContent = consulta.tipo_pago || 'No especificado';
    }
    
    // Tipo de divisa
    const divisaElement = document.getElementById('Divisa_ID');
    if (divisaElement) {
        divisaElement.textContent = consulta.divisa || 'No especificada';
    }
    
    // Total pagado
    const totalPagoElement = document.getElementById('total_pago');
    if (totalPagoElement) {
        totalPagoElement.textContent = consulta.total_pago ? `$${consulta.total_pago}` : 'No especificado';
    }
    
    // Nombre del consultorio
    const nombreConsultorioElement = document.getElementById('nombre_consultorio');
    if (nombreConsultorioElement) {
        nombreConsultorioElement.textContent = consulta.nombre_consultorio || 'No especificado';
    }
    
    // Próxima consulta
    const proximaConsultaElement = document.getElementById('proxima_consulta');
    if (proximaConsultaElement) {
        proximaConsultaElement.textContent = consulta.proxima_consulta || 'No programada';
    }
    
    // Estado de la próxima consulta
    const estadoProximaConsultaElement = document.getElementById('estado_proximaConsulta');
    if (estadoProximaConsultaElement) {
        let className = 'badge bg-dark fs-11';
        let texto = 'Desconocido';
        
        const estado = parseInt(consulta.estado_proximaConsulta);
        
        switch (estado) {
            case 0:
                className = 'badge bg-danger fs-11';
                texto = 'Cancelado';
                break;
            case 1:
                className = 'badge bg-success fs-11';
                texto = 'En Progreso';
                break;
            case 2:
                className = 'badge bg-warning fs-11';
                texto = 'Próxima Consulta';
                break;
            case 3:
                className = 'badge bg-dark fs-11';
                texto = 'Realizado';
                break;
        }
        
        estadoProximaConsultaElement.className = className;
        estadoProximaConsultaElement.textContent = texto;
    }
}

// Mostrar patologías
function mostrarPatologias(enfermedades) {
    const enfermedadElement = document.getElementById('enfermedad');
    if (enfermedadElement) {
        // Limpiar contenido previo
        const parentElement = enfermedadElement.parentElement;
        if (parentElement) {
            parentElement.innerHTML = '';
            
            // Si no hay enfermedades, mostrar un mensaje
            if (!enfermedades || enfermedades.length === 0) {
                const noEnfermedadDiv = document.createElement('div');
                noEnfermedadDiv.className = 'badge fw-15 bg-success-subtle text-success';
                noEnfermedadDiv.textContent = 'Sin patologías registradas';
                parentElement.appendChild(noEnfermedadDiv);
                return;
            }
            
            // Crear elementos para cada enfermedad
            enfermedades.forEach(enfermedad => {
                if (enfermedad && enfermedad.trim && enfermedad.trim() !== '') {
                    const enfermedadDiv = document.createElement('div');
                    enfermedadDiv.className = 'badge fw-15 bg-danger-subtle text-danger mb-1';
                    enfermedadDiv.textContent = enfermedad.trim();
                    parentElement.appendChild(enfermedadDiv);
                }
            });
        }
    }
}

// Mostrar información del nutriólogo
function mostrarNutriologo(nombreNutriologo) {
    const nutriologoElement = document.getElementById('nombre_nutriologo');
    if (nutriologoElement) {
        nutriologoElement.textContent = nombreNutriologo || 'No asignado';
    }
}


// Mostrar información del plan alimenticio
function mostrarPlanAlimenticio(documentos, multipleDocumentos, consultaId) {
    const planContainer = document.querySelector('.card-body .vstack.gap-2');
    
    if (!planContainer) return;
    
    // Limpiar contenedor
    planContainer.innerHTML = '';
    
    // Si no hay documentos
    if (!documentos || documentos.length === 0) {
        const noDocsDiv = document.createElement('div');
        noDocsDiv.className = 'border rounded border-dashed p-2';
        noDocsDiv.innerHTML = `
            <div class="d-flex align-items-center justify-content-center p-3">
                <div class="text-center">
                    <i class="ri-file-forbid-line fs-24 text-muted"></i>
                    <p class="mt-2 mb-0">No hay documentos disponibles</p>
                </div>
            </div>
        `;
        planContainer.appendChild(noDocsDiv);
        return;
    }
    
    console.log('Documentos a mostrar:', documentos);
    
    // Mostrar documentos
    documentos.forEach(doc => {
        if (!doc || !doc.nombre) return;
        
        // Asegurarnos de que la ruta esté exactamente como viene del servidor
        const ruta = doc.ruta ? doc.ruta.trim() : '';
        
        const docDiv = document.createElement('div');
        docDiv.className = 'border rounded border-dashed p-2';
        docDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-light text-secondary rounded fs-24">
                            <i class="${getIconForFile(doc.nombre)}"></i>
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="fs-13 mb-1"><a href="#" class="text-body text-truncate d-block">${doc.nombre}</a></h5>
                    <div>${doc.tamano || 'Tamaño desconocido'}</div>
                </div>
                <div class="flex-shrink-0 ms-2">
                    <div class="d-flex gap-1">
                        <button type="button" class="btn btn-icon text-muted btn-sm fs-18 download-btn" 
                               data-ruta="${doc.ruta}">
                            <i class="ri-download-2-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        planContainer.appendChild(docDiv);
    });
    
    // Si hay múltiples documentos, agregar botón para descargar todos
    if (multipleDocumentos && documentos.length > 1) {
        const downloadAllDiv = document.createElement('div');
        downloadAllDiv.className = 'text-center mt-3';
        downloadAllDiv.innerHTML = `
            <button type="button" class="btn btn-sm btn-primary download-all-btn" data-consulta-id="${consultaId}">
                <i class="ri-download-cloud-2-line me-1"></i> Descargar todos los archivos
            </button>
        `;
        planContainer.appendChild(downloadAllDiv);
    }
    
    // Agregar event listeners para los botones de descarga
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const ruta = this.getAttribute('data-ruta', 'data-consulta-id');
            if (ruta) {
                descargarDocumento(ruta, consultaId);
            }
        });
    });
    
    document.querySelectorAll('.download-all-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const consultaId = this.getAttribute('data-consulta-id');
            if (consultaId) {
                descargarTodosDocumentos(consultaId);
            }
        });
    });
}
function descargarDocumento(ruta, consultaId) {
    const token = util.checkAuth();
    if (!token) return;

    // Verifica que la ruta sea una cadena válida
    if (!ruta || typeof ruta !== 'string' || ruta.trim() === '') {
        util.showError('Ruta de archivo inválida');
        return;
    }

    // Mostrar indicador de carga
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';
    document.body.appendChild(loadingOverlay);

    // Asegúrate de que la ruta no sea un array JSON
    let rutaFinal = ruta;
    if (ruta.startsWith('["') && ruta.endsWith('"]')) {
        try {
            const rutasArray = JSON.parse(ruta);
            rutaFinal = rutasArray[0]; // Tomamos el primer elemento si es un array
        } catch (e) {
            console.error('Error al parsear ruta:', e);
        }
    }

    // Codificar SOLO el valor, no toda la URL
    const rutaCodificada = encodeURIComponent(rutaFinal);
    const apiUrl = `${BASE_URL}/api/historial-paciente/${consultaId}/descargar-archivo?ruta=${rutaCodificada}`;

    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'remember-token': token
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { 
                throw new Error(err.message || 'Error al descargar'); 
            });
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = rutaFinal.split('/').pop() || 'documento_descargado';
        document.body.appendChild(a);
        a.click();
        setTimeout(() => {
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }, 100);
        util.showSuccess('Archivo descargado correctamente');
    })
    .catch(error => {
        console.error('Error al descargar:', error);
        util.showError(error.message || 'Error al descargar el archivo');
    })
    .finally(() => {
        if (document.body.contains(loadingOverlay)) {
            document.body.removeChild(loadingOverlay);
        }
    });
}

// Función para descargar todos los documentos - CORREGIDA
function descargarTodosDocumentos(consultaId) {
    const token = util.checkAuth();
    if (!token) return;
    
    // Verificar que el consultaId sea válido
    if (!consultaId) {
        util.showError('ID de consulta inválido');
        return;
    }

    // Verificar si ya hay una descarga en progreso
    if (window.downloadInProgress) {
        return; // Simplemente salimos sin mostrar mensaje
    }
    // Marcar que hay una descarga en progreso
    window.downloadInProgress = true;
    
    // Mostrar indicador de carga
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>';
    document.body.appendChild(loadingOverlay);
    
    // URL para descargar todos los documentos
    const apiUrl = `${BASE_URL}/api/historial-paciente/consulta/${consultaId}/descargar-documentos`;
    
    // Realizar solicitud directa
    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'remember-token': token
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error al descargar los archivos (${response.status})`);
        }
        return response.blob();
    })
    .then(blob => {
        // Crear un enlace temporal para la descarga
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `plan_alimenticio_${consultaId}.zip`;
        
        // Disparar el evento de click para iniciar la descarga
        document.body.appendChild(a);
        a.click();
        
        // Limpiar
        setTimeout(() => {
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            window.downloadInProgress = false; // Marcar que la descarga ha terminado
        }, 100);
        
        util.showSuccess('Archivos descargados correctamente');
    })
    .catch(error => {
        console.error('Error al descargar todos los archivos:', error);
        util.showError(error.message || 'Error al descargar los archivos');
    })
    .finally(() => {
        // Ocultar indicador de carga
        if (document.body.contains(loadingOverlay)) {
            document.body.removeChild(loadingOverlay);
        }
    });
}

// Función para obtener el icono según el tipo de archivo
function getIconForFile(filename) {
    if (!filename) return 'ri-file-line';
    
    const ext = filename.split('.').pop().toLowerCase();
    
    switch (ext) {
        case 'pdf':
            return 'ri-file-pdf-line';
        case 'doc':
        case 'docx':
            return 'ri-file-word-line';
        case 'xls':
        case 'xlsx':
            return 'ri-file-excel-line';
        case 'ppt':
        case 'pptx':
            return 'ri-file-ppt-line';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'ri-image-line';
        case 'zip':
        case 'rar':
            return 'ri-folder-zip-line';
        default:
            return 'ri-file-line';
    }
}

// Función para formatear fecha
function formatearFecha(fechaStr) {
    if (!fechaStr) return 'No disponible';
    
    try {
        const fecha = new Date(fechaStr);
        
        if (isNaN(fecha.getTime())) {
            return 'Fecha inválida';
        }
        
        return fecha.toLocaleDateString('es-ES', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (error) {
        console.error('Error al formatear fecha:', error);
        return 'Error en fecha';
    }
}