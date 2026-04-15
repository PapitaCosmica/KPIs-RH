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
    </div>
</header>

<!-- Share Tunnel Modal -->
<div id="shareTunnelModal" class="spotlight-overlay" style="display:none;">
    <div class="spotlight-modal share-modal">
        <div class="spotlight-header">
            <span class="spotlight-icon">🌌</span>
            <h2 style="font-size: 1.2rem; margin: 0; color: var(--color-night);">Crear Túnel Temporal</h2>
            <span class="spotlight-esc" id="closeShareModal">ESC</span>
        </div>
        
        <div class="share-config-body">
            <div class="config-group" style="padding: 1rem; background: rgba(129, 161, 193, 0.05); border-radius: 12px; border: 1px dashed var(--color-ice-blue); margin-bottom: 2rem;">
                <label style="font-size: 0.8rem; color: var(--color-ice-blue);">PUENTE DE RED (URL PÚBLICA)</label>
                <div style="display:flex; gap:0.5rem; margin-top:0.5rem;">
                    <input type="text" id="publicBaseUrlInput" value="https://hfntm-189-141-234-219.run.pinggy-free.link" placeholder="https://tu-tunel.link" style="flex:1; padding: 0.5rem; border: 1px solid #ddd; border-radius: 8px; font-size: 0.85rem;">
                    <button id="btnSaveBaseUrl" class="neo-opt" style="padding: 0 0.8rem; font-size: 0.75rem;">Guardar</button>
                </div>
                <p style="font-size: 0.7rem; color: #888; margin-top: 0.5rem;">Esta URL es necesaria para que el link funcione en otros dispositivos.</p>
            </div>

            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1.5rem;">Configura los límites para este enlace temporal.</p>
            
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
                <button id="btnCreateTunnel" class="btn-neo btn-primary" style="padding: 0.8rem 2rem;">Generar Túnel</button>
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
.share-modal {
    max-width: 500px !important;
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

const btnSaveBaseUrl = document.getElementById('btnSaveBaseUrl');
if (btnSaveBaseUrl) {
    btnSaveBaseUrl.addEventListener('click', async () => {
        const baseUrl = document.getElementById('publicBaseUrlInput').value;
        const formData = new FormData();
        formData.append('base_url', baseUrl);

        btnSaveBaseUrl.innerHTML = "...";
        try {
            const res = await fetch(`${window.APP_URL}?url=survey/update-tunnel-base`, {
                method: 'POST',
                body: formData
            });
            const result = await res.json();
            alert(result.message);
        } catch (e) { alert('Error al guardar URL.'); }
        btnSaveBaseUrl.innerHTML = "Guardar";
    });
}

if (btnCreateTunnel) {
    btnCreateTunnel.addEventListener('click', async () => {
        const responses = document.querySelector('#responseLimitGrid .active').dataset.val;
        const hours = document.querySelector('#timeLimitGrid .active').dataset.val;
        
        btnCreateTunnel.disabled = true;
        btnCreateTunnel.innerHTML = "Generando...";

        try {
            const formData = new FormData();
            formData.append('max_responses', responses);
            formData.append('hours', hours);

            const response = await fetch(`${window.APP_URL}?url=survey/create-tunnel`, {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                document.getElementById('tunnelUrlInput').value = result.url;
                document.getElementById('generatedLinkContainer').style.display = 'block';
                btnCreateTunnel.innerHTML = "¡Generado!";
            } else {
                alert('Error: ' + result.message);
                btnCreateTunnel.innerHTML = "Generar Túnel";
                btnCreateTunnel.disabled = false;
            }
        } catch (err) {
            console.error(err);
            alert('Error de conexión.');
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
        spotlightOverlay.style.display = 'flex';
        spotlightInput.focus();
    }
    if (e.key === 'Escape') {
        spotlightOverlay.style.display = 'none';
        shareModal.style.display = 'none';
    }
});

// Close when clicking outside modal
[spotlightOverlay, shareModal].forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
