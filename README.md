# Dashboard Onboarding RH - MVC Architecture

Este proyecto implementa una arquitectura robusta basada en el patrón Modelo-Vista-Controlador (MVC) para la gestión de KPIs de Onboarding.

## Arquitectura del Sistema

El sistema utiliza un **Front Controller** (`public/index.php`) que centraliza todas las peticiones. La lógica está separada de la siguiente manera:

- **Logic Core (`/app`)**: Contiene modelos, controladores y vistas.
- **Templates (`/app/templates`)**: Layouts globales inamovibles (Header, Footer, Sidebar).
- **Public (`/public`)**: Único punto de acceso con assets y el controlador frontal.
- **Database (`/database`)**: Gestión de migraciones y scripts de inicialización.

## Guía de Despliegue (Fase 1)

1. **Configuración de Base de Datos**:
   - Crea una base de datos llamada `onboarding_db` en tu servidor MySQL (XAMPP).
   - Ejecuta el script de migración automática:
     ```bash
     php database/migrate.php
     ```
   - O importa manualmente `database/migrations/001_initial_schema.sql` en phpMyAdmin.

2. **Configuración de Rutas**:
   - Ajusta `URL_ROOT` en `config/config.php` si el proyecto no se encuentra en la ruta por defecto (`http://localhost/KPIs-RH`).

3. **Acceso**:
   - Abre el navegador en `http://localhost/KPIs-RH/public/`.

## Convención de Commits

Para mantener un historial de cambios profesional, seguimos esta convención:

- `feat:` Nuevas características (ej: `feat: add chart logic`).
- `fix:` Correcciones de errores (ej: `fix: db connection timeout`).
- `chore:` Tareas de mantenimiento (ej: `chore: update dependencies`).
- `docs:` Cambios en documentación (ej: `docs: update readme`).

## Base Técnica
- **PHP 8.x** con PDO (Patrón Singleton).
- **CSS Vanilla** con estética Glassmorphism & Scandinavian Minimalist.
- **PhpSpreadsheet** para reportes detallados.
- **Chart.js** para visualización de KPIs.

## Reportes y Exportación (Fase 3)

El sistema ahora soporta la generación de reportes en Excel con **semaforización inteligente**:
- **Celdas Verdes**: IGEO $\ge 85\%$.
- **Celdas Amarillas**: IGEO entre $70\%$ y $84\%$.
- **Celdas Rojas**: IGEO $< 70\%$.

### Instalación de Dependencias
Para habilitar el motor de Excel, es necesario ejecutar el siguiente comando en la raíz del proyecto:
```bash
composer update
```
