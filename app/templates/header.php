<header class="top-header">
    <div class="header-left">
        <div class="logo-text">KPIs-RH</div>
        <nav class="top-nav">
            <ul>
                <li class="<?php echo ($url ?? '') == 'home' ? 'active' : ''; ?>">
                    <a href="<?php echo URL_ROOT; ?>?url=home">Inicio</a>
                </li>
                <li class="<?php echo ($url ?? '') == 'evaluaciones' ? 'active' : ''; ?>">
                    <a href="<?php echo URL_ROOT; ?>?url=evaluaciones">Evaluaciones</a>
                </li>
                <li>
                    <a href="<?php echo URL_ROOT; ?>?url=export/download">Reportes</a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="header-center">
        <div class="spotlight-trigger" id="openSpotlight">
            <span class="icon">🔍</span>
            <span class="placeholder">Buscar colaborador, feedback...</span>
            <span class="shortcut">⌘K</span>
        </div>
    </div>

    <div class="header-right">
        <div class="user-pill">
            <span class="user-role">Admin</span>
            <div class="avatar-circle">RH</div>
        </div>
    </div>
</header>

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

// Global Shortkeys (⌘K or Ctrl+K)
document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        spotlightOverlay.style.display = 'flex';
        spotlightInput.focus();
    }
    if (e.key === 'Escape') {
        spotlightOverlay.style.display = 'none';
    }
});

// Close when clicking outside modal
spotlightOverlay.addEventListener('click', (e) => {
    if (e.target === spotlightOverlay) {
        spotlightOverlay.style.display = 'none';
    }
});
</script>
