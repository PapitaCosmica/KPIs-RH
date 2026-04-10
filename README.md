# Dashboard de Onboarding KPIs-RH

Este Dashboard es una solución avanzada de Inteligencia de Negocio para el área de Recursos Humanos, diseñada bajo estándares de arquitectura MVC y una estética premium inspirada en macOS y el minimalismo escandinavo.

## 🚀 Arquitectura del Sistema
El sistema sigue el patrón **Modelo-Vista-Controlador (MVC)** con un **Front Controller** para mayor escalabilidad y seguridad.

- **/app**: Lógica central (Modelos, Controladores, Vistas).
- **/config**: Configuración global y Conexión Singleton (PDO).
- **/public**: Assets (CSS Glassmorphism, JS Reactivo, Chart.js).
- **/database**: Migraciones SQL para control de versiones de datos.

## 📊 Módulos Principales

### 1. Motor de Inteligencia (Fase 2)
Cálculo automático del **IGEO** (Índice Global de Efectividad del Onboarding) segmentado en 5 dimensiones: Claridad, Cultura, Liderazgo, Operaciones y Satisfacción.

### 2. Visualización y Reportes (Fase 3 & 6)
- **Gráficas Interactivas**: Radar de dimensiones, Evolución temporal y Comparativa por área.
- **Exportación a Excel**: Generación de reportes con semaforización automática (Verde/Amarillo/Rojo).

### 3. Búsqueda Spotlight (Fase 5)
Barra de búsqueda asíncrona (AJAX) con tecnología **Debounce** para consulta instantánea de expedientes y actualización de métricas en tiempo real.

## 🛠️ Guía de Instalación

1. **Requisitos**: PHP 8.x, MySQL (XAMPP), Composer.
2. **Base de Datos**: 
   - Crear base `onboarding_db`.
   - Ejecutar `php database/migrate.php` o importar el SQL en `/database/migrations/`.
3. **Dependencias**:
   ```bash
   composer update
   ```
4. **Acceso**: `http://localhost/KPIs-RH/public/`

## 📘 Manual de Usuario
- **Búsqueda**: Escriba el nombre o número de empleado en la barra superior. Los gráficos y la tabla se filtrarán al instante.
- **Perfil Rápido**: Al buscar un número de empleado exacto, se desplegará el feedback cualitativo.
- **Reportes**: Use el botón "Exportar Reporte Final" para obtener la sábana oficial en formato `.xlsx`.

## 🤝 Convención de Commits
Utilizamos **Conventional Commits**: `feat:`, `fix:`, `docs:`, `style:`, `chore:`.

---
*Desarrollado con ❤️ para la gestión de talento aeroportuario.*
