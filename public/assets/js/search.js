/**
 * Spotlight Search & KPI Engine - v1.6.2
 * Final Math Fix: 17-Question Mapping & Corrected Dimensions
 */

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getFirestore, collection, getDocs, query, orderBy } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

const firebaseConfig = {
  apiKey: "AIzaSyBVRsb03EbnY3IKRAbc-3s5jTjM5X3kGxM",
  authDomain: "kpi-rh-c667e.firebaseapp.com",
  projectId: "kpi-rh-c667e",
  storageBucket: "kpi-rh-c667e.firebasestorage.app",
  messagingSenderId: "59652617692",
  appId: "1:59652617692:web:789034aa88c4ef1a4f0b19"
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

document.addEventListener('DOMContentLoaded', () => {
    const globalSpotlightInput = document.getElementById('globalSpotlightInput');
    const spotlightResults = document.getElementById('spotlightResults');
    const spotlightOverlay = document.getElementById('spotlightOverlay');
    const evaluationGrid = document.getElementById('evaluationGrid');
    
    // Modal Elements
    const detailsModal = document.getElementById('detailsModal');
    const btnCloseModal = document.getElementById('btnCloseModal');

    // 1. DASHBOARD LOAD & DYNAMIC RENDERING
    const isCloud = !window.location.hostname.includes('localhost');

    if (globalSpotlightInput) {
        globalSpotlightInput.addEventListener('input', debounce(async () => {
            const qStr = globalSpotlightInput.value.trim();
            if (qStr.length < 2) {
                spotlightResults.innerHTML = '';
                return;
            }
            
            let data = [];
            if (isCloud) {
                const querySnapshot = await getDocs(collection(db, "onboarding_evaluations"));
                data = querySnapshot.docs.map(doc => doc.data()).filter(item => 
                    (item.nombre && item.nombre.toLowerCase().includes(qStr.toLowerCase())) || 
                    (item.num_empleado && item.num_empleado.includes(qStr))
                );
            } else {
                try {
                    const response = await fetch(`${window.APP_URL}?url=apiSearch&global=${encodeURIComponent(qStr)}`);
                    const result = await response.json();
                    data = result.data || [];
                } catch(e) { console.warn("Local search failed."); }
            }
            renderSpotlightResults(data, qStr);
        }, 300));
    }

    function renderSpotlightResults(data, qStr) {
        spotlightResults.innerHTML = '';
        if (data.length === 0) {
            spotlightResults.innerHTML = '<p style="padding: 2rem; text-align:center; color:#999;">No hay coincidencias.</p>';
            return;
        }

        data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'spotlight-item';
            div.innerHTML = `
                <span class="item-icon">👤</span>
                <div class="item-info">
                    <span class="item-title">${item.nombre || 'Sin nombre'}</span>
                    <span class="item-subtitle">${item.puesto || ''} | ${item.coordinacion || ''}</span>
                </div>
            `;
            div.onclick = () => showEvaluationDetails(item);
            spotlightResults.appendChild(div);
        });
    }

    // 2. DETAILED RESULTS LOGIC
    window.showEvaluationDetails = function(item) {
        const scores = calculateScoresJS(item);
        
        document.getElementById('modalName').textContent = item.nombre || 'Colaborador';
        document.getElementById('modalSub').textContent = `${item.puesto || 'S/P'} | ${item.coordinacion || 'S/C'}`;
        
        // Render Scores
        const scoresContainer = document.getElementById('modalScores');
        scoresContainer.innerHTML = '';
        
        const displayDimensions = [
            { label: 'IGEO Global', val: scores.IGEO, icon: '📈' },
            { label: 'Claridad Puesto', val: scores.Claridad_Puesto, icon: '🔍' },
            { label: 'Integración equipo', val: scores.Integracion_Equipo, icon: '🎭' },
            { label: 'Comprensión Org', val: scores.Comprension_Org, icon: 'PURPLE' },
            { label: 'Efectividad Onb', val: scores.Efectividad_Onb, icon: '⭐' }
        ];

        displayDimensions.forEach(d => {
            const div = document.createElement('div');
            div.className = 'score-item';
            div.innerHTML = `
                <span class="score-val">${d.val}%</span>
                <span class="score-label">${d.label}</span>
            `;
            scoresContainer.appendChild(div);
        });

        // Feedback section
        const feedbackContainer = document.getElementById('modalFeedback');
        feedbackContainer.innerHTML = '';
        const feedbackLabels = {
            'f_logros': 'Logros obtenidos en el periodo',
            'f_utilidad_capacitaciones': 'Utilidad de capacitaciones de inducción',
            'f_faltantes_actividades': 'Faltantes detectados en el onboarding',
            'f_tiempo_onboarding': 'Opinión sobre el tiempo total del proceso',
            'f_satisfaccion_decision': 'Nivel de satisfacción con la decisión de ingreso',
            'f_mejoras_proceso': 'Sugerencias específicas de mejora',
            'f_comentarios_libres': 'Comentarios adicionales'
        };

        Object.keys(feedbackLabels).forEach(key => {
            if (item[key]) {
                const div = document.createElement('div');
                div.className = 'feedback-item';
                div.innerHTML = `
                    <span class="fb-label">${feedbackLabels[key]}</span>
                    <p class="fb-text">${item[key]}</p>
                `;
                feedbackContainer.appendChild(div);
            }
        });

        detailsModal.style.display = 'flex';
        if (spotlightOverlay) spotlightOverlay.style.display = 'none';
    };

    if (btnCloseModal) {
        btnCloseModal.onclick = () => detailsModal.style.display = 'none';
    }

    // 3. CLOUD LIST RENDERING
    window.loadDashboardKPIs = async function(filters = {}) {
        try {
            let data = [];
            if (isCloud) {
                console.log("Fetching from Cloud Firestore...");
                const snapshot = await getDocs(query(collection(db, "onboarding_evaluations"), orderBy("created_at", "desc")));
                data = snapshot.docs.map(doc => doc.data());

                if (filters.coordinacion) data = data.filter(i => i.coordinacion === filters.coordinacion);
                if (filters.global) {
                    const g = filters.global.toLowerCase();
                    data = data.filter(i => (i.nombre && i.nombre.toLowerCase().includes(g)) || (i.num_empleado && i.num_empleado.includes(g)));
                }
                
                if (evaluationGrid) renderEvaluationCards(data);
            } else {
                const params = new URLSearchParams(filters);
                const response = await fetch(`${window.APP_URL}?url=apiSearch&${params.toString()}`);
                const result = await response.json();
                data = result.data || [];
            }

            window.updateKPIStats(data);
            if (window.updateCharts) window.updateCharts(data);
        } catch (err) {
            console.error('Data Sync Error:', err);
        }
    }

    function renderEvaluationCards(data) {
        const placeholder = document.getElementById('emptyStatePlaceholder');
        if (placeholder) placeholder.remove();

        const plusCard = evaluationGrid.querySelector('.add-evaluation-card');
        const existingCards = evaluationGrid.querySelectorAll('.evaluation-card');
        existingCards.forEach(c => c.remove());

        data.forEach(item => {
            const scores = calculateScoresJS(item);
            const igeo = scores.IGEO;
            const color = igeo >= 80 ? '#4CAF50' : (igeo >= 60 ? '#FFC107' : '#F44336');
            
            const card = document.createElement('div');
            card.className = 'evaluation-card glass-card ripple';
            card.innerHTML = `
                <div class="card-header">
                    <span class="coordination-tag">${item.coordinacion || 'S/C'}</span>
                    <div class="igeo-badge" style="background: ${color}22; color: ${color};">
                        ${igeo}%
                    </div>
                </div>
                <div class="card-body">
                    <h3>${item.nombre || 'Colaborador'}</h3>
                    <p class="puesto-text">${item.puesto || 'Sin puesto'}</p>
                    <p class="date-text">📅 ${item.fecha_ingreso || '--/--/----'}</p>
                </div>
                <div class="card-footer">
                    <button class="btn-text">Ver Detalles →</button>
                </div>
            `;
            card.onclick = () => showEvaluationDetails(item);
            evaluationGrid.insertBefore(card, plusCard);
        });
    }

    /**
     * FINAL CORRECTED CALCULATION - v1.6.2
     * Mapping precisely matches the 17-question survey form
     */
    function calculateScoresJS(source) {
        const dimensions = {
            'Claridad_Puesto': ['m_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_contribucion_resultados', 'm_experiencia_colaboracion'],
            'Integracion_Equipo': ['m_integracion_equipo', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe', 'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion'],
            'Comprension_Org': ['m_herramientas_trabajo', 'm_espacio_fisico', 'm_atencion_rh', 'm_paquete_beneficios', 'm_percepcion_imagen'],
            'Efectividad_Onb': ['m_efectividad_onboarding', 'm_contribucion_resultados', 'm_preparacion_capacitacion']
        };

        const metricsList = [
            'm_claridad_expectativas', 'm_seguridad_responsabilidades', 'm_preparacion_capacitacion',
            'm_efectividad_onboarding', 'm_contribucion_resultados', 'm_integracion_equipo',
            'm_experiencia_colaboracion', 'm_accesibilidad_jefe', 'm_retroalimentacion_jefe',
            'm_conocimiento_cultura', 'm_alineacion_valores', 'm_organizacion_induccion',
            'm_herramientas_trabajo', 'm_espacio_fisico', 'm_atencion_rh',
            'm_paquete_beneficios', 'm_percepcion_imagen'
        ];

        const results = {};
        for (const [name, fields] of Object.entries(dimensions)) {
            let sum = 0;
            fields.forEach(f => {
                sum += parseInt(source[f]) || 0;
            });
            results[name] = Math.round((sum / (fields.length * 10)) * 100);
        }

        let globalSum = 0;
        metricsList.forEach(m => {
            globalSum += parseInt(source[m]) || 0;
        });
        results['IGEO'] = Math.round((globalSum / (metricsList.length * 10)) * 100);

        return results;
    }

    window.updateKPIStats = function(data) {
        if (!data || data.length === 0) return;
        
        // Filter out records where scores are completely zero (broken tests)
        // This ensures the average is reflective only of real data
        const validData = data.filter(item => {
            const sc = calculateScoresJS(item);
            return sc.IGEO > 0;
        });
        
        if (validData.length === 0) return;

        const totals = { igeo: 0, claridad: 0, cultura: 0, liderazgo: 0, operaciones: 0, satisfaccion: 0 };
        validData.forEach(item => {
            const sc = calculateScoresJS(item);
            totals.igeo += sc.IGEO;
            totals.claridad += sc.Claridad_Puesto;
            totals.cultura += sc.Integracion_Equipo;
            totals.liderazgo += sc.Integracion_Equipo; 
            totals.operaciones += sc.Comprension_Org;
            totals.satisfaccion += sc.Efectividad_Onb;
        });
        
        Object.keys(totals).forEach(key => {
            const avg = Math.round(totals[key] / validData.length);
            const el = document.getElementById(`val-${key}`);
            if (el) window.animateValue(el, parseInt(el.innerHTML) || 0, avg, 800);
        });
    }

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    window.animateValue = function(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start) + "%";
            if (progress < 1) window.requestAnimationFrame(step);
        };
        window.requestAnimationFrame(step);
    }

    if (document.getElementById('val-igeo') || evaluationGrid) {
        window.loadDashboardKPIs();
    }
});
