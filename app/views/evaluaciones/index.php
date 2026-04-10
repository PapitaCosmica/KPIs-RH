<div class="evaluaciones-container">
    <div class="view-header">
        <div class="title-group">
            <h1>Evaluaciones de Onboarding</h1>
            <p>Visualización y reporte de resultados por dimensión.</p>
        </div>
        <div class="action-group">
            <a href="<?php echo URL_ROOT; ?>/export/download" class="btn btn-primary glass-btn">
                <i class="icon-excel"></i> Exportar a Excel
            </a>
        </div>
    </div>

    <!-- Search / Filter Bar (Scandinavian Design) -->
    <div class="search-bar glass-card">
        <form id="searchForm" class="filter-grid">
            <div class="filter-item">
                <label for="num_empleado">Num. Empleado</label>
                <input type="text" id="num_empleado" name="num_empleado" placeholder="Ejem: 12345">
            </div>
            <div class="filter-item">
                <label for="nombre">Nombre del Empleado</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ejem: Juan Pérez">
            </div>
            <div class="filter-item">
                <label for="coordinacion">Coordinación</label>
                <select id="coordinacion" name="coordinacion">
                    <option value="">Todas las Áreas</option>
                    <option value="Operaciones">Operaciones</option>
                    <option value="Sistemas">Sistemas</option>
                    <option value="Recursos Humanos">Recursos Humanos</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-outline">Filtrar</button>
            </div>
        </form>
    </div>

    <!-- Minimalist Table -->
    <div class="table-container glass-card">
        <table class="minimal-table">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Puesto</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>IGEO</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="evaluation-data">
                <!-- Data injected via AJAX or PHP Loop -->
                <tr>
                    <td>
                        <div class="emp-info">
                            <span class="emp-name">Demo Empleado</span>
                            <span class="emp-id">#00000</span>
                        </div>
                    </td>
                    <td>Analista</td>
                    <td>Sistemas</td>
                    <td>2024-04-10</td>
                    <td><span class="badge kpi-green">95%</span></td>
                    <td><span class="status-dot active"></span> Activo</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
