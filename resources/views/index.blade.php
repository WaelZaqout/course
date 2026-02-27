@extends('master')
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>تعلم بأفضل الطرق مع منصتي</h1>
                <p>افتح عالمًا من المعرفة مع دوراتنا التعليمية المتميزة، مصممة خصيصًا لتلبية احتياجات الطلاب والمعلمين.
                </p>
                <div class="hero-buttons">
                @guest
                        <button onclick="openSignupModal()" class="btn-primary highlight">سجل الآن</button>
                    @endguest
                    <a href="#courses" class="btn-secondary">تصفح المقررات</a>
                    <button class="btn-video" id="openVideoBtn"><i class="fas fa-play"></i> شاهد الفيديو
                        التعريفي</button>

                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('assets/img/aboutus.jpg') }}" alt="فريق العمل الجماعي">
                <div class="stats-badge">
                    <div class="stats-number">15K+</div>
                    <div>
                        <div class="stats-text">طلاب</div>
                        <div class="stats-text">مسجلين</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="categories">
        <div class="categories-container">
            <div class="categories-header">
                <h2>الاقسام التعليمية</h2>
                <p>تصفح الدروس حسب التخصص الذي يهمك</p>
            </div>
            <div class="categories-list">
                @foreach ($categories as $category)
                    <!-- مثال: ترتيب ديناميكي (يمكنك لاحقًا ربطه بقاعدة بيانات) -->
                    <div class="category-item ">
                        <div class="category-icon"><i class="{{ $category->icon }}"></i></div>
                        <div class="category-name">{{ $category->name }}</div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="courses">
        <div class="section-header">
            <h2>أحدث الدروس التعليمية</h2>
            <p>استكشف مجموعة واسعة من الدروس المصممة لتناسب جميع المستويات</p>
        </div>
        <div class="courses-grid">
            <!-- Course 1 -->
            @foreach ($courses as $course)
                <div class="course-card best-seller">
                    <img src="{{ $course->cover ? asset('storage/' . $course->cover) : asset('images/default-course.jpg') }}"
                        alt="{{ $course->title }}" class="course-img">
                    <div class="course-content">
                        <div class="course-tags">
                            <div class="course-tag">{{ $course->category->name ?? 'غير محدد' }}</div>
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="course-enrolled">1200 مسجل</span>
                            </div>
                        </div>
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-description">
                            {{ Str::words(strip_tags($course->summary), 15, '...') }}
                        </p>
                        </p>
                        <div class="course-info">
                            <div><i class="fas fa-play-circle"></i>📘 {{ $course->lessons_count ?? 0 }} درس</div>
                            @php
                                $hours = intdiv($course->total_minutes, 60);
                                $minutes = $course->total_minutes % 60;
                            @endphp
                            <div><i class="fas fa-clock"></i> ⏰
                                {{ $hours ? $hours . ' ساعة ' : ' ' }}
                                {{ $minutes ? $minutes . ' دقيقة' : ' ' }}
                            </div>
                        </div>
                        <div class="course-footer">
                            <div class="course-price">
                                @if ($course->sale_price)
                                    <span class="old-price">{{ $course->price }} ر.س</span>
                                    {{ $course->sale_price }} <span>ر.س</span>
                                @else
                                    {{ $course->price }} <span>ر.س</span>
                                @endif
                            </div>

                            <a href="{{ route('coursedetails', ['id' => $course->id]) }}" class="course-btn">تفاصيل
                                الكورس</a>


                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="more-courses-btn-wrapper">
            <a href="{{ route('courses') }}" class="more-courses-btn">عرض المزيد من المقررات</a>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="about">
        <div class="about-container">
            <div class="about-content">
                <h2>من نحن؟</h2>
                <p>نحن فريق من المتخصصين في التعليم الرقمي، نؤمن بأن المعرفة يجب أن تكون في متناول الجميع. منصتنا تجمع
                    بين أفضل المعلمين والطلاب في بيئة تعليمية متكاملة.</p>
                <p>هدفنا هو تبسيط عملية التعلم وجعلها أكثر تفاعلية وفعالية، مع تقديم محتوى عالي الجودة يلبي احتياجات سوق
                    العمل الحديث.</p>
                <div class="stats-grid">
                    <div>
                        <div class="stat">10+</div>
                        <div class="stat-text">سنوات خبرة</div>
                    </div>
                    <div>
                        <div class="stat">500+</div>
                        <div class="stat-text">معلم</div>
                    </div>
                    <div>
                        <div class="stat">15K+</div>
                        <div class="stat-text">طلاب</div>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="{{ asset('assets/img/hero.jpg') }}" alt="فريق العمل الجماعي">
            </div>
        </div>
    </section>

    <!-- Subscription pricing Section -->
    <section class="pricing" id="pricing">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            <h2>ابدأ مجانًا، وارتقِ بخطوات نحو الاحتراف!</h2>

            <div class="pricing-tabs">
                <button type="button" id="tab-student" class="tab-btn">للطلاب</button>
                <button type="button" id="tab-teacher" class="tab-btn">للمعلمين</button>
            </div>
            {{-- شبكات الخطط --}}
            <div id="student-plans" class="pricing-grid" style="display: {{ $aud === 'teacher' ? 'none' : 'grid' }}">
                @forelse($studentPlans as $plan)
                    <div class="pricing-card {{ $plan->feature('recommended') ? 'recommended' : '' }}">
                        @if ($plan->feature('recommended'))
                            <span class="recommended-badge">مقترحة</span>
                        @endif
                        <h3>{{ $plan->title }}</h3>
                        <div class="price">
                            {{ rtrim(rtrim(number_format($plan->price, 2, '.', ''), '0'), '.') }}
                            <span>{{ $plan->currency }}/شهر</span>
                        </div>
                        <ul>
                            @foreach ((array) $plan->features as $li)
                                <li>{{ $li }}</li>
                            @endforeach
                        </ul>

                        @auth
                            <form method="POST" action="{{ route('subscribe.checkout', $plan->id) }}">
                                @csrf
                                <button class="subscribe-btn">اشترك الآن</button>
                            </form>
                        @else
                            <a class="subscribe-btn" href="{{ route('login') }}">سجّل للدفع</a>
                        @endauth

                    </div>
                @empty
                    <p>لا توجد باقات طلاب متاحة حاليًا.</p>
                @endforelse
            </div>

            <div id="teacher-plans" class="pricing-grid" style="display: {{ $aud === 'teacher' ? 'grid' : 'none' }}">
                @forelse($teacherPlans as $plan)
                    <div class="pricing-card {{ $plan->feature('recommended') ? 'recommended' : '' }}">
                        @if ($plan->feature('recommended'))
                            <span class="recommended-badge">مقترحة</span>
                        @endif
                        <h3>{{ $plan->title }}</h3>
                        <div class="price">
                            {{ rtrim(rtrim(number_format($plan->price, 2, '.', ''), '0'), '.') }}
                            <span>{{ $plan->currency }}/شهر</span>
                        </div>
                        <ul>
                            <ul>
                                @foreach ((array) $plan->features as $li)
                                    <li>{{ $li }}</li>
                                @endforeach
                            </ul>

                        </ul>
                        @auth
                            <form method="POST" action="{{ route('subscribe.checkout', $plan->id) }}">
                                @csrf
                                <button class="subscribe-btn">اشترك الآن</button>
                            </form>
                        @else
                            <a class="subscribe-btn" href="{{ route('login') }}">سجّل للدفع</a>
                        @endauth

                    </div>
                @empty
                    <p>لا توجد باقات معلّمين متاحة حاليًا.</p>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Testimonials -->
    <section class="testimonials">
        <div class="section-header">
            <h2>آراء المستخدمين</h2>
            <p>ما يقوله معلمينا وطلابنا عن منصتنا</p>
        </div>
        <div class="testimonials-container">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="{{ asset('assets/img/teacher.jpg') }}" class="testimonial-avatar-img" alt="أحمد محمد">
                    <div>
                        <div class="testimonial-name">أحمد محمد</div>
                        <div class="testimonial-role">معلم رياضيات</div>
                    </div>
                </div>
                <p class="testimonial-text">"المنصة ساعدتني في بناء مجتمعي التعليمي وتحقيق دخل جيد من محتواي. النظام سهل
                    الاستخدام والدعم الفني ممتاز."</p>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="{{ asset('assets/img/teacher.jpg') }}" class="testimonial-avatar-img" alt="سارة خالد">
                    <div>
                        <div class="testimonial-name">سارة خالد</div>
                        <div class="testimonial-role">طالبة جامعية</div>
                    </div>
                </div>
                <p class="testimonial-text">"أحب النظام المرن في الدفع. أستطيع شراء الدروس التي أحتاجها فقط دون التزام
                    بدورات كاملة. الجودة عالية جدًا."</p>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="{{ asset('assets/img/teacher.jpg') }}" class="testimonial-avatar-img" alt="محمد عبدالله">
                    <div>
                        <div class="testimonial-name">محمد عبدالله</div>
                        <div class="testimonial-role">معلم لغة إنجليزية</div>
                    </div>
                </div>
                <p class="testimonial-text">"الإحصائيات والتحليلات المتقدمة في الباقة الاحترافية ساعدتني في تحسين محتواي
                    بناءً على تفاعل الطلاب."</p>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>منصتي</h3>
                <p>منصة تعليمية متكاملة تربط بين المعلمين والطلاب بطريقة مبتكرة وفعالة.</p>
                <div class="social-links">
                    <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>روابط سريعة</h3>
                <ul class="footer-links">
                    <li><a href="#courses">الدورات</a></li>
                    <li><a href="#why-us">لماذا نحن؟</a></li>
                    <li><a href="#about">من نحن</a></li>
                    <li><a href="#plans">الاشتراكات</a></li>
                    <li><a href="#">سياسة الخصوصية</a></li>
                    <li><a href="#">اتفاقية الاستخدام</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>الدعم</h3>
                <ul class="footer-links">
                    <li><a href="#">الأسئلة الشائعة</a></li>
                    <li><a href="#">تواصل معنا</a></li>
                    <li><a href="#">الخصوصية</a></li>
                    <li><a href="#">الشروط والأحكام</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>اتصل بنا</h3>
                <ul class="footer-contact">
                    <li><i class="fas fa-envelope"></i> support@madrasa.com</li>
                    <li><i class="fas fa-phone"></i> 920000000</li>
                    <li><i class="fas fa-map-marker-alt"></i> الرياض، المملكة العربية السعودية</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 منصتي. جميع الحقوق محفوظة.</p>
        </div>
    </footer>


@endsection
