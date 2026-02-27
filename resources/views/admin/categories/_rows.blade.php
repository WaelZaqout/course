{{-- resources/views/admin/categories/_rows.blade.php --}}
@php
    use Illuminate\Support\Str;
@endphp

@forelse ($categories as $category)
    <tr>
        {{-- # --}}
        <td>{{ $loop->iteration }}</td>

        {{-- الاسم --}}
        <td class="name">{{ $category->name }}</td>

        {{-- الأب --}}
        {{-- <td class="parent">
            {{ optional($category->parent)->name ?? 'جذر' }}
        </td> --}}
        <td>
            <i class="{{ $category->icon }}"></i>
        </td>
        {{-- السلاج --}}
        <td class="slug">{{ $category->slug }}</td>

        {{-- الوصف (مختصر) --}}
        <td class="description">
            {{ Str::limit(strip_tags($category->description), 50) }}
        </td>

        {{-- ترتيب العرض --}}
        {{-- <td class="sort-order">
            {{ (int) $category->sort_order }}
        </td> --}}

        {{-- الحالة (تفعيل/تعطيل) --}}
        <td class="status">
            <button type="button" class="status-pill {{ $category->is_active ? 'is-active' : 'is-inactive' }}"
                data-id="{{ $category->id }}" data-url="{{ route('categories.toggle-active', $category) }}">
                {{ $category->is_active ? 'نشط' : 'غير نشط' }}
            </button>

        </td>
        {{-- الإجراءات --}}
        <td class="actions">
            <a href="#"
               class="edit-btn btn-action btn-edit"
               title="تعديل"
               data-id="{{ $category->id }}"
               data-name="{{ $category->name }}"
               data-slug="{{ $category->slug }}"
               data-description="{{ $category->description }}"
               data-icon="{{ $category->icon }}"
               data-is_active="{{ $category->is_active ? 1 : 0 }}"
               data-update-url="{{ route('categories.update', $category->id) }}">
                <i class="fas fa-edit"></i>
            </a>

            @can('حذف صفحة')
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                    class="d-inline-block delete-form" onsubmit="return confirm('تأكيد الحذف؟');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn-action btn-delete" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endcan
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted">لا توجد نتائج مطابقة.</td>
    </tr>
@endforelse
