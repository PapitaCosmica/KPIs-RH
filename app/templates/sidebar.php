<aside class="sidebar">
    <div class="logo">
        <h2>KPIs-RH</h2>
    </div>
    <nav class="nav-menu">
        <ul>
            <li class="<?php echo ($url ?? '') == 'home' ? 'active' : ''; ?>"><a href="<?php echo URL_ROOT; ?>?url=home">Inicio</a></li>
            <li class="<?php echo ($url ?? '') == 'evaluaciones' ? 'active' : ''; ?>"><a href="<?php echo URL_ROOT; ?>?url=evaluaciones">Evaluaciones</a></li>
            <li><a href="<?php echo URL_ROOT; ?>?url=export/download">Reportes (Excel)</a></li>
            <li><a href="#">Configuración</a></li>
            <li class="logout-item" style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                <a href="<?php echo URL_ROOT; ?>?url=logout" style="color: #ff6b6b; font-weight: 600;">🔒 Cerrar Sesión</a>
            </li>
        </ul>
    </nav>
</aside>
