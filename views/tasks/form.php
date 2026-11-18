<?php $editing = $task !== null; $pageTitle = $editing ? 'Editar tarefa' : 'Nova tarefa'; ?>
<div class="page-heading"><div><p class="eyebrow">ORGANIZAÇÃO</p><h1><?= $editing ? 'Editar tarefa' : 'Nova tarefa' ?></h1><p><?= $editing ? 'Atualize os detalhes da sua atividade.' : 'Adicione uma nova atividade à sua lista.' ?></p></div><a class="btn btn-light" href="/tasks">← Voltar</a></div>
<section class="panel form-panel">
    <form action="<?= $editing ? '/tasks/update' : '/tasks/store' ?>" method="post" class="form-stack">
        <input type="hidden" name="_token" value="<?= htmlspecialchars($token) ?>">
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int)$task['id'] ?>"><?php endif; ?>
        <label>Título da tarefa<input type="text" name="title" value="<?= htmlspecialchars($task['title'] ?? '') ?>" placeholder="Ex.: Finalizar relatório" maxlength="150" required></label>
        <label>Descrição <span class="optional">Opcional</span><textarea name="description" rows="4" placeholder="Adicione detalhes sobre esta tarefa..."><?= htmlspecialchars($task['description'] ?? '') ?></textarea></label>
        <div class="form-grid">
            <label>Status<select name="status"><option value="pending" <?= ($task['status'] ?? 'pending')==='pending'?'selected':'' ?>>Pendente</option><option value="in_progress" <?= ($task['status'] ?? '')==='in_progress'?'selected':'' ?>>Em andamento</option><option value="done" <?= ($task['status'] ?? '')==='done'?'selected':'' ?>>Concluída</option></select></label>
            <label>Categoria<select name="category_id"><option value="">Sem categoria</option><?php foreach ($categories as $category): ?><option value="<?= (int)$category['id'] ?>" <?= (int)($task['category_id'] ?? 0)===(int)$category['id']?'selected':'' ?>><?= htmlspecialchars($category['name']) ?></option><?php endforeach; ?></select></label>
        </div>
        <label>Data de conclusão <span class="optional">Opcional</span><input type="date" name="due_date" value="<?= htmlspecialchars($task['due_date'] ?? '') ?>"></label>
        <div class="form-actions"><a class="btn btn-light" href="/tasks">Cancelar</a><button class="btn btn-primary" type="submit"><?= $editing ? 'Salvar alterações' : 'Criar tarefa' ?></button></div>
    </form>
</section>
