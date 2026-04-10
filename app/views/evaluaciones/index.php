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
        <!-- Quick Profile Modal (Hidden by default) -->
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

    <div class="view-actions" style="margin-top: 2rem; text-align: right;">
        <a href="<?php echo URL_ROOT; ?>/export/download" class="btn-neo">
            📥 Exportar Reporte Final
        </a>
    </div>
</div>
