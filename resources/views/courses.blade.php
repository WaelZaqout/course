@extends('master')
@section('content')
    <style>
        /* ========== Reset & Base ========== */

        .section {
            text-align: center;
            padding: var(--space-60) 0 var(--space-40);
            color: var(--heading-color);
            background: none;
            padding-top: 80px;
            text-align: center;
            align-items: center;
        }

        section h1 {
            font-size: calc(var(--font-size-lg) + 6px);
            margin-bottom: var(--space-12);
            text-shadow: var(--shadow-sm);
        }

        section p {
            font-size: var(--font-size-sm);
            color: var(--muted-text);
            max-width: 700px;
            margin: 0 auto;
        }

        /* ========== فلاتر/أزرار ========== */
        .filters {
            display: flex;
            justify-content: center;
            gap: var(--space-12);
            margin: var(--space-28) 0;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: var(--btn-outline-bg);
            color: var(--btn-outline-text);
            border: 1px solid var(--btn-outline-border);
            padding: var(--btn-padding-y) var(--btn-padding-x);
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: all var(--transition-med);
            box-shadow: var(--shadow-sm);
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--btn-outline-hover-bg);
            transform: translateY(-2px);
        }

        /* ========== شبكة الكورسات ========== */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: var(--space-24);
            margin-top: var(--space-20);
        }

        /* ========== كرت الكورس ========== */
        .course-card {
            background: var(--card-bg);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-med);
            transform: translateY(0);
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .course-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background: var(--section-bg);
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-med);
        }

        .course-card:hover .course-image img {
            transform: scale(1.06);
        }

        .course-badge {
            position: absolute;
            top: var(--space-12);
            left: var(--space-12);
            background: var(--accent-color);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: var(--shadow-sm);
        }

        .course-content {
            padding: var(--space-24);
            background: var(--section-bg);
        }

        .course-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--heading-color);
            margin-bottom: var(--space-12);
            line-height: 1.3;
        }

        .course-instructor {
            color: var(--muted-text);
            font-size: 0.95rem;
            margin-bottom: var(--space-16);
            display: flex;
            align-items: center;
            gap: var(--space-8);
        }

        /* معلومات مختصرة */
        .course-info {
            display: flex;
            justify-content: space-between;
            margin: var(--space-20) 0;
            padding: var(--space-16) 0;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: var(--space-8);
            color: var(--muted-text);
            font-size: 0.9rem;
        }

        .info-item i {
            color: var(--primary-color);
        }

        /* التقدّم */
        .course-progress {
            margin: var(--space-12) 0;
        }

        .progress-bar {
            height: 8px;
            background: #ecf0f1;
            border-radius: 4px;
            overflow: hidden;
            margin: var(--space-8) 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 4px;
            transition: width var(--transition-med);
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--muted-text);
        }

        /* ذيل الكرت */
        .course-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: var(--space-16);
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--warning-color);
            font-weight: 700;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .free {
            color: var(--accent-color);
            font-weight: 700;
        }

        /* زر التسجيل — استخدم .btn-primary الجاهزة */
        .btn-enroll {
            composes: btn-primary;
            /* إن لم تدعم أداة البناء خاصية composes، انسخ خصائص .btn-primary أدناه */
        }

        /* نسخة fallback للمتصفحات بدون composes */
        .btn-enroll {
            background: var(--btn-bg);
            color: var(--btn-text);
            border-radius: 50px;
            padding: var(--btn-padding-y) var(--btn-padding-x);
            font-weight: var(--btn-font-weight);
            border: none;
            box-shadow: var(--btn-shadow);
            transition: all var(--transition-med);
            display: inline-flex;
            align-items: center;
            gap: var(--space-8);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-enroll:hover {
            background: var(--btn-hover);
            transform: translateY(-2px);
        }

        /* الموديولات داخل الكرت */
        .modules {
            margin-top: var(--space-12);
            border-top: 1px solid var(--border-color);
            padding-top: var(--space-12);
        }

        .modules-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: var(--space-8);
            display: flex;
            align-items: center;
            gap: var(--space-8);
        }

        .module-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 0.92rem;
            color: var(--text-color);
            border-bottom: 1px solid #f3f4f6;
        }

        .module-item:last-child {
            border-bottom: none;
        }

        .module-duration {
            color: var(--muted-text);
            font-size: 0.85rem;
        }

        /* ========== شريط البحث ========== */
        .search-container {
            max-width: 600px;
            margin: var(--space-20) auto;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-lg);
            font-size: 1rem;
            box-shadow: var(--shadow-md);
            background: #fff;
            backdrop-filter: blur(10px);
            padding-right: 50px;
        }

        .search-box::placeholder {
            color: var(--muted-text);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted-text);
        }

        /* وسم التصنيف */
        .category-tag {
            display: inline-block;
            background: rgba(79, 70, 229, 0.08);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: var(--space-8);
        }

        /* ========== موحدات النصوص ========== */
        h1,
        h2,
        h3 {
            color: var(--heading-color);
            font-family: var(--font-main);
        }

        p {
            font-size: var(--font-size-sm);
            color: var(--muted-text);
        }

        /* ========== أزرار عامة ========== */
        .btn-primary {
            background: var(--btn-bg);
            color: var(--btn-text);
            border-radius: var(--btn-radius);
            padding: var(--btn-padding-y) var(--btn-padding-x);
            font-weight: var(--btn-font-weight);
            border: none;
            box-shadow: var(--btn-shadow);
            transition: all var(--transition-med);
        }

        .btn-primary:hover {
            background: var(--btn-hover);
            transform: translateY(-2px);
        }

        /* ========== أنيميشن خفيفة ========== */
        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== استجابة ========== */
        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }

            header h1 {
                font-size: calc(var(--font-size-md) + 6px);
            }

            .filters {
                flex-direction: column;
                align-items: center;
            }

            .filter-btn {
                width: 100%;
                max-width: 320px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: var(--space-16);
            }

            header {
                padding: var(--space-40) 0 var(--space-20);
            }

            header h1 {
                font-size: calc(var(--font-size-md));
            }

            .course-card {
                margin-bottom: var(--space-20);
            }
        }
    </style>

    <div class="container">
        <div class="section">
            <h1>📚 المقررات التعليمية</h1>
            <p>اكتشف أفضل الدورات التعليمية في مختلف المجالات وطور مهاراتك مع أفضل المدربين</p>
        </div>
        <form method="GET" action="{{ route('courses') }}" id="filterForm">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" class="search-box" placeholder="ابحث عن مقرر دراسي..." value="{{ request('search') }}">
                <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--muted-text); cursor: pointer;">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="filters">
                <button type="submit" name="category" value="" class="filter-btn {{ !request('category') ? 'active' : '' }}">الكل</button>
                @foreach ($categories as $category)
                    <button type="submit" name="category" value="{{ $category->id }}" class="filter-btn {{ request('category') == $category->id ? 'active' : '' }}">{{ $category->name }}</button>
                @endforeach
            </div>
        </form>

        <div class="courses-grid" id="coursesGrid">
            @include('partials.courses_grid')
        </div>
    </div>
    @section('js')
        <script>
            // AJAX filtering for search and categories
            function fetchCourses(category = '', search = '') {
                $.ajax({
                    url: '{{ route("courses") }}',
                    type: 'GET',
                    data: {
                        category: category,
                        search: search
                    },
                    success: function(response) {
                        $('#coursesGrid').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching courses:', error);
                    }
                });
            }

            // Handle category button clicks
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const category = this.value;
                    const search = document.querySelector('.search-box').value;
                    fetchCourses(category, search);

                    // Update active class
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Handle search input
            let searchTimeout;
            document.querySelector('.search-box').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const search = this.value;
                const activeCategory = document.querySelector('.filter-btn.active').value || '';
                searchTimeout = setTimeout(() => {
                    fetchCourses(activeCategory, search);
                }, 500); // Debounce search
            });

            // Handle search button click
            document.querySelector('.search-container button').addEventListener('click', function(e) {
                e.preventDefault();
                const search = document.querySelector('.search-box').value;
                const activeCategory = document.querySelector('.filter-btn.active').value || '';
                fetchCourses(activeCategory, search);
            });
        </script>
    @endsection
@endsection
