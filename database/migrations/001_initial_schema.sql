-- Onboarding Dashboard SQL Schema
-- Initial Migration: 001_initial_schema.sql

CREATE DATABASE IF NOT EXISTS onboarding_db;
USE onboarding_db;

CREATE TABLE IF NOT EXISTS onboarding_evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    num_empleado VARCHAR(20) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    puesto VARCHAR(100) NOT NULL,
    coordinacion VARCHAR(100) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    
    -- Metrics (1-10)
    m_claridad_rol TINYINT UNSIGNED DEFAULT 0,
    m_bienvenida_equipo TINYINT UNSIGNED DEFAULT 0,
    m_herramientas TINYINT UNSIGNED DEFAULT 0,
    m_acceso_sistemas TINYINT UNSIGNED DEFAULT 0,
    m_cultura TINYINT UNSIGNED DEFAULT 0,
    m_relacion_jefe TINYINT UNSIGNED DEFAULT 0,
    m_entorno_fisico TINYINT UNSIGNED DEFAULT 0,
    m_capacitacion TINYINT UNSIGNED DEFAULT 0,
    m_procesos TINYINT UNSIGNED DEFAULT 0,
    m_objetivos TINYINT UNSIGNED DEFAULT 0,
    m_integracion_social TINYINT UNSIGNED DEFAULT 0,
    m_valores TINYINT UNSIGNED DEFAULT 0,
    m_vision TINYINT UNSIGNED DEFAULT 0,
    m_beneficios TINYINT UNSIGNED DEFAULT 0,
    m_seguridad TINYINT UNSIGNED DEFAULT 0,
    m_soporte_rh TINYINT UNSIGNED DEFAULT 0,
    m_calidad_induccion TINYINT UNSIGNED DEFAULT 0,
    m_expectativas TINYINT UNSIGNED DEFAULT 0,
    
    -- Open Feedback
    f_comentarios_generales TEXT,
    f_sugerencias_mejora TEXT,
    f_obstaculos TEXT,
    f_lo_mejor TEXT,
    f_lo_peor TEXT,
    
    -- Audit & Control
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'archived') DEFAULT 'active',
    
    INDEX (num_empleado),
    INDEX (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
