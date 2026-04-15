
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

    <!-- Intelligent Filter Bar -->
    <div class="dashboard-controls glass-container">
        <div class="filter-group main-search">
            <span class="filter-icon">🔍</span>
            <input type="text" id="filter-search" placeholder="Filtrar por nombre o empleado..." autocomplete="off">
        </div>
        
        <div class="filter-divider"></div>
        
        <div class="filter-group">
            <label>Coordinación</label>
            <select id="filter-coordinacion">
                <option value="">Todas las áreas</option>
                <option value="ADMINISTRACION AEROPORTUARIA">Admón. Aeroportuaria</option>
                <option value="COORDINACION ADMINISTRATIVA">Coordinación Administrativa</option>
                <option value="COORDINACION JURIDICA">Coordinación Jurídica</option>
                <option value="DIRECCION GENERAL">Dirección General</option>
                <option value="OPERACIONES">Operaciones</option>
            </select>
        </div>

        <div class="filter-group">
            <label>Desde</label>
            <input type="date" id="filter-date-start">
        </div>

        <div class="filter-group">
            <label>Hasta</label>
            <input type="date" id="filter-date-end">
        </div>

        <div class="filter-actions">
            <button id="btn-reset-filters" class="btn-icon-only" title="Limpiar Filtros">🔄</button>
        </div>
    </div>

    <style>
    .dashboard-controls {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1rem 2rem;
        margin-bottom: 2rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.4);
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .filter-group label {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        color: var(--color-ice-blue);
        letter-spacing: 0.5px;
    }
    .filter-group input, .filter-group select {
        border: 1px solid rgba(0,0,0,0.05);
        background: white;
        padding: 0.5rem 0.8rem;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--color-night);
        min-width: 150px;
    }
    .main-search {
        flex: 1;
        position: relative;
    }
    .main-search input {
        width: 100%;
        padding-left: 2.5rem;
        font-size: 1rem;
    }
    .filter-icon {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.5;
    }
    .filter-divider {
        width: 1px;
        height: 40px;
        background: rgba(0,0,0,0.05);
    }
    .btn-icon-only {
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
    .btn-icon-only:hover {
        background: var(--color-ice-blue);
        transform: rotate(180deg);
    }
    @media (max-width: 1024px) {
        .dashboard-controls {
            flex-wrap: wrap;
            padding: 1.5rem;
        }
        .filter-divider { display: none; }
        .main-search { min-width: 100%; }
        .filter-group { flex: 1; }
    }
    </style>

    <!-- Charts Grid -->
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

    <!-- Survey-specific Donut Charts -->
    <div class="charts-grid donut-grid">
        <div class="chart-card donut-card">
            <h4>Efectividad del Onboarding</h4>
            <div class="chart-container-donut">
                <canvas id="donutEfectividad"></canvas>
                <div class="donut-percentage" id="perc-efectividad">0%</div>
            </div>
        </div>
        <div class="chart-card donut-card">
            <h4>Integración a su Equipo</h4>
            <div class="chart-container-donut">
                <canvas id="donutIntegracion"></canvas>
                <div class="donut-percentage" id="perc-integracion">0%</div>
            </div>
        </div>
        <div class="chart-card donut-card">
            <h4>Claridad del Puesto</h4>
            <div class="chart-container-donut">
                <canvas id="donutClaridad"></canvas>
                <div class="donut-percentage" id="perc-claridad">0%</div>
            </div>
        </div>
        <div class="chart-card donut-card">
            <h4>Comprensión de la Organización</h4>
            <div class="chart-container-donut">
                <canvas id="donutComprension"></canvas>
                <div class="donut-percentage" id="perc-comprension">0%</div>
            </div>
        </div>
    </div>

    <style>
    .donut-grid {
        grid-template-columns: repeat(4, 1fr) !important;
        margin-top: 2rem;
    }
    .chart-container-donut {
        position: relative;
        height: 200px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .donut-percentage {
        position: absolute;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--color-night);
    }
    .donut-card {
        text-align: center;
    }
    @media (max-width: 1024px) {
        .donut-grid { grid-template-columns: repeat(2, 1fr) !important; }
    }
    </style>
