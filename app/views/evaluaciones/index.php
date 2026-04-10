<div class="evaluaciones-view">
    <!-- Spotlight Search -->
    <div class="spotlight-search">
        <input type="text" id="spotlightInput" placeholder="Buscar por número de empleado o nombre..." autofocus>
    </div>

    <!-- KPI Neomorphic Grid -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <span class="icon">📈</span>
            <span class="value">0%</span>
            <span class="label">IGEO Global</span>
        </div>
        <div class="kpi-card">
            <span class="icon">🔍</span>
            <span class="value">0%</span>
            <span class="label">Claridad</span>
        </div>
        <div class="kpi-card">
            <span class="icon">🎭</span>
            <span class="value">0%</span>
            <span class="label">Cultura</span>
        </div>
        <div class="kpi-card">
            <span class="icon">👔</span>
            <span class="value">0%</span>
            <span class="label">Liderazgo</span>
        </div>
        <div class="kpi-card">
            <span class="icon">⚙️</span>
            <span class="value">0%</span>
            <span class="label">Operaciones</span>
        </div>
        <div class="kpi-card">
            <span class="icon">⭐</span>
            <span class="value">0%</span>
            <span class="label">Satisfacción</span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <table class="minimal-table">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Puesto</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>IGEO</th>
                </tr>
            </thead>
            <tbody id="evaluation-data">
                <!-- Data will be loaded via AJAX/Skeleton -->
                <tr>
                    <td><div class="skeleton" style="height: 20px; width: 120px;"></div></td>
                    <td><div class="skeleton" style="height: 20px; width: 80px;"></div></td>
                    <td><div class="skeleton" style="height: 20px; width: 100px;"></div></td>
                    <td><div class="skeleton" style="height: 20px; width: 70px;"></div></td>
                    <td><div class="skeleton" style="height: 20px; width: 40px;"></div></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="view-actions" style="margin-top: 2rem; text-align: right;">
        <a href="<?php echo URL_ROOT; ?>/export/download" class="btn-neo">
            📥 Exportar Reporte Final
        </a>
    </div>
</div>
