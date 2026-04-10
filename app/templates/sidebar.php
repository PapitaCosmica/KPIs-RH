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
        </ul>
    </nav>
</aside>
