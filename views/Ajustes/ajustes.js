// Definimos URL base
const BASE_URL = "http://nutrifitplanner.site";

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

  // Formatear fecha para input date (YYYY-MM-DD)
  formatDateForInput(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  },

  // Formatear fecha para visualización (d M, Y)
   formatDateForDisplay(dateString) {
        if (!dateString) return '';
        
        // Si ya está en formato legible, devolverlo directamente
        if (typeof dateString === 'string' && dateString.match(/\d{1,2} \w{3}, \d{4}/)) {
            return dateString;
        }
        
        // Parsear la fecha como UTC explícitamente
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '';
        
        // Ajustar a UTC para evitar problemas de zona horaria
        const utcDate = new Date(Date.UTC(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        ));
        
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        
        const day = utcDate.getUTCDate();
        const month = monthNames[utcDate.getUTCMonth()];
        const year = utcDate.getUTCFullYear();
        
        return `${day} ${month}, ${year}`;
    }
};




// Clase principal para manejar los ajustes
class AjustesManager {
  constructor() {
    this.token = util.checkAuth();
    if (!this.token) return;
    this.userData = null;
    this.fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    this.initForms();
    this.loadAjustes();
    this.initImageUploads();
    this.initFlatpickr();
    this.initProgressTracker();
  }

       initFlatpickr() {
            if (this.fechaNacimientoInput && typeof flatpickr !== 'undefined') {
                this.flatpickrInstance = flatpickr(this.fechaNacimientoInput, {
                    dateFormat: "d M, Y",
                    altInput: true,
                    altFormat: "F j, Y",
                    allowInput: true,
                    locale: "es",
                    defaultDate: this.fechaNacimientoInput.value || null,
                    time_24hr: false,
                    parseDate: (datestr, format) => {
                        // Parsear manualmente la fecha para evitar problemas de zona horaria
                        const parts = datestr.split(' ');
                        const day = parseInt(parts[0]);
                        const month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"].indexOf(parts[1]);
                        const year = parseInt(parts[2].replace(',', ''));
                        return new Date(Date.UTC(year, month, day));
                    },
                    onChange: (selectedDates, dateStr, instance) => {
                        if (selectedDates.length > 0) {
                            // Guardar la fecha en formato ISO (YYYY-MM-DD)
                            const isoDate = selectedDates[0].toISOString().split('T')[0];
                            instance.input.setAttribute('data-date-iso', isoDate);
                        }
                    }
                });
            }
        }

  // Inicializar los formularios
  initForms() {
    // Formulario de datos personales
    const datosPersonalesForm = document.getElementById('Ajustes_Form');
    if (datosPersonalesForm) {
      datosPersonalesForm.addEventListener('submit', (e) => {
        e.preventDefault();
        this.saveDatosPersonales();
      });
    }

    // Formulario de experiencia
    const experienciaForm = document.getElementById('Ajustes_Form_2');
    if (experienciaForm) {
      experienciaForm.addEventListener('submit', (e) => {
        e.preventDefault();
        this.saveExperiencia();
      });
    }
    
    // Formulario de cambio de contraseña
    const passwordForm = document.getElementById('Ajustes_Form3');
    if (passwordForm) {
        passwordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.changePassword();
        });
    }
  }

  async changePassword() {
      try {
          const newPassword = document.getElementById('password').value;
          const confirmPassword = document.getElementById('confirmPassword').value;
          
          // Validaciones del lado del cliente
          if (!newPassword || !confirmPassword) {
              throw new Error('Ambos campos son requeridos');
          }
          
          if (newPassword !== confirmPassword) {
              throw new Error('Las contraseñas no coinciden');
          }
          
          if (newPassword.length < 8) {
              throw new Error('La contraseña debe tener al menos 8 caracteres');
          }
          
          const response = await fetch(`${BASE_URL}/api/ajustes/cambiar-password`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'remember-token': this.token
              },
              body: JSON.stringify({
                  password: newPassword,
                  password_confirmation: confirmPassword
              })
          });

          const data = await response.json();

          if (!response.ok) {
              throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
          }

          if (!data.success) {
              throw new Error(data.message || 'Error desconocido al cambiar la contraseña');
          }

          // Mostrar mensaje de éxito y redirigir
          Swal.fire({
              title: '¡Éxito!',
              text: data.message || 'Contraseña cambiada correctamente',
              icon: 'success',
              confirmButtonText: 'Aceptar'
          }).then(() => {
              // Limpiar el token y redirigir
              localStorage.removeItem('remember_token');
              document.cookie = 'remember_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
              window.location.href = '../login/login.php';
          });
      } catch (error) {
          console.error('Error:', error);
          util.showError(`Error al cambiar contraseña: ${error.message}`);
      }
  }

  initProgressTracker() {
  
      const fieldsToTrack = [
          // Datos personales
          'nombre_nutriologo', 'apellido_nutriologo', 'telefono', 'edad',
          'genero', 'fecha_nacimiento', 'profesion', 'especialidad',
          'universidad', 'displomados', 'especializacion', 
          'descripcion_especialziacion', 'pacientes_tratados',
          'horario_antencion', 'descripcion_nutriologo', 'ciudad', 'estado',
          'modalidad', 'disponibilidad',
          
          // Experiencia
          'experiencia', 'enfermedades_tratadas',
          
          // Archivos (fotos)
          'profile-img-file-input', 'profile-foreground-img-file-input'
      ];

      // Monitorear cambios en todos los campos
      fieldsToTrack.forEach(fieldId => {
          const field = document.getElementById(fieldId);
          if (field) {
              field.addEventListener('input', () => this.updateProfileProgress());
              field.addEventListener('change', () => this.updateProfileProgress());
          }
      });

      // Para CKEditor (enfermedades_tratadas)
      if (window.enfermedadesEditor) {
          window.enfermedadesEditor.model.document.on('change:data', () => {
              this.updateProfileProgress();
          });
      }

      // Actualizar progreso inicial
      this.updateProfileProgress();
  }

  updateProgressBar(percentage) {
      const progressBar = document.getElementById('profileProgressBar');
      const progressText = document.getElementById('progressPercentage');
      
      if (progressBar && progressText) {
          // Cambiar color según el porcentaje
          let bgClass = 'bg-danger';
          if (percentage >= 70) bgClass = 'bg-success';
          else if (percentage >= 40) bgClass = 'bg-warning';
          
          // Actualizar la barra de progreso
          progressBar.style.width = `${percentage}%`;
          progressBar.setAttribute('aria-valuenow', percentage);
          progressBar.className = `progress-bar ${bgClass}`;
          progressText.textContent = `${percentage}%`;
      }
  }

  updateProfileProgress() {
      // Definir todos los campos con sus pesos (ajusta según importancia)
      const allFields = {
          // Información básica (más importante)
          'nombre_nutriologo': 5,
          'apellido_nutriologo': 5,
          'telefono': 4,
          'edad': 3,
          'genero': 3,
          'fecha_nacimiento': 4,
          
          // Información profesional
          'profesion': 4,
          'especialidad': 4,
          'universidad': 3,
          'displomados': 2,
          'especializacion': 3,
          'descripcion_especialziacion': 2,
          'pacientes_tratados': 2,
          'horario_antencion': 3,
          'descripcion_nutriologo': 3,
          'ciudad': 2,
          'estado': 2,
          'modalidad': 3,
          'disponibilidad': 3,
          
          // Experiencia
          'experiencia': 5,
          'enfermedades_tratadas': 5,
          
          // Imágenes
          'profile-img-file-input': 8,    // Foto perfil
          'profile-foreground-img-file-input': 7  // Foto portada
      };

      let totalWeight = 0;
      let completedWeight = 0;

      // Calcular progreso para cada campo
      Object.entries(allFields).forEach(([fieldId, weight]) => {
          totalWeight += weight;
          
          const field = document.getElementById(fieldId);
          let isCompleted = false;
          
          if (field) {
              // Campos de archivo (imágenes)
              if (field.type === 'file') {
                  if (field.files && field.files.length > 0) {
                      isCompleted = true;
                  } else {
                      // Verificar si ya tiene imagen (previa)
                      const imgId = fieldId === 'profile-img-file-input' ? 'foto' : 'foto_portada';
                      const imgPreview = document.getElementById(imgId);
                      if (imgPreview && imgPreview.src && !imgPreview.src.includes('placeholder')) {
                          isCompleted = true;
                      }
                  }
              } 
              // Campo de CKEditor (enfermedades_tratadas)
              else if (fieldId === 'enfermedades_tratadas' && window.enfermedadesEditor) {
                  isCompleted = window.enfermedadesEditor.getData().trim() !== '';
              }
              // Todos los demás campos
              else if (field.value && field.value.trim() !== '') {
                  isCompleted = true;
              }
          }
          
          if (isCompleted) {
              completedWeight += weight;
          }
      });

      // Calcular porcentaje (asegurando que esté entre 0 y 100)
      const percentage = totalWeight > 0 ? 
          Math.min(Math.round((completedWeight / totalWeight) * 100), 100) : 0;

      this.updateProgressBar(percentage);
  }

  

  // Inicializar la subida de imágenes
  initImageUploads() {
      // Foto de perfil
    const profileImgInput = document.getElementById('profile-img-file-input');
    if (profileImgInput) {
      profileImgInput.addEventListener('change', (e) => {
        if (e.target.files && e.target.files.length > 0) {
          this.uploadImage(e.target.files[0], 'foto-perfil');
        }
      });
    }

    // Foto de portada
    const coverImgInput = document.getElementById('profile-foreground-img-file-input');
    if (coverImgInput) {
      coverImgInput.addEventListener('change', (e) => {
        if (e.target.files && e.target.files.length > 0) {
          this.uploadImage(e.target.files[0], 'foto-portada');
        }
      });
    }
  
  }

  
  // Cargar los ajustes desde el servidor
  async loadAjustes() {
    try {
      const response = await fetch(`${BASE_URL}/api/ajustes`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'remember-token': this.token
        }
      });

      if (!response.ok) {
        throw new Error(`Error al cargar los ajustes: ${response.status} ${response.statusText}`);
      }

      const data = await response.json();
      this.userData = data.user || {};

      if (data.success) {
        this.populateForm(data.data || {}, data.user || {});
        
      } else {
        throw new Error(data.message || 'Error desconocido al cargar los ajustes');
      }
    } catch (error) {
      console.error('Error:', error);
      
      // Si es un error 404, probablemente las rutas no están bien configuradas
      if (error.message && error.message.includes('404')) {
        util.showError('No se pudieron cargar los ajustes. Verifique que las rutas API estén correctamente configuradas.');
      } else {
        util.showError(`No se pudieron cargar los ajustes: ${error.message}`);
      }
    }
  }

  // Rellenar el formulario con los datos
  populateForm(ajustes, userData) {
    // Usar datos del usuario para información básica si no hay ajustes
    this.fillInputIfExists('nombre_nutriologo', ajustes.nombre_nutriologo || userData.nombre || '');
    this.fillInputIfExists('apellido_nutriologo', ajustes.apellido_nutriologo || userData.apellidos  || '');
    this.fillInputIfExists('email', userData.email || '');
    
    // Resto de datos personales
    this.fillInputIfExists('telefono', ajustes.telefono || '');
    this.fillInputIfExists('edad', ajustes.edad || '');
    
    // Select de género
    const generoSelect = document.getElementById('genero');
    if (generoSelect && ajustes.genero) {
      generoSelect.value = ajustes.genero;
    }
    
    // Fecha de nacimiento
    // Fecha de nacimiento - Modifica esta parte
    if (ajustes.fecha_nacimiento) {
        const fechaInput = document.getElementById('fecha_nacimiento');
        if (fechaInput) {
            // Convertir la fecha ISO a objeto Date
            const dateObj = new Date(ajustes.fecha_nacimiento);
        
            if (!isNaN(dateObj.getTime())) {
                // Formatear para flatpickr (d M, Y)
                const formattedDate = util.formatDateForDisplay(ajustes.fecha_nacimiento);
                fechaInput.value = formattedDate;
                
                // Si flatpickr está inicializado, actualizar su instancia
                if (fechaInput._flatpickr) {
                fechaInput._flatpickr.setDate(dateObj, true);
                fechaInput.setAttribute('data-date-iso', ajustes.fecha_nacimiento);
                }
            }
        }
    }
    
    // Otros campos de información profesional
    this.fillInputIfExists('profesion', ajustes.profesion || '');
    this.fillInputIfExists('especialidad', ajustes.especialidad || '');
    this.fillInputIfExists('universidad', ajustes.universidad || '');
    this.fillInputIfExists('displomados', ajustes.displomados || '');
    this.fillInputIfExists('especializacion', ajustes.especializacion || '');
    this.fillInputIfExists('descripcion_especialziacion', ajustes.descripcion_especialziacion || '');
    this.fillInputIfExists('pacientes_tratados', ajustes.pacientes_tratados || '');
    this.fillInputIfExists('horario_antencion', ajustes.horario_antencion || '');
    this.fillInputIfExists('descripcion_nutriologo', ajustes.descripcion_nutriologo || '');
    this.fillInputIfExists('ciudad', ajustes.ciudad || '');
    this.fillInputIfExists('estado', ajustes.estado || '');
    
    // Selects
    const modalidadSelect = document.getElementById('modalidad');
    if (modalidadSelect && ajustes.modalidad) {
      modalidadSelect.value = ajustes.modalidad;
    }
    
    const disponibilidadSelect = document.getElementById('disponibilidad');
    if (disponibilidadSelect && ajustes.disponibilidad) {
      disponibilidadSelect.value = ajustes.disponibilidad;
    }

    // Experiencia
    this.fillInputIfExists('experiencia', ajustes.experiencia || '');
    
   if (ajustes.enfermedades_tratadas) {
        // Si ya tenemos el editor inicializado
        if (window.enfermedadesEditor) {
            window.enfermedadesEditor.setData(ajustes.enfermedades_tratadas);
        } 
        // Si usamos CKEDITOR tradicional
        else if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.enfermedades_tratadas) {
            CKEDITOR.instances.enfermedades_tratadas.setData(ajustes.enfermedades_tratadas);
        }
        // Fallback a textarea
        else {
            const textarea = document.getElementById('enfermedades_tratadas');
            if (textarea) {
                textarea.value = ajustes.enfermedades_tratadas;
            }
        }
    }

    // Fotos
    this.updateImageIfExists('foto', ajustes.foto);
    this.updateImageIfExists('foto_portada', ajustes.foto_portada);

    // Actualizar nombre en el perfil
    this.updateProfileName(ajustes, userData);
    this.updateProfileProgress();
  }
  
  // Método auxiliar para actualizar un input si existe
  fillInputIfExists(id, value) {
    const element = document.getElementById(id);
    if (element) {
      element.value = value;
    }
  }
  
  // Método auxiliar para actualizar una imagen si existe
  updateImageIfExists(id, src) {
    const element = document.getElementById(id);
    if (element && src) {
      element.src = src;
    }
  }
  
  // Actualizar nombre en el perfil
  updateProfileName(ajustes, userData) {
    // Intentar primero con el ID específico para la visualización
    let nameElement = document.querySelector('.text-center h5.fs-16');
    
    if (nameElement) {
      const nombreCompleto = `${ajustes.nombre_nutriologo || ''} ${ajustes.apellido_nutriologo || ''}`.trim();
      if (nombreCompleto) {
        nameElement.textContent = nombreCompleto;
      } else if (userData && userData.name) {
        nameElement.textContent = userData.name;
      }
    }
    
    // Actualizar el rol si existe (no implementado completamente)
    const rolElement = document.getElementById('rol_nombre');
    if (rolElement) {
      rolElement.textContent = "Nutriólogo";  // Por defecto
    }
  }

  // Guardar datos personales
  async saveDatosPersonales() {
    try {
        const fechaVisualizada = document.getElementById('fecha_nacimiento').value;
        let fechaISO = '';

        // Usar el atributo data-date-iso si existe
      if (this.fechaNacimientoInput && this.fechaNacimientoInput.getAttribute('data-date-iso')) {
            fechaISO = this.fechaNacimientoInput.getAttribute('data-date-iso');
            } else if (fechaVisualizada) {
            // Convertir manualmente si no hay atributo data-date-iso
            const dateObj = new Date(fechaVisualizada);
            if (!isNaN(dateObj.getTime())) {
            const year = dateObj.getFullYear();
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const day = String(dateObj.getDate()).padStart(2, '0');
            fechaISO = `${year}-${month}-${day}`;
            }
        }

      const formData = {
        nombre_nutriologo: document.getElementById('nombre_nutriologo').value,
        apellido_nutriologo: document.getElementById('apellido_nutriologo').value,
        telefono: document.getElementById('telefono').value,
        edad: document.getElementById('edad').value ? parseInt(document.getElementById('edad').value) : null,
        genero: document.getElementById('genero').value,
        fecha_nacimiento: fechaISO, 
        profesion: document.getElementById('profesion').value,
        especialidad: document.getElementById('especialidad').value,
        universidad: document.getElementById('universidad').value,
        displomados: document.getElementById('displomados').value,
        especializacion: document.getElementById('especializacion').value,
        descripcion_especialziacion: document.getElementById('descripcion_especialziacion').value,
        pacientes_tratados: document.getElementById('pacientes_tratados').value ? parseInt(document.getElementById('pacientes_tratados').value) : null,
        horario_antencion: document.getElementById('horario_antencion').value,
        descripcion_nutriologo: document.getElementById('descripcion_nutriologo').value,
        ciudad: document.getElementById('ciudad').value,
        estado: document.getElementById('estado').value,
        modalidad: document.getElementById('modalidad').value,
        disponibilidad: document.getElementById('disponibilidad').value
      };

      const response = await fetch(`${BASE_URL}/api/ajustes/datos-personales`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'remember-token': this.token
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
      }

      if (!data.success) {
        throw new Error(data.message || 'Error desconocido al guardar los datos personales');
      }

      util.showSuccess('Datos personales guardados correctamente');
      
      // Actualizar el nombre en el perfil si cambió
      this.updateProfileName(formData, this.userData);
    } catch (error) {
      console.error('Error:', error);
      util.showError(`Error al guardar datos personales: ${error.message}`);
    }
  }

  // Guardar experiencia
  async saveExperiencia() {
    try {
        let enfermedadesTratadas = '';
        if (window.enfermedadesEditor) {
            enfermedadesTratadas = window.enfermedadesEditor.getData();
        } 
        else if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.enfermedades_tratadas) {
            enfermedadesTratadas = CKEDITOR.instances.enfermedades_tratadas.getData();
        }
        else {
            const textarea = document.getElementById('enfermedades_tratadas');
            if (textarea) {
                enfermedadesTratadas = textarea.value;
            }
        }
             const formData = {
        experiencia: document.getElementById('experiencia').value,
        enfermedades_tratadas: enfermedadesTratadas
        };

      const response = await fetch(`${BASE_URL}/api/ajustes/experiencia`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'remember-token': this.token
        },
        body: JSON.stringify(formData)
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
      }

      if (!data.success) {
        throw new Error(data.message || 'Error desconocido al guardar la experiencia');
      }

      util.showSuccess('Experiencia guardada correctamente');
    } catch (error) {
      console.error('Error:', error);
      util.showError(`Error al guardar experiencia: ${error.message}`);
    }
  }

  

  // Subir imagen (perfil o portada)
  async uploadImage(file, type) {
        if (!file) return;

        try {
            const formData = new FormData();
            
            // Asignar el nombre de campo correcto según el tipo
            const fieldName = type === 'foto-perfil' ? 'foto' : 'foto_portada';
            formData.append(fieldName, file);

            // Construir la URL correcta
            const endpoint = type;
            const url = `${BASE_URL}/api/ajustes/${endpoint}`;
            
            // Mostrar notificación de carga
            const loadingMsg = Swal.fire({
            title: 'Subiendo imagen...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
            });
            
            console.log(`Enviando ${fieldName} a ${url}`);
            
            const response = await fetch(url, {
            method: 'POST',
            headers: {
                'remember-token': this.token
                // No agregar Content-Type para FormData
            },
            body: formData
            });

            // Cerrar notificación de carga
            loadingMsg.close();

            // Para depuración
            console.log('Response status:', response.status);
            
            // Verificar errores HTTP
            if (!response.ok) {
            const data = await response.json();
            console.error('Error response:', data);
            throw new Error(data.message || `Error ${response.status}: ${response.statusText}`);
            }

            // Procesar la respuesta
            const data = await response.json();
            console.log('Success response:', data);
            
            if (!data.success) {
            throw new Error(data.message || `Error al subir la ${type === 'foto-perfil' ? 'foto de perfil' : 'foto de portada'}`);
            }

            // Actualizar la imagen en el frontend
            if (type === 'foto-perfil') {
            // Actualizar todas las imágenes de perfil posibles
            const images = document.querySelectorAll('.profile-user img, #foto');
            images.forEach(img => {
                if (img && data.foto_url) {
                img.src = data.foto_url;
                }
            });
            } else {
            // Actualizar imagen de portada
            const img = document.getElementById('foto_portada');
            if (img && data.foto_portada_url) {
                img.src = data.foto_portada_url;
            }
            
            // También actualizar el fondo si existe
            const bgElement = document.querySelector('.profile-foreground-img');
            if (bgElement && data.foto_portada_url) {
                bgElement.style.backgroundImage = `url('${data.foto_portada_url}')`;
            }
            }

            util.showSuccess(`${type === 'foto-perfil' ? 'Foto de perfil' : 'Foto de portada'} actualizada correctamente`);
        } catch (error) {
            console.error('Error al subir imagen:', error);
            util.showError(`Error al subir imagen: ${error.message}`);
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  // Inicializar el gestor de ajustes
  const ajustesManager = new AjustesManager();
  
  // Inicializar flatpickr para la fecha de nacimiento si está disponible
  const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
  if (fechaNacimientoInput && typeof flatpickr !== 'undefined') {
        flatpickr(fechaNacimientoInput, {
            dateFormat: "d M, Y", // Formato de visualización
            altInput: true,
            altFormat: "F j, Y", // Formato alternativo para visualización
            allowInput: true,
            locale: "es",
            // Asegurar que el valor real sea en formato YYYY-MM-DD
            onChange: function(selectedDates, dateStr, instance) {
            instance.input.setAttribute('data-date-iso', selectedDates[0].toISOString().split('T')[0]);
            }
        });
    }
  
    if (typeof ClassicEditor !== 'undefined') {
        const enfermedadesElement = document.getElementById('enfermedades_tratadas');
        if (enfermedadesElement) {
            ClassicEditor.create(enfermedadesElement)
                .then(editor => {
                    console.log('CKEditor inicializado correctamente');
                    window.enfermedadesEditor = editor;
                    
                    // Cargar datos después de la inicialización
                    if (this.userData && this.userData.enfermedades_tratadas) {
                        editor.setData(this.userData.enfermedades_tratadas);
                    }
                })
                .catch(error => {
                    console.error('Error al inicializar CKEditor:', error);
                });
        }
    }
});