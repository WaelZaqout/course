@extends('profile.master')
@section('title', 'ملفي الشخصي')
@section('content')
    <!-- Main Content -->

            <!-- Main Content -->
            <div class="main-content">
                <div id="profile" class="tab-content active">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h2 class="section-title">تفاصيل الكورس</h2>


                    </div>

                    <div class="course-details">
                        <!-- عنوان الكورس -->
                        <div class="course-header">
                            <h2>🎓 {{ $course->title }}</h2>
                        </div>

                        <!-- صورة + ملخص -->
                        <div style="display:flex; gap:20px; margin:20px 0;">
                            <div style="flex:1;">
                                <img src="{{ $course->cover ? asset('storage/' . $course->cover) : asset('images/default-course.jpg') }}"
                                    alt="{{ $course->title }}"
                                    style="width:100%; max-height:280px; border-radius:15px; object-fit:cover;">
                            </div>
                            <div style="flex:1; display:flex; flex-direction:column; justify-content:center;">
                                <span
                                    style="background:#6c63ff; color:#fff; padding:5px 12px; border-radius:8px; font-size:13px; margin-bottom:10px;">
                                    {{ $course->category->name ?? 'بدون تصنيف' }}
                                </span>
                                <p class="course-summary">{{ $course->summary }}</p>
                                <p style="font-size:18px; font-weight:700; color:#4CAF50;">💰 {{ $course->price }} ر.س
                                </p>
                            </div>
                        </div>

                        <!-- قسم الفيديوهات -->
                        <!-- قسم الفيديوهات (عرض فقط للطالب) -->
                        <div>
                            <h3>🎬 دروس الكورس</h3>

                            @forelse($course->sections as $section)
                                <div class="lesson-card"
                                    style="margin-bottom:20px; border:1px solid #ddd; border-radius:10px; padding:15px; background:#fff;">

                                    <div class="lesson-header"
                                        style="display:flex; justify-content:space-between; align-items:center;">
                                        <h4 style="margin:0;">📚 {{ $section->title }}</h4>
                                    </div>

                                    @if ($section->lessons->count())
                                        @foreach ($section->lessons as $lesson)
                                            <div class="lesson-card"
                                                style="margin-top:10px; padding:10px; border:1px solid #eee; border-radius:8px;">

                                                <!-- عنوان الدرس مع السهم -->
                                                <div class="lesson-title"
                                                    style="cursor:pointer; display:flex; justify-content:space-between; align-items:center;"
                                                    onclick="toggleLesson({{ $lesson->id }})">
                                                    {{ $lesson->title }}
                                                    <span id="arrow-{{ $lesson->id }}">▶</span>
                                                </div>

                                                <!-- المحتوى -->
                                                <div class="lesson-content" id="lesson-{{ $lesson->id }}"
                                                    style="display:none; margin-top:10px;">

                                                    @if ($lesson->video_path)
                                                        <video width="100%" height="240" style="border-radius:10px;"
                                                            controls>
                                                            <source src="{{ asset('storage/' . $lesson->video_path) }}"
                                                                type="video/mp4">
                                                            متصفحك لا يدعم الفيديو
                                                        </video>
                                                    @elseif($lesson->file_path)
                                                        <a href="{{ asset('storage/' . $lesson->file_path) }}"
                                                            target="_blank" class="btn-primary">
                                                            📂 تحميل الملف
                                                        </a>
                                                    @elseif($lesson->body)
                                                        <p>{{ $lesson->body }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p style="color:#777; margin-top:10px;">🚫 لا يوجد دروس في هذا السكشن</p>
                                    @endif
                                </div>
                            @empty
                                <p style="margin-top:20px; color:#777; text-align:center;">🚫 لا يوجد سكاشن بعد</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>


    <!-- Modal إضافة درس -->

    <script>
        function openModal() {
            document.getElementById('add-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('add-modal').classList.remove('active');
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('add-modal');
            if (e.target === modal) closeModal();
        });

        function toggleLesson(id) {
            let el = document.getElementById('lesson-' + id);
            let icon = document.getElementById('icon-' + id);

            if (el.style.display === "block") {
                el.style.display = "none";
                icon.style.transform = "rotate(0deg)";
            } else {
                el.style.display = "block";
                icon.style.transform = "rotate(180deg)";
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("video").forEach(video => {
                video.addEventListener("loadedmetadata", function() {
                    let duration = video.duration; // المدة بالثواني
                    let hours = Math.floor(duration / 3600);
                    let minutes = Math.floor((duration % 3600) / 60);
                    let seconds = Math.floor(duration % 60);

                    let formatted = hours > 0 ?
                        `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}` :
                        `${minutes}:${seconds.toString().padStart(2, '0')}`;

                    // حطها في span
                    video.closest(".lesson-content").querySelector(".video-duration").textContent =
                        formatted;
                });
            });
        });
    </script>
    <script>
        function toggleLesson(id) {
            let content = document.getElementById("lesson-" + id);
            let arrow = document.getElementById("arrow-" + id);

            if (content.style.display === "none") {
                content.style.display = "block";
                arrow.textContent = "▼"; // فتح
            } else {
                content.style.display = "none";
                arrow.textContent = "▶"; // إغلاق
            }
        }
    </script>
@endsection
