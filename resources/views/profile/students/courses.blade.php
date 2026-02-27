@extends('profile.master')
@section('title', 'ملفي الشخصي')
@section('content')
    <!-- Main Content -->

            <!-- Main Content -->
            <div class="main-content">
                <div id="profile" class="tab-content active">
                    <div class="section-header d-flex justify-content-between align-items-center">
                        <h2 class="section-title">كورساتي</h2>


                    </div>

                    <!-- Grid of Courses -->
                    <div class="courses-grid"
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-top:20px;">
                        @forelse($courses as $course)
                            <div class="course-card"
                                style="background:#fff; border-radius:20px; box-shadow:0 4px 12px rgba(0,0,0,0.1); overflow:hidden; transition:.3s;">

                                <!-- صورة الكورس -->
                                <div class="course-image"
                                    style="position:relative; width:100%; height:200px; overflow:hidden;">
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
                                        <a href="{{ route('student.courses.show', $course->id) }}"
                                            style="background:#6c63ff; color:white; padding:8px 15px; border-radius:10px;
                                                 text-decoration:none; font-size:14px;">
                                            تفاصيل الكورس
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>لا يوجد كورسات حتى الآن.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>




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

@endsection
