@forelse($courses as $course)
    <div class="course-card"
        style="background:#fff; border-radius:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); overflow:hidden; transition:.3s; cursor:pointer;"
        onclick="window.location.href='{{ route('courses') }}?category={{ $course->category->id }}'">

        <!-- صورة الكورس -->
        <div class="course-image" style="position:relative; width:100%; height:200px; overflow:hidden;">
            <img src="{{ $course->cover ? asset('storage/' . $course->cover) : asset('images/default-course.jpg') }}"
                alt="{{ $course->title }}"
                style="width:100%; height:100%; object-fit:cover; display:block; border-radius:15px 15px 0 0;">

            <!-- شارة الأكثر مبيعًا -->
            <span
                style="position:absolute; top:10px; left:10px; background:#4CAF50; color:white;
                               padding:5px 12px; font-size:13px; border-radius:8px; font-weight:bold;">
                الأكثر مبيعًا
            </span>
        </div>

        <!-- التفاصيل -->
        <div class="course-content" style="padding:15px; text-align:right;">

            <!-- الفئة -->
            <span class="badge"
                style="background:#e0d7ff; color:#6c63ff; padding:3px 12px; border-radius:12px; font-size:13px; width: 20%;">
                {{ $course->category->name ?? 'بدون تصنيف' }}
            </span>

            <!-- العنوان -->
            <h3 style="margin:12px 0; font-size:20px; font-weight:700; color:#222;">
                {{ $course->title }}
            </h3>

            <!-- الملخص -->
            <p style="font-size:14px; color:#555; line-height:1.6; margin-bottom:10px;">
                {{ Str::limit($course->summary, 80) }}
            </p>

            <!-- عدد المسجلين + التقييم -->
            <div style="font-size:14px; color:#777; margin-bottom:8px;">
                {{ $course->students_count ?? '0' }} مسجل
                <span style="color:#FFD700; margin-left:5px;">★★★★★</span>
            </div>

            <!-- عدد الدروس والمدة -->
            <div
                style="display:flex; justify-content:space-between; font-size:14px; color:#444; margin-bottom:12px;">
                <span>📘 {{ $course->lessons_count ?? 0 }} درس</span>
                <span>⏰ {{ $course->total_minutes ?? 'غير محدد' }} ساعة</span>
            </div>

                        <!-- السعر وزر -->
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:18px; font-weight:700; color:#4CAF50;">
                                {{ $course->price }} ر.س
                            </span>

                            <a href="{{ route('coursedetails', ['id' => $course->id]) }}" class="course-btn">عرض تفاصيل
                                الكورس</a>


                        </div>
        </div>
    </div>
@empty
    <p>لا يوجد كورسات حتى الآن.</p>
@endforelse
