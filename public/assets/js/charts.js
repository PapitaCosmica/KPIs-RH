/**
 * Charts Engine - Phase 6
 * Scandinavian Aesthetic & Real-time Update Logic
 */

let radarChart, lineChart, barChart;

const scandiColors = {
    iceBlue: 'rgba(129, 161, 193, 0.7)',
    iceBlueSolid: 'rgba(129, 161, 193, 1)',
    slate: 'rgba(76, 86, 106, 0.7)',
    frost: 'rgba(236, 239, 244, 0.8)',
    success: '#81A1C1',
    warning: '#EBCB8B',
    danger: '#BF616A'
};

document.addEventListener('DOMContentLoaded', () => {
    // Global Configuration
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#4C566A';
    Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(255, 255, 255, 0.8)';
    Chart.defaults.plugins.tooltip.titleColor = '#2E3440';
    Chart.defaults.plugins.tooltip.bodyColor = '#4C566A';
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.cornerRadius = 12;
    Chart.defaults.plugins.tooltip.displayColors = false;
    Chart.defaults.plugins.tooltip.borderColor = 'rgba(0,0,0,0.05)';
    Chart.defaults.plugins.tooltip.borderWidth = 1;

    initCharts();
});

function initCharts() {
    // 1. Radar Chart
    const ctxRadar = document.getElementById('radarChart').getContext('2d');
    radarChart = new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: ['Claridad', 'Cultura', 'Liderazgo', 'Operaciones', 'Satisfacción'],
            datasets: [{
                label: 'Dimensiones',
                data: [0, 0, 0, 0, 0],
                backgroundColor: scandiColors.iceBlue,
                borderColor: scandiColors.iceBlueSolid,
                pointBackgroundColor: scandiColors.iceBlueSolid,
                fill: true
            }]
        },
        options: {
            scales: {
                r: { min: 0, max: 100, ticks: { display: false }, grid: { color: 'rgba(0,0,0,0.05)' } }
            },
            animation: { duration: 1500, easing: 'easeOutQuart' }
        }
    });

    // 2. Line Chart
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'IGEO Promedio',
                data: [],
                borderColor: scandiColors.iceBlueSolid,
                backgroundColor: 'transparent',
                tension: 0.4,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            scales: {
                y: { min: 0, max: 100, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // 3. Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Desempeño por Área',
                data: [],
                backgroundColor: scandiColors.iceBlue,
                borderRadius: 8
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { min: 0, max: 100, grid: { display: false } },
                y: { grid: { display: false } }
            }
        }
    });
}

/**
 * Main Sync Function called from search.js
 */
window.updateCharts = function(data) {
    if (!radarChart || !lineChart || !barChart) return;

    // A. Radar Logic
    const dimensions = {
        claridad: ['m_claridad_rol', 'm_bienvenida_equipo', 'm_capacitacion', 'm_procesos', 'm_objetivos', 'm_calidad_induccion'],
        cultura: ['m_cultura', 'm_relacion_jefe', 'm_entorno_fisico', 'm_integracion_social', 'm_valores'],
        liderazgo: ['m_vision'],
        operaciones: ['m_herramientas'],
        satisfaccion: ['m_acceso_sistemas', 'm_beneficios', 'm_seguridad', 'm_soporte_rh', 'm_expectativas']
    };

    let dimAvgs = [0, 0, 0, 0, 0];
    if (data.length > 0) {
        const sums = [0, 0, 0, 0, 0];
        data.forEach(item => {
            Object.keys(dimensions).forEach((dim, i) => {
                let s = 0;
                dimensions[dim].forEach(f => s += parseInt(item[f] || 0));
                sums[i] += (s / (dimensions[dim].length * 10)) * 100;
            });
        });
        dimAvgs = sums.map(s => Math.round(s / data.length));
    }
    radarChart.data.datasets[0].data = dimAvgs;
    radarChart.update();

    // B. Line Chart (Evolution)
    const timeData = {};
    data.forEach(item => {
        const date = item.fecha_ingreso;
        if (!timeData[date]) timeData[date] = { sum: 0, count: 0 };
        timeData[date].sum += parseFloat(item.IGEO || 0);
        timeData[date].count++;
    });
    const sortedDates = Object.keys(timeData).sort();
    lineChart.data.labels = sortedDates;
    lineChart.data.datasets[0].data = sortedDates.map(d => Math.round(timeData[d].sum / timeData[d].count));
    lineChart.update();

    // C. Bar Chart (Comparative)
    const areaData = {};
    data.forEach(item => {
        const area = item.coordinacion || 'S/A';
        if (!areaData[area]) areaData[area] = { sum: 0, count: 0 };
        areaData[area].sum += parseFloat(item.IGEO || 0);
        areaData[area].count++;
    });
    const areas = Object.keys(areaData);
    barChart.data.labels = areas;
    barChart.data.datasets[0].data = areas.map(a => Math.round(areaData[a].sum / areaData[a].count));
    barChart.update();
}
