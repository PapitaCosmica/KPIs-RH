<div class="survey-container">
    <div class="survey-header">
        <h1>Encuesta de Onboarding</h1>
        <p>Tu opinión es fundamental para mejorar nuestra experiencia de integración.</p>
    </div>

    <form id="onboardingForm" class="glass-card survey-form">
        <!-- Part 1: General Info -->
        <div class="form-section">
            <h3>Información General</h3>
            <div class="form-group-grid">
                <input type="text" name="num_empleado" id="num_empleado" placeholder="Número de Empleado" required>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre Completo" required>
                <input type="text" name="puesto" id="puesto" placeholder="Puesto" required>
                <select name="coordinacion" id="coordinacion" required>
                    <option value="">Selecciona tu Coordinación</option>
                    <option value="Operaciones">Operaciones</option>
                    <option value="Sistemas">Sistemas</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                </select>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso" required>
            </div>
        </div>

        <!-- Part 2: Metrics (Simplified for display) -->
        <div class="form-section">
            <h3>Evaluación (Escala 1 al 10)</h3>
            <div class="metrics-grid">
                <!-- We'll add a few examples, in a real app all 18 would be here -->
                <div class="metric-item">
                    <label>¿Tienes claro tu rol y responsabilidades?</label>
                    <input type="number" name="m_claridad_rol" min="1" max="10" required>
                </div>
                <div class="metric-item">
                    <label>¿Recibiste herramientas necesarias (PC, Accesos, etc)?</label>
                    <input type="number" name="m_herramientas" min="1" max="10" required>
                </div>
                <!-- ... other metrics ... -->
            </div>
        </div>

        <!-- Part 3: Qualitative Feedback -->
        <div class="form-section">
            <h3>Tu Feedback Sugerencias</h3>
            <textarea name="f_comentarios_generales" placeholder="¿Cómo calificarías tu experiencia general hasta ahora?"></textarea>
            <textarea name="f_lo_mejor" placeholder="¿Qué es lo que más te ha gustado?"></textarea>
            <textarea name="f_obstaculos" placeholder="¿Has tenido algún obstáculo?"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-neo">Enviar Evaluación</button>
        </div>
    </form>
</div>

<style>
.isolated-mode .main-content {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem;
    background: var(--color-frost);
}

.survey-container {
    max-width: 800px;
    width: 100%;
    margin-top: 2rem;
}

.survey-header {
    text-align: center;
    margin-bottom: 2rem;
}

.survey-header h1 {
    font-size: 2rem;
    color: var(--color-night);
    margin-bottom: 0.5rem;
}

.form-section {
    margin-bottom: 2.5rem;
}

.form-section h3 {
    margin-bottom: 1.5rem;
    color: var(--color-ice-blue);
    font-size: 1.1rem;
    border-bottom: 2px solid var(--color-frost);
    padding-bottom: 0.5rem;
}

.form-group-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.survey-form input, .survey-form select, .survey-form textarea {
    width: 100%;
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.05);
    background: white;
}

.metrics-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
}

.metric-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fcfcfc;
    padding: 1rem;
    border-radius: 10px;
}

.metric-item input {
    width: 60px;
    text-align: center;
}

.form-actions {
    text-align: center;
    margin-top: 2rem;
}

@media (max-width: 600px) {
    .form-group-grid {
        grid-template-columns: 1fr;
    }
}
</style>
