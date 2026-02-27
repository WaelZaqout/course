@extends('master')
@section('content')

    <main>
        <div class="lesson-header">
            <h1 class="lesson-title"> {{ $course->title }}</h1>
            <div class="lesson-info">
                <span><i class="fas fa-star"></i> 49 (تقييمات)</span>
                <span><i class="fas fa-clock"></i> {{ $course->total_minutes ?? 'غير محدد' }}ساعة </span>
                <span><i class="fas fa-globe"></i> {{ $course->language ?? 'غير محدد' }}</span>
                <span><i class="fas fa-user"></i> {{ $course->teacher->name ?? 'غير محدد' }}</span>
                <span class="lesson-tag">{{ $course->category->name ?? 'غير محدد' }}</span>
            </div>
        </div>

        <div class="course-container">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="rating-container">
                    <h2 class="section-title">تقييم الكورس</h2>
                    <div class="rating-value">5</div>
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="rating-count">49 تقييمات</div>
                    <button class="rate-button">عرض تقييمات الطلاب</button>
                </div>

                <!-- Related Courses Section -->
                <div class="related-courses">
                    <h2 class="section-title">كورسات مشابهة</h2>
                    <div class="related-lesson-card">
                        <img src="{{ asset('assets/img/algebra.jpg') }}" alt="Course Image" class="lesson-image">
                        <div class="lesson-details">
                            <div class="lesson-name">تصميم موقع ويب احترافي باستخدام HTML و CSS</div>
                            <div class="lesson-duration">15:30:00</div>
                            <div class="lesson-author">محمد علي</div>
                        </div>
                    </div>
                    <div class="related-lesson-card">
                        <img src="{{ asset('assets/img/algebra.jpg') }}" alt="Course Image" class="lesson-image">
                        <div class="lesson-details">
                            <div class="lesson-name">تطوير تطبيقات الهاتف باستخدام React Native</div>
                            <div class="lesson-duration">18:45:00</div>
                            <div class="lesson-author">أحمد حسن</div>
                        </div>
                    </div>
                    <div class="related-lesson-card">
                        <img src="{{ asset('assets/img/algebra.jpg') }}" alt="Course Image" class="lesson-image">
                        <div class="lesson-details">
                            <div class="lesson-name">إدارة قواعد البيانات باستخدام MySQL</div>
                            <div class="lesson-duration">12:20:00</div>
                            <div class="lesson-author">رانيا عصام</div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <section class="main-content">
                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab-button active" data-tab="videos">
                        <i class="fas fa-video"></i>
                        الفيديوهات
                    </button>
                    <button class="tab-button" data-tab="files">
                        <i class="fas fa-file-alt"></i>
                        الملفات
                    </button>
                </div>

                <!-- Video Player -->
                <div class="video-player" id="videoContainer"
                    style="
                            background-image: url('{{ $course->cover ? asset('storage/' . $course->cover) : asset('images/default-course.jpg') }}');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            ">
                    <div class="play-btn" id="playButton" onclick="playLocalVideo(event)">
                        <i class="fas fa-play"></i>
                    </div>

                    <!-- عنصر الفيديو المحلي -->
                    <video id="localVideo" width="100%" height="100%" controls style="display:none;">
                        <source src="{{ $course->intro_video ? asset('storage/' . $course->intro_video) : '' }}"
                            type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                </div>

                <!-- Tab Content -->
                <div id="videos" class="tab-content active">
                    @forelse($course->sections as $section)
                        <div class="lesson-card"
                            style="margin-top:20px; border:1px solid #ddd; border-radius:10px; background:#fff;">
                            <div class="lesson-header"
                                style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;"
                                onclick="toggleSection({{ $section->id }})">
                                <h4 style="margin:0;">📚 {{ $section->title }}</h4>
                                <span id="section-arrow-{{ $section->id }}">▶</span>
                            </div>

                            <div class="section-content" id="section-{{ $section->id }}"
                                style="display:none; margin-top:15px;">
                                @php
                                    $videoLessons = $section->lessons->whereNotNull('video_path');
                                @endphp

                                @if ($videoLessons->count())
                                    @foreach ($videoLessons as $lesson)
                                        <div class="lesson-card"
                                            style="margin-top:10px; padding:10px; border:1px solid #eee; border-radius:8px; display:flex; justify-content:space-between; align-items:center;">

                                            <div class="lesson-title" style="display:flex; align-items:center; gap:10px;">
                                                🎬 {{ $lesson->title }}
                                                @if ($lesson->duration_sec)
                                                    <span style="color:#666; font-size:13px;">
                                                        ⏱
                                                        {{ gmdate($lesson->duration_sec >= 3600 ? 'H:i:s' : 'i:s', $lesson->duration_sec) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <button
                                                onclick="playLessonVideo('{{ asset('storage/' . $lesson->video_path) }}')"
                                                style="width:40px; height:40px; border-radius:50%; background:#ffc107; border:none; cursor:pointer; display:flex; justify-content:center; align-items:center;">
                                                <i class="fas fa-play"
                                                    style="color:#000; font-size:14px; margin-left:2px;"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <p style="color:#777; margin-top:10px;">🚫 لا يوجد فيديوهات في هذا السكشن</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p style="margin-top:20px; color:#777; text-align:center;">🚫 لا يوجد سكاشن بعد</p>
                    @endforelse
                </div>

                <div id="files" class="tab-content">
                    @php
                        $lessonsWithFiles = collect();
                        foreach ($course->sections as $section) {
                            $lessonsWithFiles = $lessonsWithFiles->merge($section->lessons->whereNotNull('file_path'));
                        }
                    @endphp

                    @forelse ($lessonsWithFiles as $lesson)
                        <div class="file-item">
                            <div class="file-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="file-info">
                                <h4>{{ $lesson->title ?? 'ملف' }}</h4>
                                <small>📂 اضغط للعرض أو التحميل</small>
                            </div>
                            <div class="file-action">
                                <a href="{{ asset('storage/' . $lesson->file_path) }}" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            <h3>🚫 لا توجد ملفات متاحة</h3>
                            <p>سيتم إضافة الملفات قريبًا</p>
                        </div>
                    @endforelse
                </div>


        </div>




        </section>
        </div>
    </main>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active');
                });

                // Remove active class from all content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Add active class to clicked button and corresponding content
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Video player functionality

        function playLocalVideo(event) {
            event.stopPropagation();
            const playBtn = document.getElementById('playButton');
            const videoContainer = document.getElementById('videoContainer');
            const video = document.getElementById('localVideo');

            // إخفاء زر التشغيل وخلفية الصورة
            playBtn.style.display = 'none';
            videoContainer.style.backgroundImage = 'none';

            // إظهار الفيديو وتشغيله
            video.style.display = 'block';
            video.play();
        }
    </script>
    <script>
        // تشغيل فيديو عند اختيار عنصر
        function attachVideoItemHandlers() {
            document.querySelectorAll('.video-item').forEach(item => {
                item.addEventListener('click', function() {
                    const videoUrl = this.getAttribute('data-video-url');
                    if (!videoUrl) return;

                    const player = document.getElementById('video-player');
                    // لو نفس الرابط لا تعيد التحميل بلا داعٍ
                    if (player.src !== videoUrl) {
                        player.src = videoUrl;
                    }

                    // تمييز العنصر النشط
                    document.querySelectorAll('.video-item').forEach(el => el.style.backgroundColor = '');
                    this.style.backgroundColor = '#f8f9fa';
                });
            });
        }

        attachVideoItemHandlers();

        // سلوك Accordion: اسمح بفتح قسم واحد فقط
        const accordions = document.querySelectorAll('details.accordion');
        accordions.forEach(acc => {
            acc.addEventListener('toggle', () => {
                if (acc.open) {
                    // أغلق البقية
                    accordions.forEach(other => {
                        if (other !== acc) other.removeAttribute('open');
                    });

                    // تشغيل أول فيديو في هذا القسم إذا لا يوجد اختيار سابق
                    const firstItem = acc.querySelector('.video-item');
                    const player = document.getElementById('video-player');
                    if (firstItem && (!player.src || player.src.trim() === '' || player.src.endsWith(
                            '#'))) {
                        firstItem.click();
                    }
                }
            });
        });

        // عند تحميل الصفحة: شغّل أول فيديو من أول قسم مفتوح (إن وجد)
        window.addEventListener('DOMContentLoaded', () => {
            const firstOpen = document.querySelector('details.accordion[open]');
            if (firstOpen) {
                const firstItem = firstOpen.querySelector('.video-item');
                if (firstItem) firstItem.click();
            }
        });

        // **مهم**: إن بدّلت تبويب "الاختبارات/المحتويات"، تأكد أن الفيديو يبقى كما هو
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.addEventListener('click', () => {
                // لا شيء إضافي مطلوب هنا لأن الإطار يبقى داخل نفس الصفحة
                // لكن يمكن لاحقًا حفظ آخر عنصر مُشغّل في localStorage.
            });
        });
    </script>
    <script>
        function toggleLesson(id) {
            const content = document.getElementById('lesson-' + id);
            const arrow = document.getElementById('arrow-' + id);

            if (content.style.display === "none") {
                content.style.display = "block";
                arrow.textContent = "▼";
            } else {
                content.style.display = "none";
                arrow.textContent = "▶";
            }
        }
    </script>
    <script>
        function toggleLesson(id) {
            const content = document.getElementById(`lesson-${id}`);
            const arrow = document.getElementById(`arrow-${id}`);

            if (content.style.display === "block") {
                content.style.display = "none";
                arrow.classList.remove("open");
            } else {
                content.style.display = "block";
                arrow.classList.add("open");
            }
        }
    </script>

    <script>
        // فتح/إغلاق السكشن
        function toggleSection(sectionId) {
            let section = document.getElementById('section-' + sectionId);
            let arrow = document.getElementById('section-arrow-' + sectionId);

            if (section.style.display === "none") {
                section.style.display = "block";
                arrow.textContent = "▼";
            } else {
                section.style.display = "none";
                arrow.textContent = "▶";
            }
        }

        // فتح/إغلاق الدرس
        function toggleLesson(lessonId) {
            let lesson = document.getElementById('lesson-' + lessonId);
            let arrow = document.getElementById('arrow-' + lessonId);

            if (lesson.style.display === "none") {
                lesson.style.display = "block";
                arrow.textContent = "▼";
            } else {
                lesson.style.display = "none";
                arrow.textContent = "▶";
            }
        }
    </script>
    <script>
        function playLessonVideo(videoUrl) {
            const playBtn = document.getElementById('playButton');
            const videoContainer = document.getElementById('videoContainer');
            const mainVideo = document.getElementById('localVideo');

            // لو زر التشغيل ظاهر نخفيه ونشغل الفيديو
            playBtn.style.display = 'none';
            videoContainer.style.backgroundImage = 'none';

            // تغيير مصدر الفيديو
            mainVideo.style.display = 'block';
            mainVideo.src = videoUrl;
            mainVideo.play();
        }
    </script>


@endsection
