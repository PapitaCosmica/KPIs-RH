<div class="evaluations-header">
    <h2>Listado de Evaluaciones</h2>
    <p>Gestiona y visualiza el progreso individual de cada colaborador.</p>
</div>

<div class="evaluation-grid-container">
    <div id="evaluationGrid" class="evaluation-grid">
        <?php if (empty($evaluaciones)): ?>
            <div id="emptyStatePlaceholder" class="empty-state glass-card" style="grid-column: 1/-1; padding: 3rem; text-align: center;">
                <p>Aún no hay evaluaciones registradas. ¡Crea la primera!</p>
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

        <!-- The "+" Card -->
        <a href="<?php echo URL_ROOT; ?>?url=survey" class="add-evaluation-card ripple" title="Nueva Evaluación">
            <div class="plus-icon">+</div>
            <span>Nueva Evaluación</span>
        </a>
    </div>
</div>

<style>
.evaluations-header { margin-bottom: 2rem; }
.evaluations-header h2 { font-size: 1.8rem; color: var(--color-night); }
.evaluations-header p { color: #888; }

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

.add-evaluation-card:hover { border-color: var(--color-ice-blue); background: rgba(129, 161, 193, 0.1); }
.plus-icon { font-size: 3rem; color: var(--color-ice-blue); margin-bottom: 0.5rem; }
.add-evaluation-card span { color: var(--color-ice-blue); font-weight: 600; }
</style>
