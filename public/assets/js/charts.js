/**
 * Charts Engine - v1.7.1
 * CRITICAL FIX: All charts now RECALCULATE scores from raw data
 * instead of reading stale pre-calculated scores from Firestore.
 */

let radarChart, lineChart, barChart;
let donutEfectividad, donutIntegracion, donutClaridad, donutComprension;

const scandiColors = {
    iceBlue: 'rgba(129, 161, 193, 0.7)',
    iceBlueSolid: 'rgba(129, 161, 193, 1)',
    slate: 'rgba(76, 86, 106, 0.7)',
    frost: 'rgba(236, 239, 244, 0.8)',
    onbBlue: '#81A1C1',
    onbOrange: '#D08770',
    onbGreen: '#A3BE8C',
    onbPurple: '#B48EAD'
};

/**
 * SINGLE SOURCE OF TRUTH for score calculation.
 * Attached to window for search.js to consume.
 */
window.calcScores = function(source) {
    if (!source) return { IGEO: 0, Efectividad_Onb: 0, Integracion_Equipo: 0, Claridad_Puesto: 0, Comprension_Org: 0 };

    const dimensions = {
        'Efectividad_Onb': ['m_preparacion_capacitacion', 'm_atencion_rh', 'm_paquete_beneficios', 'm_percepcion_imagen', 'm_satisfaccion_decision'],
        'Integracion_Equipo': ['m_contribucion_resultados', 'm_integracion_equipo', 'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe'],
        'Claridad_Puesto': ['m_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion', 'm_efectividad_onboarding'],
        'Comprension_Org': ['m_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion', 'm_herramientas_trabajo', 'm_espacio_fisico']
    };

    const results = {};
    const dimValues = [];
    
    for (const [name, fields] of Object.entries(dimensions)) {
        let sum = 0;
        let answeredFields = 0;
        fields.forEach(f => { 
            const val = parseInt(source[f]);
            if (!isNaN(val)) {
                sum += val;
                answeredFields++;
            }
        });
        
        // Resilience: divide by actually answered fields or total fields (keep consistency with Excel)
        // Excel assumes 1-10, so missing = 0.
        const dimAvg = (sum / (fields.length * 10)) * 100;
        results[name] = Math.round(dimAvg);
        dimValues.push(dimAvg);
    }

    // IGEO in Excel is the average of the 4 dimension scores
    const globalAvg = dimValues.reduce((a, b) => a + b, 0) / dimValues.length;
    results['IGEO'] = Math.round(globalAvg);

    return results;
};

document.addEventListener('DOMContentLoaded', () => {
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

    if (radarEl) {
        radarChart = new Chart(radarEl.getContext('2d'), {
            type: 'radar',
            data: {
                labels: ['Claridad', 'Integración', 'Comprensión', 'Efectividad'],
                datasets: [{
                    label: 'Dimensiones',
                    data: [0, 0, 0, 0],
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

    if (lineEl) {
        lineChart = new Chart(lineEl.getContext('2d'), {
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

    if (barEl) {
        barChart = new Chart(barEl.getContext('2d'), {
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
 * CRITICAL: Recalculates ALL scores from raw fields instead of using
 * stale pre-calculated item.scores from Firestore.
 */
window.updateCharts = function(data) {
    if (!radarChart || !lineChart || !barChart) return;

    // Filter out broken records (no real metric data)
    const validData = data.filter(item => {
        const sc = calcScores(item);
        return sc.IGEO > 0;
    });

    // A. Radar Chart — recalculate from raw fields
    let dimAvgs = [0, 0, 0, 0];
    if (validData.length > 0) {
        const sums = { Claridad_Puesto: 0, Integracion_Equipo: 0, Comprension_Org: 0, Efectividad_Onb: 0 };
        validData.forEach(item => {
            const sc = calcScores(item);
            sums.Claridad_Puesto += sc.Claridad_Puesto;
            sums.Integracion_Equipo += sc.Integracion_Equipo;
            sums.Comprension_Org += sc.Comprension_Org;
            sums.Efectividad_Onb += sc.Efectividad_Onb;
        });
        dimAvgs = [
            Math.round(sums.Claridad_Puesto / validData.length),
            Math.round(sums.Integracion_Equipo / validData.length),
            Math.round(sums.Comprension_Org / validData.length),
            Math.round(sums.Efectividad_Onb / validData.length)
        ];
    }
    radarChart.data.datasets[0].data = dimAvgs;
    radarChart.update();

    // B. Line Chart — recalculate IGEO from raw fields
    const timeData = {};
    validData.forEach(item => {
        const date = item.fecha_ingreso || 'Sin fecha';
        const sc = calcScores(item);
        if (!timeData[date]) timeData[date] = { sum: 0, count: 0 };
        timeData[date].sum += sc.IGEO;
        timeData[date].count++;
    });
    const sortedDates = Object.keys(timeData).sort();
    lineChart.data.labels = sortedDates;
    lineChart.data.datasets[0].data = sortedDates.map(d => Math.round(timeData[d].sum / timeData[d].count));
    lineChart.update();

    // C. Bar Chart — recalculate IGEO from raw fields
    const areaData = {};
    validData.forEach(item => {
        const area = item.coordinacion || 'S/A';
        const sc = calcScores(item);
        if (!areaData[area]) areaData[area] = { sum: 0, count: 0 };
        areaData[area].sum += sc.IGEO;
        areaData[area].count++;
    });
    const areas = Object.keys(areaData);
    barChart.data.labels = areas;
    barChart.data.datasets[0].data = areas.map(a => Math.round(areaData[a].sum / areaData[a].count));
    barChart.update();

    // D. Donut Charts — recalculate from raw fields
    const donutMap = {
        'Efectividad_Onb': { chart: donutEfectividad, el: 'perc-efectividad' },
        'Integracion_Equipo': { chart: donutIntegracion, el: 'perc-integracion' },
        'Claridad_Puesto': { chart: donutClaridad, el: 'perc-claridad' },
        'Comprension_Org': { chart: donutComprension, el: 'perc-comprension' }
    };

    Object.keys(donutMap).forEach(key => {
        const spec = donutMap[key];
        if (!spec.chart) return;

        let avg = 0;
        if (validData.length > 0) {
            const sum = validData.reduce((acc, item) => {
                const sc = calcScores(item);
                return acc + sc[key];
            }, 0);
            avg = Math.round(sum / validData.length);
        }

        spec.chart.data.datasets[0].data = [avg, Math.max(0, 100 - avg)];
        spec.chart.update();

        const labelEl = document.getElementById(spec.el);
        if (labelEl) labelEl.innerHTML = `${avg}%`;
    });
}
