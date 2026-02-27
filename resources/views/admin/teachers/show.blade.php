@extends('admin.master')

@section('title', 'بيانات الأستاذ')

@section('content')
    <div class="container">
        <div class="card shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">بيانات الأستاذ</h5>
                <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-outline-secondary">
                    رجوع لقائمة الأساتذة
                </a>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">الاسم</dt>
                    <dd class="col-sm-9">{{ $teacher->name ?? '-' }}</dd>

                    <dt class="col-sm-3">البريد الإلكتروني</dt>
                    <dd class="col-sm-9">{{ $teacher->email ?? '-' }}</dd>

                    <dt class="col-sm-3">الهاتف</dt>
                    <dd class="col-sm-9">{{ $teacher->phone ?? '-' }}</dd>

                    <dt class="col-sm-3">الدولة</dt>
                    <dd class="col-sm-9">{{ $teacher->country ?? '-' }}</dd>

                    <dt class="col-sm-3">الدور</dt>
                    <dd class="col-sm-9">{{ $teacher->role ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection

