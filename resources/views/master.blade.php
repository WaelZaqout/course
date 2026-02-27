<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة تعليمية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lesson.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
@yield('css')

<body>
    <nav>
        <div class="nav-container">
            <div class="logo"><a href="{{ route('site.home') }}">🎓 منصتي</a></div>
            <div class="nav-links">
                <div class="dropdown">
                    <button class="dropbtn">الاقسام <i class="fas fa-chevron-down"></i></button>
                    <div class="dropdown-content">
                        @foreach ($categories as $category)
                            <a href="{{ route('courses', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="#courses">الدورات</a>
                <a href="#about">من نحن</a>
                <a href="#pricing">الاشتراكات</a>
                @auth
                    <div class="user-menu relative" x-data="{ open: false }">
                        <button type="button" class="user-trigger flex items-center gap-2" onclick="toggleUserMenu(event)" aria-haspopup="menu" aria-expanded="false">
                            @if (Auth::user()->avatar)
                                <img id="profilePreview" src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/default-avatar.png') }}" alt="Avatar" class="user-avatar">
                            @else
                                @php $parts = preg_split('/\s+/', trim(Auth::user()->name)); $initials = ''; foreach ($parts as $part) { $initials .= mb_substr($part, 0, 1); } $initials = mb_strtoupper($initials); @endphp
                                <div class="user-initials">{{ $initials }}</div>
                            @endif
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down" style="font-size:12px;"></i>
                        </button>
                        <div class="user-dropdown" id="userDropdown" hidden role="menu" aria-label="قائمة المستخدم">
                            <a href="{{ route('profile.index') }}" class="dropdown-item" role="menuitem"><i class="fas fa-user"></i> الملف الشخصي</a>
                            @if (Auth::user()->role === 'teacher')
                                <a href="" class="dropdown-item" role="menuitem"><i class="fas fa-chalkboard-teacher"></i> كورساتي</a>
                            @else
                                <a href="{{ route('courses') }}" class="dropdown-item" role="menuitem"><i class="fas fa-book-open"></i> كورساتي</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" role="menuitem">
                                @csrf
                                <button type="submit" class="dropdown-item danger"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</button>
                            </form>
                        </div>
                    </div>
                @else
                    <button onclick="openLoginModal()" class="login-btn">تسجيل الدخول</button>
                @endauth
            </div>
            <button class="hamburger" onclick="toggleMobileMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <div id="mobileMenu" class="mobile-menu">
        <button class="close-mobile-menu" onclick="closeMobileMenu()">&times;</button>
        <div class="dropdown">
            <button class="dropbtn">الاقسام <i class="fas fa-chevron-down"></i></button>
            <div class="dropdown-content">
                @foreach ($categories as $category)
                    <a href="#">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <a href="#courses">الدورات</a>
        <a href="#about">من نحن</a>
        <a href="#pricing">الاشتراكات</a>
        @auth
            <div class="user-menu">
                @if (Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="user-avatar">
                @else
                    @php $nameParts = explode(' ', Auth::user()->name); $initials = ''; foreach ($nameParts as $part) { $initials .= mb_substr($part, 0, 1); } $initials = mb_strtoupper($initials); @endphp
                    <div class="user-initials">{{ $initials }}</div>
                @endif
                <span class="user-name">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn">تسجيل الخروج</button>
                </form>
            </div>
        @endauth
    </div>

    @yield('content')

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('loginModal')">&times;</span>
                <h3 class="modal-title">تسجيل الدخول</h3>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني">
                </div>
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور">
                </div>
                <div class="form-check">
                    <input type="checkbox" id="remember">
                    <label for="remember">تذكرني</label>
                </div>
                <button type="submit" class="modal-btn">تسجيل الدخول</button>
                <p class="modal-link">ليس لديك حساب؟ <a href="#" onclick="openSignupModal()">انشئ حساب</a></p>
            </div>
        </form>
    </div>

    <!-- Teacher Modal -->
    <div id="teacherModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('teacherModal')">&times;</span>
            <h3 class="modal-title">أنا معلم</h3>
            <p style="text-align: center; margin-bottom: 24px;">أنشئ محتواك التعليمي وحقق دخلًا من مشاركته مع الطلاب.</p>
            <button onclick="openSignupModal('معلم')" class="modal-btn">إنشاء حساب كمعلم</button>
            <button onclick="openLoginModal()" class="modal-btn" style="background: white; color: #4f46e5; border: 2px solid #4f46e5;">تسجيل الدخول</button>
        </div>
    </div>

    <!-- Student Modal -->
    <div id="studentModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('studentModal')">&times;</span>
            <h3 class="modal-title">أنا طالب</h3>
            <p style="text-align: center; margin-bottom: 24px;">تعلم من أفضل المعلمين واختر الدروس التي تناسب احتياجاتك.</p>
            <button onclick="openSignupModal('طالب')" class="modal-btn">إنشاء حساب كطالب</button>
            <button onclick="openLoginModal()" class="modal-btn" style="background: white; color: #4f46e5; border: 2px solid #4f46e5;">تسجيل الدخول</button>
        </div>
    </div>

    <!-- Signup Modal -->
    <div id="signupModal" class="modal">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal('signupModal')">&times;</span>
                <h3 class="modal-title">إنشاء حساب</h3>
                <div class="form-group">
                    <label>الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" placeholder="أدخل اسمك الكامل" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                </div>
                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="أعد إدخال كلمة المرور" required>
                </div>
                <div class="form-group">
                    <label>نوع الحساب</label>
                    <select name="role" id="accountType" class="form-control" required>
                        <option value="student">طالب</option>
                        <option value="teacher">معلم</option>
                    </select>
                </div>
                <button type="submit" class="modal-btn">إنشاء الحساب</button>
                <p class="modal-link">لديك حساب بالفعل؟ <a href="#" onclick="openLoginModal()">تسجيل الدخول</a></p>
            </div>
        </form>
    </div>

    <!-- Video Modal -->
    <div id="videoModal" class="modalVideo">
        <div class="modalVideo-content">
            <span id="closeModal" class="close">&times;</span>
            <iframe id="videoFrame" width="560" height="315" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>

    @yield('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studentTabBtn = document.getElementById('tab-student');
            const teacherTabBtn = document.getElementById('tab-teacher');
            const studentPlans = document.getElementById('student-plans');
            const teacherPlans = document.getElementById('teacher-plans');

            function applyAud(aud) {
                const isStudent = (aud === 'student');
                studentPlans.style.display = isStudent ? 'grid' : 'none';
                teacherPlans.style.display = isStudent ? 'none' : 'grid';
                studentTabBtn.classList.toggle('active', isStudent);
                teacherTabBtn.classList.toggle('active', !isStudent);
            }

            function setAud(aud, updateUrl = true) {
                applyAud(aud);
                if (updateUrl) {
                    const url = new URL(window.location.href);
                    url.searchParams.set('aud', aud);
                    history.replaceState({}, '', url);
                }
            }

            const defaultAud = @json($aud ?? 'student');
            setAud(defaultAud, false);
            studentTabBtn.addEventListener('click', () => setAud('student'));
            teacherTabBtn.addEventListener('click', () => setAud('teacher'));

            const qsAud = new URLSearchParams(location.search).get('aud');
            if (qsAud && qsAud !== defaultAud) {
                setAud(qsAud, false);
                history.replaceState({}, '', window.location.pathname);
            }
        });
    </script>

    <script>
        function openLoginModal() { document.getElementById('loginModal').classList.add('active'); }
        function openTeacherModal() { document.getElementById('teacherModal').classList.add('active'); }
        function openStudentModal() { document.getElementById('studentModal').classList.add('active'); }
        function openSignupModal(type = null) {
            document.getElementById('signupModal').classList.add('active');
            if (type) { document.getElementById('accountType').value = type; }
        }
        function closeModal(modalId) { document.getElementById(modalId).classList.remove('active'); }

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) { if (e.target === this) { this.classList.remove('active'); } });
        });

        window.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                document.querySelectorAll('.modal.active').forEach(modal => { modal.classList.remove('active'); });
            }
        });

        function toggleMobileMenu() { document.getElementById('mobileMenu').classList.add('active'); }
        function closeMobileMenu() { document.getElementById('mobileMenu').classList.remove('active'); }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobileMenu');
            const isHamburger = e.target.classList.contains('hamburger') || e.target.closest('.hamburger');
            const isCloseButton = e.target.classList.contains('close-mobile-menu') || e.target.closest('.close-mobile-menu');
            if (menu.classList.contains('active') && !menu.contains(e.target) && !isHamburger && !isCloseButton) {
                closeMobileMenu();
            }
        });

        const openBtn = document.getElementById("openVideoBtn");
        const modal = document.getElementById("videoModal");
        const closeBtn = document.getElementById("closeModal");
        const videoFrame = document.getElementById("videoFrame");

        if (openBtn) {
            openBtn.onclick = function() {
                videoFrame.src = "https://www.youtube.com/embed/aNYEtGxjGVc";
                modal.classList.add("active");
            };
        }

        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.classList.remove("active");
                videoFrame.src = "";
            };
        }

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove("active");
                videoFrame.src = "";
            }
        });

        let _udOpen = false;
        function toggleUserMenu(e) {
            const menu = document.getElementById('userDropdown');
            _udOpen = !_udOpen;
            if (menu) {
                menu.hidden = !_udOpen;
                e.currentTarget.setAttribute('aria-expanded', String(_udOpen));
            }
        }

        document.addEventListener('click', function(ev) {
            const menu = document.getElementById('userDropdown');
            const container = ev.target.closest('.user-menu');
            if (!container && menu && !menu.hidden) {
                menu.hidden = true;
                _udOpen = false;
                const t = document.querySelector('.user-trigger');
                if (t) t.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function(ev) {
            if (ev.key === 'Escape') {
                const menu = document.getElementById('userDropdown');
                if (menu && !menu.hidden) {
                    menu.hidden = true;
                    _udOpen = false;
                }
                const t = document.querySelector('.user-trigger');
                if (t) t.setAttribute('aria-expanded', 'false');
            }
        });
    </script>

    <!-- Toast Notifications -->
    @if(session('toast'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('toast.type') }}', '{{ session('toast.message') }}');
        });
    </script>
    @endif

    <script>
        function showToast(type, message) {
            const toast = document.createElement('div');
            toast.className = 'toast-notification toast-' + type;
            toast.innerHTML = '<span class="toast-message">' + message + '</span>';
            toast.style.cssText = 'position:fixed;top:20px;right:20px;padding:15px 25px;border-radius:8px;color:white;font-family:Cairo,sans-serif;z-index:10000;animation:slideIn 0.3s ease;';
            toast.style.background = type === 'success' ? '#4CAF50' : (type === 'error' ? '#f44336' : '#2196F3');
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.animation = 'slideOut 0.3s ease'; setTimeout(() => toast.remove(), 300); }, 4000);
        }
    </script>
    <style>
        @keyframes slideIn{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}
        @keyframes slideOut{from{transform:translateX(0);opacity:1;}to{transform:translateX(100%);opacity:0;}}
    </style>

</body>
</html>
