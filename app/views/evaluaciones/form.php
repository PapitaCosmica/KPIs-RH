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
                <div class="input-group">
                    <label>Puesto de Trabajo *</label>
                    <input type="text" name="puesto" required placeholder="Tu cargo actual">
                </div>
                <div class="input-group">
                    <label>Coordinación *</label>
                    <select name="coordinacion" required>
                        <option value="">Selecciona...</option>
                        <option value="ADMINISTRACION AEROPORTUARIA">Admón. Aeroportuaria</option>
                        <option value="COORDINACION ADMINISTRATIVA">Coordinación Administrativa</option>
                        <option value="COORDINACION JURIDICA">Coordinación Jurídica</option>
                        <option value="DIRECCION GENERAL">Dirección General</option>
                        <option value="OPERACIONES">Operaciones</option>
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

        <!-- Section 2: Métricas Cuantitativas -->
        <div class="form-section glass-card">
            <h3>2. Evaluación de Adaptación (Escala 1 al 10)</h3>
            <p class="section-desc">Donde 1 es "Muy Insatisfecho" y 10 es "Excelente Experiencia".</p>
            
            <div class="metrics-list">
                <?php 
                $questions = [
                    'm_claridad_expectativas' => '1. ¿Qué tan claro tienes lo que se espera de ti en tu puesto?',
                    'm_seguridad_responsabilidades' => '2. ¿Qué tan seguro(a) te sientes al ejecutar tus responsabilidades?',
                    'm_preparacion_capacitacion' => '3. ¿La capacitación recibida te preparó para los retos del puesto?',
                    'm_efectividad_onboarding' => '4. ¿Qué tan preparado te sientes para realizar tus actividades de manera independiente?',
                    'm_contribucion_resultados' => '5. ¿Qué tan bien comprendes cómo tu trabajo contribuye a los resultados?',
                    'm_integracion_equipo' => '6. ¿Qué tan integrado(a) te sientes en tu equipo de trabajo?',
                    'm_experiencia_colaboracion' => '7. ¿Qué tan positiva ha sido tu experiencia de colaboración?',
                    'm_accesibilidad_jefe' => '8. ¿Qué tan accesible y disponible ha sido tu Jefe Inmediato?',
                    'm_retroalimentacion_jefe' => '9. ¿Recibes retroalimentación constructiva de tu líder?',
                    'm_conocimiento_cultura' => '10. ¿Qué tanto conoces la misión y valores del aeropuerto?',
                    'm_alineacion_valores' => '11. ¿Te sientes alineado(a) con la cultura institucional?',
                    'm_organizacion_induccion' => '12. ¿Cómo calificas la organización de tu primer día?',
                    'm_herramientas_trabajo' => '13. ¿Recibiste las herramientas necesarias (PC, Accesos)?',
                    'm_espacio_fisico' => '14. ¿Tu espacio físico de trabajo es adecuado y funcional?',
                    'm_atencion_rh' => '15. ¿Cómo calificas la atención de Recursos Humanos?',
                    'm_paquete_beneficios' => '16. ¿Conoces y estás satisfecho con tu paquete de prestaciones?',
                    'm_percepcion_imagen' => '17. ¿Qué imagen tienes del aeropuerto como empleador?'
                ];
                foreach ($questions as $id => $q): ?>
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

        <!-- Section 3: Feedback Cualitativo -->
        <div class="form-section glass-card">
            <h3>3. Experiencia y Sugerencias</h3>
            <div class="feedback-list">
                <div class="input-group">
                    <label>18. ¿Qué cuáles han sido tus mayores logros en este periodo? *</label>
                    <textarea name="f_logros" required placeholder="Cuéntanos tus éxitos..."></textarea>
                </div>
                <div class="input-group">
                    <label>19. ¿Las capacitaciones fueron útiles para tu integración? *</label>
                    <textarea name="f_utilidad_capacitaciones" required></textarea>
                </div>
                <div class="input-group">
                    <label>20. ¿Qué faltó para conocer mejor tus actividades? *</label>
                    <textarea name="f_faltantes_actividades" required></textarea>
                </div>
                <div class="input-group">
                    <label>21. ¿Cómo calificas el tiempo total de onboarding? *</label>
                    <textarea name="f_tiempo_onboarding" required></textarea>
                </div>
                <div class="input-group">
                    <label>22. ¿Qué tan satisfecho estás con tu decisión de integrarte? *</label>
                    <textarea name="f_satisfaccion_decision" required></textarea>
                </div>
                <div class="input-group">
                    <label>23. ¿Qué mejorarías del proceso de Onboarding? *</label>
                    <textarea name="f_mejoras_proceso" required></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-neo btn-primary">Enviar Evaluación Final</button>
        </div>
    </form>
</div>

<style>
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

<script>
document.getElementById('fullSurveyForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Check for invalid fields manually to give better feedback
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
    formData.append('is_ajax', 'true');
    
    try {
        const response = await fetch('<?php echo URL_ROOT; ?>?url=survey/store', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        
        if (result.status === 'success') {
            alert('¡Gracias! Tu evaluación ha sido enviada correctamente.');
            window.location.href = '<?php echo URL_ROOT; ?>?url=survey/thanks';
        } else {
            alert('Error: ' + result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Ocurrió un error al enviar el formulario.');
    }
});
</script>
