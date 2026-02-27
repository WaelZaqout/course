    @extends('master')
    @section('content')
        <div class="course-container">

            <div class="course-info">
                <div class="instructor-info">
                    <img src="{{ $course->teacher->avatar
                        ? asset('storage/' . $course->teacher->avatar)
                        : asset('assets/images/default-avatar.png') }}"
                        alt="صورة الأستاذ {{ $course->teacher->name }}">

                    <div class="instructor-text">
                        <div class="instructor-name">{{ $course->teacher->name }}</div>
                        <p class="instructor-desc"> {{ Str::limit($course->summary, 80) }}
                        </p>

                        <div class="instructor-social">
                            <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-meta">
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>⏰ {{ $course->total_minutes ?? 'غير محدد' }} ساعة</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-video"></i>
                        <span>📘 {{ $course->lessons_count ?? 0 }} درس</span>

                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        <span>{{ $course->students->count() ?? '0' }} طالب</span>


                    </div>

                </div>


            </div>

            <div class="course-image-container">
                <div class="gradient-overlay"></div>

                <!-- Video Section -->
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

                <div class="cta-banner">
                    <p><strong>سجل الآن</strong> واحصل على شهادة معتمدة + دعم مدى الحياة + مجتمع الطلاب</p>
                </div>


                @auth
                    @php
                        // تحقق هل الطالب اشترى هذا الكورس من قبل (موجود في جدول enrollments)
                        $alreadyEnrolled = auth()->user()->enrollments->where('course_id', $course->id)->count() > 0;
                    @endphp

                    @if ($alreadyEnrolled)
                        <!-- الطالب مشترك -->
                        <a href="{{ route('lesson.show', $course->id) }}" class="enroll-button">
                            🚀 شاهد الكورس كاملًا
                        </a>
                    @else
                        <!-- الطالب غير مشترك - زر شراء الكورس -->
                        <form method="POST" action="{{ route('courses.checkout', $course->id) }}">
                            @csrf
                            <button type="submit" class="enroll-button">
                                💳 اشترِ هذا الكورس ({{ $course->price }} {{ $course->currency }})
                            </button>
                        </form>
                    @endif
                @else
                    <!-- زائر غير مسجل -->
                    <a href="{{ route('login') }}" class="enroll-button">
                        <i class="fas fa-sign-in-alt"></i> سجّل أولاً للشراء
                    </a>
                @endauth


            </div>

        </div>
        <div class="main-content">
            <div class="container">
                <div class="content-wrapper">
                    <div class="course-content">
                        <!-- Countdown Timer -->
                        <div class="countdown">
                            <h4>عرض محدود - انتهى التسجيل خلال:</h4>
                            <div class="timer">
                                <div class="timer-item">
                                    <div class="timer-number" id="days">03</div>
                                    <div class="timer-label">أيام</div>
                                </div>
                                <div class="timer-item">
                                    <div class="timer-number" id="hours">12</div>
                                    <div class="timer-label">ساعات</div>
                                </div>
                                <div class="timer-item">
                                    <div class="timer-number" id="minutes">45</div>
                                    <div class="timer-label">دقائق</div>
                                </div>
                                <div class="timer-item">
                                    <div class="timer-number" id="seconds">30</div>
                                    <div class="timer-label">ثواني</div>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="trust-badges">
                            <div class="badge">
                                <i class="fas fa-certificate"></i>
                                شهادة معتمدة
                            </div>
                            <div class="badge">
                                <i class="fas fa-graduation-cap"></i>
                                معترف بها
                            </div>
                            <div class="badge">
                                <i class="fas fa-award"></i>
                                جودة عالية
                            </div>
                        </div>

                        <!-- Course Description -->
                        <div class="section fade-in fade-in-delay-1">
                            <h2><i class="fas fa-info-circle"></i> نظرة عامة على الكورس</h2>
                            <ul class="overview-list">
                                <li class="overview-item">
                                    <div class="overview-icon">
                                        <i class="fas fa-rocket"></i>
                                    </div>
                                    <div class="overview-text">
                                        <strong>ابن مشاريع حقيقية</strong> تضيفها إلى معرض أعمالك وتجذب العملاء
                                    </div>
                                </li>
                                <li class="overview-item">
                                    <div class="overview-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="overview-text">
                                        <strong>جهّز نفسك لوظيفة</strong> كمطور ويب برواتب تبدأ من 15,000 ر.س شهريًا
                                    </div>
                                </li>
                                <li class="overview-item">
                                    <div class="overview-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div class="overview-text">
                                        <strong>ابن مهاراتك</strong> خطوة بخطوة من المبتدئ إلى المحترف
                                    </div>
                                </li>
                                <li class="overview-item">
                                    <div class="overview-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <div class="overview-text">
                                        <strong>احصل على دعم مباشر</strong> من المدرب وزملائك في مجتمع الطلاب
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- What You'll Learn -->
                        <div class="section fade-in fade-in-delay-2">
                            <h2><i class="fas fa-graduation-cap"></i> ما ستتعلمه</h2>
                            <ul class="course-features">
                                <li><i class="fas fa-check-circle"></i> بناء مواقع ويب تفاعلية باستخدام HTML5 و CSS3</li>
                                <li><i class="fas fa-check-circle"></i> تطوير تطبيقات حديثة باستخدام JavaScript و React
                                </li>
                                <li><i class="fas fa-check-circle"></i> إنشاء خدمات خلفية قوية باستخدام Node.js و Express
                                </li>
                                <li><i class="fas fa-check-circle"></i> التعامل مع قواعد البيانات وتخزين البيانات</li>
                                <li><i class="fas fa-check-circle"></i> نشر تطبيقاتك على الإنترنت وجعلها متاحة للعالم</li>
                                <li><i class="fas fa-check-circle"></i> أفضل الممارسات في البرمجة وتحسين الأداء</li>
                                <li><i class="fas fa-check-circle"></i> بناء معرض أعمال قوي يجذب العملاء وأصحاب العمل</li>
                                <li><i class="fas fa-check-circle"></i> التحضير لمقابلات العمل وبناء السيرة الذاتية</li>
                            </ul>
                        </div>





                        <!-- Reviews -->
                        <div class="section fade-in">
                            <h2><i class="fas fa-star"></i> تقييمات الطلاب</h2>
                            <div class="reviews-container">
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">أ</div>
                                            <div>
                                                <div class="reviewer-name">أحمد محمد</div>
                                                <div class="review-date">منذ أسبوع</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <p class="review-text">كورس رائع جداً! الشرح واضح والمشاريع العملية ساعدتني كثيراً في
                                        فهم المفاهيم. أنصح به لكل من يريد تعلم تطوير الويب.</p>
                                </div>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">ف</div>
                                            <div>
                                                <div class="reviewer-name">فاطمة علي</div>
                                                <div class="review-date">منذ أسبوعين</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <p class="review-text">المدرب محترف والدعم المستمر ممتاز. حصلت على وظيفة بعد إنهاء
                                        الكورس
                                        بشهر!
                                        أنصح بهذا الكورس لكل من يريد تعلم تطوير الويب.</p>
                                </div>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">م</div>
                                            <div>
                                                <div class="reviewer-name">محمد سالم</div>
                                                <div class="review-date">منذ 3 أسابيع</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <p class="review-text">كورس شامل ومفيد. حصلت على وظيفة كمطور ويب بعد إنهاء الكورس بشهر!
                                        المحتوى ممتاز والمشاريع العملية ساعدتني كثيراً في بناء معرض الأعمال.</p>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Sidebar -->
                    <div class="sidebar">
                        <div class="sidebar-card">
                            <div class="price-section">
                                @if ($course->sale_price)
                                    @php
                                        $discount = (($course->price - $course->sale_price) / $course->price) * 100;
                                    @endphp
                                    <div class="discount-badge">
                                        <i class="fas fa-tag"></i> خصم {{ round($discount) }}%
                                    </div>
                                    <div class="price">
                                        <span class="original-price">{{ $course->price }} ر.س</span>
                                        {{ $course->sale_price }} <span>ر.س</span>
                                    </div>
                                @else
                                    <div class="price">
                                        {{ $course->price }} <span>ر.س</span>
                                    </div>
                                @endif
                                <div class="price-note">سعر لفترة محدودة</div>
                            </div>

                            <div class="guarantee">
                                <i class="fas fa-shield-alt"></i>
                                <div class="guarantee-text">ضمان استرداد 14 يومًا إذا لم تكن راضيًا</div>
                            </div>

                            <ul class="course-features">
                                <li><i class="fas fa-infinity"></i> وصول مدى الحياة</li>
                                <li><i class="fas fa-mobile-alt"></i> متاح على الهاتف والكمبيوتر</li>
                                <li><i class="fas fa-certificate"></i> شهادة إتمام معتمدة</li>
                                <li><i class="fas fa-headset"></i> دعم فني مباشر</li>
                                <li><i class="fas fa-users"></i> مجتمع طلاب نشط</li>
                                <li><i class="fas fa-download"></i> مواد قابلة للتحميل</li>
                                <li><i class="fas fa-briefcase"></i> إعداد للوظائف</li>
                                <li><i class="fas fa-award"></i> شهادة معتمدة</li>
                            </ul>

                            @auth
                                @php
                                    // تحقق هل الطالب اشترى هذا الكورس من قبل (موجود في جدول enrollments)
                                    $alreadyEnrolled =
                                        auth()->user()->enrollments->where('course_id', $course->id)->count() > 0;
                                @endphp

                                @if ($alreadyEnrolled)
                                    <!-- الطالب مشترك -->
                                    <a href="{{ route('lesson.show', $course->id) }}" class="enroll-button">
                                        🚀 شاهد الكورس كاملًا
                                    </a>
                                @else
                                    <!-- الطالب غير مشترك - زر شراء الكورس -->
                                    <form method="POST" action="{{ route('courses.checkout', $course->id) }}">
                                        @csrf
                                        <button type="submit" class="enroll-button">
                                            💳 اشترِ هذا الكورس ({{ $course->price }} {{ $course->currency }})
                                        </button>
                                    </form>
                                @endif
                            @else
                                <!-- زائر غير مسجل -->
                                <a href="{{ route('login') }}" class="enroll-button">
                                    <i class="fas fa-sign-in-alt"></i> سجّل أولاً للشراء
                                </a>
                            @endauth


                            <div class="skills-section">
                                <h3>المهارات التي ستكتسبها</h3>
                                <div class="skills-container">
                                    <div class="skill-pill">HTML5</div>
                                    <div class="skill-pill">CSS3</div>
                                    <div class="skill-pill">JavaScript</div>
                                    <div class="skill-pill">React</div>
                                    <div class="skill-pill">Node.js</div>
                                    <div class="skill-pill">Express</div>
                                    <div class="skill-pill">MongoDB</div>
                                    <div class="skill-pill">REST API</div>
                                </div>
                            </div>

                            <div class="progress-section">
                                <h3>إحصائيات التقدم</h3>
                                <div class="progress-bar">
                                    <div class="progress-fill" id="progressFill"></div>
                                </div>
                                <div class="progress-text">
                                    <span>معدل الإنجاز</span>
                                    <span id="progressText">0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="instructor-card">
                            <div class="instructor-avatar"> <img
                                    src="{{ $course->teacher->avatar
                                        ? asset('storage/' . $course->teacher->avatar)
                                        : asset('assets/images/default-avatar.png') }}"
                                    alt="صورة الأستاذ {{ $course->teacher->name }}"></div>

                            <div class="instructor-name">{{ $course->teacher->name }}</div>
                            <div class="instructor-title">مطور ويب متخصص ومهندس برمجيات</div>
                            <div class="instructor-bio">
                                خبرة 8 سنوات في تطوير الويب. عمل في شركات تقنية رائدة ودرب أكثر من 2000 طالب.
                            </div>
                            <div class="instructor-social">
                                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section ">
                        <h3>عن الأكاديمية</h3>
                        <p>مؤسسة تعليمية رائدة تهدف لتقديم تجربة تعليمية تفاعلية ومميزة تواكب تطورات العصر الرقمي.</p>
                    </div>
                    <div class="footer-section links">
                        <h3>روابط سريعة</h3>
                        <ul>
                            <li><a href="#hero">الرئيسية</a></li>
                            <li><a href="#courses">الكورسات</a></li>
                            <li><a href="#teachers">المعلمين</a></li>
                            <li><a href="#about">من نحن</a></li>
                            <li><a href="#contact">اتصل بنا</a></li>
                        </ul>
                    </div>
                    <div class="footer-section social">
                        <h3>تابعنا</h3>
                        <div class="footer-social">
                            <a href="#" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="تويتر"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="انستجرام"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    &copy; 2025 أكاديمية العلم والمعرفة. جميع الحقوق محفوظة.
                </div>
            </div>
        </footer>
        <script>
            // Toggle curriculum sections
            function toggleCurriculum(element) {
                const content = element.nextElementSibling;
                const toggle = element.querySelector('.curriculum-toggle');
                if (content.classList.contains('active')) {
                    content.classList.remove('active');
                    toggle.style.transform = 'rotate(0deg)';
                } else {
                    content.classList.add('active');
                    toggle.style.transform = 'rotate(180deg)';
                }
            }

            // Progress bar animation
            function animateProgress() {
                const progressFill = document.getElementById('progressFill');
                const progressText = document.getElementById('progressText');
                let progress = 0;
                const targetProgress = 75;
                const interval = setInterval(() => {
                    if (progress < targetProgress) {
                        progress += 1;
                        progressFill.style.width = progress + '%';
                        progressText.textContent = progress + '%';
                    } else {
                        clearInterval(interval);
                    }
                }, 30);
            }

            // Countdown timer
            function startCountdown() {
                const countdownDate = new Date();
                countdownDate.setDate(countdownDate.getDate() + 3); // 3 days from now

                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = countdownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById('days').textContent = days.toString().padStart(2, '0');
                    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');

                    if (distance < 0) {
                        clearInterval(timer);
                        document.querySelector('.countdown').innerHTML = '<p>انتهى التسجيل!</p>';
                    }
                }

                updateCountdown();
                const timer = setInterval(updateCountdown, 1000);
            }

            // Fade in animations
            function observeElements() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                });
                document.querySelectorAll('.fade-in').forEach(el => {
                    observer.observe(el);
                });
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                observeElements();
                setTimeout(animateProgress, 1000);
                startCountdown();
            });
        </script>

        <script>
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
    @endsection
