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
body {
    background-color: var(--color-background);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
.login-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
}
.login-card {
    background: var(--color-surface);
    border-radius: 16px;
    padding: 3rem 2rem;
    box-shadow: 10px 10px 20px #d1d5da, -10px -10px 20px #ffffff;
    text-align: center;
}
.login-card .logo {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--color-primary);
    margin-bottom: 0.5rem;
}
.login-card h2 {
    margin: 0 0 0.5rem;
    font-size: 1.3rem;
    color: var(--color-text-dark);
}
.login-card p {
    color: var(--color-text-muted);
    font-size: 0.95rem;
    margin-bottom: 2rem;
}
.input-group input {
    width: 100%;
    padding: 1rem 1.2rem;
    border: none;
    border-radius: 12px;
    background: #f0f2f5;
    box-shadow: inset 5px 5px 10px #d1d5da, inset -5px -5px 10px #ffffff;
    font-size: 1rem;
    box-sizing: border-box;
    margin-bottom: 1.5rem;
    transition: all 0.3s;
}
.input-group input:focus {
    outline: none;
    box-shadow: inset 2px 2px 5px #d1d5da, inset -2px -2px 5px #ffffff;
}
.btn-neo {
    width: 100%;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    background: var(--color-primary);
    color: white;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 6px 6px 12px #d1d5da, -6px -6px 12px #ffffff;
    transition: all 0.3s;
}
.btn-neo:hover {
    box-shadow: inset 4px 4px 8px rgba(0,0,0,0.1), inset -4px -4px 8px rgba(255,255,255,0.2);
}
.btn-neo:focus {
    outline: none;
}
.alert.error {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    padding: 0.8rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    font-weight: 600;
}
</style>
