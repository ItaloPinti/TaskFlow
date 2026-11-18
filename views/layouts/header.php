<?php
$loggedIn = !empty($_SESSION['user_id']);
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' · ' : '' ?>TaskFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php if ($loggedIn): ?>
<div class="app-shell">
    <aside class="sidebar">
        <a class="brand" href="/dashboard"><span class="brand-mark">T</span><span>taskflow</span></a>
        <div class="side-label">MENU</div>
        <nav class="side-nav">
            <a class="<?= $currentPath === '/dashboard' || $currentPath === '/' ? 'active' : '' ?>" href="/dashboard"><span>▦</span> Visão geral</a>
            <a class="<?= $currentPath === '/tasks' || str_starts_with($currentPath, '/tasks/') ? 'active' : '' ?>" href="/tasks"><span>✓</span> Minhas tarefas</a>
            <a class="<?= $currentPath === '/categories' ? 'active' : '' ?>" href="/categories"><span>▤</span> Categorias</a>
        </nav>
        <div class="sidebar-bottom">
            <div class="user-mini"><div class="avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?></div><div><strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuário') ?></strong><small>Minha conta</small></div></div>
            <form action="/logout" method="post">
                <input type="hidden" name="_token" value="<?= htmlspecialchars($this->csrfToken()) ?>">
                <button class="logout-button" type="submit">↗ Sair da conta</button>
            </form>
        </div>
    </aside>
    <main class="main-content">
        <header class="topbar"><span>Seu espaço de produtividade</span><span class="topbar-date"><?= date('d/m/Y') ?></span></header>
        <div class="page-wrap">
<?php else: ?>
<div class="auth-shell">
<?php endif; ?>
<?php if ($flash): ?>
    <div class="alert <?= htmlspecialchars($flash['type']) ?>"><?= htmlspecialchars($flash['message']) ?></div>
<?php endif; ?>
