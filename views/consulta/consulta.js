
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
    dropzone: null
  };

  // Inicialización
  init();

  function init() {
    inicializarAPI();
    inicializarCalendario();
    inicializarFechaConsulta();
    configurarEventListeners();
    inicializarDropzone(); // Añade esta línea
    setTimeout(inicializarComponentes, 500);
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
    inicializarCKEditors();
    
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

  // Implementación completa de inicializarDropzone() con botón de eliminar funcional

  function inicializarDropzone() {
    if (typeof Dropzone === "undefined") {
      console.error("Error: Dropzone no está definido");
      return;
    }

    // Deshabilitar completamente el auto-descubrimiento
    Dropzone.autoDiscover = false;
    
    // Eliminar cualquier instancia previa
    const dropzoneElement = document.querySelector(".dropzone");
    if (dropzoneElement.dropzone) {
      dropzoneElement.dropzone.destroy();
    }
    
    // Clonar el elemento para limpiar eventos
    const newDropzoneElement = dropzoneElement.cloneNode(true);
    dropzoneElement.parentNode.replaceChild(newDropzoneElement, dropzoneElement);

    // Configurar nueva instancia
    state.dropzone = new Dropzone(newDropzoneElement, {
      url: `${BASE_URL}/api/consulta/guardar`,
      paramName: "plan_nutricional_path",
      autoProcessQueue: false,
      uploadMultiple: true,
      parallelUploads: 10,      // Aumentado para manejar más archivos
      maxFiles: 10,             // Aumentado para más flexibilidad
      maxFilesize: 10,          // Tamaño máximo en MB
      acceptedFiles: ".pdf, .doc, .docx",
      addRemoveLinks: false,
      dictRemoveFile:"Eliminar",
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
            <button type="button" class="btn-delete-file btn btn-sm btn-danger" >Eliminar</button>
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
          //console.log("Archivo añadido:", file.name, "tipo:", file.type);
          
          // Generar un ID único basado en nombre y tamaño (simplificado)
          const fileId = `${file.name}-${file.size}`;
          
          // Verificar si es un duplicado simple
          if (procesados.has(fileId)) {
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
              //console.log("Botón eliminar presionado para:", file.name);
              dropzoneInstance.removeFile(file);
            });
          }
          
          // Actualizar la lista de archivos en el input oculto
          actualizarListaArchivos(this);
        });
        
        this.on("removedfile", function(file) {
          //console.log("Archivo eliminado:", file.name);
          
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
            for (let i = dropzoneInstance.files.length - 1; i >= 0; i--) {
              dropzoneInstance.removeFile(dropzoneInstance.files[i]);
            }
            // Limpiamos el conjunto de archivos procesados
            procesados.clear();
            //console.log("Todos los archivos han sido eliminados");
          });
        }
        
        // Función para actualizar la lista de archivos en el input oculto
        function actualizarListaArchivos(dropzone) {
          const archivosValidos = dropzone.files.filter(f => !f.isRemoved).map(f => f.name);
          document.getElementById("plan_nutricional").value = archivosValidos.join(",");
          //console.log("Lista de archivos actualizada:", archivosValidos);
        }
      }
    });

    // Limpiar la plantilla de vista previa
    document.getElementById("dropzone-preview-list").innerHTML = "";
    
    //console.log("Dropzone inicializado correctamente");
  }
  
  // Función para manejar el envío del formulario
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
  
    // Agregar datos de los CKEditor
    for (const [id, contenido] of Object.entries(datosCKEditor)) {
      formData.append(id, contenido);
    }
    const camposAdicionales = {
      "nombre_consultorio": document.getElementById("nombre_consultorio")?.value || "",
      "direccion_consultorio": document.getElementById("direccion_consultorio")?.value || "",
      'mm':document.getElementById("mm")?.value || ""
    };
    
    for (const [key, value] of Object.entries(camposAdicionales)) {
        formData.append(key, value);
    }
    // Agregar próxima consulta
    if (proximaConsulta) {
      formData.append("proxima_consulta", proximaConsulta);
    }
  
    // Verificar si hay archivos aceptados y filtrar duplicados
    const archivos = state.dropzone.getAcceptedFiles();
    //console.log(`Total de archivos aceptados: ${archivos.length}`);
    
    // Filtrar archivos que no están marcados como removidos
    const archivosValidos = archivos.filter(file => !file.isRemoved);
    //console.log(`Total de archivos válidos después del filtrado: ${archivosValidos.length}`);
    
    // Agregar contador de archivos PDF y Word para depuración
    const pdfCount = archivosValidos.filter(file => file.name.toLowerCase().endsWith('.pdf')).length;
    const docCount = archivosValidos.filter(file => 
      file.name.toLowerCase().endsWith('.doc') || file.name.toLowerCase().endsWith('.docx')
    ).length;
    //console.log(`Archivos PDF: ${pdfCount}, Archivos Word: ${docCount}`);
    
    // Agregar los archivos válidos al FormData
    archivosValidos.forEach((file, index) => {
      // Renombrar el parámetro para asegurar que cada archivo sea único
      const paramName = `plan_nutricional_path_${index}`;
      //console.log(`Agregando archivo ${index}: ${file.name} (${file.type}) como ${paramName}`);
      formData.append(paramName, file);
    });
    
    // Agregar cantidad total de archivos - IMPORTANTE
    formData.append("total_archivos", archivosValidos.length);
  
    // Imprimir datos que se van a enviar para depuración
    //console.log("Datos a enviar:");
    for (const [key, value] of formData.entries()) {
      if (value instanceof File) {
        //console.log(`${key}: ${value.name} (${value.type}, ${value.size} bytes)`);
      } else {
        //console.log(`${key}: ${value}`);
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
  
    // Enviar la solicitud al servidor
    fetch(`${BASE_URL}/api/consulta/guardar`, {
      method: "POST",
      headers: {
        Accept: "application/json",
        "remember-token": getToken(),
        // No incluir Content-Type para FormData
      },
      body: formData,
    })
      .then((response) => {
        // Primero obtener el texto de la respuesta
        return response.text().then((text) => {
          //console.log("Respuesta del servidor:", text);
          try {
            // Intentar parsear como JSON
            const data = JSON.parse(text);
            if (!response.ok) {
              throw new Error(data.message || "Error al guardar la consulta");
            }
            return data;
          } catch (e) {
            //console.error("Error al parsear la respuesta:", e);
            throw new Error("Error al procesar la respuesta del servidor");
          }
        });
      })
      .then((data) => {
        //console.log("Consulta guardada:", data);
  
        // Mostrar mensaje de éxito
        Swal.fire({
          title: "¡Éxito!",
          text: "Consulta guardada correctamente",
          icon: "success",
          confirmButtonText: "Aceptar",
        }).then((result) => {
          // Redirigir a la página de listado de consultas
          window.location.href = "./generarConsulta.php";
        });
      })
      .catch((error) => {
        //console.error("Error al guardar la consulta:", error);
  
        // Mostrar mensaje de error
        Swal.fire({
          title: "Error",
          text: "Error al guardar la consulta: " + error.message,
          icon: "error",
          confirmButtonText: "Aceptar",
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
        allowInput: false,
        static: false,
        readOnly: true,
        disableMobile: "true",
        locale: { firstDayOfWeek: 1 }
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
  
  // Función para limpiar el formulario
  function limpiarFormulario() {
    Swal.fire({
      title: "¿Está seguro?",
      text: "Se borrarán todos los datos la consulta",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, limpiar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        // Resetear el formulario
        document.getElementById("formConsulta").reset();

        // Limpiar los CKEditor
        for (const [id, instance] of Object.entries(state.ckeditorInstances)) {
          instance.setData("");
        }
        document.getElementById("nombre_consultorio").value = "";
        document.getElementById("direccion_consultorio").value = "";
        document.getElementById('mm').value="";

        // Limpiar dropzone (usando el botón btn-limpiar-archivos como mencionaste)
        const btnLimpiarArchivos = document.getElementById(
          "btn-limpiar-archivos"
        );
        if (btnLimpiarArchivos) {
          btnLimpiarArchivos.click(); // Simular click en el botón de limpiar archivos
        }

        // Limpiar campos de paciente
        limpiarCamposPaciente();
        limpiarCampoEnfermedades();

        // Reiniciar Select2 para que muestre "Seleccionar"
        if (typeof $.fn.select2 !== "undefined") {
          $(".js-example-basic-single").each(function () {
            $(this).val(null).trigger("change");
          });
        }

        // Limpiar campo de rutas de archivos
        const rutasArchivosInput = document.getElementById("plan_nutricional");
        if (rutasArchivosInput) {
          rutasArchivosInput.value = "";
        }

        // Mostrar mensaje de éxito
        Swal.fire({
          title: "Formulario limpiado",
          text: "Se han borrado todos los datos del formulario",
          icon: "success",
          timer: 2000,
          showConfirmButton: false,
        });
      }
    });
  }

  function configurarEventListenersDatosAdicionales() {
    // Actualizar unidad de talla
    const tallaInput = document.getElementById("talla");
    if (tallaInput) {
      tallaInput.addEventListener("input", actualizarUnidadTalla);
      tallaInput.addEventListener("blur", normalizarTalla);
    }

    // Validar entradas numéricas
    ["peso", "cintura", "cadera", "gc", "em", "altura", "proteina", "ec", "me", "gv", "pg", "gs", "meq", "bmr", "ac", "imc"].forEach(id => {
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
        window.location.href = "login.html";
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

  function cargarDatosPaciente() {
    // Obtener ID del paciente
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
        // Llenar campos con datos del paciente
        const campos = {
          "email": data.email || "",
          "telefono": data.telefono || "",
          "genero": data.genero || "",
          "usuario": data.usuario || "",
          "localidad": data.localidad || "",
          "ciudad": data.ciudad || "",
          "edad": data.edad || "",
          "user_id": data.nutriologo_nombre || ""
        };

        Object.entries(campos).forEach(([id, valor]) => {
          const elemento = document.getElementById(id);
          if (elemento) elemento.value = valor;
        });

        // Cargar enfermedades y fecha de nacimiento
        cargarTagsEnfermedad(data.enfermedad || "");
        formatearFechaNacimiento(data.fecha_nacimiento || "");
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