# NutriFit - Panel Administrativo Web

**NutriFit Planner**: Plataforma web para la gestión integral de citas y planes nutricionales, diseñada especialmente para nutriólogos.

---

## 👥 Integrantes ISC 8A

- Quintal Pech Carlos Daniel – 7647  
- Puc Yam Alan Antony – 7637  
- Huchin Yeh Jesus Eduardo – 7623  
- Canul Cocom Jesus Roberto – 7605  

---

## 📋 Descripción

**NutriFit - Panel Administrativo Web** es la interfaz de administración para profesionales de la salud que permite gestionar todas las funcionalidades disponibles en la aplicación móvil de NutriFit. Desde esta plataforma, los nutriólogos pueden aceptar o rechazar citas, gestionar pacientes y mantener organizada su agenda y los planes nutricionales personalizados.

---

## 🚀 Características

- Panel de control para nutriólogos.
- Gestión de pacientes y citas.
- Visualización y control de planes nutricionales.
- Autenticación con recordatorio de sesión (`remember_token`).
- Comunicación fluida entre móvil y panel web.

---

## 🧰 Requisitos

Antes de comenzar, asegúrate de tener instalado lo siguiente:

- **XAMPP** (versión que incluya):
  - PHP `8.2.28`
  - MySQL (Puerto `3306` por defecto)
- **Composer** ([getcomposer.org](https://getcomposer.org/))
- **Laravel** `12.8.1`

---

## 🛠️ Instalación y Configuración

### 1. Clonar el repositorio

Ubica tu carpeta `htdocs` de XAMPP y clona el proyecto allí:

```bash
cd C:\xampp\htdocs
git clone https://github.com/WoolyOlvel/NutriFit-Panel-Admin-Web.git
```
### 2. Instalar Laravel y Composer

Dirígete a la carpeta del proyecto, y entra en la subcarpeta nutrifit-api:

```bash
cd NutriFit-Panel-Admin-Web/nutrifit-api

```
### Asegúrate de tener Composer instalado en tu equipo. Luego ejecuta:

```bash
composer install

```

### Recuerda tambien instalar Composer en nutrifit-api:

```bash
composer install

```
Esto descargará todas las dependencias necesarias del backend.


## 🧪 Ejecución del servidor
Una vez completada la instalación, ejecuta el servidor de desarrollo de Laravel:
```bash
php artisan serve --host=0.0.0.0 --port=8000

```
## 🌐 Acceso a la plataforma
Abre un navegador y ve a la siguiente URL:

```bash

http://localhost/NutriFit-Panel-Admin-Web

```
⚠️ Asegúrate de usar el nombre real de la carpeta donde clonaste el proyecto si es diferente.


## 🗃️ Base de datos

- ## 1. Importar la base de datos
   - Inicia XAMPP y asegúrate de que Apache y MySQL estén activos
   - Entra a phpMyAdmin
   - Crea una nueva base de datos llamada: nutrifit
   - Importa el archivo nutrifit.sql ubicado en el repositorio clonado
## 🔐 Inicio de sesión
Una vez importada la base de datos, puedes acceder al sistema con las siguientes credenciales:
  - Correo electrónico: puc-alan20@hotmail.com
  - Contraseña: N20pyalik

✅ Marca la casilla "Recuérdame" para activar el autologin por 30 días mediante el remember_token.

⚠️ Las Credenciales otorgados son para cuenta DEMO

##  📬 Contacto
Para dudas, soporte o sugerencias:

  - Correo electrónico: puc-alan20@hotmail.com
  - GitHub: @WoolyOlvel
    
## 🤝 Contribuciones
¡Las contribuciones son bienvenidas! Puedes hacerlo mediante:
  - Pull Requests
  - Reportes de errores (Issues)
## 📄 Licencia
Este proyecto se encuentra bajo la licencia MIT.

## © Derechos de Autor
NutriFit - Panel Administrativo Web es un producto desarrollado y propiedad intelectual de:
### ASCRIB
  - Fundador: Alan Puc Yam
  - Todos los derechos reservados.
