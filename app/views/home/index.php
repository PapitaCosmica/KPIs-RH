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
