<!-- Add Course Modal -->
<div id="add-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">إضافة كورس جديد</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>

        <form id="add-form" action="{{ route('profile.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- صف 1 -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">عنوان الكورس</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">تاريخ النشر</label>
                    <input type="text" name="published_at" class="form-control" value="{{ now()->format('Y-m-d') }}"
                        readonly>
                </div>

            </div>

            <!-- صف 2 -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">التصنيف</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">اختر التصنيف</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">المدرّس</label>
                    <input type="hidden" name="teacher_id" value="{{ auth()->id() }}">
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>

                </div>
            </div>


            <!-- صف 4 -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">السعر</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price') }}">
                    @error('price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">سعر العرض</label>
                    <input type="number" name="sale_price" class="form-control" step="0.01" value="{{ old('sale_price') }}">
                    @error('sale_price')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <!-- صف 6 -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">صورة الغلاف</label>
                    <input type="file" name="cover" class="form-control" accept="image/*">
                    @error('cover')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">فيديو المقدمة</label>
                    <input type="file" name="intro_video" class="form-control" accept="video/*">
                    @error('intro_video')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- صف 7 -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">عدد ساعات الكورس</label>
                    <input type="number" name="total_minutes" class="form-control" min="0" step="0.5"
                        placeholder="مثال: 10" value="{{ old('total_minutes') }}">
                    @error('total_minutes')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- ملخص -->
            <div class="form-group">
                <label class="form-label">ملخص الكورس</label>
                <textarea name="summary" class="form-control" rows="3">{{ old('summary') }}</textarea>
                @error('summary')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- الأزرار -->
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">إلغاء</button>
                <button type="submit" class="btn-primary">إضافة الكورس</button>
            </div>
        </form>
    </div>
</div>

<style>
    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 4px;
    }
</style>
