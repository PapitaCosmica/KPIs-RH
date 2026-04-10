/**
 * Search & KPI Engine - Phase 5
 * Dynamic Asynchronous Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    const spotlightInput = document.getElementById('spotlightInput');
    const coordinacionSelect = document.getElementById('coordinacionSelect');
    const tableBody = document.getElementById('evaluation-data');

    // Debounce Helper
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Modern Fetch Search
    async function performSearch() {
        // Show loading state (Skeleton)
        tableBody.innerHTML = `
            <tr>
                <td><div class="skeleton" style="height: 20px; width: 120px;"></div></td>
                <td><div class="skeleton" style="height: 20px; width: 80px;"></div></td>
                <td><div class="skeleton" style="height: 20px; width: 100px;"></div></td>
                <td><div class="skeleton" style="height: 20px; width: 70px;"></div></td>
                <td><div class="skeleton" style="height: 20px; width: 40px;"></div></td>
            </tr>`;

        const query = spotlightInput.value;
        const coord = coordinacionSelect.value;
        
        // Use global URL_ROOT defined in layout.php
        const url = `${window.APP_URL}/apiSearch?nombre=${query}&coordinacion=${coord}`;

        try {
            const response = await fetch(url);
            const result = await response.json();

            if (result.status === 'success') {
                updateUI(result.data);
                // Phase 6: Sync Charts
                if (window.updateCharts) {
                    window.updateCharts(result.data);
                }
                // Check for exact match for Quick Profile
                if (result.data.length === 1 && query === result.data[0].num_empleado) {
                    showQuickProfile(result.data[0]);
                }
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            tableBody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Error al cargar datos.</td></tr>';
        }
    }

    // Dynamic UI Update
    function updateUI(data) {
        // 1. Update Table
        tableBody.innerHTML = '';
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No se encontraron resultados.</td></tr>';
            resetKPIs();
            return;
        }

        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="emp-info">
                        <span class="emp-name">${item.nombre}</span>
                        <span class="emp-id">#${item.num_empleado}</span>
                    </div>
                </td>
                <td>${item.puesto}</td>
                <td>${item.coordinacion}</td>
                <td>${item.fecha_ingreso}</td>
                <td><span class="badge ${getKPIClass(item.IGEO || 0)}">${item.IGEO || 'N/A'}%</span></td>
            `;
            tableBody.appendChild(row);
        });

        // 2. Update KPI Cards (Calculated from filtered data)
        updateKPIs(data);
    }

    function updateKPIs(data) {
        const dimensions = {
            claridad: ['m_claridad_rol', 'm_bienvenida_equipo', 'm_capacitacion', 'm_procesos', 'm_objetivos', 'm_calidad_induccion'],
            cultura: ['m_cultura', 'm_relacion_jefe', 'm_entorno_fisico', 'm_integracion_social', 'm_valores'],
            liderazgo: ['m_vision'],
            operaciones: ['m_herramientas'],
            satisfaccion: ['m_acceso_sistemas', 'm_beneficios', 'm_seguridad', 'm_soporte_rh', 'm_expectativas']
        };

        const totals = { igeo: 0, claridad: 0, cultura: 0, liderazgo: 0, operaciones: 0, satisfaccion: 0 };
        const count = data.length;

        data.forEach(item => {
            let itemTotal = 0;
            // Calculate item's IGEO if not provided by server
            Object.keys(dimensions).forEach(dim => {
                let dimSum = 0;
                dimensions[dim].forEach(field => dimSum += parseInt(item[field] || 0));
                const dimAvg = (dimSum / (dimensions[dim].length * 10)) * 100;
                totals[dim] += dimAvg;
                itemTotal += dimSum;
            });
            totals.igeo += (itemTotal / 180) * 100;
        });

        Object.keys(totals).forEach(key => {
            const avg = Math.round(totals[key] / count);
            const el = document.getElementById(`val-${key}`);
            if (el) {
                animateValue(el, parseInt(el.innerText), avg, 500);
            }
        });
    }

    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start) + "%";
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    function getKPIClass(val) {
        if (val >= 85) return 'kpi-green';
        if (val >= 70) return 'kpi-orange';
        return 'kpi-red';
    }

    function resetKPIs() {
        ['igeo', 'claridad', 'cultura', 'liderazgo', 'operaciones', 'satisfaccion'].forEach(id => {
            document.getElementById(`val-${id}`).innerText = "0%";
        });
    }

    function showQuickProfile(item) {
        const modal = document.getElementById('quickProfile');
        const content = document.getElementById('profileContent');
        
        content.innerHTML = `
            <div class="profile-meta">
                <p><strong>Puesto:</strong> ${item.puesto}</p>
                <p><strong>Coordinación:</strong> ${item.coordinacion}</p>
                <p><strong>Ingreso:</strong> ${item.fecha_ingreso}</p>
            </div>
            <hr>
            <h4>Respuestas Cualitativas</h4>
            <div class="qualitative-grid">
                <div class="q-item"><h5>Sugerencias</h5><p>${item.f_sugerencias_mejora || 'N/A'}</p></div>
                <div class="q-item"><h5>Obstáculos</h5><p>${item.f_obstaculos || 'N/A'}</p></div>
                <div class="q-item"><h5>Lo Mejor</h5><p>${item.f_lo_mejor || 'N/A'}</p></div>
                <div class="q-item"><h5>Lo Peor</h5><p>${item.f_lo_peor || 'N/A'}</p></div>
                <div class="q-item"><h5>Gral.</h5><p>${item.f_comentarios_generales || 'N/A'}</p></div>
            </div>
        `;
        
        modal.style.display = 'block';
    }

    // Listeners
    spotlightInput.addEventListener('input', debounce(performSearch, 300));
    coordinacionSelect.addEventListener('change', performSearch);

    // Initial load
    performSearch();
});
