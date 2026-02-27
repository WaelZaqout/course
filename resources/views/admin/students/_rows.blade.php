@php
    use Illuminate\Support\Str;
@endphp

@forelse ($students as $student)
   <tr>
    {{-- # --}}
    <td>{{ $loop->iteration }}</td>

    {{-- الاسم --}}
    <td class="fw-semibold text-dark">
        {{ $student->name ?? 'لا يوجد معلومات' }}
    </td>

    {{-- البريد --}}
    <td>
        {{ $student->email ?? 'لا يوجد معلومات' }}
    </td>

    {{-- الهاتف --}}
    <td>
        {{ $student->phone ?? 'لا يوجد معلومات' }}
    </td>

    {{-- حالة الاشتراك --}}
    <td class="text-center">
        <span class="badge px-3 py-2 shadow-sm fw-semibold
            {{ $student->subscription_status === 'active' ? 'bg-success' : 'bg-danger' }}">
            {{ $student->subscription_status
                ? ($student->subscription_status === 'active' ? 'نشط' : 'غير محدد')
                : 'لا يوجد معلومات' }}
        </span>
    </td>
        <td>
            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>
        </td>



    </tr>
@empty
    <tr>
        <td colspan="12" class="text-center text-muted">لا توجد بيانات طلاب.</td>
    </tr>
@endforelse
