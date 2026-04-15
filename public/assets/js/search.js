/**
 * Spotlight Search & KPI Engine - v1.5.0
 * Global Search & Cloud-to-Local Data Switching
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

    if (globalSpotlightInput) {
        globalSpotlightInput.addEventListener('input', debounce(async () => {
            const qStr = globalSpotlightInput.value.trim();
            if (qStr.length < 2) {
                spotlightResults.innerHTML = '';
                return;
            }
            
            const isCloud = !window.location.hostname.includes('localhost');
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
                } catch(e) { console.warn("Local search failed, falling back to empty."); }
            }
            renderSpotlightResults(data, qStr);
        }, 300));
    }

    function renderSpotlightResults(data, qStr) {
        spotlightResults.innerHTML = '';
        if (data.length === 0) {
            spotlightResults.innerHTML = '<p style="padding: 2rem; text-align:center; color:#999;">No hay coincidencias en el sistema.</p>';
            return;
        }

        data.forEach(item => {
            let category = 'Colaborador';
            let icon = '👤';
            let subtitle = `${item.puesto || ''} | ${item.coordinacion || ''}`;

            const div = document.createElement('div');
            div.className = 'spotlight-item';
            div.innerHTML = `
                <span class="item-icon">${icon}</span>
                <div class="item-info">
                    <span class="item-title">${item.nombre || 'Sin nombre'}</span>
                    <span class="item-subtitle">${subtitle}</span>
                </div>
            `;
            
            div.onclick = () => {
                window.location.href = `${window.APP_URL}?url=evaluaciones&highlight=${item.num_empleado}`;
            };
            spotlightResults.appendChild(div);
        });
    }

    // DASHBOARD KPI UPDATE
    window.loadDashboardKPIs = async function(filters = {}) {
        const isCloud = !window.location.hostname.includes('localhost');
        try {
            let data = [];
            if (isCloud) {
                console.log("Fetching from Cloud Firestore...");
                const snapshot = await getDocs(query(collection(db, "onboarding_evaluations"), orderBy("created_at", "desc")));
                data = snapshot.docs.map(doc => doc.data());

                // Apply filters in JS for Cloud mode
                if (filters.coordinacion) data = data.filter(i => i.coordinacion === filters.coordinacion);
                if (filters.global) {
                    const g = filters.global.toLowerCase();
                    data = data.filter(i => (i.nombre && i.nombre.toLowerCase().includes(g)) || (i.num_empleado && i.num_empleado.includes(g)));
                }
                if (filters.date_start) data = data.filter(i => i.fecha_ingreso >= filters.date_start);
                if (filters.date_end) data = data.filter(i => i.fecha_ingreso <= filters.date_end);
            } else {
                const params = new URLSearchParams(filters);
                const response = await fetch(`${window.APP_URL}?url=apiSearch&${params.toString()}`);
                const result = await response.json();
                data = result.data || [];
            }

            window.updateKPIStats(data);
            if (window.updateCharts) window.updateCharts(data);
        } catch (err) {
            console.error('KPI Update Error:', err);
        }
    }

    window.updateKPIStats = function(data) {
        if (!data || data.length === 0) {
            ['igeo', 'claridad', 'cultura', 'liderazgo', 'operaciones', 'satisfaccion'].forEach(key => {
                const el = document.getElementById(`val-${key}`);
                if (el) el.innerHTML = "0%";
            });
            return;
        }
        const totals = { igeo: 0, claridad: 0, cultura: 0, liderazgo: 0, operaciones: 0, satisfaccion: 0 };
        data.forEach(item => {
            const s = item.scores || {};
            totals.igeo += parseFloat(item.IGEO || 0);
            totals.claridad += parseFloat(s['Claridad'] || 0);
            totals.cultura += parseFloat(s['Cultura'] || 0);
            totals.liderazgo += parseFloat(s['Liderazgo'] || 0);
            totals.operaciones += parseFloat(s['Operaciones'] || 0);
            totals.satisfaccion += parseFloat(s['Satisfacción'] || 0);
        });
        Object.keys(totals).forEach(key => {
            const avg = Math.round(totals[key] / data.length);
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

    if (document.getElementById('val-igeo')) {
        window.loadDashboardKPIs();
    }
});
