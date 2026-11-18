<div class="auth-card">
    <a class="brand auth-brand" href="/login"><span class="brand-mark">T</span><span>taskflow</span></a>
    <div class="auth-heading"><p class="eyebrow">BEM-VINDO DE VOLTA</p><h1>Entre na sua conta</h1><p>Organize suas tarefas e mantenha o foco no que importa.</p></div>
    <form action="/login" method="post" class="form-stack">
        <input type="hidden" name="_token" value="<?= htmlspecialchars($token) ?>">
        <label>E-mail<input type="email" name="email" placeholder="voce@exemplo.com" required autocomplete="email"></label>
        <label>Senha<input type="password" name="password" placeholder="Sua senha" required autocomplete="current-password"></label>
        <button class="btn btn-primary btn-full" type="submit">Entrar na plataforma <span>→</span></button>
    </form>
    <p class="auth-switch">Ainda não tem uma conta? <a href="/register">Criar conta</a></p>
</div>
