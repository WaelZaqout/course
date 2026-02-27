@extends('profile.master')
@section('title', 'ملفي الشخصي')
@section('content')
    <!-- Main Content -->


    <div class="main-content">
        <!-- Profile Tab -->
        <div id="profile" class="tab-content active">
            <div class="section-header">
                <h2 class="section-title">ملفي الشخصي</h2>
                <a href="{{route('profile.settings.index')}}" class="edit-btn"  style="background: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-id-card"></i>
                 عرض بياناتي
                </a>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ $progressRate }}%</div>
                    <div class="stat-label">معدل إنجاز الدورات</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $learningHours }}</div>
                    <div class="stat-label">ساعة تعلم</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $completedLessons }}</div>
                    <div class="stat-label">دروس مكتملة</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">3</div>
                    <div class="stat-label">مشاريع مكتملة</div>
                </div>
            </div>


            <div style="margin-top: 2rem;">
                <h3 style="margin-bottom: 1rem; color: #333;">المهارات المكتسبة</h3>
                <div class="badges-container">
                    <span class="badge"><i class="fas fa-code"></i> HTML5</span>
                    <span class="badge"><i class="fas fa-paint-brush"></i> CSS3</span>
                    <span class="badge"><i class="fas fa-code"></i> JavaScript</span>
                    <span class="badge"><i class="fab fa-react"></i> React</span>
                    <span class="badge"><i class="fab fa-node-js"></i> Node.js</span>
                    <span class="badge"><i class="fas fa-database"></i> MongoDB</span>
                </div>
            </div>

            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-top: 1rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: #666;">آخر دخول</span>
                    <span style="font-weight: 500;">{{ $u->last_login_at?->format('Y-m-d H:i') ?? 'لم يسجل بعد' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: #666;">عدد الدروس هذا الأسبوع</span>
                    <span style="font-weight: 500;">{{ $completedLessons }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span style="color: #666;">معدل التقدم</span>
                    <span style="font-weight: 500;">{{ $progressRate }}%</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">الدورات النشطة</span>
                    <span style="font-weight: 500;">{{ $activeCourses }} دورات</span>
                </div>
            </div>

        </div>
    </div>


    <!-- Hidden file input -->
    <input type="file" id="avatar-upload" accept="image/*">
    @include('profile.teachers.addcourse')

@endsection
