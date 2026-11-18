document.addEventListener('DOMContentLoaded', () => {
    const search = document.getElementById('taskSearch');
    if (search) {
        search.addEventListener('input', () => {
            const term = search.value.toLowerCase().trim();
            document.querySelectorAll('.searchable-task').forEach(row => {
                row.hidden = !row.dataset.search.includes(term);
            });
        });
    }

    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', event => {
            if (!window.confirm(form.dataset.confirm)) event.preventDefault();
        });
    });
});
