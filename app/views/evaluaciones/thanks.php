<div class="glass-container success-card" style="max-width: 600px; margin: 5rem auto; text-align: center; padding: 4rem;">
    <div class="success-icon" style="font-size: 5rem; color: #4CAF50; margin-bottom: 2rem;">
        <i class="fas fa-check-circle"></i>
    </div>
    <h1 style="color: var(--color-night); margin-bottom: 1rem;">¡Muchas Gracias!</h1>
    <p style="font-size: 1.2rem; color: var(--color-deep-slate); margin-bottom: 3rem;">
        Tu evaluación ha sido registrada correctamente. Tu feedback es vital para seguir mejorando.
    </p>
    <a href="<?php echo URL_ROOT; ?>" class="btn-neo btn-primary" style="display: inline-block; padding: 1rem 2rem; background: var(--color-ice-blue); color: white; text-decoration: none; border-radius: 12px;">
        Volver al Inicio
    </a>
</div>

<style>
.success-card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
