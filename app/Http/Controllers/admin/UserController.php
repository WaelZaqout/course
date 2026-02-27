<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function index()
    {
        $roles = Role::all();

        $users = User::with('roles', 'permissions')->get();
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.users.index', compact('users', 'roles', 'permissions'));
    }
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.users.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'confirmed', 'min:6'],
            'roles'       => ['array'],
            'roles.*'     => ['string', 'exists:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        // 👇 أضِف السطرين التاليين
        $this->syncRoleColumn($user);
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // لو طلب AJAX: رجّع صفوف محدثة
        if ($request->wantsJson()) {
            // الأفضل ترجع paginate لو جدولك فيه ترقيم
            $users = User::with('roles', 'permissions')->latest()->paginate(10);
            return response()->json([
                'ok'         => true,
                'rows'       => view('admin.users._rows', ['users' => $users])->render(),
                'pagination' => $users->links()->toHtml(),
            ], 201);
        }

        // غير AJAX → سلوك قديم
        return redirect()->route('users.index')->with([
            'msg'  => 'تم إنشاء المستخدم بنجاح',
            'type' => 'success',
        ]);
    }



    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'         => ['sometimes', 'string', 'max:255'],
            'email'        => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'     => ['nullable', 'confirmed', 'min:6'],
            'roles'        => ['sometimes', 'array'],
            'roles.*'      => ['string', 'exists:roles,name'],
            'permissions'  => ['sometimes', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        // 1) تحديث بيانات الحساب
        if ($request->filled('name'))  $user->name  = $data['name'];
        if ($request->filled('email')) $user->email = $data['email'];
        if (!empty($data['password'])) $user->password = bcrypt($data['password']);
        $user->save();

        // 2) تحديث الأدوار/الصلاحيات (Spatie)
        if ($request->has('roles'))       $user->syncRoles($data['roles'] ?? []);
        if ($request->has('permissions')) $user->syncPermissions($data['permissions'] ?? []);

        // 3) مزامنة عمود users.role (لو تعتمد عليه في واجهتك)
        $this->syncRoleColumn($user);

        // 4) تفريغ كاش صلاحيات Spatie (مهم بعد أي تعديل للأدوار/الصلاحيات)
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        if ($request->wantsJson()) {
            $users = User::with('roles', 'permissions')->latest()->paginate(10);
            return response()->json([
                'ok'         => true,
                'rows'       => view('admin.users._rows', compact('users'))->render(),
                'pagination' => $users->links()->toHtml(),
            ]);
        }

        return redirect()->route('users.index')->with([
            'msg'  => 'تم التحديث بنجاح',
            'type' => 'success',
        ]);
    }

    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()
            ->route('users.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف المستخدم بنجاح'
            ]);
    }
    protected function syncRoleColumn(User $user): void
    {
        $priority = ['admin', 'teacher', 'student']; // ترتيب الأولوية
        $assigned = $user->roles->pluck('name')->all();

        $role = 'student'; // قيمة افتراضية آمنة
        foreach ($priority as $r) {
            if (in_array($r, $assigned, true)) {
                $role = $r;
                break;
            }
        }

        $user->forceFill(['role' => $role])->save();
    }
}
