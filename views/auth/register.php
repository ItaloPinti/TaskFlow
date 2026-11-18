<div class="auth-card">
    <a class="brand auth-brand" href="/register"><span class="brand-mark">T</span><span>taskflow</span></a>
    <div class="auth-heading"><p class="eyebrow">COMECE AGORA</p><h1>Crie sua conta</h1><p>Um espaço simples para tirar seus planos do papel.</p></div>
    <form action="/register" method="post" class="form-stack">
        <input type="hidden" name="_token" value="<?= htmlspecialchars($token) ?>">
        <label>Nome completo<input type="text" name="name" placeholder="Como podemos te chamar?" required maxlength="100" autocomplete="name"></label>
        <label>E-mail<input type="email" name="email" placeholder="voce@exemplo.com" required autocomplete="email"></label>
        <label>Senha<input type="password" name="password" placeholder="Mínimo de 8 caracteres" required minlength="8" autocomplete="new-password"></label>
        <button class="btn btn-primary btn-full" type="submit">Criar minha conta <span>→</span></button>
    </form>
    <p class="auth-switch">Já possui uma conta? <a href="/login">Fazer login</a></p>
</div>
