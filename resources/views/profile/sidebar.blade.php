<!-- Sidebar -->
@php
    $u = $u ?? auth()->user();
    $name = trim($u?->name ?? '');
    // توليد الأحرف الأولى
    $initials = null;
    if ($name !== '') {
        $parts = preg_split('/\s+/', $name);
        $tmp = '';
        foreach ($parts as $p) {
            $tmp .= mb_substr($p, 0, 1);
        }
        $initials = mb_strtoupper($tmp);
    }
@endphp

<div class="sidebar">
    <div class="profile-header">
        <div class="profile-avatar" style="position:relative;">
            @if ($u?->avatar)
                <img id="sidebarProfilePreview"
                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/default-avatar.png') }}"
                    alt="Avatar"
                    style="width:100px; height:100px; border-radius:50%; object-fit:cover; display:block; margin-bottom:5px; cursor:pointer;"
                    onclick="showAvatarModal()">
            @elseif ($initials)
                <span>{{ $initials }}</span>
            @else
                <i class="fas fa-user"></i>
            @endif
            <!-- input مخفي للرفع -->
            <input type="file" id="avatar-upload" name="avatar" accept="image/*" style="display:none;">
        </div>

        <h3 class="profile-name">{{ $u?->role }}
            <br> {{ $u?->name ?? 'مستخدم' }}
        </h3>
        <p class="profile-email">{{ $u?->email ?? '' }}</p>
    </div>

    <ul class="nav-menu">
        {{-- للجميع --}}
        <li class="nav-item">
            <a href="{{ route('profile.index') }}"
                class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                الملف الشخصي
            </a>
        </li>
        {{-- كورساتي (للمعلم) --}}
        @role('teacher')
            @can('إنشاء دورة')
                <li class="nav-item">
                    <a href="{{ route('profile.courses.index') }}"
                        class="nav-link {{ request()->routeIs('profile.courses.index') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        كورساتي
                    </a>
                </li>
            @endcan
        @endrole

        @role('student')
            <a href="{{ route('student.courses.index') }}" class="nav-link">
                <i class="fas fa-folder"></i>
                كورساتي (طالب)
            </a>

            </li>
            @can('رؤية درجاتي')
                <li class="nav-item">
                    <a href="javascript:void(0)" data-tab="certificates" class="nav-link">
                        <i class="fas fa-certificate"></i>
                        الشهادات
                    </a>
                </li>
            @endcan

            <li class="nav-item">
                <a href="javascript:void(0)" data-tab="achievements" class="nav-link">
                    <i class="fas fa-trophy"></i>
                    الإنجازات
                </a>
            </li>

            @canany(['عرض الدورات', 'الانضمام إلى دورة'])
                <li class="nav-item">
                    <a href="javascript:void(0)" data-tab="all-courses" class="nav-link">
                        <i class="fas fa-graduation-cap"></i>
                        الدورات
                    </a>
                </li>
            @endcanany
        @endrole

        <li class="nav-item">
            <a href="{{ route('profile.settings.index') }}"
                class="nav-link {{ request()->routeIs('profile.settings.index') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                الإعدادات
            </a>
        </li>

        {{-- تسجيل الخروج --}}
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                تسجيل الخروج
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>
    </ul>
</div>

<!-- نافذة منبثقة لعرض الصورة -->
<div id="avatarModal"
    style="display:none; position:fixed; z-index:9999; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.7); align-items:center; justify-content:center;">
    <span onclick="closeAvatarModal()"
        style="position:absolute; top:30px; right:40px; color:#fff; font-size:40px; cursor:pointer;">&times;</span>
    <img id="avatarModalImg" src="" alt="Avatar"
        style="width:320px; height:320px; border-radius:50%; object-fit:cover; box-shadow:0 0 20px #000; display:block;">
</div>

<!-- CSS -->
<style>
    .nav-link.active {
        background-color: #007bff;
        color: #fff !important;
        border-radius: 8px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        color: #333;
        text-decoration: none;
        transition: 0.3s;
    }

    .nav-link:hover {
        background: #f0f0f0;
    }
</style>

<script>
    function showAvatarModal() {
        var imgSrc = document.getElementById('sidebarProfilePreview').src;
        document.getElementById('avatarModalImg').src = imgSrc;
        document.getElementById('avatarModal').style.display = 'flex';
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').style.display = 'none';
    }
    // إغلاق النافذة عند الضغط خارج الصورة
    document.addEventListener('click', function(e) {
        var modal = document.getElementById('avatarModal');
        if (modal && e.target === modal) {
            closeAvatarModal();
        }
    });
</script>
