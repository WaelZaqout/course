@extends('admin.master')
@section('content')
@section('title', 'إدارة الطلاب')


<div class="container">

    {{-- Header + إحصائيات + زر إضافة --}}
   <div class="header mb-4 d-flex justify-content-between align-items-center p-3 rounded shadow-sm"
     style="background: linear-gradient(90deg, #f9fafb, #ffffff); border:1px solid #e9edf3;">

    <!-- شريط البحث -->
    <div class="search-bar position-relative" style="max-width: 320px; flex:1;">
        <input
            id="searchByName"
            type="text"
            placeholder="🔍 ابحث باسم الطالب..."
            class="form-control shadow-sm rounded-pill px-4"
            value="{{ $q ?? '' }}"
            style="border: 1px solid #d1d5db; font-size:15px;"
        >
    </div>

    <!-- العنوان -->
    <h3 class="fw-bold text-primary d-flex align-items-center ms-3 mb-0">
        <i class="bi bi-journal-text ms-2 text-secondary"></i> عرض بيانات الطلاب
    </h3>
</div>

    <div class="table-container">
        <table class="table student-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الهاتف</th>
                    <th>حالة الاشتراك</th>
                    <th> التفاصيل</th>

                </tr>

            </thead>
            <tbody id="studentsTbody">
                @include('admin.students._rows', ['students' => $students])
            </tbody>

            <div id="studentsPagination" class="mt-3">
                {{ $students->links() }}
            </div>


        </table>
    </div>

</div>



@section('js')
    <script>
        (function() {
            const input = document.getElementById('searchByName');
            const tbody = document.getElementById('studentsTbody');
            const pagerBox = document.getElementById('studentsPagination');
            const baseIndex = "{{ route('students.index') }}";

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
