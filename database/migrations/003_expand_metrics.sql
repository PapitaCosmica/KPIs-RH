-- Migration: Expand metrics to 30 fields
-- Created by Antigravity

DROP TABLE IF EXISTS onboarding_evaluations;

CREATE TABLE onboarding_evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    num_empleado VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    puesto VARCHAR(100) NOT NULL,
    coordinacion VARCHAR(100) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    fecha_realizacion DATE NOT NULL,
    email VARCHAR(100) NOT NULL,
    
    -- Metrics (17 Quantitative Questions 1-10)
    m_claridad_expectativas INT DEFAULT 0,
    m_seguridad_responsabilidades INT DEFAULT 0,
    m_integracion_equipo INT DEFAULT 0,
    m_experiencia_colaboracion INT DEFAULT 0,
    m_accesibilidad_jefe INT DEFAULT 0,
    m_retroalimentacion_jefe INT DEFAULT 0,
    m_conocimiento_cultura INT DEFAULT 0,
    m_alineacion_valores INT DEFAULT 0,
    m_organizacion_induccion INT DEFAULT 0,
    m_claridad_procedimientos INT DEFAULT 0,
    m_herramientas_trabajo INT DEFAULT 0,
    m_espacio_fisico INT DEFAULT 0,
    m_atencion_rh INT DEFAULT 0,
    m_paquete_beneficios INT DEFAULT 0,
    m_proceso_administrativo INT DEFAULT 0,
    m_percepcion_imagen INT DEFAULT 0,
    m_efectividad_onboarding INT DEFAULT 0,
    
    -- Feedback (6 Qualitative Questions)
    f_utilidad_capacitaciones TEXT,
    f_faltantes_actividades TEXT,
    f_tiempo_onboarding TEXT,
    f_satisfaccion_decision TEXT,
    f_mejoras_proceso TEXT,
    f_comentarios_libres TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Performance Indexes
    INDEX idx_num_empleado (num_empleado),
    INDEX idx_coordinacion (coordinacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
