<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ملفي الشخصي - منصتي التعليمية</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <header>
        <nav>
            <a href="{{ route('site.home') }}" class="logo">🎓 منصتي</a>
            <a href="{{ route('site.home') }}" class="back-btn">
                <i class="fas fa-arrow-right"></i>
                العودة للوحة التحكم
            </a>
        </nav>
    </header>


    <div class="container">
        <div class="profile-container">
            @include('profile.sidebar')
            <!-- Main Content -->
            <div class="main-content">

    @yield('content')

                {{-- @can('عرض الدورات')
                    <!-- Courses Tab -->
                    <div id="courses" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">الدورات الخاصة بي</h2>
                        </div>

                        <div class="tabs">
                            <div class="tab active" onclick="showCourseTab('in-progress')">جارية</div>
                            <div class="tab" onclick="showCourseTab('completed')">مكتملة</div>
                            <div class="tab" onclick="showCourseTab('saved')">محفوظة</div>
                        </div>

                        <!-- In Progress Courses -->
                        <div id="in-progress" class="course-tab active">
                            <div class="courses-grid">
                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-in-progress">قيد التقدم</span>
                                        <h3 class="course-title">إتقان برمجة تطبيقات الويب</h3>
                                        <p class="course-instructor">د. محمد أحمد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 65%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>65% مكتمل</span>
                                                <span>8 من 12 أسبوع</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">متابعة الدورة</a>
                                            <a href="#" class="course-btn course-btn-outline">عرض التفاصيل</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-in-progress">قيد التقدم</span>
                                        <h3 class="course-title">تطوير تطبيقات الجوال باستخدام React Native</h3>
                                        <p class="course-instructor">د. سارة خالد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 42%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>42% مكتمل</span>
                                                <span>5 من 12 أسبوع</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">متابعة الدورة</a>
                                            <a href="#" class="course-btn course-btn-outline">عرض التفاصيل</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Courses -->
                        <div id="completed" class="course-tab">
                            <div class="courses-grid">
                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-laptop-code"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-completed">مكتملة</span>
                                        <h3 class="course-title">أساسيات برمجة الويب</h3>
                                        <p class="course-instructor">د. محمد أحمد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>100% مكتمل</span>
                                                <span>تم في 15/3/2025</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">عرض الشهادة</a>
                                            <a href="#" class="course-btn course-btn-outline">إعادة الدورة</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fas fa-database"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-completed">مكتملة</span>
                                        <h3 class="course-title">قواعد البيانات وSQL</h3>
                                        <p class="course-instructor">د. خالد حسن</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>100% مكتمل</span>
                                                <span>تم في 10/2/2025</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">عرض الشهادة</a>
                                            <a href="#" class="course-btn course-btn-outline">إعادة الدورة</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="course-card">
                                    <div class="course-image">
                                        <i class="fab fa-js"></i>
                                    </div>
                                    <div class="course-body">
                                        <span class="course-status status-completed">مكتملة</span>
                                        <h3 class="course-title">JavaScript المتقدم</h3>
                                        <p class="course-instructor">د. سارة خالد</p>
                                        <div class="course-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: 100%"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span>100% مكتمل</span>
                                                <span>تم في 5/1/2025</span>
                                            </div>
                                        </div>
                                        <div class="course-actions">
                                            <a href="#" class="course-btn course-btn-primary">عرض الشهادة</a>
                                            <a href="#" class="course-btn course-btn-outline">إعادة الدورة</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Saved Courses -->
                        <div id="saved" class="course-tab">
                            <div style="text-align: center; padding: 3rem; color: #666;">
                                <i class="fas fa-heart" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                                <h3>لا توجد دورات محفوظة بعد</h3>
                                <p>يمكنك حفظ الدورات التي تهمك للمستقبل</p>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('رؤية درجاتي')
                    <!-- Certificates Tab -->
                    <div id="certificates" class="tab-content">
                        <div class="section-header">
                            <h2 class="section-title">الشهادات</h2>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-image">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="certificate-info">
                                <h3 class="certificate-title">شهادة إتمام دورة أساسيات برمجة الويب</h3>
                                <p class="certificate-date">تم الإصدار: 15 مارس 2025</p>
                                <p class="certificate-instructor">مُصدرة من: د. محمد أحمد</p>
                                <div class="certificate-actions">
                                    <a href="#" class="certificate-btn certificate-btn-primary">
                                        <i class="fas fa-download"></i>
                                        تحميل الشهادة
                                    </a>
                                    <a href="#" class="certificate-btn certificate-btn-outline">
                                        <i class="fas fa-share-alt"></i>
                                        مشاركة
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-image">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="certificate-info">
                                <h3 class="certificate-title">شهادة إتمام دورة قواعد البيانات وSQL</h3>
                                <p class="certificate-date">تم الإصدار: 10 فبراير 2025</p>
                                <p class="certificate-instructor">مُصدرة من: د. خالد حسن</p>
                                <div class="certificate-actions">
                                    <a href="#" class="certificate-btn certificate-btn-primary">
                                        <i class="fas fa-download"></i>
                                        تحميل الشهادة
                                    </a>
                                    <a href="#" class="certificate-btn certificate-btn-outline">
                                        <i class="fas fa-share-alt"></i>
                                        مشاركة
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="certificate-item">
                            <div class="certificate-image">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="certificate-info">
                                <h3 class="certificate-title">شهادة إتمام دورة JavaScript المتقدم</h3>
                                <p class="certificate-date">تم الإصدار: 5 يناير 2025</p>
                                <p class="certificate-instructor">مُصدرة من: د. سارة خالد</p>
                                <div class="certificate-actions">
                                    <a href="#" class="certificate-btn certificate-btn-primary">
                                        <i class="fas fa-download"></i>
                                        تحميل الشهادة
                                    </a>
                                    <a href="#" class="certificate-btn certificate-btn-outline">
                                        <i class="fas fa-share-alt"></i>
                                        مشاركة
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan --}}



            </div>
            <!-- /Main Content -->
        </div>
    </div>

    <!-- Hidden file input -->
    <input type="file" id="avatar-upload" accept="image/*">

    <!-- Edit Profile Modal -->

    @yield('scripts ')

    <script>
        // Tab navigation
        function showTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabId).classList.add('active');

            // Add active class to clicked nav link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('onclick').includes(tabId)) {
                    link.classList.add('active');
                }
            });
        }


        // Course tabs
        function showCourseTab(tabId) {
            document.querySelectorAll('.course-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // Settings tabs
        function showSettingsTab(tabId) {
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // Modal functions
        function openEditModal(type) {
            document.getElementById('edit-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('edit-modal').classList.remove('active');
        }

        // Password strength meter
        document.getElementById('new-password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('password-strength');
            const strengthText = document.getElementById('password-strength-text');

            if (password.length === 0) {
                strengthMeter.className = 'password-strength-fill';
                strengthText.textContent = 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل';
            } else if (password.length < 8) {
                strengthMeter.className = 'password-strength-fill strength-weak';
                strengthText.textContent = 'ضعيفة - يجب أن تحتوي على 8 أحرف على الأقل';
                strengthText.style.color = '#f44336';
            } else if (password.length >= 8 && /[a-z]/.test(password) && /[A-Z]/.test(password) && /\d/.test(
                    password)) {
                strengthMeter.className = 'password-strength-fill strength-strong';
                strengthText.textContent = 'قوية - كلمة مرور جيدة جدًا';
                strengthText.style.color = '#4caf50';
            } else {
                strengthMeter.className = 'password-strength-fill strength-medium';
                strengthText.textContent = 'متوسطة - أضف أحرف كبيرة، صغيرة، وأرقام';
                strengthText.style.color = '#ff9800';
            }
        });

        // Form submissions
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم حفظ التغييرات بنجاح!');
        });

        document.getElementById('password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const currentPassword = document.querySelector('#password-form input[type="password"]').value;
            const newPassword = document.getElementById('new-password').value;

            if (!currentPassword || !newPassword) {
                alert('يرجى تعبئة جميع الحقول');
                return;
            }

            if (newPassword.length < 8) {
                alert('كلمة المرور الجديدة يجب أن تحتوي على 8 أحرف على الأقل');
                return;
            }

            alert('تم تغيير كلمة المرور بنجاح!');
        });

        document.getElementById('edit-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم تحديث الملف الشخصي بنجاح!');
            closeModal();
        });

        // Avatar upload
        document.getElementById('avatar-upload').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelectorAll('.profile-avatar').forEach(avatar => {
                        avatar.style.backgroundImage = `url(${e.target.result})`;
                        avatar.style.backgroundSize = 'cover';
                        avatar.innerHTML = '';
                    });
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('edit-modal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            setTimeout(() => {
                document.querySelectorAll('.progress-fill').forEach(fill => {
                    const width = fill.style.width;
                    fill.style.width = '0%';
                    setTimeout(() => {
                        fill.style.width = width;
                        fill.style.transition = 'width 1.5s ease';
                    }, 100);
                });
            }, 500);
        });
    </script>
      <script>
        // Tab navigation
        function showTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabId).classList.add('active');

            // Add active class to clicked nav link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('onclick').includes(tabId)) {
                    link.classList.add('active');
                }
            });
        }


        // Course tabs
        function showCourseTab(tabId) {
            document.querySelectorAll('.course-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // Settings tabs
        function showSettingsTab(tabId) {
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.tabs .tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');
            event.target.classList.add('active');
        }

        // Modal functions
        function openEditModal(type) {
            document.getElementById('add-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('add-modal').classList.remove('active');
        }

        // Password strength meter
        document.getElementById('new-password').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('password-strength');
            const strengthText = document.getElementById('password-strength-text');

            if (password.length === 0) {
                strengthMeter.className = 'password-strength-fill';
                strengthText.textContent = 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل';
            } else if (password.length < 8) {
                strengthMeter.className = 'password-strength-fill strength-weak';
                strengthText.textContent = 'ضعيفة - يجب أن تحتوي على 8 أحرف على الأقل';
                strengthText.style.color = '#f44336';
            } else if (password.length >= 8 && /[a-z]/.test(password) && /[A-Z]/.test(password) && /\d/.test(
                    password)) {
                strengthMeter.className = 'password-strength-fill strength-strong';
                strengthText.textContent = 'قوية - كلمة مرور جيدة جدًا';
                strengthText.style.color = '#4caf50';
            } else {
                strengthMeter.className = 'password-strength-fill strength-medium';
                strengthText.textContent = 'متوسطة - أضف أحرف كبيرة، صغيرة، وأرقام';
                strengthText.style.color = '#ff9800';
            }
        });

        // Form submissions
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم حفظ التغييرات بنجاح!');
        });

        document.getElementById('password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const currentPassword = document.querySelector('#password-form input[type="password"]').value;
            const newPassword = document.getElementById('new-password').value;

            if (!currentPassword || !newPassword) {
                alert('يرجى تعبئة جميع الحقول');
                return;
            }

            if (newPassword.length < 8) {
                alert('كلمة المرور الجديدة يجب أن تحتوي على 8 أحرف على الأقل');
                return;
            }

            alert('تم تغيير كلمة المرور بنجاح!');
        });

        // document.getElementById('add-form').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     alert('تم تحديث الملف الشخصي بنجاح!');
        //     closeModal();
        // });

        // Avatar upload
        document.getElementById('avatar-upload').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelectorAll('.profile-avatar').forEach(avatar => {
                        avatar.style.backgroundImage = `url(${e.target.result})`;
                        avatar.style.backgroundSize = 'cover';
                        avatar.innerHTML = '';
                    });
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('add-modal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            setTimeout(() => {
                document.querySelectorAll('.progress-fill').forEach(fill => {
                    const width = fill.style.width;
                    fill.style.width = '0%';
                    setTimeout(() => {
                        fill.style.width = width;
                        fill.style.transition = 'width 1.5s ease';
                    }, 100);
                });
            }, 500);
        });
    </script>
</body>

</html>
