document.addEventListener('DOMContentLoaded', function () {

    // Функция инициализации TinyMCE на одном textarea
    function initTiny(textarea) {
        if (tinymce.get(textarea.id)) return; // уже инициализирован

        // Генерируем id если нет
        if (!textarea.id) {
            textarea.id = 'tiny_' + Math.random().toString(36).substring(2, 10);
        }

        tinymce.init({
            selector: '#' + textarea.id,
            height: 400,
            menubar: false,
            plugins: 'image code lists',
            toolbar: 'undo redo | bold italic | bullist numlist | image | code',
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*';
                    input.onchange = function () {
                        const file = this.files[0];
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            callback(e.target.result, {alt: file.name});
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            }
        });
    }

    // Инициализация всех существующих textarea с классом tiny
    document.querySelectorAll('textarea.tiny').forEach(initTiny);

    // Отслеживаем динамически добавленные textarea
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (node.tagName === 'TEXTAREA' && node.classList.contains('tiny')) {
                    initTiny(node);
                }
                // Если добавляется контейнер с несколькими textarea
                if (node.querySelectorAll) {
                    node.querySelectorAll('textarea.tiny').forEach(initTiny);
                }
            });
        });
    });

    observer.observe(document.body, {childList: true, subtree: true});
});
