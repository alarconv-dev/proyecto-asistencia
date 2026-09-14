# 📋 Sistema de Control de Asistencia

![PHP](https://img.shields.io/badge/PHP-7.4%20%7C%208.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Supported-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Licencia](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Sistema web para el registro y gestión de asistencia académica en tiempo real mediante tokens únicos y códigos QR. Permite la validación automatizada de horarios y el cierre programado de sesiones de clase.

---

## ⚡ Características Principales

* **Lógica de Asistencia Automatizada:** Clasificación instantánea (*Asistió*, *Tardanza*, *Ausente*) según el timestamp de registro del estudiante.
* **Despliegue Dockerizado:** Entorno de contenedores listo para levantar el servidor web y la base de datos con un solo comando.
* **Cierre Automático de Sesiones:** Proceso en segundo plano mediante `MySQL Event Scheduler` con *fallback* programático en PHP (`SesionClase::cerrarVencidas()`).
* **Generación de QR y Tokens:** Cada sesión genera un enlace único e indescifrable con un token aleatorio de 32 caracteres.
* **Multi-usuario Aislado:** Control de acceso estricto por `profesor_id` a nivel de base de datos.

---

## 🛡️ Seguridad Integrada

* **Autenticación Segura:** Encriptación de contraseñas de profesores con `password_hash()` (bcrypt).
* **Protección contra SQL Injection:** Consultas preparadas (*Prepared Statements*) en el 100% de las operaciones a la base de datos.
* **Protección XSS:** Sanitización de salidas HTML mediante `htmlspecialchars()`.
* **Rate Limiting:** Mitigación de ataques de fuerza bruta limitando a 5 intentos de login fallidos por IP/usuario cada 15 minutos.

---

## 🛠️ Requisitos e Instalación

El proyecto soporta despliegue inmediato mediante **Docker** (recomendado) o **XAMPP**.

### Opción A: Despliegue con Docker 🐳 (Recomendado)

Si cuentas con Docker y Docker Compose instalados:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/tu-usuario/proyecto-asistencia.git](https://github.com/tu-usuario/proyecto-asistencia.git)
   cd proyecto-asistencia