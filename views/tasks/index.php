<?php $pageTitle = 'Minhas tarefas'; ?>
<div class="page-heading"><div><p class="eyebrow">ORGANIZAÇÃO</p><h1>Minhas tarefas</h1><p>Gerencie suas atividades em um só lugar.</p></div><a class="btn btn-primary" href="/tasks/create">＋ Nova tarefa</a></div>
<section class="panel">
    <div class="panel-heading"><div><h2>Lista de tarefas</h2><p><?= count($tasks) ?> atividade(s) cadastrada(s)</p></div><input class="search-input" id="taskSearch" type="search" placeholder="Buscar tarefa..."></div>
    <?php if (!$tasks): ?><div class="empty-state"><div class="empty-icon">✓</div><h3>Nenhuma tarefa por aqui</h3><p>Adicione uma tarefa para começar a se organizar.</p><a class="btn btn-primary" href="/tasks/create">Adicionar tarefa</a></div>
    <?php else: ?>
    <div class="task-list" id="taskList">
    <?php foreach ($tasks as $task): ?>
        <div class="task-row searchable-task" data-search="<?= htmlspecialchars(strtolower($task['title'].' '.$task['description'].' '.($task['category_name'] ?? ''))) ?>">
            <div class="task-check <?= $task['status']==='done'?'checked':'' ?>"><?= $task['status']==='done'?'✓':'' ?></div>
            <div class="task-info"><strong><?= htmlspecialchars($task['title']) ?></strong><small><?= htmlspecialchars($task['category_name'] ?? 'Sem categoria') ?><?= $task['due_date'] ? ' · Prazo ' . date('d/m/Y', strtotime($task['due_date'])) : '' ?></small></div>
            <span class="status status-<?= htmlspecialchars($task['status']) ?>"><?= ['pending'=>'Pendente','in_progress'=>'Em andamento','done'=>'Concluída'][$task['status']] ?></span>
            <a class="icon-link" href="/tasks/edit?id=<?= (int)$task['id'] ?>" title="Editar">✎</a>
            <form action="/tasks/delete" method="post" data-confirm="Tem certeza que deseja excluir esta tarefa?"><input type="hidden" name="_token" value="<?= htmlspecialchars($token) ?>"><input type="hidden" name="id" value="<?= (int)$task['id'] ?>"><button class="icon-button danger" title="Excluir" type="submit">×</button></form>
        </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>
