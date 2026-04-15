# Dashboard de Onboarding KPIs-RH v1.5.1

Este Dashboard es una solución avanzada de Inteligencia de Negocio para el área de Recursos Humanos, diseñada bajo estándares de arquitectura MVC y una estética premium inspirada en macOS Apple Design.

## 🚀 Novedades v1.5.1 (Cloud Ready)
- **Sincronización Híbrida (Dual-Sync)**: Los datos se guardan simultáneamente en **MySQL (Local)** y **Google Firebase Firestore (Nube)**.
- **Modo Inteligente Vercel**: El sistema detecta automáticamente si está en producción y conecta con la nube sin necesidad de cambios manuales.
- **Control Center (Filtros Pro)**: Nuevo panel de filtrado dinámico por Coordinación, Rango de Flechas e Identidad.

## 📊 Arquitectura del Sistema
El sistema sigue el patrón **Modelo-Vista-Controlador (MVC)** con un **Front Controller** para mayor escalabilidad y seguridad.

- **/app**: Lógica central (Modelos, Controladores, Vistas).
- **/config**: Configuración global y Conexión Híbrida.
- **/public**: Assets (CSS Glassmorphism, JS Reactivo, Chart.js).
- **/vercel.json**: Configuración de despliegue para Serverless PHP.

##  Blueprints Técnicos
- **Frontend**: ES6 Modules, Chart.js, Vanilla CSS Glassmorphism.
- **Backend**: PHP 8.x, PDO Singleton, Firebase SDK integration.
- **Database**: Dual-Write Strategy (SQL + NoSQL).

## 🛠️ Guía de Instalación

1. **Requisitos**: PHP 8.x, MySQL (XAMPP), Firebase Project.
2. **Firebase Config**: Actualice las credenciales en `form.php` y `search.js`.
3. **Acceso**: `http://localhost/KPIs-RH/public/`

---
*Desarrollado con ❤️ para la gestión de talento aeroportuario de alto nivel.*
