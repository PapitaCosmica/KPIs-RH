/**
 * KPI Engine & Results Manager - v1.8.0
 * Features: Dashboard KPIs, Results filtering, Context menu delete via Firestore.
 */

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getFirestore, collection, getDocs, deleteDoc, doc, query, orderBy } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

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
    const evaluationGrid = document.getElementById('evaluationGrid');
    const detailsModal = document.getElementById('detailsModal');
    const btnCloseModal = document.getElementById('btnCloseModal');
    const isCloud = !window.location.hostname.includes('localhost');

    // ============================================================
    // CONTEXT MENU (Right-click delete on results page)
    // ============================================================
    const contextMenu = document.getElementById('contextMenu');
    let contextTarget = null; // Stores { docId, cardElement, itemData }

    // Hide context menu on any click
    document.addEventListener('click', () => {
        if (contextMenu) contextMenu.style.display = 'none';
    });

    // Delete handler
    const ctxDelete = document.getElementById('ctxDelete');
    if (ctxDelete) {
        ctxDelete.addEventListener('click', async (e) => {
            e.stopPropagation();
            if (!contextTarget) return;

            const confirmed = confirm(`¿Eliminar la respuesta de "${contextTarget.itemData.nombre || 'este colaborador'}"?\n\nEsta acción no se puede deshacer.`);
            if (!confirmed) {
                contextMenu.style.display = 'none';
                return;
            }

            try {
                await deleteDoc(doc(db, "onboarding_evaluations", contextTarget.docId));
                contextTarget.cardElement.style.transition = 'all 0.3s ease';
                contextTarget.cardElement.style.opacity = '0';
                contextTarget.cardElement.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    contextTarget.cardElement.remove();
                }, 300);
                console.log('Deleted:', contextTarget.docId);
            } catch (err) {
                console.error('Delete error:', err);
                alert('Error al eliminar. Verifica tu conexión.');
            }

            contextMenu.style.display = 'none';
            contextTarget = null;
        });
    }

    // ============================================================
    // DETAILED RESULTS MODAL
    // ============================================================
    window.showEvaluationDetails = function(item) {
        const scores = window.calcScores ? window.calcScores(item) : { IGEO: 0 };
        
        document.getElementById('modalName').textContent = item.nombre || 'Colaborador';
        document.getElementById('modalSub').textContent = `${item.puesto || 'S/P'} | ${item.coordinacion || 'S/C'}`;
        
        const scoresContainer = document.getElementById('modalScores');
        scoresContainer.innerHTML = '';
        
        const displayDimensions = [
            { label: 'IGEO Global', val: scores.IGEO },
            { label: 'Claridad Puesto', val: scores.Claridad_Puesto },
            { label: 'Integración Equipo', val: scores.Integracion_Equipo },
            { label: 'Comprensión Org', val: scores.Comprension_Org },
            { label: 'Efectividad Onb', val: scores.Efectividad_Onb }
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
    };

    if (btnCloseModal) {
        btnCloseModal.onclick = () => detailsModal.style.display = 'none';
    }

    // ============================================================
    // LOAD DATA (Dashboard + Results Page)
    // ============================================================
    window.loadDashboardKPIs = async function(filters = {}) {
        try {
            let data = [];
            let docsWithIds = [];

            if (isCloud) {
                const snapshot = await getDocs(query(collection(db, "onboarding_evaluations"), orderBy("created_at", "desc")));
                docsWithIds = snapshot.docs.map(d => ({ id: d.id, ...d.data() }));
                data = docsWithIds;

                // Apply filters
                if (filters.global && filters.global.length > 0) {
                    const q = filters.global.toLowerCase();
                    data = data.filter(item =>
                        (item.nombre && item.nombre.toLowerCase().includes(q)) ||
                        (item.num_empleado && item.num_empleado.includes(q)) ||
                        (item.puesto && item.puesto.toLowerCase().includes(q))
                    );
                }
                if (filters.coordinacion) {
                    data = data.filter(item => item.coordinacion === filters.coordinacion);
                }
                if (filters.date_start) {
                    data = data.filter(item => item.fecha_ingreso && item.fecha_ingreso >= filters.date_start);
                }
                if (filters.date_end) {
                    data = data.filter(item => item.fecha_ingreso && item.fecha_ingreso <= filters.date_end);
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

    // ============================================================
    // RENDER CARDS (with right-click support)
    // ============================================================
    function renderEvaluationCards(data) {
        const placeholder = document.getElementById('emptyStatePlaceholder');
        if (placeholder) placeholder.remove();

        const existingCards = evaluationGrid.querySelectorAll('.evaluation-card');
        existingCards.forEach(c => c.remove());

        if (data.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'empty-state glass-card';
            empty.style.cssText = 'grid-column: 1/-1; padding: 3rem; text-align: center;';
            empty.innerHTML = '<p>No se encontraron resultados con esos filtros.</p>';
            evaluationGrid.appendChild(empty);
            return;
        }

        data.forEach(item => {
            const scores = window.calcScores ? window.calcScores(item) : { IGEO: 0 };
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

            // Left click → details
            card.addEventListener('click', (e) => {
                if (contextMenu && contextMenu.style.display === 'block') return;
                showEvaluationDetails(item);
            });

            // Right click → context menu
            card.addEventListener('contextmenu', (e) => {
                e.preventDefault();
                if (!contextMenu) return;

                contextTarget = {
                    docId: item.id,
                    cardElement: card,
                    itemData: item
                };

                contextMenu.style.display = 'block';
                contextMenu.style.left = `${e.clientX}px`;
                contextMenu.style.top = `${e.clientY}px`;

                // Keep menu within viewport
                const rect = contextMenu.getBoundingClientRect();
                if (rect.right > window.innerWidth) {
                    contextMenu.style.left = `${e.clientX - rect.width}px`;
                }
                if (rect.bottom > window.innerHeight) {
                    contextMenu.style.top = `${e.clientY - rect.height}px`;
                }
            });

            evaluationGrid.appendChild(card);
        });
    }

    // ============================================================
    // KPI STATS (Top cards)
    // ============================================================
    window.updateKPIStats = function(data) {
        if (!data || data.length === 0) return;
        const validData = data.filter(item => {
            const sc = window.calcScores ? window.calcScores(item) : { IGEO: 0 };
            return sc.IGEO > 0;
        });
        if (validData.length === 0) {
            // Reset to 0 if no valid data
            ['igeo', 'claridad', 'cultura', 'liderazgo', 'operaciones', 'satisfaccion'].forEach(key => {
                const el = document.getElementById(`val-${key}`);
                if (el) el.innerHTML = "0%";
            });
            return;
        }

        const totals = { igeo: 0, claridad: 0, cultura: 0, liderazgo: 0, operaciones: 0, satisfaccion: 0 };
        validData.forEach(item => {
            const sc = window.calcScores ? window.calcScores(item) : { IGEO: 0 };
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

    // ============================================================
    // RESULTS PAGE FILTER (separate from dashboard filter)
    // ============================================================
    const resultsSearch = document.getElementById('results-search');
    const resultsCoord = document.getElementById('results-coordinacion');
    const resultsDateStart = document.getElementById('results-date-start');
    const resultsDateEnd = document.getElementById('results-date-end');
    const btnResultsSearch = document.getElementById('btn-results-search');
    const btnResultsReset = document.getElementById('btn-results-reset');

    function getResultsFilters() {
        return {
            global: resultsSearch ? resultsSearch.value.trim() : '',
            coordinacion: resultsCoord ? resultsCoord.value : '',
            date_start: resultsDateStart ? resultsDateStart.value : '',
            date_end: resultsDateEnd ? resultsDateEnd.value : ''
        };
    }

    if (btnResultsSearch) {
        btnResultsSearch.addEventListener('click', () => {
            window.loadDashboardKPIs(getResultsFilters());
        });
    }

    if (resultsSearch) {
        resultsSearch.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                window.loadDashboardKPIs(getResultsFilters());
            }
        });
    }

    if (resultsCoord) {
        resultsCoord.addEventListener('change', () => {
            window.loadDashboardKPIs(getResultsFilters());
        });
    }

    [resultsDateStart, resultsDateEnd].forEach(el => {
        if (el) el.addEventListener('change', () => {
            window.loadDashboardKPIs(getResultsFilters());
        });
    });

    if (btnResultsReset) {
        btnResultsReset.addEventListener('click', () => {
            if (resultsSearch) resultsSearch.value = '';
            if (resultsCoord) resultsCoord.value = '';
            if (resultsDateStart) resultsDateStart.value = '';
            if (resultsDateEnd) resultsDateEnd.value = '';
            window.loadDashboardKPIs({});
        });
    }

    // ============================================================
    // AUTO-LOAD
    // ============================================================
    if (document.getElementById('val-igeo') || evaluationGrid) {
        window.loadDashboardKPIs();
    }
});
