<?php $pageTitle = 'Categorias'; ?>
<div class="page-heading"><div><p class="eyebrow">PERSONALIZAÇÃO</p><h1>Categorias</h1><p>Separe suas tarefas por áreas ou assuntos.</p></div></div>
<div class="content-grid">
    <section class="panel"><div class="panel-heading"><div><h2>Nova categoria</h2><p>Crie uma forma de organizar suas tarefas.</p></div></div>
        <form action="/categories/store" method="post" class="form-stack"><input type="hidden" name="_token" value="<?= htmlspecialchars($token) ?>"><label>Nome da categoria<input type="text" name="name" placeholder="Ex.: Trabalho, Estudos..." maxlength="60" required></label><button class="btn btn-primary" type="submit">＋ Adicionar categoria</button></form>
    </section>
    <section class="panel"><div class="panel-heading"><div><h2>Suas categorias</h2><p><?= count($categories) ?> categoria(s)</p></div></div>
        <?php if (!$categories): ?><div class="empty-compact">Você ainda não criou categorias.</div><?php else: ?>
        <div class="category-list"><?php foreach ($categories as $category): ?><div class="category-row"><span class="category-dot"></span><strong><?= htmlspecialchars($category['name']) ?></strong><form action="/categories/delete" method="post" data-confirm="Excluir esta categoria?"><input type="hidden" name="_token" value="<?= htmlspecialchars($token) ?>"><input type="hidden" name="id" value="<?= (int)$category['id'] ?>"><button class="icon-button danger" type="submit" title="Excluir">×</button></form></div><?php endforeach; ?></div>
        <?php endif; ?>
    </section>
</div>
