    <!-- Spotlight Search & Filters -->
    <div class="search-controls">
        <div class="spotlight-search">
            <input type="text" id="spotlightInput" placeholder="Buscar por número de empleado o nombre..." autofocus>
        </div>
        <div class="secondary-filters">
            <select id="coordinacionSelect" class="btn-neo">
                <option value="">Todas las Áreas</option>
                <option value="Operaciones">Operaciones</option>
                <option value="Sistemas">Sistemas</option>
                <option value="Recursos Humanos">Recursos Humanos</option>
            </select>
        </div>
    </div>

    <!-- KPI Neomorphic Grid -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <span class="icon">📈</span>
            <span class="value" id="val-igeo">0%</span>
            <span class="label">IGEO Global</span>
        </div>
        <div class="kpi-card">
            <span class="icon">🔍</span>
            <span class="value" id="val-claridad">0%</span>
            <span class="label">Claridad</span>
        </div>
        <div class="kpi-card">
            <span class="icon">🎭</span>
            <span class="value" id="val-cultura">0%</span>
            <span class="label">Cultura</span>
        </div>
        <div class="kpi-card">
            <span class="icon">👔</span>
            <span class="value" id="val-liderazgo">0%</span>
            <span class="label">Liderazgo</span>
        </div>
        <div class="kpi-card">
            <span class="icon">⚙️</span>
            <span class="value" id="val-operaciones">0%</span>
            <span class="label">Operaciones</span>
        </div>
        <div class="kpi-card">
            <span class="icon">⭐</span>
            <span class="value" id="val-satisfaccion">0%</span>
            <span class="label">Satisfacción</span>
        </div>
    </div>

    <!-- Charts Grid (Phase 6) -->
    <div class="charts-grid">
        <div class="chart-card table-card">
            <h4>Dimensiones Onboarding</h4>
            <canvas id="radarChart"></canvas>
        </div>
        <div class="chart-card table-card">
            <h4>Evolución IGEO</h4>
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-card table-card">
            <h4>KPI por Coordinación</h4>
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Table Card -->
    <div class="evaluation-grid-container" style="margin-top: 2rem;">
    <div id="evaluationGrid" class="evaluation-grid">
        <?php foreach ($evaluaciones as $eval): 
            $scores = (new \App\Models\Evaluation())->calculateScores($eval);
            $igeo = $scores['IGEO'];
            $color = $igeo >= 80 ? '#4CAF50' : ($igeo >= 60 ? '#FFC107' : '#F44336');
        ?>
            <div class="evaluation-card glass-card ripple">
                <div class="card-header">
                    <span class="coordination-tag"><?php echo $eval['coordinacion']; ?></span>
                    <div class="igeo-badge" style="background: <?php echo $color; ?>22; color: <?php echo $color; ?>;">
                        <?php echo $igeo; ?>%
                    </div>
                </div>
                <div class="card-body">
                    <h3><?php echo $eval['nombre']; ?></h3>
                    <p class="puesto-text"><?php echo $eval['puesto']; ?></p>
                    <p class="date-text">📅 <?php echo date('d/m/Y', strtotime($eval['fecha_ingreso'])); ?></p>
                </div>
                <div class="card-footer">
                    <button class="btn-text">Ver Detalles →</button>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- The "+" Card -->
        <a href="<?php echo URL_ROOT; ?>?url=survey" class="add-evaluation-card ripple" title="Nueva Evaluación">
            <div class="plus-icon">+</div>
            <span>Nueva Evaluación</span>
        </a>
    </div>
</div>

<style>
.evaluation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

.evaluation-card {
    display: flex;
    flex-direction: column;
    padding: 1.5rem;
    position: relative;
    border: 1px solid rgba(255,255,255,0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.evaluation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.coordination-tag {
    font-size: 0.75rem;
    padding: 2px 10px;
    background: #f0f4f8;
    border-radius: 20px;
    color: var(--color-deep-slate);
}

.igeo-badge {
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 10px;
}

.card-body h3 {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: var(--color-night);
}

.puesto-text {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
}

.date-text {
    font-size: 0.8rem;
    color: #999;
}

.card-footer {
    margin-top: auto;
    padding-top: 1rem;
    text-align: right;
}

.btn-text {
    background: none;
    border: none;
    color: var(--color-ice-blue);
    font-weight: 600;
    cursor: pointer;
}

/* Add Card Style */
.add-evaluation-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 2px dashed rgba(129, 161, 193, 0.4);
    border-radius: 20px;
    background: rgba(129, 161, 193, 0.05);
    text-decoration: none;
    min-height: 200px;
    transition: all 0.3s ease;
}

.add-evaluation-card:hover {
    background: rgba(129, 161, 193, 0.1);
    border-color: var(--color-ice-blue);
}

.plus-icon {
    font-size: 3rem;
    color: var(--color-ice-blue);
    margin-bottom: 0.5rem;
}

.add-evaluation-card span {
    color: var(--color-ice-blue);
    font-weight: 600;
}
</style>
    <div id="quickProfile" class="quick-profile glass-card" style="display:none; position: fixed; top: 10%; left: 50%; transform: translateX(-50%); width: 80%; max-width: 800px; z-index: 1000; max-height: 80vh; overflow-y: auto;">
        <div class="profile-header">
            <h3>Perfil del Colaborador</h3>
            <button onclick="document.getElementById('quickProfile').style.display='none'" class="btn-close">×</button>
        </div>
        <div id="profileContent" class="profile-body">
            <!-- Details will be injected here -->
        </div>
    </div>
</div>

    <div class="view-actions" style="margin-top: 2rem; display: flex; justify-content: flex-end; gap: 1rem;">
        <button id="btnShareSurvey" class="btn-neo" style="background: var(--color-ice-blue); color: white;">
            🔗 Compartir Encuesta
        </button>
        <a href="<?php echo URL_ROOT; ?>?url=export/download" class="btn-neo">
            📥 Exportar Reporte Final
        </a>
    </div>
</div>

<script>
document.getElementById('btnShareSurvey').addEventListener('click', () => {
    const surveyUrl = window.APP_URL + '?url=survey';
    navigator.clipboard.writeText(surveyUrl).then(() => {
        alert('Enlace de la encuesta copiado al portapapeles: ' + surveyUrl);
    }).catch(err => {
        console.error('Error al copiar el enlace:', err);
    });
});
</script>
