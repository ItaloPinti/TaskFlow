<?php $pageTitle = 'Visão geral'; ?>
<div class="page-heading">
    <div><p class="eyebrow">PAINEL DE CONTROLE</p><h1>Olá, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]) ?> <span class="wave">✦</span></h1><p>Aqui está um resumo do que está acontecendo.</p></div>
    <a class="btn btn-primary" href="/tasks/create">＋ Nova tarefa</a>
</div>
<div class="stats-grid">
    <article class="stat-card"><div class="stat-top"><span>Total de tarefas</span><span class="stat-icon">▦</span></div><strong><?= (int)($counts['total'] ?? 0) ?></strong><small>Suas tarefas cadastradas</small></article>
    <article class="stat-card"><div class="stat-top"><span>Pendentes</span><span class="stat-icon amber">◷</span></div><strong><?= (int)($counts['pending'] ?? 0) ?></strong><small>Aguardando início</small></article>
    <article class="stat-card"><div class="stat-top"><span>Em andamento</span><span class="stat-icon blue">↗</span></div><strong><?= (int)($counts['in_progress'] ?? 0) ?></strong><small>Você está trabalhando</small></article>
    <article class="stat-card"><div class="stat-top"><span>Concluídas</span><span class="stat-icon green">✓</span></div><strong><?= (int)($counts['done'] ?? 0) ?></strong><small>Bom trabalho!</small></article>
</div>
<section class="panel">
    <div class="panel-heading"><div><h2>Tarefas recentes</h2><p>Acompanhe suas atividades mais recentes.</p></div><a class="text-link" href="/tasks">Ver todas <span>→</span></a></div>
    <?php if (!$tasks): ?>
        <div class="empty-state"><div class="empty-icon">✦</div><h3>Sua lista começa aqui</h3><p>Crie sua primeira tarefa e organize suas prioridades.</p><a class="btn btn-primary" href="/tasks/create">Criar primeira tarefa</a></div>
    <?php else: ?>
        <div class="task-list">
        <?php foreach ($tasks as $task): ?>
            <div class="task-row"><div class="task-check <?= $task['status']==='done'?'checked':'' ?>"><?= $task['status']==='done'?'✓':'' ?></div><div class="task-info"><strong><?= htmlspecialchars($task['title']) ?></strong><small><?= htmlspecialchars($task['category_name'] ?? 'Sem categoria') ?><?= $task['due_date'] ? ' · Prazo ' . date('d/m/Y', strtotime($task['due_date'])) : '' ?></small></div><span class="status status-<?= htmlspecialchars($task['status']) ?>"><?= ['pending'=>'Pendente','in_progress'=>'Em andamento','done'=>'Concluída'][$task['status']] ?></span><a class="icon-link" href="/tasks/edit?id=<?= (int)$task['id'] ?>" aria-label="Editar tarefa">↗</a></div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
