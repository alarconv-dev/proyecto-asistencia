# 📋 Sistema de Control de Asistencia

Sistema web para el registro y gestión de asistencia académica en tiempo real mediante tokens únicos y códigos QR. Desarrollado en **PHP** y **MySQL**.

---

## ⚡ Características Principales

* **Lógica de Asistencia Automatizada:** Clasificación instantánea (*Asistió*, *Tardanza*, *Ausente*) según el horario de registro del estudiante.
* **Cierre Automático de Sesiones:** Proceso en segundo plano mediante `MySQL Event Scheduler` con *fallback* programático en PHP.
* **Generación de QR y Tokens:** Cada sesión genera un enlace único e indescifrable con token aleatorio de 32 caracteres.
* **Multi-usuario Aislado:** Control de acceso estricto por `profesor_id` a nivel de base de datos.

---

## 🛡️ Seguridad Integrada

* **Contraseñas:** Encriptación robusta mediante `password_hash()` (bcrypt).
* **Protección SQL Injection:** *Prepared statements* (consultas preparadas) en el 100% de las transacciones a la base de datos.
* **Protección XSS:** Sanitización exhaustiva de salidas HTML mediante `htmlspecialchars()`.
* **Rate Limiting:** Mitigación de ataques de fuerza bruta limitando a 5 intentos de inicio de sesión fallidos por IP/usuario cada 15 minutos.

---

## 🛠️ Requisitos e Instalación

Puedes desplegar el proyecto rápidamente usando **XAMPP**.

### Configuración con XAMPP

1. **Clonar/Copiar el Proyecto**  
   Copia la carpeta del proyecto en el directorio `htdocs` de XAMPP:
   ```bash
   C:\xampp\htdocs\proyecto-asistencia