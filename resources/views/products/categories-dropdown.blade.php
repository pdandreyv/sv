<div class="form-group">
    <label for="main_category" class="required">Основная категория</label>
    <select id="main_category" name="main_category_id" class="form-control">
        <option value="">Выберите категорию</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ (isset($current_main) && $current_main == $category->id) ? 'selected' : '' }}>
                {{ $category->title }}
            </option>
        @endforeach
    </select>
</div>

<div id="subcategories-container" class="form-group" style="display: none;">
    <label for="sub_category" class="required">Подкатегория</label>
    <select id="sub_category" name="category_id" class="form-control">
        <option value="">Выберите подкатегорию</option>
    </select>
</div>

<script>
function loadSubcategories(mainCategoryId) {
    const subcategoriesContainer = document.getElementById('subcategories-container');
    const subCategorySelect = document.getElementById('sub_category');
    
    console.log('Загрузка подкатегорий для категории ID:', mainCategoryId);
    
    if (!mainCategoryId) {
        subcategoriesContainer.style.display = 'none';
        subCategorySelect.innerHTML = '<option value="">Выберите подкатегорию</option>';
        return;
    }
    
    // Показать контейнер подкатегорий
    subcategoriesContainer.style.display = 'block';
    
    // Загрузить подкатегории через AJAX
    fetch(`/api/categories/${mainCategoryId}/subcategories`)
        .then(response => {
            console.log('Ответ сервера:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Получены подкатегории:', data);
            subCategorySelect.innerHTML = '<option value="">Выберите подкатегорию</option>';
            if (data && data.length > 0) {
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.title;
                    subCategorySelect.appendChild(option);
                });
                
                // Устанавливаем выбранную подкатегорию после загрузки
                @if(isset($current_sub) && $current_sub)
                    subCategorySelect.value = '{{ $current_sub }}';
                @endif
            } else {
                console.log('Подкатегории не найдены для категории:', mainCategoryId);
            }
        })
        .catch(error => {
            console.error('Ошибка загрузки подкатегорий:', error);
            subcategoriesContainer.style.display = 'none';
        });
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    const mainCategorySelect = document.getElementById('main_category');
    const subCategorySelect = document.getElementById('sub_category');
    
    // Добавляем обработчик события изменения
    mainCategorySelect.addEventListener('change', function() {
        loadSubcategories(this.value);
    });
    
    // Если есть выбранная основная категория, загружаем подкатегории
    if (mainCategorySelect.value) {
        loadSubcategories(mainCategorySelect.value);
    }
});
</script>
