/**
 * Spotlight Search & KPI Engine - v1.3.0
 * Global Search & macOS Integration
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. GLOBAL SPOTLIGHT LOGIC
    const globalSpotlightInput = document.getElementById('globalSpotlightInput');
    const spotlightResults = document.getElementById('spotlightResults');
    const spotlightOverlay = document.getElementById('spotlightOverlay');

    if (globalSpotlightInput) {
        globalSpotlightInput.addEventListener('input', debounce(async () => {
            const query = globalSpotlightInput.value.trim();
            if (query.length < 2) {
                spotlightResults.innerHTML = '';
                return;
            }

            try {
                const response = await fetch(`${window.APP_URL}?url=apiSearch&global=${encodeURIComponent(query)}`);
                const result = await response.json();

                if (result.status === 'success') {
                    renderSpotlightResults(result.data, query);
                }
            } catch (err) {
                console.error('Spotlight Error:', err);
            }
        }, 300));
    }

    function renderSpotlightResults(data, query) {
        spotlightResults.innerHTML = '';
        if (data.length === 0) {
            spotlightResults.innerHTML = '<p style="padding: 2rem; text-align:center; color:#999;">No hay coincidencias en el sistema.</p>';
            return;
        }

        data.forEach(item => {
            // Check where the match was found for categorization
            let category = 'Colaborador';
            let icon = '👤';
            let subtitle = `${item.puesto} | ${item.coordinacion}`;

            // Logic to identify if it was a feedback match
            const feedbackFields = {
                f_logros: 'Logros',
                f_mejoras_proceso: 'Sugerencia de Mejora',
                f_comentarios_libres: 'Comentario'
            };

            for (let [field, label] of Object.entries(feedbackFields)) {
                if (item[field] && item[field].toLowerCase().includes(query.toLowerCase())) {
                    category = 'Feedback';
                    icon = '💬';
                    subtitle = `Respuesta: "${item[field].substring(0, 60)}..."`;
                    break;
                }
            }

            const div = document.createElement('div');
            div.className = 'spotlight-item';
            div.innerHTML = `
                <span class="item-icon">${icon}</span>
                <div class="item-info">
                    <span class="item-title">${item.nombre}</span>
                    <span class="item-subtitle">${subtitle}</span>
                </div>
                <span class="item-category">${category}</span>
            `;
            
            div.onclick = () => {
                window.location.href = `${window.APP_URL}?url=evaluaciones&highlight=${item.num_empleado}`;
            };
            
            spotlightResults.appendChild(div);
        });
    }

    // 2. DASHBOARD KPI UPDATE (AJAX)
    async function loadDashboardKPIs() {
        try {
            const response = await fetch(`${window.APP_URL}?url=apiSearch`);
            const result = await response.json();
            if (result.status === 'success') {
                updateKPIStats(result.data);
                if (window.updateCharts) window.updateCharts(result.data);
            }
        } catch (err) {
            console.error('KPI Update Error:', err);
        }
    }

    function updateKPIStats(data) {
        if (!data || data.length === 0) {
            // Reset to 0 if no data
            ['igeo', 'claridad', 'cultura', 'liderazgo', 'operaciones', 'satisfaccion'].forEach(key => {
                const el = document.getElementById(`val-${key}`);
                if (el) el.innerHTML = "0%";
            });
            return;
        }

        const totals = { igeo: 0, claridad: 0, cultura: 0, liderazgo: 0, operaciones: 0, satisfaccion: 0 };

        data.forEach(item => {
            if (item.scores) {
                totals.igeo += parseFloat(item.IGEO || 0);
                totals.claridad += parseFloat(item.scores['Claridad'] || 0);
                totals.cultura += parseFloat(item.scores['Cultura'] || 0);
                totals.liderazgo += parseFloat(item.scores['Liderazgo'] || 0);
                totals.operaciones += parseFloat(item.scores['Operaciones'] || 0);
                totals.satisfaccion += parseFloat(item.scores['Satisfacción'] || 0);
            }
        });

        Object.keys(totals).forEach(key => {
            const avg = Math.round(totals[key] / data.length);
            const el = document.getElementById(`val-${key}`);
            if (el) animateValue(el, parseInt(el.innerHTML) || 0, avg, 800);
        });
    }

    // UTILITIES
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start) + "%";
            if (progress < 1) window.requestAnimationFrame(step);
        };
        window.requestAnimationFrame(step);
    }

    // Initial load for Home Dashboard
    if (document.getElementById('val-igeo')) {
        loadDashboardKPIs();
    }
});
