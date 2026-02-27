@extends('admin.master')
@section('content')
@section('title', 'إدارة الأقسام')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
    <div class="header">
        <div class="search-bar mb-3">
            <input id="searchByName" type="text" placeholder="الاسم" class="form-control" value="{{ $q ?? '' }}">

        </div>

        <a href="#" class="add-button">
            <i class="fas fa-plus"></i> إضافة قسم
        </a>
    </div>
    <div class="table-container">
        <table class="table category-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الايقونة</th>
                    <th>الرابط المختصر</th>
                    <th>الوصف</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody id="categoriesTbody">
                @include('admin.categories._rows', ['categories' => $categories])
            </tbody>

            <div id="categoriesPagination" class="mt-3">
                {{ $categories->links() }}
            </div>


        </table>
    </div>

</div>



<!-- Responsive Modal -->
<div id="modalOverlay" class="modal-overlay">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">إضافة قسم جديد</h3>
            <button id="closeModalBtn" class="close-btn">&times;</button>
        </div>

        <div class="modal-body">
            {{-- ملاحظة: سيُستبدل الـaction و _method ديناميكياً عند التعديل --}}
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                id="categoryForm">
                @csrf
                <input type="hidden" id="methodSpoof" name="_method" value=""> {{-- 'PUT' عند التعديل --}}
                <input type="hidden" id="formAction" value="{{ route('categories.store') }}"> {{-- للتبديل JS --}}

                <div class="form-grid">
                    {{-- الاسم --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="name">
                            <i class="fas fa-tag me-2"></i>اسم الفئة
                        </label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="أدخل اسم الفئة"
                            value="{{ old('name') }}"
                            {{ !auth()->user()->can('إضافة تصنيف') && !auth()->user()->can('تعديل تصنيف') ? 'disabled' : '' }}
                            required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- الرابط المختصر (slug) --}}
                    <div class="form-group has-icon">
                        <label class="form-label" for="slug">
                            <i class="fas fa-link me-2"></i>الرابط المختصر
                        </label>
                        <input type="text" id="slug" name="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            placeholder="أدخل الرابط المختصر (مثال: web-development)" value="{{ old('slug') }}"
                            {{ !auth()->user()->can('إضافة تصنيف') && !auth()->user()->can('تعديل تصنيف') ? 'disabled' : '' }}
                            required>
                        @error('slug')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group has-icon">
                        <label for="icon">Icon Class</label>
                        <input type="text" name="icon" id="icon" class="form-control"
                               placeholder="مثال: fas fa-laptop-code" required>
                        @error('icon')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        <!-- Preview مباشر -->
                        <div class="mt-2">
                            <p>Preview:</p>
                            <i id="icon_preview" class="fa-2x"></i>
                        </div>
                    </div>

                    {{-- التصنيف الأب --}}
                    {{-- <div class="form-group has-icon">
                        <label class="form-label" for="parent_id">
                            <i class="fas fa-sitemap me-2"></i>التصنيف الأب
                        </label>
                        <select
                            id="parent_id"
                            name="parent_id"
                            class="form-control @error('parent_id') is-invalid @enderror"
                            {{ !auth()->user()->can('إضافة تصنيف') && !auth()->user()->can('تعديل تصنيف') ? 'disabled' : '' }}
                        >
                            <option value="">— جذر —</option>
                            @foreach ($parents ?? [] as $p)
                                <option value="{{ $p->id }}" {{ old('parent_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div> --}}

                    {{-- ترتيب العرض --}}
                    {{-- <div class="form-group has-icon">
                        <label class="form-label" for="sort_order">
                            <i class="fas fa-sort-numeric-down me-2"></i>ترتيب العرض
                        </label>
                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            placeholder="0"
                            min="0"
                            value="{{ old('sort_order', 0) }}"
                            {{ !auth()->user()->can('إضافة تصنيف') && !auth()->user()->can('تعديل تصنيف') ? 'disabled' : '' }}
                        >
                        <small class="text-muted">كلما صغر الرقم ظهر العنصر أعلى القوائم.</small>
                        @error('sort_order') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div> --}}

                    {{-- الحالة (مُفعل) --}}
                    {{-- <div class="form-group has-icon">
                        <label class="form-label" for="is_active">
                            <i class="fas fa-toggle-on me-2"></i>الحالة
                        </label>
                        <div class="d-flex align-items-center gap-2">
                            <label class="switch">
                                <input
                                    type="checkbox"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', 1) ? 'checked' : '' }}
                                    {{ !auth()->user()->can('إضافة تصنيف') && !auth()->user()->can('تعديل تصنيف') ? 'disabled' : '' }}
                                >
                                <span class="slider round"></span>
                            </label>
                            <span id="isActiveLabel">{{ old('is_active', 1) ? 'نشط' : 'غير نشط' }}</span>
                        </div>
                        @error('is_active') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div> --}}

                    {{-- الوصف --}}
                    <div class="form-group full-width">
                        <label for="description">
                            <i class="fas fa-newspaper me-2"></i>المحتوى الكامل
                        </label>
                        <textarea name="description" id="editor" class="form-control @error('description') is-invalid @enderror"
                            rows="8">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button id="cancelBtn" class="btn btn-secondary">إلغاء</button>
            <button id="saveBtn" class="btn btn-primary">حفظ</button>
        </div>
    </div>
</div>

@section('js')
    <script>
        // عناصر المودال والحقول
        const modalOverlay = document.getElementById('modalOverlay');
        const modalTitle = document.getElementById('modalTitle');
        const categoryForm = document.getElementById('categoryForm');
        const methodSpoof = document.getElementById('methodSpoof');

        const openModalBtn = document.querySelector('.add-button');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');

        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon_preview');

        // سنخزن المعرف هنا لو تعديل
        let currentCategoryId = null;

        function openModal(editMode = false, data = null) {
            modalOverlay.classList.add('active');

            if (editMode && data) {
                modalTitle.textContent = 'تعديل القسم';
                currentCategoryId = data.id;

                nameInput.value = data.name || '';
                slugInput.value = data.slug || '';
                iconInput.value = data.icon || '';
                if (iconPreview) {
                    iconPreview.className = `fa-2x ${data.icon || ''}`;
                }

                // تعبئة CKEditor عند التعديل
                if (window.CKEDITOR && CKEDITOR.instances.editor) {
                    CKEDITOR.instances.editor.setData(data.description || '');
                }

                categoryForm.action = data.updateUrl;
                methodSpoof.value = 'PUT';
            } else {
                modalTitle.textContent = 'إضافة قسم جديد';
                currentCategoryId = null;

                categoryForm.reset();
                if (iconPreview) {
                    iconPreview.className = 'fa-2x';
                }
                // تفريغ CKEditor عند الإضافة
                if (window.CKEDITOR && CKEDITOR.instances.editor) {
                    CKEDITOR.instances.editor.setData('');
                }

                categoryForm.action = "{{ route('categories.store') }}";
                methodSpoof.value = '';
            }
        }

        function closeModal() {
            modalOverlay.classList.remove('active');
        }

        // زر إضافة: مودال فارغ
        openModalBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal(false, null);
        });

        // أزرار تعديل: مودال معبأ + action/updateUrl
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const data = {
                    id: btn.dataset.id,
                    name: btn.dataset.name,
                    slug: btn.dataset.slug,
                    description: btn.dataset.description,
                    status: btn.dataset.status,
                    updateUrl: btn.dataset.updateUrl // تأكد إضافتها في Blade
                };
                openModal(true, data);
            });
        });

        // إغلاق
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });

        // حفظ: submit فعلي
        saveBtn.addEventListener('click', (e) => {
            e.preventDefault();
            // مزامنة CKEditor مع textarea قبل الإرسال
            if (window.CKEDITOR && CKEDITOR.instances.editor) {
                CKEDITOR.instances.editor.updateElement();
            }
            if (categoryForm.checkValidity()) {
                categoryForm.submit();
            } else {
                categoryForm.reportValidity();
            }
        });
    </script>
    <script>
        (function() {
            const input = document.getElementById('searchByName');
            const tbody = document.getElementById('categoriesTbody');
            const pagerBox = document.getElementById('categoriesPagination');
            const baseIndex = "{{ route('categories.index') }}";

            let timer = null;

            function runSearch(url) {
                const finalUrl = new URL(url || baseIndex, window.location.origin);
                // ضمّن قيمة البحث الحالية في الرابط
                const q = (input?.value || '').trim();
                if (q !== '') finalUrl.searchParams.set('q', q);
                else finalUrl.searchParams.delete('q');

                // حالة تحميل بسيطة
                if (input) input.disabled = true;

                fetch(finalUrl.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (tbody && data.rows !== undefined) {
                            tbody.innerHTML = data.rows;
                        }
                        if (pagerBox && data.pagination !== undefined) {
                            pagerBox.innerHTML = data.pagination;
                        }
                        // حدّث شريط العنوان بدون إعادة تحميل
                        if (window.history && window.history.replaceState) {
                            window.history.replaceState({}, '', finalUrl.toString());
                        }
                    })
                    .catch(() => {
                        // تقدر تعرض Toast خطأ هنا لو عندك util
                        console.error('Search failed');
                    })
                    .finally(() => {
                        if (input) input.disabled = false;
                    });
            }

            // Debounce on input
            if (input) {
                input.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => runSearch(baseIndex), 300);
                });
            }

            // AJAX pagination (تفويض أحداث)
            document.addEventListener('click', function(e) {
                const a = e.target.closest('#categoriesPagination a');
                if (!a) return;
                e.preventDefault();
                runSearch(a.href);
            });


        })();
    </script>

@endsection
@endsection
