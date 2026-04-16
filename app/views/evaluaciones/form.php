<div class="survey-wrapper">
    <div class="survey-header">
        <div class="logo-placeholder" style="margin-bottom: 1rem;">
            <img src="https://placehold.co/200x60/81a1c1/ffffff?text=AEROPUERTO" alt="Logo">
        </div>
        <h1>Evaluación de Efectividad del Onboarding</h1>
        <p>Tu opinión es fundamental para mejorar nuestra experiencia de integración institucional.</p>
    </div>

    <form id="fullSurveyForm" class="glass-container survey-form">
        <?php if (isset($tunnelToken)): ?>
            <input type="hidden" name="tunnel_token" value="<?php echo $tunnelToken; ?>">
        <?php endif; ?>
        <!-- Section 1: Perfil -->
        <div class="form-section glass-card">
            <h3>1. Información del Colaborador</h3>
            <div class="input-grid">
                <div class="input-group">
                    <label>Número de Empleado *</label>
                    <input type="text" name="num_empleado" required placeholder="Ej: 12345">
                </div>
                <div class="input-group">
                    <label>Nombre Completo *</label>
                    <input type="text" name="nombre" required placeholder="Tu nombre completo">
                </div>
                <div class="input-group autocomplete-wrapper">
                    <label>Puesto de Trabajo *</label>
                    <input type="text" name="puesto" id="puestoInput" required placeholder="Escribe para buscar tu puesto..." autocomplete="off">
                    <div class="autocomplete-dropdown" id="puestoDropdown"></div>
                </div>
                <div class="input-group">
                    <label>Coordinación *</label>
                    <select name="coordinacion" required>
                        <option value="">Selecciona...</option>
                        <option value="ADMINISTRACION AEROPORTUARIA">ADMINISTRACION AEROPORTUARIA</option>
                        <option value="COORDINACION ADMINISTRATIVA">COORDINACION ADMINISTRATIVA</option>
                        <option value="COORDINACION DE PLANEACIÓN ESTRATÉGICA">COORDINACION DE PLANEACIÓN ESTRATÉGICA</option>
                        <option value="COORDINACION JURIDICA">COORDINACION JURIDICA</option>
                        <option value="DIRECCION GENERAL">DIRECCION GENERAL</option>
                        <option value="DIRECCION COMERCIAL">DIRECCION COMERCIAL</option>
                        <option value="ORGANO INTERNO DE CONTROL">ORGANO INTERNO DE CONTROL</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Fecha de Ingreso *</label>
                    <input type="date" name="fecha_ingreso" required>
                </div>
                <div class="input-group">
                    <label>Fecha de Evaluación *</label>
                    <input type="date" name="fecha_realizacion" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="input-group full-width">
                    <label>Correo Institucional *</label>
                    <input type="email" name="email" required placeholder="usuario@aeropuerto.com">
                </div>
            </div>
        </div>

        <!-- Instrucciones generales -->
        <div class="form-instructions glass-card">
            <p class="section-desc">📋 <strong>Instrucciones:</strong> Evalúa cada pregunta en una escala del 1 al 10, donde <strong>1</strong> es "Muy en desacuerdo" y <strong>10</strong> es "Totalmente de acuerdo".</p>
        </div>

        <!-- Preguntas 1-2 -->
        <div class="form-section glass-card">
            
            <div class="metrics-list">
                <?php 
                // Preguntas 1-2: Claridad del Puesto
                $bloque1 = [
                    'm_claridad_expectativas' => '1. ¿Qué tan claro tienes actualmente lo que se espera de ti en tu puesto?',
                    'm_seguridad_responsabilidades' => '2. ¿Qué tan seguro(a) te sientes al ejecutar tus responsabilidades diarias?'
                ];
                foreach ($bloque1 as $id => $q): ?>
                    <div class="metric-item">
                        <label><?php echo $q; ?></label>
                        <div class="rating-group">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <label class="rating-option">
                                    <input type="radio" name="<?php echo $id; ?>" value="<?php echo $i; ?>" required>
                                    <span><?php echo $i; ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Preguntas 3-4 -->
        <div class="form-section glass-card">
            <div class="feedback-list">
                <div class="input-group">
                    <label>3. ¿Cuáles han sido tus mayores logros durante este periodo? *</label>
                    <textarea name="f_logros" required placeholder="Texto de respuesta larga..."></textarea>
                </div>
                <div class="input-group">
                    <label>4. ¿Hay algún aspecto en el que necesites apoyo adicional?</label>
                    <input type="text" name="f_utilidad_capacitaciones" placeholder="Texto de respuesta corta">
                </div>
            </div>
        </div>

        <!-- Pregunta 5: Capacitación -->
        <div class="form-section glass-card">
            <div class="metrics-list">
                <?php 
                $bloque2 = [
                    'm_preparacion_capacitacion' => '5. ¿En qué medida la capacitación recibida te preparó para enfrentar los retos del puesto?'
                ];
                foreach ($bloque2 as $id => $q): ?>
                    <div class="metric-item">
                        <label><?php echo $q; ?></label>
                        <div class="rating-group">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <label class="rating-option">
                                    <input type="radio" name="<?php echo $id; ?>" value="<?php echo $i; ?>" required>
                                    <span><?php echo $i; ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 6 -->
        <div class="form-section glass-card">
            <div class="feedback-list">
                <div class="input-group">
                    <label>6. ¿Hay algún tema o punto específico en el que necesites apoyo adicional?</label>
                    <input type="text" name="f_faltantes_actividades" placeholder="Texto de respuesta corta">
                </div>
            </div>
        </div>

        <!-- Preguntas 7-12: Preparación, Equipo y Liderazgo -->
        <div class="form-section glass-card">
            <div class="metrics-list">
                <?php 
                $bloque3 = [
                    'm_efectividad_onboarding' => '7. ¿Qué tan preparado(a) te sientes para realizar tus actividades de manera independiente?',
                    'm_contribucion_resultados' => '8. ¿Qué tan bien comprendes cómo tu trabajo contribuye a los resultados del equipo?',
                    'm_integracion_equipo' => '9. ¿Qué tan integrado(a) te sientes en tu equipo de trabajo?',
                    'm_experiencia_colaboracion' => '10. ¿Qué tan positiva ha sido tu experiencia de colaboración con tu equipo de trabajo?',
                    'm_accesibilidad_jefe' => '11. ¿Qué tan accesible y disponible ha sido tu Jefe Inmediato para orientarte cuando lo necesitas?',
                    'm_retroalimentacion_jefe' => '12. ¿Qué tan cómodo(a) te sientes compartiendo ideas, dudas o retroalimentación dentro del equipo?'
                ];
                foreach ($bloque3 as $id => $q): ?>
                    <div class="metric-item">
                        <label><?php echo $q; ?></label>
                        <div class="rating-group">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <label class="rating-option">
                                    <input type="radio" name="<?php echo $id; ?>" value="<?php echo $i; ?>" required>
                                    <span><?php echo $i; ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Preguntas 13-17: Cultura y Organización -->
        <div class="form-section glass-card">
            <div class="metrics-list">
                <?php 
                $bloque4 = [
                    'm_conocimiento_cultura' => '13. ¿Qué tan bien comprendes la cultura, valores y forma de trabajo del Aeropuerto?',
                    'm_alineacion_valores' => '14. ¿Qué tan clara es tu comprensión de los protocolos de seguridad y operaciones dentro del Aeropuerto?',
                    'm_organizacion_induccion' => '15. ¿Qué tan bien te has adaptado al ritmo de trabajo y a las exigencias propias de tu área de trabajo?',
                    'm_herramientas_trabajo' => '16. ¿Qué tan alineadas están hoy tus expectativas laborales con la realidad del Aeropuerto?',
                    'm_espacio_fisico' => '17. ¿Qué tan identificado(a) te sientes con la organización (su misión y valores) desde tu ingreso?'
                ];
                foreach ($bloque4 as $id => $q): ?>
                    <div class="metric-item">
                        <label><?php echo $q; ?></label>
                        <div class="rating-group">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <label class="rating-option">
                                    <input type="radio" name="<?php echo $id; ?>" value="<?php echo $i; ?>" required>
                                    <span><?php echo $i; ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Preguntas 18-19: Efectividad del Onboarding -->
        <div class="form-section glass-card">
            <div class="metrics-list">
                <?php 
                $bloque5 = [
                    'm_atencion_rh' => '18. ¿Qué tan efectivo consideras que fue tu proceso de onboarding para facilitar tu adaptación?',
                    'm_paquete_beneficios' => '19. ¿Las capacitaciones fueron útiles para tu integración al puesto y al Aeropuerto?'
                ];
                foreach ($bloque5 as $id => $q): ?>
                    <div class="metric-item">
                        <label><?php echo $q; ?></label>
                        <div class="rating-group">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <label class="rating-option">
                                    <input type="radio" name="<?php echo $id; ?>" value="<?php echo $i; ?>" required>
                                    <span><?php echo $i; ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 20 -->
        <div class="form-section glass-card">
            <div class="feedback-list">
                <div class="input-group">
                    <label>20. ¿Qué consideras pudo faltar para conocer mejor tus actividades o al Aeropuerto?</label>
                    <input type="text" name="f_tiempo_onboarding" placeholder="Texto de respuesta corta">
                </div>
            </div>
        </div>

        <!-- Preguntas 21-22: Satisfacción Final -->
        <div class="form-section glass-card">
            <div class="metrics-list">
                <?php 
                $bloque6 = [
                    'm_percepcion_imagen' => '21. ¿Qué tan bien consideras fue el tiempo de onboarding para tener una adecuada integración a tu puesto de trabajo?',
                    'm_satisfaccion_decision' => '22. Considerando estos primeros 3 meses, ¿qué tan satisfecho(a) estás con tu decisión de integrarte al Aeropuerto?'
                ];
                foreach ($bloque6 as $id => $q): ?>
                    <div class="metric-item">
                        <label><?php echo $q; ?></label>
                        <div class="rating-group">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <label class="rating-option">
                                    <input type="radio" name="<?php echo $id; ?>" value="<?php echo $i; ?>" required>
                                    <span><?php echo $i; ?></span>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 23 -->
        <div class="form-section glass-card">
            <div class="feedback-list">
                <div class="input-group">
                    <label>23. De manera general, ¿qué integrarías en el proceso de Onboarding para tener una mejor experiencia e integración al Aeropuerto? *</label>
                    <input type="text" name="f_mejoras_proceso" required placeholder="Texto de respuesta corta">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-neo btn-primary">Enviar Evaluación Final</button>
        </div>
    </form>
</div>

<style>
/* Instructions */
.form-instructions {
    margin-bottom: 0.5rem;
}
.form-instructions .section-desc {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #555;
}
/* Autocomplete */
.autocomplete-wrapper {
    position: relative;
}
.autocomplete-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 100;
    max-height: 220px;
    overflow-y: auto;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 0 0 14px 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}
.autocomplete-dropdown.open {
    display: block;
}
.ac-item {
    padding: 0.55rem 1rem;
    cursor: pointer;
    font-size: 0.85rem;
    color: #333;
    transition: background 0.15s;
    border-bottom: 1px solid rgba(0,0,0,0.03);
}
.ac-item:hover, .ac-item.active {
    background: rgba(129, 161, 193, 0.12);
    color: var(--color-night, #2E3440);
}
.ac-item mark {
    background: rgba(129, 161, 193, 0.3);
    color: inherit;
    border-radius: 2px;
    padding: 0 1px;
}
.ac-empty {
    padding: 0.8rem 1rem;
    font-size: 0.85rem;
    color: #999;
    font-style: italic;
}

.survey-wrapper {
    max-width: 900px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.survey-header {
    text-align: center;
    margin-bottom: 3rem;
}

.survey-header h1 {
    font-size: 2.5rem;
    color: var(--color-night);
    margin-bottom: 0.5rem;
}

.form-section {
    margin-bottom: 2rem;
    padding: 2rem;
}

.form-section h3 {
    color: var(--color-ice-blue);
    margin-bottom: 1.5rem;
    font-size: 1.3rem;
}

.input-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.full-width {
    grid-column: span 2;
}

.input-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--color-deep-slate);
}

.survey-form input, .survey-form select, .survey-form textarea {
    width: 100%;
    padding: 0.8rem;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.1);
    background: white;
}

.metrics-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.metric-item {
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding-bottom: 1rem;
}

.rating-group {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.rating-option input {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
    white-space: nowrap;
}

.rating-option span {
    display: flex;
    width: 40px;
    height: 40px;
    background: #f0f4f8;
    border-radius: 10px;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-weight: 700;
    transition: all 0.2s;
}

.rating-option input:checked + span {
    background: var(--color-ice-blue);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(129, 161, 193, 0.4);
}

.form-actions {
    margin-top: 3rem;
    text-align: center;
}

.btn-primary {
    padding: 1rem 3rem;
    font-size: 1.1rem;
    background: var(--color-ice-blue);
    color: white;
}

@media (max-width: 600px) {
    .input-grid { grid-template-columns: 1fr; }
    .full-width { grid-column: span 1; }
    .rating-group { justify-content: flex-start; }
}
</style>

<!-- Firebase SDK Integration -->
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getFirestore, collection, addDoc, serverTimestamp, doc, getDoc, updateDoc, increment } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

const firebaseConfig = {
  apiKey: "AIzaSyBVRsb03EbnY3IKRAbc-3s5jTjM5X3kGxM",
  authDomain: "kpi-rh-c667e.firebaseapp.com",
  projectId: "kpi-rh-c667e",
  storageBucket: "kpi-rh-c667e.firebasestorage.app",
  messagingSenderId: "59652617692",
  appId: "1:59652617692:web:789034aa88c4ef1a4f0b19"
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// Tunnel validation (if accessed via tunnel link)
const tunnelToken = '<?php echo isset($tunnelToken) ? $tunnelToken : ""; ?>';
if (tunnelToken) {
    (async () => {
        try {
            const tunnelRef = doc(db, 'tunnels', tunnelToken);
            const tunnelSnap = await getDoc(tunnelRef);
            
            if (!tunnelSnap.exists()) {
                document.body.innerHTML = '<div style="text-align:center;padding:4rem;font-family:sans-serif;"><h2>⚠️ Enlace inválido</h2><p>Este enlace de evaluación no existe.</p></div>';
                return;
            }
            
            const data = tunnelSnap.data();
            const now = new Date();
            const expiresAt = data.expires_at?.toDate ? data.expires_at.toDate() : new Date(data.expires_at);
            
            if (now > expiresAt) {
                document.body.innerHTML = '<div style="text-align:center;padding:4rem;font-family:sans-serif;"><h2>⏰ Enlace expirado</h2><p>Este enlace temporal ha expirado.</p></div>';
                return;
            }
            
            if (data.current_responses >= data.max_responses) {
                document.body.innerHTML = '<div style="text-align:center;padding:4rem;font-family:sans-serif;"><h2>📊 Límite alcanzado</h2><p>Este enlace ha alcanzado su límite de respuestas.</p></div>';
                return;
            }
        } catch (err) {
            console.error('Tunnel validation error:', err);
        }
    })();
}

document.getElementById('fullSurveyForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Check for invalid fields
    const form = e.target;
    if (!form.checkValidity()) {
        const firstInvalid = form.querySelector(':invalid');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            alert('Por favor, completa todos los campos obligatorios marcados con (*).');
            return;
        }
    }

    const formData = new FormData(form);
    const dataObj = Object.fromEntries(formData.entries());
    
    // UI Feedback: Disable button
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = "Enviando...";
    submitBtn.disabled = true;

    try {
        // 1. DUAL-WRITE: Step A -> Cloud Firestore (for Vercel Dashboard)
        const scores = calculateScoresJS(dataObj);
        await addDoc(collection(db, "onboarding_evaluations"), {
            ...dataObj,
            scores: scores,
            IGEO: scores.IGEO,
            created_at: serverTimestamp(),
            source: 'Web App'
        });
        console.log("Firebase Sync: OK");

        // 2. Increment tunnel usage if accessed via tunnel
        if (tunnelToken) {
            try {
                const tunnelRef = doc(db, 'tunnels', tunnelToken);
                await updateDoc(tunnelRef, { current_responses: increment(1) });
            } catch (tunnelErr) {
                console.warn('Tunnel increment failed:', tunnelErr);
            }
        }

        // 3. DUAL-WRITE: Step B -> Local SQL (for Backup)
        // Wrapped in try/catch because Vercel has no MySQL and PHP will fail, but we shouldn't block the user.
        try {
            formData.append('is_ajax', 'true');
            const response = await fetch('<?php echo URL_ROOT; ?>?url=survey/store', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.status !== 'success') {
                console.warn('Backup SQL failed:', result.message);
            }
        } catch (localErr) {
            console.warn('Backup SQL skipped (Vercel environment)');
        }
        
        alert('¡Gracias! Tu evaluación ha sido enviada correctamente.');
        window.location.href = '<?php echo URL_ROOT; ?>?url=survey/thanks';

    } catch (err) {
        console.error("Sync Error:", err);
        alert('Ocurrió un error. Verifica tu conexión a internet.');
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
});

/**
 * Replicates PHP calculateScores logic in JS for Firestore metadata
 */
/**
 * Replicates PHP calculateScores logic in JS for Firestore metadata - v1.6.1
 */
/**
 * Replicates PHP calculateScores logic in JS for Firestore metadata - v1.6.2
 */
function calculateScoresJS(source) {
    const dimensions = {
        'Claridad_Puesto': ['m_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_contribucion_resultados', 'm_experiencia_colaboracion'],
        'Integracion_Equipo': ['m_integracion_equipo', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe', 'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion'],
        'Comprension_Org': ['m_herramientas_trabajo', 'm_espacio_fisico', 'm_atencion_rh', 'm_paquete_beneficios', 'm_percepcion_imagen'],
        'Efectividad_Onb': ['m_efectividad_onboarding', 'm_contribucion_resultados', 'm_preparacion_capacitacion']
    };

    const results = {};
    Object.keys(dimensions).forEach(name => {
        let sum = 0;
        dimensions[name].forEach(field => {
            sum += parseInt(source[field]) || 0;
        });
        results[name] = Math.round((sum / (dimensions[name].length * 10)) * 100);
    });

    const metricsList = [
        'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion',
        'm_efectividad_onboarding', 'm_contribucion_resultados', 'm_integracion_equipo',
        'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe',
        'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion',
        'm_herramientas_trabajo', 'm_espacio_fisico', 'm_atencion_rh',
        'm_paquete_beneficios', 'm_percepcion_imagen'
    ];

    let globalSum = 0;
    metricsList.forEach(m => {
        globalSum += parseInt(source[m]) || 0;
    });
    results['IGEO'] = Math.round((globalSum / (metricsList.length * 10)) * 100);

    return results;
}
</script>

<script>
// ===== AUTOCOMPLETE: Puesto de Trabajo (107 opciones) =====
(function() {
    const puestos = [
        'ADMINISTRADOR AEROPORTUARIO',
        'ANALISTA DE ASUNTOS LEGALES',
        'ANALISTA DE COMPRAS',
        'ANALISTA DE CONTRATOS',
        'ANALISTA DE CONTROL DE INVENTARIOS Y ARCHIVOS',
        'ANALISTA DE CONTROL PRESUPUESTAL',
        'ANALISTA DE EGRESOS Y CUENTAS POR PAGAR',
        'ANALISTA DE INGRESOS Y CUENTAS POR COBRAR',
        'ANALISTA DE NOMINA Y PRESTACIONES',
        'ANALISTA DE PERSONAL',
        'ANALISTA DE PLANEACION ESTRATEGICA',
        'ANALISTA DE PROYECTOS',
        'ANALISTA DE SEGURIDAD E HIGIENE',
        'ANALISTA DE TESORERIA',
        'ANALISTA JURIDICO',
        'ASISTENTE DE DIRECCION',
        'ASISTENTE EJECUTIVA (COORDINACION ADMINISTRATIVA)',
        'ASISTENTE EJECUTIVA (ADMINISTRACION AEROPORTUARIA)',
        'ATENCION AL PASAJERO',
        'AUDITOR',
        'AUDITOR / TITULAR DE AUDITORIA',
        'AUDITOR JURIDICO / TITULAR DE RESPONSABILIDADES ADMINISTRATIVAS',
        'AUDITOR JURIDICO DE INVESTIGACION / TITULAR DE ATENCION A QUEJAS',
        'AUXILIAR ADMINISTRATIVO (MANTENIMIENTO)',
        'AUXILIAR ADMINISTRATIVO (SEGURIDAD)',
        'AUXILIAR ADMINISTRATIVO (DIRECCION GENERAL)',
        'AUXILIAR ADMINISTRATIVO (DIRECCION COMERCIAL)',
        'AUXILIAR DE CAJA GENERAL',
        'AUXILIAR DE CAPACITACION',
        'AUXILIAR DE COBRANZA',
        'AUXILIAR DE COMPRAS',
        'AUXILIAR DE CUENTAS POR PAGAR',
        'AUXILIAR DE EGRESOS',
        'AUXILIAR DE INFORMATICA',
        'AUXILIAR DE INGRESOS',
        'AUXILIAR DE INGRESOS DEL ESTACIONAMIENTO',
        'AUXILIAR DE INVENTARIO Y ARCHIVO',
        'AUXILIAR DE OPERACIONES',
        'AUXILIAR DE PLANEACION ESTRATEGICA',
        'AUXILIAR DE RECURSOS FINANCIEROS',
        'AUXILIAR DE SERVICIOS',
        'AUXILIAR DE SERVICIOS INTERNOS',
        'AUXILIAR DE SOPORTE TECNICO',
        'AUXILIAR DE SUMINISTROS Y CONTROL VEHICULAR',
        'AUXILIAR DE EXPEDICION DE TIAS',
        'AUXILIAR JURIDICO',
        'BOMBERO DEL SSEI',
        'CAJERO DEL ESTACIONAMIENTO',
        'CAJERO GENERAL',
        'CHOFER AEROCAR',
        'COMANDANTE DEL SSEI',
        'CONTADOR GENERAL',
        'CONTROLADOR DE ACCESO DEL ESTACIONAMIENTO',
        'COORDINADOR ADMINISTRATIVO',
        'COORDINADOR DE PLANEACION ESTRATEGICA',
        'COORDINADOR JURIDICO',
        'DIRECTOR COMERCIAL',
        'DIRECTOR GENERAL',
        'ELECTROMECANICO',
        'ENCARGADO DE CONTROL DE TIAS',
        'ENCARGADO DE SEGURIDAD',
        'ENLACE DE ADMINISTRACION AEROPORTUARIA',
        'INSPECTOR DE ARRENDAMIENTOS',
        'JEFE DE AREA DE ASUNTOS CORPORATIVOS',
        'JEFE DE AREA DE ATENCION A CLIENTES',
        'JEFE DE AREA DE CALIDAD',
        'JEFE DE AREA DE COMUNICACION SOCIAL',
        'JEFE DE AREA DE CONTROL PATRIMONIAL Y SERVICIOS INTERNOS',
        'JEFE DE AREA DE DESARROLLO COMERCIAL',
        'JEFE DE AREA DE INFORMATICA',
        'JEFE DE AREA DE PLANEACION DE RUTAS',
        'JEFE DE AREA DE PROFESIONALIZACION',
        'JEFE DE DEPARTAMENTO DE ADQUISICIONES Y SERVICIOS',
        'JEFE DE DEPARTAMENTO DE GESTION PREVENTIVA SMS',
        'JEFE DE DEPARTAMENTO DE LO CONTENCIOSO',
        'JEFE DE DEPARTAMENTO DE MANTENIMIENTO',
        'JEFE DE DEPARTAMENTO DE OPERACIONES Y SERVICIOS',
        'JEFE DE DEPARTAMENTO DE PLANEACION ESTRATEGICA',
        'JEFE DE DEPARTAMENTO DE RECURSOS FINANCIEROS',
        'JEFE DE DEPARTAMENTO DE RECURSOS HUMANOS',
        'JEFE DE DEPARTAMENTO DE SEGURIDAD',
        'JEFE DE TURNO DEL SSEI',
        'MENSAJERO (CONTROL PATRIMONIAL)',
        'MENSAJERO (DIRECCION GENERAL)',
        'MONITORISTA DEL CECOM',
        'OFICIAL DE OPERACIONES',
        'ORGANO INTERNO DE CONTROL',
        'PINTOR',
        'PROMOTOR COMERCIAL',
        'PROMOTOR DE COMUNICACION',
        'PROMOTOR DE RUTAS',
        'RECEPCIONISTA',
        'SECRETARIO PARTICULAR',
        'SECRETARIO TECNICO',
        'SUBJEFE DE ESTACIONAMIENTO',
        'SUBJEFE DE IMPUESTOS',
        'SUBJEFE DE INFORMATICA',
        'SUBJEFE DE MANTENIMIENTO (EDIFICIOS)',
        'SUBJEFE DE MANTENIMIENTO (PLATAFORMA)',
        'SUBJEFE DE OPERACIONES Y SERVICIOS',
        'SUBJEFE DE SEGURIDAD',
        'SUBJEFE DE TESORERIA',
        'SUPERVISOR DE ESTACIONAMIENTO',
        'SUPERVISOR DE INFRAESTRUCTURA',
        'SUPERVISOR DE SMS',
        'TECNICO AMBIENTALISTA',
        'TECNICO EN MATENIMIENTO'
    ];

    const input = document.getElementById('puestoInput');
    const dropdown = document.getElementById('puestoDropdown');
    if (!input || !dropdown) return;

    let activeIndex = -1;

    function render(filtered, query) {
        dropdown.innerHTML = '';
        activeIndex = -1;

        if (filtered.length === 0) {
            dropdown.innerHTML = '<div class="ac-empty">Sin coincidencias — puedes escribir un puesto personalizado</div>';
            dropdown.classList.add('open');
            return;
        }

        filtered.forEach((p, i) => {
            const div = document.createElement('div');
            div.className = 'ac-item';
            // Highlight matching text
            if (query) {
                const re = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                div.innerHTML = p.replace(re, '<mark>$1</mark>');
            } else {
                div.textContent = p;
            }
            div.addEventListener('mousedown', (e) => {
                e.preventDefault();
                input.value = p;
                close();
            });
            dropdown.appendChild(div);
        });

        dropdown.classList.add('open');
    }

    function close() {
        dropdown.classList.remove('open');
        activeIndex = -1;
    }

    input.addEventListener('input', () => {
        const q = input.value.trim();
        if (q.length === 0) {
            close();
            return;
        }
        const filtered = puestos.filter(p => p.toLowerCase().includes(q.toLowerCase()));
        render(filtered, q);
    });

    input.addEventListener('focus', () => {
        if (input.value.trim().length > 0) {
            const filtered = puestos.filter(p => p.toLowerCase().includes(input.value.trim().toLowerCase()));
            render(filtered, input.value.trim());
        }
    });

    input.addEventListener('blur', () => {
        setTimeout(close, 150);
    });

    // Keyboard navigation
    input.addEventListener('keydown', (e) => {
        const items = dropdown.querySelectorAll('.ac-item');
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            activeIndex = Math.min(activeIndex + 1, items.length - 1);
            items.forEach(it => it.classList.remove('active'));
            items[activeIndex].classList.add('active');
            items[activeIndex].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            activeIndex = Math.max(activeIndex - 1, 0);
            items.forEach(it => it.classList.remove('active'));
            items[activeIndex].classList.add('active');
            items[activeIndex].scrollIntoView({ block: 'nearest' });
        } else if (e.key === 'Enter' && activeIndex >= 0) {
            e.preventDefault();
            input.value = items[activeIndex].textContent;
            close();
        } else if (e.key === 'Escape') {
            close();
        }
    });
})();
</script>
