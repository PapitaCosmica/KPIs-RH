/**
 * Charts Engine - Phase 6
 * Scandinavian Aesthetic & Real-time Update Logic
 */

let radarChart, lineChart, barChart;
let donutEfectividad, donutIntegracion, donutClaridad, donutComprension;

const scandiColors = {
    iceBlue: 'rgba(129, 161, 193, 0.7)',
    iceBlueSolid: 'rgba(129, 161, 193, 1)',
    slate: 'rgba(76, 86, 106, 0.7)',
    frost: 'rgba(236, 239, 244, 0.8)',
    success: '#81A1C1',
    warning: '#EBCB8B',
    danger: '#BF616A',
    // New Survey Branding Colors
    onbBlue: '#81A1C1',
    onbOrange: '#D08770',
    onbGreen: '#A3BE8C',
    onbPurple: '#B48EAD'
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
    const radarEl = document.getElementById('radarChart');
    const lineEl = document.getElementById('lineChart');
    const barEl = document.getElementById('barChart');

    // 1. Radar Chart
    if (radarEl) {
        const ctxRadar = radarEl.getContext('2d');
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
    }

    // 2. Line Chart
    if (lineEl) {
        const ctxLine = lineEl.getContext('2d');
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
    }

    // 3. Bar Chart
    if (barEl) {
        const ctxBar = barEl.getContext('2d');
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

    // 4. Donut Charts (Surveys)
    const donutSpecs = [
        { id: 'donutEfectividad', color: scandiColors.onbBlue },
        { id: 'donutIntegracion', color: scandiColors.onbOrange },
        { id: 'donutClaridad', color: scandiColors.onbGreen },
        { id: 'donutComprension', color: scandiColors.onbPurple }
    ];

    donutSpecs.forEach(spec => {
        const el = document.getElementById(spec.id);
        if (el) {
            const chart = new Chart(el.getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [0, 100],
                        backgroundColor: [spec.color, '#ECEFF4'],
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    plugins: { tooltip: { enabled: false } },
                    events: [],
                    animation: { duration: 1500, easing: 'easeOutQuart' }
                }
            });
            if (spec.id === 'donutEfectividad') donutEfectividad = chart;
            if (spec.id === 'donutIntegracion') donutIntegracion = chart;
            if (spec.id === 'donutClaridad') donutClaridad = chart;
            if (spec.id === 'donutComprension') donutComprension = chart;
        }
    });
}

/**
 * Main Sync Function called from search.js
 */
window.updateCharts = function(data) {
    console.log("Updating charts with data:", data); // Debug
    if (!radarChart || !lineChart || !barChart) {
        console.warn("Charts not initialized yet.");
        return;
    }

    // A. Radar Logic (Simplified by using pre-calculated scores)
    let dimAvgs = [0, 0, 0, 0, 0];
    if (data.length > 0) {
        const sums = [0, 0, 0, 0, 0];
        data.forEach(item => {
            // Ensure scores exist and handle key names carefully
            const s = item.scores || {};
            sums[0] += parseFloat(s['Claridad'] || 0);
            sums[1] += parseFloat(s['Cultura'] || 0);
            sums[2] += parseFloat(s['Liderazgo'] || 0);
            sums[3] += parseFloat(s['Operaciones'] || 0);
            sums[4] += parseFloat(s['Satisfacción'] || s['Satisfacción'] || 0);
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

    // D. Donut Charts Logic
    const newDonutStats = {
        'Efectividad_Onb': { chart: donutEfectividad, el: 'perc-efectividad' },
        'Integracion_Equipo': { chart: donutIntegracion, el: 'perc-integracion' },
        'Claridad_Puesto': { chart: donutClaridad, el: 'perc-claridad' },
        'Comprension_Org': { chart: donutComprension, el: 'perc-comprension' }
    };

    Object.keys(newDonutStats).forEach(key => {
        const spec = newDonutStats[key];
        if (!spec.chart) {
            console.warn(`Chart for ${key} not initialized`);
            return;
        }

        let avg = 0;
        if (data.length > 0) {
            const sum = data.reduce((acc, item) => {
                const s = item.scores || {};
                const val = parseFloat(s[key] || 0);
                return acc + val;
            }, 0);
            avg = Math.round(sum / data.length);
        }

        console.log(`Donut ${key} avg:`, avg); // Debug log

        spec.chart.data.datasets[0].data = [avg, Math.max(0, 100 - avg)];
        spec.chart.update();

        const labelEl = document.getElementById(spec.el);
        if (labelEl) labelEl.innerHTML = `${avg}%`;
    });
}
