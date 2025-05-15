const BASE_URL = "http://127.0.0.1:8000";
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

