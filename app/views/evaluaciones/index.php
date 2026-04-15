<div class="evaluations-header">
    <h2>Resultados de Evaluaciones</h2>
    <p>Visualiza, filtra y gestiona las respuestas de los colaboradores.</p>
</div>

<!-- Filter Bar -->
<div class="results-filter-bar glass-container">
    <div class="filter-group main-search">
        <span class="filter-icon">🔍</span>
        <input type="text" id="results-search" placeholder="Buscar por nombre, puesto o # empleado..." autocomplete="off">
        <button id="btn-results-search" class="btn-search" title="Buscar">Buscar</button>
    </div>

    <div class="filter-divider"></div>

    <div class="filter-group">
        <label>Coordinación</label>
        <select id="results-coordinacion">
            <option value="">Todas las áreas</option>
            <option value="ADMINISTRACION AEROPORTUARIA">ADMINISTRACION AEROPORTUARIA</option>
            <option value="COORDINACION ADMINISTRATIVA">COORDINACION ADMINISTRATIVA</option>
            <option value="COORDINACION DE PLANEACIÓN ESTRATÉGICA">COORDINACION DE PLANEACIÓN ESTRATÉGICA</option>
            <option value="COORDINACION JURIDICA">COORDINACION JURIDICA</option>
            <option value="DIRECCION GENERAL">DIRECCION GENERAL</option>
            <option value="DIRECCION COMERCIAL">DIRECCION COMERCIAL</option>
            <option value="ORGANO INTERNO DE CONTROL">ORGANO INTERNO DE CONTROL</option>
        </select>
    </div>

    <div class="filter-group">
        <label>Desde</label>
        <input type="date" id="results-date-start">
    </div>

    <div class="filter-group">
        <label>Hasta</label>
        <input type="date" id="results-date-end">
    </div>

    <div class="filter-actions">
        <button id="btn-results-reset" class="btn-icon-only" title="Limpiar Filtros">🔄</button>
    </div>
</div>

<div class="evaluation-grid-container">
    <div id="evaluationGrid" class="evaluation-grid">
        <?php if (empty($evaluaciones)): ?>
            <div id="emptyStatePlaceholder" class="empty-state glass-card" style="grid-column: 1/-1; padding: 3rem; text-align: center;">
                <p>Aún no hay evaluaciones registradas.</p>
            </div>
        <?php else: ?>
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
        <?php endif; ?>
    </div>
</div>

<!-- Custom Context Menu -->
<div id="contextMenu" class="context-menu" style="display:none;">
    <div class="context-menu-item delete-item" id="ctxDelete">
        <span class="ctx-icon">🗑️</span>
        <span>Eliminar Respuesta</span>
    </div>
</div>

<style>
.evaluations-header { margin-bottom: 2rem; }
.evaluations-header h2 { font-size: 1.8rem; color: var(--color-night); }
.evaluations-header p { color: #888; }

/* Filter Bar */
.results-filter-bar {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 2rem;
    margin-bottom: 2rem;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.4);
}
.results-filter-bar .filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}
.results-filter-bar .filter-group label {
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 700;
    color: var(--color-ice-blue);
    letter-spacing: 0.5px;
}
.results-filter-bar .filter-group input,
.results-filter-bar .filter-group select {
    border: 1px solid rgba(0,0,0,0.05);
    background: white;
    padding: 0.5rem 0.8rem;
    border-radius: 10px;
    font-family: inherit;
    font-size: 0.9rem;
    color: var(--color-night);
    min-width: 150px;
}
.results-filter-bar .main-search {
    flex: 1;
    position: relative;
    flex-direction: row !important;
    align-items: center;
    gap: 0.5rem;
}
.results-filter-bar .main-search input {
    width: 100%;
    padding-left: 2.5rem;
    font-size: 1rem;
}
.results-filter-bar .filter-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.5;
}
.results-filter-bar .filter-divider {
    width: 1px;
    height: 40px;
    background: rgba(0,0,0,0.05);
}
.results-filter-bar .btn-icon-only {
    background: white;
    border: 1px solid rgba(0,0,0,0.05);
    width: 40px;
    height: 40px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.results-filter-bar .btn-icon-only:hover {
    background: var(--color-ice-blue);
    transform: rotate(180deg);
}
.btn-search {
    padding: 0.5rem 1.2rem;
    background: var(--color-ice-blue);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-family: inherit;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}
.btn-search:hover {
    background: var(--color-night);
    transform: scale(1.03);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Grid */
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
    cursor: pointer;
    user-select: none;
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

/* Context Menu */
.context-menu {
    position: fixed;
    z-index: 5000;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.06);
    padding: 0.4rem;
    min-width: 200px;
    animation: ctxFadeIn 0.15s ease;
}
@keyframes ctxFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.context-menu-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--color-night);
    transition: all 0.15s;
}
.context-menu-item:hover {
    background: rgba(129, 161, 193, 0.1);
}
.context-menu-item.delete-item {
    color: #BF616A;
}
.context-menu-item.delete-item:hover {
    background: rgba(191, 97, 106, 0.1);
}
.ctx-icon {
    font-size: 1rem;
}

@media (max-width: 1024px) {
    .results-filter-bar {
        flex-wrap: wrap;
        padding: 1.5rem;
    }
    .results-filter-bar .filter-divider { display: none; }
    .results-filter-bar .main-search { min-width: 100%; }
    .results-filter-bar .filter-group { flex: 1; }
}
</style>
