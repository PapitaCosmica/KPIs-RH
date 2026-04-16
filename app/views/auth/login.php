<div class="login-container">
    <div class="login-card">
        <div class="logo">🔒 KPIs-RH</div>
        <h2>Acceso Restringido</h2>
        <p>Por favor ingresa la contraseña para acceder al Dashboard de Onboarding.</p>
        
        <?php if(isset($_GET['err'])): ?>
            <div class="alert error">Contraseña incorrecta. Intenta nuevamente.</div>
        <?php endif; ?>

        <form action="<?php echo URL_ROOT; ?>?url=login/submit" method="POST">
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña..." required autofocus autocomplete="off">
            </div>
            <button type="submit" class="btn-neo">Entrar</button>
        </form>
    </div>
</div>

<style>
/* Override default content wrapper for isolated login screen */
.content-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90vh; /* Adjust for MAC window wrapper */
    background: var(--color-frost);
    padding: 0;
}

.login-container {
    width: 100%;
    max-width: 420px;
    padding: 20px;
}
.login-card {
    background: white;
    border-radius: 20px;
    padding: 3.5rem 2.5rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    text-align: center;
}
.login-card .logo {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--color-ice-blue);
    margin-bottom: 0.5rem;
}
.login-card h2 {
    margin: 0 0 1rem;
    font-size: 1.4rem;
    color: var(--color-night);
}
.login-card p {
    color: var(--color-deep-slate);
    font-size: 0.95rem;
    margin-bottom: 2.5rem;
    line-height: 1.5;
}
.input-group input {
    width: 100%;
    padding: 1.2rem;
    border: none;
    border-radius: 12px;
    background: var(--color-snow);
    box-shadow: inset 2px 2px 5px rgba(0,0,0,0.05);
    font-size: 1rem;
    box-sizing: border-box;
    margin-bottom: 2rem;
    transition: all 0.3s;
    color: var(--color-deep-slate);
}
.input-group input:focus {
    outline: none;
    box-shadow: inset 1px 1px 3px rgba(0,0,0,0.1);
    background: white;
}
.btn-neo {
    width: 100%;
    padding: 1.2rem;
    border: none;
    border-radius: 12px;
    background: var(--color-ice-blue);
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    box-shadow: 0 10px 20px rgba(129, 161, 193, 0.3);
    transition: all 0.3s;
}
.btn-neo:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px rgba(129, 161, 193, 0.4);
}
.btn-neo:focus {
    outline: none;
}
.alert.error {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    font-size: 0.95rem;
    font-weight: 600;
}
</style>
