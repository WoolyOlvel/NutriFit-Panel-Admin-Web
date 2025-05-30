// actualizarConsulta.js - Versión corregida
const BASE_URL = "http://127.0.0.1:8000";

document.addEventListener("DOMContentLoaded", function () {
  if (window.Dropzone) {
    Dropzone.autoDiscover = false;
  }
  // Estado global
  const state = {
    tiposConsulta: [],
    divisas: [],
    pagoSelect: [],
    ckeditorInstances: {},
    dropzone: null,
    datosConsultaCargados: false, // Flag para rastrear si ya se cargaron datos
    componentesInicializados: false // Flag para rastrear si los componentes ya se inicializaron
    
  };

  // Inicialización
  init();

  function init() {
    console.log("Iniciando aplicación...");
    
    // Verificar si hay un ID de consulta en la URL
    const consultaId = obtenerIdConsultaDeURL();
    console.log("¿Se ha encontrado ID de consulta?", consultaId ? `Sí: ${consultaId}` : "No");
    
    // Inicializar API primero para cargar datos básicos
    inicializarAPI();
    
    // Inicializar componentes generales
    inicializarCalendario();
    configurarEventListeners();
    inicializarCKEditors();
    cargarDatosConsulta(consultaId);
    inicializarDropzone();
    cargarArchivosAdjuntos(consulta.archivos);


    // Si hay ID de consulta, esperar a que todo esté listo antes de cargar datos
    if (consultaId) {
      console.log(`Detectado ID de consulta en URL: ${consultaId}, preparando carga de datos...`);
      
      // Inicializar componentes esenciales inmediatamente
      inicializarComponentes();
      inicializarFechaConsulta();
      inicializarDropzone();
      inicializarCKEditors();
      
      // Esperar a que los selects y componentes estén completamente cargados
      // antes de intentar cargar los datos de la consulta
      const checkComponentsReady = setInterval(function() {
        // Comprobar si los datos esenciales ya están cargados
        const selectsReady = document.getElementById("Tipo_Consulta_ID").options.length > 1 &&
                            document.getElementById("Divisa_ID").options.length > 1 &&
                            document.getElementById("Documento_ID").options.length > 1 &&
                            document.getElementById("Pago_ID").options.length > 1 &&
                            document.getElementById("Paciente_ID").options.length > 1;
        
        if (selectsReady) {
          console.log("Componentes inicializados correctamente, cargando datos de consulta...");
          clearInterval(checkComponentsReady);
          state.componentesInicializados = true;
          cargarDatosConsulta(consultaId);
        }
      }, 500); // Comprobar cada 500ms
      
      // Timeout de seguridad para evitar esperar indefinidamente
      setTimeout(() => {
        if (!state.datosConsultaCargados) {
          console.warn("Tiempo de espera agotado, intentando cargar datos de consulta de todos modos...");
          clearInterval(checkComponentsReady);
          cargarDatosConsulta(consultaId);
        }
      }, 5000); // Timeout después de 5 segundos
    } else {
      // Inicialización normal sin carga de datos
      console.log("Inicialización normal sin ID de consulta");
      inicializarComponentes();
      inicializarFechaConsulta();
      inicializarDropzone();
      inicializarCKEditors();
    }
  }

  // === FUNCIONES DE INICIALIZACIÓN ===

  function configurarEventListeners() {
    // Mantén tus event listeners existentes
    ["Tipo_Consulta_ID", "Divisa_ID"].forEach(id => {
      const elemento = document.getElementById(id);
      if (elemento) elemento.addEventListener("change", actualizarCosto);
    });
  
    // Configura eventos para datos adicionales
    configurarEventListenersDatosAdicionales();
    
    // Configurar el envío del formulario
    const formulario = document.getElementById("formConsulta");
    if (formulario) {
      formulario.addEventListener("submit", manejarEnvioFormulario);
    }
  
    // Limpiar formulario
    const btnLimpiar = document.getElementById("btnLimpiar");
    if (btnLimpiar) {
      btnLimpiar.addEventListener("click", limpiarFormulario);
    }
  }

  // Función para obtener el ID de consulta de la URL
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

  // Función mejorada para cargar los datos de una consulta existente
  function cargarDatosConsulta(consultaId) {
    console.log(`Iniciando carga de datos para consulta ID: ${consultaId}`);
    
    const token = getToken();
    if (!token) {
      console.error("Error: No hay token de autenticación disponible");
      return;
    }
  
    Swal.fire({
      title: "Cargando",
      text: "Cargando datos de la consulta...",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });
  
    // Hacer petición al servidor
    fetch(`${BASE_URL}/api/consulta/obtener/${consultaId}`, {
      method: "GET",
      headers: {
        "Accept": "application/json",
        "remember-token": token
      }
    })
    .then(response => {
      if (!response.ok) {
        return response.json().then(errData => {
          console.error("Error de API:", errData);
          throw new Error(errData.message || `Error HTTP: ${response.status}`);
        });
      }
      return response.json();
    })
    .then(data => {
      Swal.close();
      console.log("Datos recibidos del servidor:", data);
      
      if (data.status === 'success' && data.data) {
        // Transformar los nombres de los campos para que coincidan con los IDs de los selects
        const datosTransformados = transformarNombresCampos(data.data);
        state.datosConsultaCargados = true;
        llenarFormularioConDatosConsulta(datosTransformados);
      } else {
        throw new Error(data.message || "Error al cargar la consulta: respuesta sin datos");
      }
    })
    .catch(error => {
      Swal.close();
      console.error("Error en cargarDatosConsulta:", error);
      Swal.fire({
        title: "Error",
        text: "No se pudieron cargar los datos de la consulta: " + error.message,
        icon: "error",
        confirmButtonText: "Aceptar"
      });
    });
  }

  function transformarNombresCampos(datos) {
    return {
      ...datos,
      // Mapear los campos que pueden venir con nombres diferentes
      Paciente_ID: datos.Paciente_ID || datos.paciente_id,
      Tipo_Consulta_ID: datos.Tipo_Consulta_ID || datos.tipo_consulta_id,
      Documento_ID: datos.Documento_ID || datos.documento_id,
      Pago_ID: datos.Pago_ID || datos.pago_id,
      Divisa_ID: datos.Divisa_ID || datos.divisa_id,
      localidad: datos.localidad || datos.Localidad || null,
      ciudad: datos.ciudad || datos.Ciudad || null,
      edad: datos.edad || datos.Edad || null,
      fecha_nacimiento: datos.fecha_nacimiento || datos.Fecha_Nacimiento || null,
      // Mantener el resto de campos igual
      Consulta_ID: datos.Consulta_ID || datos.consulta_id,
      talla: datos.talla,
      peso: datos.peso,
      cintura: datos.cintura,
      cadera: datos.cadera,
      gc: datos.gc,
      em: datos.em,
      altura: datos.altura,
      proteina: datos.proteina,
      ec: datos.ec,
      me: datos.me,
      gv: datos.gv,
      pg: datos.pg,
      gs: datos.gs,
      meq: datos.meq,
      bmr: datos.bmr,
      ac: datos.ac,
      imc: datos.imc,
      proxima_consulta: datos.proxima_consulta,
      nombre_consultorio: datos.nombre_consultorio,
      direccion_consultorio: datos.direccion_consultorio,
      detalles_diagnostico: datos.detalles_diagnostico,
      resultados_evaluacion: datos.resultados_evaluacion,
      analisis_nutricional: datos.analisis_nutricional,
      objetivo_descripcion: datos.objetivo_descripcion,
      archivos: datos.archivos || []
    };
  }
  
  
  // Función mejorada para llenar el formulario con los datos de la consulta
  function llenarFormularioConDatosConsulta(consulta) {
    console.log("Llenando formulario con datos:", consulta);
    
    // Campo oculto para Consulta_ID
    const consultaIdInput = document.getElementById("Consulta_ID");
    if (consultaIdInput) {
      consultaIdInput.value = consulta.Consulta_ID;
      console.log(`Campo Consulta_ID establecido: ${consultaIdInput.value}`);
    }
    
    // Asegurar que los selects estén inicializados
    inicializarSelect2();
    
    // Llenar campos básicos (texto, número, etc.)
    const camposNumericos = ["peso", "cintura", "cadera", "gc", "em", "altura", "proteina", "ec", "me", "gv", "pg", "gs", "meq", "bmr", "ac", "imc"];
    camposNumericos.forEach(campo => {
      const input = document.getElementById(campo);
      if (input && consulta[campo] !== undefined && consulta[campo] !== null) {
        input.value = consulta[campo];
        console.log(`Campo ${campo} establecido: ${input.value}`);
      }
    });
    
    // Llenar selects con Select2
    setTimeout(() => {
      // Llenar selects básicos
      const selects = ["Paciente_ID", "Tipo_Consulta_ID", "Documento_ID", "Pago_ID", "Divisa_ID"];
      selects.forEach(id => {
        const select = document.getElementById(id);
        if (select && consulta[id] !== undefined && consulta[id] !== null) {
          try {
            // Para Select2
            if (typeof $.fn.select2 !== "undefined" && $(select).data('select2')) {
              console.log(`Configurando select ${id} con valor: ${consulta[id]}`);
              $(select).val(consulta[id]).trigger('change');
              
              // Verificar si el valor se estableció correctamente
              setTimeout(() => {
                const valorActual = $(select).val();
                console.log(`Select ${id}: valor actual después de establecer: ${valorActual}`);
                if (valorActual != consulta[id]) {
                  console.warn(`¡Error! El valor del select ${id} no coincide (${valorActual} vs ${consulta[id]})`);
                  
                  // Si falla, intentar establecer el valor directamente
                  select.value = consulta[id];
                  $(select).trigger('change');
                }
              }, 100);
            } else {
              // Para selects normales
              select.value = consulta[id];
              console.log(`Select estándar ${id} establecido: ${select.value}`);
            }
          } catch (e) {
            console.error(`Error al configurar select ${id}:`, e);
          }
        }
      });
      
      // Llenar talla
      const tallaInput = document.getElementById("talla");
      if (tallaInput && consulta.talla) {
        tallaInput.value = consulta.talla;
        console.log(`Campo talla establecido: ${tallaInput.value}`);
        actualizarUnidadTalla();
      }
      
      // Cargar datos del paciente
      setTimeout(() => {
        cargarDatosPaciente(consulta);
      }, 300);
      
      // Configurar fecha de próxima consulta
      if (consulta.proxima_consulta && typeof flatpickr !== "undefined") {
        setTimeout(() => {
          try {
            inicializarFechaConsulta();
            const fechaProximaConsulta = new Date(consulta.proxima_consulta);
            const flatpickrInstance = document.getElementById("proxima_consulta")._flatpickr;
            if (flatpickrInstance) {
              flatpickrInstance.setDate(fechaProximaConsulta);
              console.log(`Fecha próxima consulta establecida: ${fechaProximaConsulta.toLocaleString()}`);
            } else {
              console.warn("No se encontró instancia flatpickr para proxima_consulta");
              document.getElementById("proxima_consulta").value = formatFechaParaFlatpickr(fechaProximaConsulta);
            }
          } catch (e) {
            console.error("Error al configurar fecha próxima consulta:", e);
          }
        }, 500);
      }
      
      // Llenar datos adicionales en campos de texto
      const camposAdicionales = {
        "nombre_consultorio": consulta.nombre_consultorio,
        "direccion_consultorio": consulta.direccion_consultorio,
        'mm':consulta.mm,
      };
    
      Object.entries(camposAdicionales).forEach(([id, valor]) => {
        const elemento = document.getElementById(id);
        if (elemento && valor) {
          elemento.value = valor;
          console.log(`Campo adicional ${id} establecido: ${elemento.value}`);
        }
      });
    
      // Llenar los editores CKEditor
      setTimeout(() => {
        llenarCKEditors(consulta);
      }, 500);
    
      // Cargar archivos adjuntos si existen
      if (consulta.archivos && consulta.archivos.length > 0) {
        setTimeout(() => {
          inicializarDropzone();
          cargarArchivosAdjuntos(consulta.archivos);
        }, 800);
      }
    
      // Actualizar costo
      setTimeout(() => {
        actualizarCosto();
      }, 1000);
    }, 500); // Esperar 500ms para asegurar que los selects estén listos
  }

  function llenarCKEditors(consulta) {
    const editores = {
      "detalles_diagnostico": consulta.detalles_diagnostico,
      "resultados_evaluacion": consulta.resultados_evaluacion,
      "analisis_nutricional": consulta.analisis_nutricional,
      "objetivo_descripcion": consulta.objetivo_descripcion
    };
  
    Object.entries(editores).forEach(([id, contenido]) => {
      if (state.ckeditorInstances[id] && contenido) {
        try {
          state.ckeditorInstances[id].setData(contenido);
          console.log(`CKEditor ${id} contenido establecido`);
        } catch (e) {
          console.error(`Error al establecer contenido en CKEditor ${id}:`, e);
        }
      } else if (!state.ckeditorInstances[id]) {
        console.warn(`CKEditor ${id} no está inicializado`);
      }
    });
  }

  function formatFechaParaFlatpickr(fecha) {
    if (!fecha) return "";
    
    const meses = [
      "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    
    const dia = fecha.getDate();
    const mes = meses[fecha.getMonth()];
    const anio = fecha.getFullYear();
    const horas = fecha.getHours();
    const minutos = String(fecha.getMinutes()).padStart(2, "0");
    const ampm = horas >= 12 ? "PM" : "AM";
    const hora12 = horas % 12 || 12;
    
    return `${mes}, ${dia}, ${anio}, ${hora12}:${minutos} ${ampm}`;
  }
  
  // Función para cargar archivos adjuntos en Dropzone
  function cargarArchivosAdjuntos(archivos) {
    if (!state.dropzone || !archivos || archivos.length === 0) {
      console.warn("No se pueden cargar archivos: dropzone no inicializado o no hay archivos");
      return;
    }
  
    console.log(`Cargando ${archivos.length} archivos adjuntos en Dropzone:`, archivos);
  
    // Esperar a que Dropzone esté completamente inicializado
    setTimeout(() => {
      try {
        // Limpiar archivos existentes primero
        if (state.dropzone.files && state.dropzone.files.length > 0) {
          state.dropzone.removeAllFiles(true);
        }
  
        // Simular archivos para cada URL
        archivos.forEach(archivo => {
          if (!archivo.url || !archivo.nombre) {
            console.warn("Archivo sin URL o nombre:", archivo);
            return;
          }
  
          console.log(`Procesando archivo: ${archivo.nombre}, URL: ${archivo.url}`);
  
          // Crear un objeto de archivo simulado para Dropzone
          const mockFile = {
            name: archivo.nombre,
            size: archivo.size || 12345, // Usar tamaño si existe o un valor predeterminado
            type: obtenerTipoMIME(archivo.nombre),
            status: Dropzone.ADDED,
            accepted: true,
            url: archivo.url,
            serverFile: true // Marca para identificar que ya existe en el servidor
          };
  
          // Agregar el archivo simulado a Dropzone
          state.dropzone.emit("addedfile", mockFile);
          
          // Marcar como completo (ya subido)
          state.dropzone.emit("success", mockFile);
          state.dropzone.emit("complete", mockFile);
  
          // Si es una imagen, intentar mostrar miniatura
          if (mockFile.type.startsWith("image/")) {
            state.dropzone.emit("thumbnail", mockFile, archivo.url);
          }
  
          // Conectar el botón de eliminar
          if (mockFile.previewElement) {
            const deleteButton = mockFile.previewElement.querySelector('.btn-delete-file');
            if (deleteButton) {
              deleteButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log("Botón eliminar presionado para archivo del servidor:", mockFile.name);
                state.dropzone.removeFile(mockFile);
              });
            }
          }
        });
  
        // Actualizar la lista de archivos
        actualizarListaArchivos(state.dropzone);
        
      } catch (error) {
        console.error("Error al cargar archivos adjuntos:", error);
      }
    }, 1000); // Mayor tiempo de espera para asegurar que Dropzone esté listo
  }
  function actualizarListaArchivos(dropzone) {
    if (!dropzone) return;
    
    const archivosInput = document.getElementById("plan_nutricional");
    if (!archivosInput) return;
    
    const archivos = dropzone.getAcceptedFiles().filter(file => !file.isRemoved);
    
    // Si hay archivos, actualizar el input oculto con los nombres
    if (archivos.length > 0) {
      const nombresArchivos = archivos.map(file => file.name).join(',');
      archivosInput.value = nombresArchivos;
      console.log("Lista de archivos actualizada:", nombresArchivos);
    } else {
      archivosInput.value = "";
      console.log("Lista de archivos vacía");
    }
  }

  // Función auxiliar para determinar tipo MIME
  function obtenerTipoMIME(nombreArchivo) {
    if (!nombreArchivo) return 'application/octet-stream';
    
    const extension = nombreArchivo.split('.').pop().toLowerCase();
    switch (extension) {
      case 'pdf': return 'application/pdf';
      case 'doc': return 'application/msword';
      case 'docx': return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
      case 'jpg':
      case 'jpeg': return 'image/jpeg';
      case 'png': return 'image/png';
      default: return 'application/octet-stream';
    }
  }

  // Implementación completa de inicializarDropzone() con botón de eliminar funcional

  function inicializarDropzone() {
    if (typeof Dropzone === "undefined") {
      console.error("Error: Dropzone no está definido");
      return;
    }
  
    // Deshabilitar completamente el auto-descubrimiento
    Dropzone.autoDiscover = false;
    
    // Verificar si ya existe una instancia
    const dropzoneElement = document.querySelector(".dropzone");
    if (!dropzoneElement) {
      console.error("No se encontró el elemento .dropzone");
      return;
    }
    
    // Limpiar instancia previa si existe
    if (state.dropzone) {
      try {
        state.dropzone.destroy();
      } catch (e) {
        console.warn("Error al destruir Dropzone anterior:", e);
      }
    }
    
    // Limpiar elementos y crear una nueva instancia
    try {
      // Clonar el elemento para limpiar eventos
      const newDropzoneElement = dropzoneElement.cloneNode(true);
      dropzoneElement.parentNode.replaceChild(newDropzoneElement, dropzoneElement);
      
      // Limpiar la plantilla de vista previa
      const previewContainer = document.getElementById("dropzone-preview-list");
      if (previewContainer) {
        previewContainer.innerHTML = "";
      }
  
      // Configurar nueva instancia
      state.dropzone = new Dropzone(newDropzoneElement, {
        url: `${BASE_URL}/api/consulta/guardar`,
        paramName: "plan_nutricional_path",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 10,
        maxFiles: 10,
        maxFilesize: 10,
        acceptedFiles: ".pdf, .doc, .docx, .jpg, .jpeg, .png", // Agregamos soporte para imágenes
        addRemoveLinks: false,
        dictRemoveFile: "Eliminar",
        dictMaxFilesExceeded: "Máximo 10 archivos permitidos",
        dictDefaultMessage: "<i class='display-4 text-muted ri-upload-cloud-2-fill'></i><h4>Suelte los archivos aquí o haga clic para cargarlos.</h4>",
        previewsContainer: "#dropzone-preview",
        previewTemplate: `
        <div class="border rounded mt-2">
          <div class="d-flex p-2">
            <div class="flex-shrink-0 me-3">
              <div class="avatar-sm bg-light rounded">
                <img data-dz-thumbnail class="img-fluid rounded d-block" src="../../assets/images/new-document.png" alt="Dropzone-Image"/>
              </div>
            </div>
            <div class="flex-grow-1">
              <div class="pt-1">
                <h5 class="fs-14 mb-1" data-dz-name></h5>
                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
              </div>
            </div>
            <div class="flex-shrink-0 ms-3">
              <button type="button" class="btn-delete-file btn btn-sm btn-danger">Eliminar</button>
            </div>
          </div>
        </div>
        `,
        headers: {
          "remember-token": getToken()
        },
        init: function() {
          // Simplificar el tracking de archivos duplicados
          const procesados = new Set();
          const dropzoneInstance = this;
          
          // Corregir el comportamiento del botón de eliminar en cada archivo añadido
          this.on("addedfile", function(file) {
            console.log("Archivo añadido:", file.name, "tipo:", file.type);
            
            // Generar un ID único basado en nombre y tamaño
            const fileId = `${file.name}-${file.size}`;
            
            // Verificar si es un duplicado simple (solo para archivos nuevos, no para archivos del servidor)
            if (!file.serverFile && procesados.has(fileId)) {
              console.warn("Archivo duplicado detectado y removido:", file.name);
              this.removeFile(file);
              return;
            }
            
            // Registrar el archivo
            procesados.add(fileId);
            file.fileId = fileId; // Guardar el ID para referencia posterior
            
            // Conectar el botón de eliminar al evento removeFile manualmente
            const deleteButton = file.previewElement.querySelector('.btn-delete-file');
            if (deleteButton) {
              deleteButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log("Botón eliminar presionado para:", file.name);
                dropzoneInstance.removeFile(file);
              });
            }
            
            // Actualizar la lista de archivos en el input oculto
            actualizarListaArchivos(this);
          });
          
          this.on("removedfile", function(file) {
            console.log("Archivo eliminado:", file.name);
            
            // Marcar como eliminado explícitamente
            file.isRemoved = true;
            
            // Eliminar del registro
            if (file.fileId) {
              procesados.delete(file.fileId);
            }
            
            // Actualizar la lista de archivos en el input oculto
            actualizarListaArchivos(this);
          });
          
          this.on("error", function(file, errorMessage) {
            console.error("Error en Dropzone:", errorMessage);
            Swal.fire("Error", "Error al subir el archivo: " + errorMessage, "error");
          });
          
          // Agregar funcionalidad para limpiar todos los archivos
          const btnLimpiarArchivos = document.getElementById('btn-limpiar-archivos');
          if (btnLimpiarArchivos) {
            btnLimpiarArchivos.addEventListener('click', function() {
              // Eliminamos todos los archivos de Dropzone
              dropzoneInstance.removeAllFiles(true);
              // Limpiamos el conjunto de archivos procesados
              procesados.clear();
              console.log("Todos los archivos han sido eliminados");
              // Actualizar el input oculto
              document.getElementById("plan_nutricional").value = "";
            });
          }
        }
      });
  
      console.log("Dropzone inicializado correctamente");
      return state.dropzone;
      
    } catch (error) {
      console.error("Error al inicializar Dropzone:", error);
      return null;
    }
  }

  function prepararArchivosParaEnvio(formData) {
    // Verificar si hay archivos aceptados y filtrar duplicados
    if (!state.dropzone) {
      console.warn("Dropzone no está inicializado");
      return formData;
    }
    
    const archivos = state.dropzone.getAcceptedFiles();
    console.log(`Total de archivos aceptados: ${archivos.length}`);
    
    // Filtrar archivos que no están marcados como removidos
    const archivosValidos = archivos.filter(file => !file.isRemoved);
    console.log(`Total de archivos válidos: ${archivosValidos.length}`);
    
    // Separar archivos del servidor y archivos nuevos
    const archivosDelServidor = archivosValidos.filter(file => file.serverFile);
    const archivosNuevos = archivosValidos.filter(file => !file.serverFile);
    
    console.log(`Archivos del servidor: ${archivosDelServidor.length}`);
    console.log(`Archivos nuevos: ${archivosNuevos.length}`);
  
    // Eliminar cualquier campo relacionado con el plan nutricional que pueda tener fecha_modificacion
    formData.delete("plan_nutricional_path[fecha_modificacion]");
    
    // Agregar lista de archivos existentes que se mantienen
    if (archivosDelServidor.length > 0) {
      const archivosExistentes = archivosDelServidor.map(file => {
        // Extraer solo el nombre del archivo de la URL
        if (file.url) {
          return file.url.split('/').pop();
        }
        return file.name;
      }).join(",");
      
      formData.append("archivos_existentes", archivosExistentes);
      console.log("Archivos existentes a mantener:", archivosExistentes);
    } else {
      formData.append("archivos_existentes", "");
      console.log("No se mantienen archivos existentes");
    }
    
    // Agregar los archivos nuevos al FormData
    if (archivosNuevos.length > 0) {
      archivosNuevos.forEach((file, index) => {
        const paramName = `plan_nutricional_path_${index}`;
        console.log(`Agregando archivo nuevo ${index}: ${file.name} (${file.type}) como ${paramName}`);
        formData.append(paramName, file);
      });
    } else {
      // Asegurar que se envía al menos un valor vacío si no hay archivos nuevos
      formData.append("plan_nutricional_path", "");
    }
    
    // Agregar cantidad total de archivos nuevos
    formData.append("total_archivos_nuevos", archivosNuevos.length);
    
    return formData;
  }
  
// Función para manejar el envío del formulario (corregida)
  function manejarEnvioFormulario(event) {
    event.preventDefault();
    
    // Verificar que Dropzone esté inicializado
    if (!state.dropzone) {
      console.error("Dropzone no está inicializado");
      Swal.fire(
        "Error",
        "El sistema de subida de archivos no está listo",
        "error"
      );
      return;
    }
    
    // Validar que los campos requeridos estén completos
    if (!validarCamposRequeridos()) {
      return;
    }

    // Obtener datos de los CKEditor
    const datosCKEditor = prepararDatosCKEditor();

    // Preparar datos adicionales
    const datosAdicionales = prepararDatosAdicionales();


    // Obtener ID de consulta (si existe)
    const consultaIdInput = document.getElementById("Consulta_ID");
    const consultaId = consultaIdInput ? consultaIdInput.value : "";
    
    // Definir el endpoint y método
    let endpoint = consultaId ? 
      `${BASE_URL}/api/consulta/actualizar/${consultaId}` : 
      `${BASE_URL}/api/consulta/guardar`;
    
    // SIEMPRE usar POST, incluso para actualizar
    const metodo = "POST"; 
    
    // Obtener datos de la próxima consulta
    const proximaConsultaInput = document.getElementById("proxima_consulta");
    let proximaConsulta = null;
    if (proximaConsultaInput && proximaConsultaInput.value) {
      try {
        const fecha = parseFechaEspanol(proximaConsultaInput.value);
        proximaConsulta = formatearFechaMySQL(fecha);
      } catch (error) {
        console.error("Error al parsear la fecha:", error);
        proximaConsulta = null;
      }
    }

    // Crear FormData
    const formData = new FormData(document.getElementById("formConsulta"));

    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    if (fechaNacimientoInput) {
      // Obtener la fecha en formato YYYY-MM-DD del atributo data-fecha-bd
      const fechaBD = fechaNacimientoInput.getAttribute("data-fecha-bd");
      if (fechaBD) {
        // Reemplazar el valor del formulario con el formato para BD
        formData.delete("fecha_nacimiento"); // Eliminar el valor original del formulario
        formData.append("fecha_nacimiento", fechaBD); // Añadir el valor en formato BD
      } else if (fechaNacimientoInput.value && !fechaNacimientoInput.disabled) {
        // Si no hay data-fecha-bd pero hay un valor y el campo está habilitado, intentar convertir
        try {
          // Intentar parsear el valor del input (que debería estar en formato d, M, Y)
          const partes = fechaNacimientoInput.value.split(", ");
          if (partes.length === 3) {
            const dia = parseInt(partes[0]);
            const mes = partes[1];
            const anio = parseInt(partes[2]);
            
            const meses = {'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'May': 4, 'Jun': 5, 
                           'Jul': 6, 'Aug': 7, 'Sep': 8, 'Oct': 9, 'Nov': 10, 'Dec': 11};
            
            if (mes in meses) {
              const fecha = new Date(anio, meses[mes], dia);
              const fechaBD = formatearFechaMySQL(fecha);
              
              formData.delete("fecha_nacimiento");
              formData.append("fecha_nacimiento", fechaBD);
            }
          }
        } catch (error) {
          console.error("Error al parsear la fecha de nacimiento:", error);
        }
      }
    }

    // Si es una actualización, agregar un campo adicional para indicarlo
    if (consultaId) {
      formData.append("_method", "PUT"); // Para simular PUT en backends que solo aceptan POST
      
      // Asegurarse de que el ID de consulta se envía correctamente
      formData.append("Consulta_ID", consultaId);
      
      // IMPORTANTE: Eliminar el campo fecha_modificacion que está causando el error
      formData.delete("fecha_modificacion");
    }

    // Agregar datos de los CKEditor
    for (const [id, contenido] of Object.entries(datosCKEditor)) {
      formData.append(id, contenido);
    }
    
    // Agregar datos adicionales
    const camposAdicionales = {
      "nombre_consultorio": document.getElementById("nombre_consultorio")?.value || "",
      "direccion_consultorio": document.getElementById("direccion_consultorio")?.value || "",
      "mm":document.getElementById("mm")?.value || "",
      "localidad": document.getElementById("localidad")?.value || "",
      "ciudad": document.getElementById("ciudad")?.value || "",
      "edad": document.getElementById("edad")?.value || ""
    };
    
    for (const [key, value] of Object.entries(camposAdicionales)) {
      formData.append(key, value);
    }
    
    // Agregar próxima consulta
    if (proximaConsulta) {
      formData.append("proxima_consulta", proximaConsulta);
    }

    // Preparar y agregar archivos
    prepararArchivosParaEnvio(formData);

    // Imprimir datos que se van a enviar para depuración
    console.log("Datos a enviar:");
    for (const [key, value] of formData.entries()) {
      if (value instanceof File) {
        console.log(`${key}: ${value.name} (${value.type}, ${value.size} bytes)`);
      } else {
        console.log(`${key}: ${value}`);
      }
    }

    // Mostrar indicador de carga
    Swal.fire({
      title: "Guardando",
      text: "Guardando consulta...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    // Enviar la solicitud al servidor - SIEMPRE usando POST
    fetch(endpoint, {
      method: metodo,
      headers: {
        Accept: "application/json",
        "remember-token": getToken(),
        // No incluir Content-Type, FormData lo establece automáticamente con el boundary
      },
      body: formData,
    })
      .then((response) => {
        // Primero obtener el texto de la respuesta
        return response.text().then((text) => {
          console.log("Respuesta del servidor:", text);
          try {
            // Intentar parsear como JSON
            const data = JSON.parse(text);
            if (!response.ok) {
              throw new Error(data.message || `Error HTTP: ${response.status}`);
            }
            return data;
          } catch (e) {
            console.error("Error al parsear la respuesta:", e);
            throw new Error("Error al procesar la respuesta del servidor: " + text);
          }
        });
      })
      .then((data) => {
        console.log("Consulta guardada:", data);

        // Mostrar mensaje de éxito
        Swal.fire({
          title: "¡Éxito!",
          text: "Consulta guardada correctamente",
          icon: "success",
          confirmButtonText: "Aceptar",
        }).then((result) => {
          const paciente = document.getElementById("Paciente_ID")?.value;
          if (paciente) {
            window.location.href = `index.php?id=${paciente}`;
          } else {
            console.error("No se encontró el ID del paciente");
          }
        });
      })
      .catch((error) => {
        console.error("Error al guardar la consulta:", error);

        // Mostrar mensaje de error
        Swal.fire({
          title: "Error",
          text: "Error al guardar la consulta: " + error.message,
          icon: "error",
          confirmButtonText: "Aceptar",
        });
      });
  }

// Función mejorada para cargar los datos de una consulta existente
function cargarDatosConsulta(consultaId) {
  console.log(`Iniciando carga de datos para consulta ID: ${consultaId}`);
  
  const token = getToken();
  if (!token) {
    console.error("Error: No hay token de autenticación disponible");
    return;
  }

  Swal.fire({
    title: "Cargando",
    text: "Cargando datos de la consulta...",
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading(),
  });

  // Hacer petición al servidor
  fetch(`${BASE_URL}/api/consulta/obtener/${consultaId}`, {
    method: "GET",
    headers: {
      "Accept": "application/json",
      "remember-token": token
    }
  })
  .then(response => {
    if (!response.ok) {
      return response.json().then(errData => {
        console.error("Error de API:", errData);
        throw new Error(errData.message || `Error HTTP: ${response.status}`);
      });
    }
    return response.json();
  })
  .then(data => {
    Swal.close();
    console.log("Datos recibidos del servidor:", data);
    
    if (data.status === 'success' && data.data) {
      // Transformar los nombres de los campos para que coincidan con los IDs de los selects
      const datosTransformados = transformarNombresCampos(data.data);
      state.datosConsultaCargados = true;
      llenarFormularioConDatosConsulta(datosTransformados);
    } else {
      throw new Error(data.message || "Error al cargar la consulta: respuesta sin datos");
    }
  })
  .catch(error => {
    Swal.close();
    console.error("Error en cargarDatosConsulta:", error);
    Swal.fire({
      title: "Error",
      text: "No se pudieron cargar los datos de la consulta: " + error.message,
      icon: "error",
      confirmButtonText: "Aceptar"
    });
  });
}

  function inicializarCalendario() {
    const calendarEl = document.getElementById("calendar");
    if (calendarEl) {
      new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
        },
        initialView: "dayGridMonth",
      }).render();
    }
  }

  function inicializarFechaConsulta() {
    const proximaConsultaInput = document.getElementById("proxima_consulta");
    if (!proximaConsultaInput || typeof flatpickr === "undefined") return;

    flatpickr(proximaConsultaInput, {
      dateFormat: "F, j, Y, h:i K",
      enableTime: true,
      minDate: "today",
      minTime: "08:00",
      maxTime: "19:00",
      time_24hr: false,
      locale: {
        firstDayOfWeek: 1,
        weekdays: {
          shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
          longhand: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        },
        months: {
          shorthand: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
          longhand: [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
          ],
        },
      },
      disable: [date => date.getDay() === 0 || date.getDay() === 6],
      onChange: (selectedDates, dateStr) => dateStr
    });
  }

  function inicializarCKEditors() {
    if (typeof ClassicEditor === "undefined") {
      console.error("ClassicEditor no está definido");
      return;
    }

    const editorIDs = [
      "detalles_diagnostico",
      "resultados_evaluacion",
      "analisis_nutricional",
      "objetivo_descripcion"
    ];

    editorIDs.forEach(id => {
      const element = document.getElementById(id);
      if (element) {
        ClassicEditor.create(element)
          .then(editor => {
            state.ckeditorInstances[id] = editor;
          })
          .catch(error => console.error(`Error al inicializar el editor ${id}:`, error));
      }
    });
  }

  function inicializarComponentes() {
    // Fecha de nacimiento con Flatpickr
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    if (fechaNacimientoInput && typeof flatpickr !== "undefined") {
      flatpickr(fechaNacimientoInput, {
        dateFormat: "d, M, Y",
        allowInput: true, // Cambio para permitir entrada
        static: false,
        readOnly: false, // Cambio para permitir edición
        disableMobile: "true",
        locale: { firstDayOfWeek: 1 },
        onChange: function(selectedDates, dateStr) {
          // Asegurarse de que el valor esté en el formato correcto para la BD
          const formattedDate = dateStr; // Ya está en formato "d, M, Y"
          fechaNacimientoInput.setAttribute("data-fecha-bd", formattedDate);
        }
      });
    }

    // Choices.js para enfermedades
    const enfermedadInput = document.getElementById("taginput-choices");
    if (enfermedadInput && typeof Choices !== "undefined") {
      new Choices(enfermedadInput, {
        delimiter: ",",
        editItems: false,
        removeItemButton: false,
        maxItemCount: -1,
      });
    }

    // Select2 para selector de pacientes
    inicializarSelect2();
  }

  function inicializarSelect2() {
    // Selector de pacientes
    const pacienteSelect = document.getElementById("Paciente_ID");
    if (pacienteSelect && typeof $.fn.select2 !== "undefined") {
      $(pacienteSelect).select2({
        placeholder: "Seleccionar paciente",
        width: "100%",
      }).on("select2:select", cargarDatosPaciente);
    }

    // Otros selects con Select2
    $(".js-example-basic-single").each(function () {
      if (typeof $.fn.select2 !== "undefined" && this.id !== "Paciente_ID") {
        $(this).select2({ width: "100%" });

        if (["Tipo_Consulta_ID", "Divisa_ID"].includes(this.id)) {
          $(this).on("select2:select", actualizarCosto);
        }
      }
    });
  }

  function validarCamposRequeridos() {
    const camposRequeridos = [
      { id: "Paciente_ID", mensaje: "Debe seleccionar un paciente" },
      { id: "Tipo_Consulta_ID", mensaje: "Debe seleccionar un tipo de consulta" },
      { id: "Documento_ID", mensaje: "Debe seleccionar un documento" },
      { id: "Pago_ID", mensaje: "Debe seleccionar un tipo de pago" },
      { id: "Divisa_ID", mensaje: "Debe seleccionar una divisa" },

    ];
    
    for (const campo of camposRequeridos) {
      const elemento = document.getElementById(campo.id);
      if (!elemento || !esSeleccionValida(elemento.value)) {
        Swal.fire({
          title: "Campos incompletos",
          text: campo.mensaje,
          icon: "warning",
          confirmButtonText: "Aceptar"
        });
        return false;
      }
      //console.log(`Validando campo ${campo.id}: ${elemento.value}`);
    }
    
    // Verificar que haya al menos datos básicos de diagnóstico
    const detallesDiagnostico = obtenerContenidoCKEditor("detalles_diagnostico");
    if (!detallesDiagnostico || detallesDiagnostico.trim() === "") {
      Swal.fire({
        title: "Campos incompletos",
        text: "Debe ingresar los detalles del diagnóstico",
        icon: "warning",
        confirmButtonText: "Aceptar"
      });
      return false;
    }
    
    return true;
  }

  function configurarEventListenersDatosAdicionales() {
    // Actualizar unidad de talla
    const tallaInput = document.getElementById("talla");
    if (tallaInput) {
      tallaInput.addEventListener("input", actualizarUnidadTalla);
      tallaInput.addEventListener("blur", normalizarTalla);
    }

    // Validar entradas numéricas
    ["peso", "cintura", "cadera", "gc", "em", "altura", 'proteina', 'ec', 'me', 'gv', 'pg', 'gs', 'meq', 'bmr', 'ac', 'imc'].forEach(id => {
      const elemento = document.getElementById(id);
      if (elemento) elemento.addEventListener("input", validarEntradaNumerica);
    });
  }

  function inicializarAPI() {
    const token = getToken();
    if (!validarSesion(token)) return;

    cargarDatos([
      { endpoint: "consulta/tipos", handler: procesarTiposConsulta },
      { endpoint: "consulta/documentos", handler: procesarDocumentos },
      { endpoint: "consulta/tipos-pago", handler: procesarTiposPago },
      { endpoint: "consulta/divisas", handler: procesarDivisas },
      { endpoint: "consulta/pacientes", handler: procesarPacientes }
    ], token);
    
  }

  // === UTILIDADES ===

  function getToken() {
    return localStorage.getItem("remember_token") || getCookie("remember_token");
  }

  function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(";").shift();
    return null;
  }

  function validarSesion(token) {
    if (!token) {
      Swal.fire({
        title: "Error de sesión",
        text: "No hay sesión activa. Por favor inicie sesión nuevamente.",
        icon: "error",
        confirmButtonText: "Aceptar"
      }).then(() => {
        window.location.href = "../../index.php";
      });
      return false;
    }
    return true;
  }

  function formatearFechaMySQL(fecha) {
    const anio = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const dia = String(fecha.getDate()).padStart(2, "0");
    const hora = String(fecha.getHours()).padStart(2, "0");
    const minutos = String(fecha.getMinutes()).padStart(2, "0");
    const segundos = String(fecha.getSeconds()).padStart(2, "0");

    return `${anio}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;
  }

  function parseFechaEspanol(fechaTexto) {
    const meses = {
      enero: 0, febrero: 1, marzo: 2, abril: 3, mayo: 4, junio: 5,
      julio: 6, agosto: 7, septiembre: 8, octubre: 9, noviembre: 10, diciembre: 11
    };

    const partes = fechaTexto.split(",").map(p => p.trim());
    if (partes.length < 4) throw new Error("Formato de fecha inválido");

    const mes = meses[partes[0].toLowerCase()];
    const dia = parseInt(partes[1]);
    const anio = parseInt(partes[2]);

    const horaParte = partes[3].split(" ");
    const [hora, minutos] = horaParte[0].split(":").map(n => parseInt(n));
    const esPM = horaParte[1] === "PM";

    const fecha = new Date(anio, mes, dia);
    fecha.setHours(esPM && hora < 12 ? hora + 12 : hora);
    fecha.setMinutes(minutos);

    return fecha;
  }

  function esSeleccionValida(valor) {
    return valor && valor !== "Seleccionar" && valor !== "";
  }

  // === FUNCIONES PARA CARGA DE DATOS ===

  function cargarDatos(configuraciones, token) {
    configuraciones.forEach(config => {
      fetch(`${BASE_URL}/api/${config.endpoint}`, {
        method: "GET",
        headers: {
          Accept: "application/json",
          "remember-token": token
        }
      })
        .then(response => {
          if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
          return response.json();
        })
        .then(data => {
          // Para pacientes, el API devuelve un objeto con data en su interior
          if (config.endpoint === "consulta/pacientes" && data.data) {
            config.handler(data.data);
          } else {
            config.handler(data);
          }
        })
        .catch(error => console.error(`Error al cargar ${config.endpoint}:`, error));
    });
  }

  // === PROCESADORES DE DATOS ===

  function procesarTiposConsulta(data) {
    state.tiposConsulta = data;
    llenarSelect("Tipo_Consulta_ID", data, item => ({
      value: item.Tipo_Consulta_ID,
      text: `${item.Nombre} - $${item.Precio} MXN`
    }));
  }

  function procesarDocumentos(data) {
    llenarSelect("Documento_ID", data, item => ({
      value: item.Documento_ID,
      text: item.nombre
    }));
  }

  function procesarTiposPago(data) {
    llenarSelect("Pago_ID", data, item => ({
      value: item.Pago_ID,
      text: item.nombre
    }));
  }

  function procesarDivisas(data) {
    state.divisas = data.map(divisa => ({
      id: divisa.Divisa_ID,
      nombre: divisa.nombre,
      tasa_cambio: divisa.tasa_cambio
    }));

    llenarSelect("Divisa_ID", state.divisas, item => ({
      value: item.id,
      text: item.nombre
    }));
  }

  function procesarPacientes(data) {
    if (!Array.isArray(data)) {
      console.error("Error: Los datos de pacientes no son un array", data);
      return;
    }

    llenarSelect("Paciente_ID", data, item => ({
      value: item.Paciente_ID,
      text: `${item.nombre} ${item.apellidos}`
    }));

    // Reinicializar Select2 para pacientes
    const pacienteSelect = document.getElementById("Paciente_ID");
    if (pacienteSelect && typeof $.fn.select2 !== "undefined") {
      try {
        $(pacienteSelect).select2("destroy");
      } catch (e) {
        // Ignorar si no existe instancia previa
      }

      $(pacienteSelect).select2({
        placeholder: "Seleccionar paciente",
        width: "100%"
      }).off("select2:select").on("select2:select", cargarDatosPaciente);
    }
  }

  // === FUNCIONES PARA MANEJO DE INTERFAZ ===

  function llenarSelect(id, datos, transformador) {
    const select = document.getElementById(id);
    if (!select) return;

    // Guardar la opción por defecto
    const defaultOption = select.options[0];
    select.innerHTML = "";
    select.appendChild(defaultOption);

    // Agregar opciones
    if (Array.isArray(datos)) {
      datos.forEach(item => {
        const { value, text } = transformador(item);
        const option = document.createElement("option");
        option.value = value;
        option.textContent = text;
        select.appendChild(option);
      });
    } else {
      console.error(`Error: El parámetro datos para ${id} no es un array`, datos);
    }
  }

  function actualizarCosto() {
    const consultaSelect = document.getElementById("Tipo_Consulta_ID");
    const divisaSelect = document.getElementById("Divisa_ID");
    const contenedor = document.getElementById("contenedorCostos");

    if (!consultaSelect || !divisaSelect || !contenedor) return;

    // Obtener valores (considerando Select2)
    const consultaId = typeof $.fn.select2 !== "undefined" && $(consultaSelect).data("select2") 
      ? $(consultaSelect).val() 
      : consultaSelect.value;
      
    const divisaId = typeof $.fn.select2 !== "undefined" && $(divisaSelect).data("select2")
      ? $(divisaSelect).val()
      : divisaSelect.value;

    // Limpiar contenedor
    contenedor.innerHTML = "";

    // Validar selecciones
    if (!esSeleccionValida(consultaId) || !esSeleccionValida(divisaId)) return;

    // Buscar datos seleccionados
    const tipoConsulta = state.tiposConsulta.find(tipo => tipo.Tipo_Consulta_ID == consultaId);
    const divisa = state.divisas.find(div => div.id == divisaId);

    if (tipoConsulta && divisa) {
      mostrarCostoConsulta(contenedor, tipoConsulta, divisa);
    }
  }

  function mostrarCostoConsulta(contenedor, tipoConsulta, divisa) {
    const precioMXN = parseFloat(tipoConsulta.Precio);
    const precioConvertido = precioMXN / parseFloat(divisa.tasa_cambio);
    const esMXN = divisa.nombre === "MXN";

    contenedor.innerHTML = `
      <div class="col-xl-12">
        <div class="alert alert-danger">
          Costo De La Consulta (<b>${tipoConsulta.Nombre}</b>): 
          <b>${precioConvertido.toFixed(2)} ${divisa.nombre}</b>
          ${!esMXN ? `, Equivalente a <b>${precioMXN.toFixed(2)} MXN</b>` : ""}.
        </div>
      </div>
    `;
  }

  // === MANEJO DE DATOS DE PACIENTE ===

  function cargarDatosPaciente(consultaData) {
    // Si tenemos datos de la consulta, usarlos directamente
    if (consultaData && consultaData.Paciente_ID) {
      // Llenar campos con datos del paciente
      const campos = {
        "email": consultaData.email || "",
        "telefono": consultaData.telefono || "",
        "genero": consultaData.genero || "",
        "usuario": consultaData.usuario || "",
        "localidad": consultaData.localidad || "",
        "ciudad": consultaData.ciudad || "",
        "edad": consultaData.edad || "",
        "user_id": consultaData.nombre_nutriologo || ""
      };
  
      Object.entries(campos).forEach(([id, valor]) => {
        const elemento = document.getElementById(id);
        if (elemento) {
          elemento.value = valor;
          
          // Habilitar campos editables si son nulos
          if ((id === "localidad" || id === "ciudad" || id === "edad") && 
              (valor === "" || valor === null || valor === undefined)) {
            elemento.removeAttribute("readonly");
            elemento.classList.add("editable");
          }
        }
      });
  
      // Cargar enfermedades y fecha de nacimiento
      cargarTagsEnfermedad(consultaData.enfermedad || "");
      manejarFechaNacimiento(consultaData.fecha_nacimiento || "");
      return;
    }
    
    // Si no tenemos datos, hacer la petición al API
    const pacienteSelect = document.getElementById("Paciente_ID");
    const pacienteId = typeof $.fn.select2 !== "undefined" && $(pacienteSelect).data("select2")
      ? $(pacienteSelect).val()
      : pacienteSelect ? pacienteSelect.value : null;
  
    if (!pacienteId || pacienteId === "Seleccionar") {
      limpiarCamposPaciente();
      return;
    }
  
    const token = getToken();
    if (!token) {
      console.error("Error: No hay token de autenticación");
      return;
    }
  
    fetch(`${BASE_URL}/api/consulta/pacientes/${pacienteId}`, {
      method: "GET",
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        "remember-token": token
      }
    })
      .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
      })
      .then(data => {
        if (data && data.data) {
          const paciente = data.data;
          // Llenar campos con datos del paciente
          const campos = {
            "email": paciente.email || "",
            "telefono": paciente.telefono || "",
            "genero": paciente.genero || "",
            "usuario": paciente.usuario || "",
            "localidad": paciente.localidad || "",
            "ciudad": paciente.ciudad || "",
            "edad": paciente.edad || "",
            "user_id": paciente.nombre_nutriologo || ""
          };
  
          Object.entries(campos).forEach(([id, valor]) => {
            const elemento = document.getElementById(id);
            if (elemento) {
              elemento.value = valor;
              
              // Habilitar campos editables si son nulos
              if ((id === "localidad" || id === "ciudad" || id === "edad") && 
                  (valor === "" || valor === null || valor === undefined)) {
                elemento.removeAttribute("readonly");
                elemento.classList.add("editable");
              }
            }
          });
  
          // Cargar enfermedades y fecha de nacimiento
          cargarTagsEnfermedad(paciente.enfermedad || "");
          manejarFechaNacimiento(paciente.fecha_nacimiento || "");
        }
      })
      .catch(error => {
        console.error("Error al cargar los datos del paciente:", error);
        Swal.fire({
          title: "Error",
          text: "No se pudieron cargar los datos del paciente. Por favor intente nuevamente.",
          icon: "error",
          confirmButtonText: "Aceptar"
        });
        
        limpiarCamposPaciente();
      });
  }

  function manejarFechaNacimiento(fechaNacimiento) {
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    
    if (!fechaNacimientoInput) return;
    
    // Si la fecha es nula o vacía, habilitar el input para edición
    if (!fechaNacimiento || fechaNacimiento === "") {
      // Eliminar atributo disabled para permitir la edición
      fechaNacimientoInput.removeAttribute("disabled");
      fechaNacimientoInput.removeAttribute("readonly");
      
      // Reiniciar flatpickr si existe
      if (fechaNacimientoInput._flatpickr) {
        fechaNacimientoInput._flatpickr.destroy();
      }
      
      // Inicializar nuevo flatpickr editable
      if (typeof flatpickr !== "undefined") {
        flatpickr(fechaNacimientoInput, {
          dateFormat: "d, M, Y",
          allowInput: true,
          static: false,
          disableMobile: "true",
          locale: { firstDayOfWeek: 1 },
          onChange: function(selectedDates, dateStr) {
            // Guardar la fecha en formato "YYYY-MM-DD" para la BD
            if (selectedDates[0]) {
              const fechaBD = formatearFechaMySQL(selectedDates[0]);
              fechaNacimientoInput.setAttribute("data-fecha-bd", fechaBD);
            }
          }
        });
      }
      
      fechaNacimientoInput.classList.add("editable");
      fechaNacimientoInput.placeholder = "Seleccione fecha de nacimiento";
    } else {
      // Mantener los atributos disabled y readonly para fechas existentes
      fechaNacimientoInput.setAttribute("disabled", "disabled");
      fechaNacimientoInput.setAttribute("readonly", "readonly");
      
      // Formatear la fecha existente
      formatearFechaNacimiento(fechaNacimiento);
    }
  }
  

  function limpiarCamposPaciente() {
    const campos = [
      "apellidos",
      "email",
      "telefono",
      "genero",
      "usuario",
      "localidad",
      "ciudad",
      "edad",
      "fecha_nacimiento",
      "user_id",
    ];

    campos.forEach((id) => {
      const elemento = document.getElementById(id);
      if (elemento) elemento.value = "";
    });

    // Limpiar el campo de enfermedades (taginput-choices)
    const enfermedadInput = document.getElementById("taginput-choices");
    if (enfermedadInput) {
      // Destruir la instancia actual de Choices si existe
      if (enfermedadInput._choices) {
        enfermedadInput._choices.destroy();
      }
      limpiarCampoEnfermedades();

      // Crear una nueva instancia limpia
      new Choices(enfermedadInput, {
        delimiter: ",",
        editItems: false,
        removeItemButton: false,
        maxItemCount: -1,
      });

      // Limpiar el valor del input
      enfermedadInput.value = "";
    }
  }

  function limpiarCampoEnfermedades() {
      const enfermedadInput = document.getElementById("taginput-choices");
      if (!enfermedadInput) return;
      
      // Solución 1: Destruir y recrear Choices
      if (enfermedadInput._choices) {
          enfermedadInput._choices.destroy();
      }
      
      // Limpiar el valor directamente
      enfermedadInput.value = "";
      
      // Volver a inicializar Choices
      new Choices(enfermedadInput, {
          delimiter: ",",
          editItems: false,
          removeItemButton: false,
          maxItemCount: -1
      });
      
      // Solución alternativa: Forzar limpieza del DOM
      const choicesList = document.querySelector('.choices__list--multiple');
      if (choicesList) {
          choicesList.innerHTML = '';
      }
  }

  function cargarTagsEnfermedad(enfermedadesString) {
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
      newInput.setAttribute("readonly", "readonly");

      if (enfermedades.length > 0) {
        newInput.value = enfermedades.join(",");
      }

      choicesContainer.parentNode.replaceChild(newInput, choicesContainer);

      setTimeout(() => {
        if (window.Choices) {
          new Choices(newInput, { removeItemButton: false });
        }
      }, 10);
    } else {
      tagsInput.value = enfermedades.join(",");
      if (window.Choices) {
        new Choices(tagsInput, { removeItemButton: false });
      }
    }
  }

  function formatearFechaNacimiento(fechaStr) {
    const fechaNacimientoInput = document.getElementById("fecha_nacimiento");
    if (!fechaNacimientoInput || !fechaStr) {
      if (fechaNacimientoInput) fechaNacimientoInput.value = "";
      return;
    }

    try {
      const flatpickrInstance = fechaNacimientoInput._flatpickr;
      const partesFecha = fechaStr.split("-");
      
      if (partesFecha.length !== 3) {
        fechaNacimientoInput.value = fechaStr;
        return;
      }

      const fechaObj = new Date(
        parseInt(partesFecha[0]),
        parseInt(partesFecha[1]) - 1,
        parseInt(partesFecha[2])
      );

      if (isNaN(fechaObj.getTime())) {
        fechaNacimientoInput.value = fechaStr;
        return;
      }

      if (flatpickrInstance) {
        flatpickrInstance.setDate(fechaObj);
      } else {
        // Formatear manualmente
        const meses = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        fechaNacimientoInput.value = `${fechaObj.getDate()}, ${meses[fechaObj.getMonth()]}, ${fechaObj.getFullYear()}`;
      }
    } catch (e) {
      console.error("Error al formatear la fecha:", e);
      fechaNacimientoInput.value = fechaStr;
    }
  }

  // === FUNCIONES PARA MANEJO DE TALLA ===

  function actualizarUnidadTalla() {
    const tallaInput = document.getElementById("talla");
    const tallaSpan = document.getElementById("basic-addon2");

    if (!tallaInput || !tallaSpan) return;

    const valorTalla = tallaInput.value.trim();
    if (!valorTalla) {
      tallaSpan.textContent = "M"; // Valor por defecto
      return;
    }

    // Verificar si contiene referencias a tallas conocidas
    const tallaLower = valorTalla.toLowerCase();
    const terminosTalla = {
      chic: "CH", pequeñ: "CH", median: "M", medi: "M", grande: "G",
      "extra grande": "XG", extragrande: "XG", xl: "XG", xxl: "XXG",
      "extra chic": "XCH", xs: "XCH"
    };

    // Comprobar coincidencias
    let unidad = "M"; // Valor por defecto
    for (const [termino, abreviatura] of Object.entries(terminosTalla)) {
      if (tallaLower.includes(termino)) {
        unidad = abreviatura;
        break;
      }
    }

    // Comprobar si ya es una abreviatura
    const abreviaturas = ["CH", "M", "G", "XG", "XCH", "XXG"];
    const tallaUpper = valorTalla.toUpperCase();
    for (const abreviatura of abreviaturas) {
      if (tallaUpper === abreviatura) {
        unidad = abreviatura;
        break;
      }
    }

    tallaSpan.textContent = unidad;
  }

  function normalizarTalla() {
    const tallaInput = document.getElementById("talla");
    const tallaSpan = document.getElementById("basic-addon2");

    if (!tallaInput || !tallaSpan) return;

    const valorTalla = tallaInput.value.trim();
    const tallaLower = valorTalla.toLowerCase();
    const mappingTallas = {
      chico: "CH", chica: "CH", pequeño: "CH", pequeña: "CH",
      mediano: "M", mediana: "M", medio: "M", media: "M",
      grande: "G", "extra grande": "XG", extragrande: "XG", "extra-grande": "XG",
      xl: "XG", "extra chico": "XCH", extrachico: "XCH", "extra-chico": "XCH",
      xs: "XCH", xxl: "XXG"
    };

    // Verificar coincidencias exactas
    for (const [termino, abreviatura] of Object.entries(mappingTallas)) {
      if (tallaLower === termino) {
        tallaInput.value = abreviatura;
        tallaSpan.textContent = abreviatura;
        return;
      }
    }
    
    // Si no hay coincidencia exacta, actualizar la unidad
    actualizarUnidadTalla();
  }

  function validarEntradaNumerica(event) {
    const input = event.target;
    const valor = input.value;

    // Permitir solo números, punto decimal y retroceso
    if (!/^\d*\.?\d*$/.test(valor)) {
      input.value = valor.replace(/[^\d.]/g, "");
    }

    // Asegurar que solo hay un punto decimal
    const puntos = (input.value.match(/\./g) || []).length;
    if (puntos > 1) {
      input.value = valor.substring(0, valor.lastIndexOf("."));
    }
  }

  // === UTILIDADES PARA CKEDITOR ===

  function obtenerContenidoCKEditor(id) {
    return state.ckeditorInstances[id] ? state.ckeditorInstances[id].getData() : null;
  }

  function prepararDatosCKEditor() {
    const datos = {};
    for (const [id, instance] of Object.entries(state.ckeditorInstances)) {
      datos[id] = instance.getData();
    }
    return datos;
  }

  function prepararDatosAdicionales() {
    const campos = ["peso", "talla", "cintura", "cadera", "gc", "em", "altura", 'proteina', 'ec', 'me', 'gv', 'pg', 'gs', 'meq', 'bmr', 'ac', 'imc'];
    const datos = {};

    campos.forEach(campo => {
      const elemento = document.getElementById(campo);
      if (elemento) datos[campo] = elemento.value.trim();
    });

    return datos;
  }
});