<header class="top-header">
    <div class="header-left">
        <div class="logo-text">KPIs-RH</div>
        <nav class="top-nav">
            <ul>
                <li class="<?php echo ($url ?? '') == 'home' ? 'active' : ''; ?>">
                    <a href="<?php echo URL_ROOT; ?>?url=home">Inicio</a>
                </li>
                <li class="<?php echo ($url ?? '') == 'survey' ? 'active' : ''; ?>">
                    <a href="<?php echo URL_ROOT; ?>?url=survey">Evaluaciones</a>
                </li>
                <li class="<?php echo ($url ?? '') == 'resultados' ? 'active' : ''; ?>">
                    <a href="<?php echo URL_ROOT; ?>?url=resultados">Resultados</a>
                </li>
                <li>
                    <a href="<?php echo URL_ROOT; ?>?url=export/download">Reportes</a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="header-center"></div>

    <div class="header-right">
        <button class="btn-share-tunnel" id="openShareModal">
            <span class="icon">🔗</span>
            <span>Compartir</span>
        </button>
        <div class="user-pill">
            <span class="user-role">Admin</span>
            <div class="avatar-circle">RH</div>
        </div>
        <a href="<?php echo URL_ROOT; ?>?url=logout" class="btn-logout" title="Cerrar Sesión">
            <span class="icon">🔒</span>
        </a>
    </div>
</header>

<!-- Share Modal -->
<div id="shareTunnelModal" class="spotlight-overlay" style="display:none;">
    <div class="spotlight-modal share-modal">
        <div class="share-modal-header">
            <h2>📋 Compartir Evaluación</h2>
            <button class="btn-close-modal" id="closeShareModal" title="Cerrar">✕</button>
        </div>
        
        <div class="share-config-body">
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Configura los límites para el enlace de evaluación.</p>
            
            <div class="config-group">
                <label>Límite de Respuestas</label>
                <div class="neo-select-grid" id="responseLimitGrid">
                    <button class="neo-opt active" data-val="1">1</button>
                    <button class="neo-opt" data-val="5">5</button>
                    <button class="neo-opt" data-val="10">10</button>
                    <button class="neo-opt" data-val="50">50</button>
                    <button class="neo-opt" data-val="1000">Ilimitado</button>
                </div>
            </div>

            <div class="config-group" id="timeLimitSection" style="margin-top: 1.5rem;">
                <label>Vigencia del Enlace <span id="timePriorityNote" style="font-weight: normal; font-size: 0.75rem; color: #888; display:none;">(Prioridad: Respuestas)</span></label>
                <div class="neo-select-grid" id="timeLimitGrid">
                    <button class="neo-opt" data-val="1">1h</button>
                    <button class="neo-opt" data-val="4">4h</button>
                    <button class="neo-opt active" data-val="24">24h</button>
                    <button class="neo-opt" data-val="168">7 días</button>
                    <button class="neo-opt" data-val="8760">1 año</button>
                </div>
            </div>

            <div id="generatedLinkContainer" style="display:none; margin-top: 2rem; padding: 1.5rem; border-radius: 15px; background: rgba(129, 161, 193, 0.1); border: 1px solid rgba(129, 161, 193, 0.2);">
                <label style="display:block; font-size: 0.8rem; color: var(--color-ice-blue); margin-bottom: 0.5rem; font-weight: bold;">ENLACE GENERADO</label>
                <div style="display:flex; gap: 0.5rem;">
                    <input type="text" id="tunnelUrlInput" readonly style="flex:1; padding: 0.6rem; border: none; background: white; border-radius: 8px; font-size: 0.85rem; color: #444;">
                    <button id="copyUrlBtn" class="neo-opt" style="padding: 0 1rem; background: var(--color-ice-blue); color: white; border: none;">Copiar</button>
                </div>
            </div>

            <div class="share-actions" style="margin-top: 2rem; text-align: right;">
                <button id="btnCreateTunnel" class="btn-neo btn-primary" style="padding: 0.8rem 2rem;">Generar Enlace</button>
            </div>
        </div>
    </div>
</div>

<style>
.btn-share-tunnel {
    background: rgba(129, 161, 193, 0.1);
    border: 1px solid rgba(129, 161, 193, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s;
    color: var(--color-deep-slate);
    font-weight: 600;
}
.btn-share-tunnel:hover {
    background: var(--color-ice-blue);
    color: white;
}
.btn-logout {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: none;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s;
    font-size: 1.1rem;
    cursor: pointer;
}
.btn-logout:hover {
    background: #dc3545;
    color: white;
}
.share-modal {
    max-width: 500px !important;
}
.share-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.2rem 1.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}
.share-modal-header h2 {
    font-size: 1.15rem;
    margin: 0;
    color: var(--color-night);
}
.btn-close-modal {
    background: rgba(0,0,0,0.05);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 1rem;
    cursor: pointer;
    color: #666;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.btn-close-modal:hover {
    background: rgba(220, 50, 50, 0.12);
    color: #d33;
}
.share-config-body {
    padding: 2rem;
}
.config-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.8rem;
    color: var(--color-night);
    font-size: 0.95rem;
}
.neo-select-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0.5rem;
}
.neo-opt {
    padding: 0.6rem;
    border: 1px solid rgba(0,0,0,0.05);
    background: #f8f9fa;
    border-radius: 10px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 600;
}
.neo-opt.active {
    background: var(--color-ice-blue);
    color: white;
    border-color: var(--color-ice-blue);
    box-shadow: 0 4px 8px rgba(129, 161, 193, 0.3);
}
</style>

<script>
// Spotlight Toggle Logic
const spotlightTabTrigger = document.getElementById('openSpotlight');
const spotlightOverlay = document.getElementById('spotlightOverlay');
const spotlightInput = document.getElementById('globalSpotlightInput');

if (spotlightTabTrigger) {
    spotlightTabTrigger.addEventListener('click', () => {
        spotlightOverlay.style.display = 'flex';
        spotlightInput.focus();
    });
}

// Share Tunnel Logic
const shareBtn = document.getElementById('openShareModal');
const shareModal = document.getElementById('shareTunnelModal');
const btnCreateTunnel = document.getElementById('btnCreateTunnel');
const closeShareModal = document.getElementById('closeShareModal');

if (shareBtn) {
    shareBtn.addEventListener('click', () => {
        shareModal.style.display = 'flex';
        document.getElementById('generatedLinkContainer').style.display = 'none';
    });
}

if (closeShareModal) {
    closeShareModal.addEventListener('click', () => shareModal.style.display = 'none');
}

// Toggle logic for neo-options
document.querySelectorAll('.neo-select-grid .neo-opt').forEach(btn => {
    btn.addEventListener('click', function() {
        this.parentElement.querySelectorAll('.neo-opt').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        // Logic: If response limit is selected (not 1000), fade out time limit
        if (this.closest('#responseLimitGrid')) {
            const timeSection = document.getElementById('timeLimitSection');
            const note = document.getElementById('timePriorityNote');
            if (this.dataset.val < 1000) {
                timeSection.style.opacity = "0.5";
                note.style.display = "inline";
            } else {
                timeSection.style.opacity = "1";
                note.style.display = "none";
            }
        }
    });
});


if (btnCreateTunnel) {
    btnCreateTunnel.addEventListener('click', async () => {
        const responses = document.querySelector('#responseLimitGrid .active').dataset.val;
        const hours = document.querySelector('#timeLimitGrid .active').dataset.val;
        
        btnCreateTunnel.disabled = true;
        btnCreateTunnel.innerHTML = "Generando...";

        try {
            // Import Firebase modules dynamically
            const { initializeApp } = await import("https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js");
            const { getFirestore, collection, addDoc, Timestamp } = await import("https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js");
            
            const firebaseConfig = {
                apiKey: "AIzaSyBVRsb03EbnY3IKRAbc-3s5jTjM5X3kGxM",
                authDomain: "kpi-rh-c667e.firebaseapp.com",
                projectId: "kpi-rh-c667e",
                storageBucket: "kpi-rh-c667e.firebasestorage.app",
                messagingSenderId: "59652617692",
                appId: "1:59652617692:web:789034aa88c4ef1a4f0b19"
            };
            
            const app = initializeApp(firebaseConfig, 'tunnel-app');
            const db = getFirestore(app);
            
            // Calculate expiration
            const maxResp = parseInt(responses);
            let expiresAt;
            if (maxResp < 1000) {
                expiresAt = Timestamp.fromDate(new Date(Date.now() + 365 * 24 * 60 * 60 * 1000)); // 1 year
            } else {
                expiresAt = Timestamp.fromDate(new Date(Date.now() + parseInt(hours) * 60 * 60 * 1000));
            }
            
            // Create tunnel document in Firestore
            const docRef = await addDoc(collection(db, 'tunnels'), {
                max_responses: maxResp,
                current_responses: 0,
                expires_at: expiresAt,
                created_at: Timestamp.now()
            });
            
            const baseUrl = window.location.origin;
            const url = `${baseUrl}/?url=survey/tunnel&token=${docRef.id}`;
            
            document.getElementById('tunnelUrlInput').value = url;
            document.getElementById('generatedLinkContainer').style.display = 'block';
            btnCreateTunnel.innerHTML = "¡Enlace generado!";
        } catch (err) {
            console.error('Tunnel creation error:', err);
            alert('Error al generar el enlace.');
            btnCreateTunnel.innerHTML = "Generar Enlace";
            btnCreateTunnel.disabled = false;
        }
    });
}

const copyBtn = document.getElementById('copyUrlBtn');
if (copyBtn) {
    copyBtn.addEventListener('click', () => {
        const input = document.getElementById('tunnelUrlInput');
        input.select();
        document.execCommand('copy');
        copyBtn.innerHTML = "¡Copiado!";
        setTimeout(() => copyBtn.innerHTML = "Copiar", 2000);
    });
}

// Global Shortkeys (⌘K or Ctrl+K)
document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        if (spotlightOverlay) spotlightOverlay.style.display = 'flex';
        if (spotlightInput) spotlightInput.focus();
    }
    if (e.key === 'Escape') {
        if (spotlightOverlay) spotlightOverlay.style.display = 'none';
        if (shareModal) shareModal.style.display = 'none';
    }
});

// Close when clicking outside modal
[spotlightOverlay, shareModal].filter(Boolean).forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
