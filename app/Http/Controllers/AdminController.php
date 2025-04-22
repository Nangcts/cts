<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Role;
use App\Permission_Role;
use Hash;
use Auth;
use Session;
use App\Permission;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    public function __construct()
    {
    }

    public function getAddUser ()
    {
        return view('auth.register');
    }

    public function getListUser ()
    {
        $this->authorize('admin-manager');

        $admins = User::orderBy('created_at','desc')->get();
        return view('admin.admin-manager.list', compact('admins'));
    }

    public function getEditUser ($id)
    {
        $this->authorize('edit-profile', $id);

        $user = User::findOrFail($id);
        return view('admin.admin-manager.edit-user', compact('user'));
    }

    public function postEditUser ($id, Request $request)
    {
        $user = User::find($id);
        $this->validate($request,
            [
                'password' => 'required|string',
                'newPassword' => 'required|string|min:6|max:25',
                'new_password_confirmation' => 'same:newPassword',
            ],
            [
                'password.required' => 'Bạn phải nhập mật khẩu cũ',
                'newPassword.required' => 'Bạn chưa nhập mật khẩu mới',
                'newPassword.min' => 'Mật khẩu phải từ 6 ký tự trở lên',
                'newPassword.max' => 'Mật khẩu không được quá 25 ký tự',
                'new_password_confirmation.same' => 'Mật khẩu xác nhận không khớp',
            ]
        );
        if (Auth::guard('web')->user()->id == 1) {
            $user->role_id = $request->sltUserRole;
        }
        if (Hash::check($request->password, $user->password)) { 
            $user->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();
            Session::flash('success','Bạn đã đổi mật khẩu thành công');
            return back();
        } else {
            Session::flash('error','Mật khẩu hiện tại sai.');
            return back();
        }    
    }

    public function getAddRole ()
    {
        $this->authorize('admin-manager');

        $permission_group = \App\PermissionGroup::all();
        return view('admin.admin-manager.add-role', compact('permission_group'));
    }

    public function postAddRole (Request $request)
    {
        $this->authorize('admin-manager');

        $this->validate($request, 
            [
                'iptTitle' => 'required|unique:roles,title'
            ],
            [
                'iptTitle.required' => 'Chưa nhập tên Vai trò',
                'iptTitle.unique' => 'Tên vai trò đã tồn tại trên hệ thống',
            ]
        );

        $role = new Role;
        $role->title = $request->iptTitle;
        $role->save();
        // Thêm quyền cho Role vừa tạo ra
        $permissions = $request->permissions;
        $role->permissions()->attach($permissions);
        Session::flash('success','Thêm vai trò thành công !');
        return redirect('/admin/admin-manager/list-roles');  
        
    }

    public function getEditRole ($id)
    {
        $this->authorize('admin-manager');

        $role = Role::findOrFail($id);
        $role_permission = $role->permissions;
        $permissions = Permission::all();
        $permission_group = \App\PermissionGroup::all();
        
        return view('admin.admin-manager.edit-role', compact('role','role_permission','permissions','permission_group'));
    }

    public function postEditRole ($id, Request $request)
    {
        $this->authorize('admin-manager');

        $this->validate($request, 
            [
                'iptTitle' => 'required|unique:roles,title,'.$id
            ],
            [
                'iptTitle.required' => 'Chưa nhập tên Vai trò',
                'iptTitle.unique' => 'Tên vai trò đã tồn tại trên hệ thống',
            ]
        );

        $role = Role::findOrFail($id);
        $role->title = $request->iptTitle;
        $role->save();
        // Quyền của Role này
        $permissions = $request->permissions;
        $role->permissions()->sync($permissions);

        Session::flash('success','Sửa vai trò thành công !');
        return redirect('/admin/admin-manager/list-roles');  
    }

    public function listRoles()
    {
        $this->authorize('admin-manager');

        $roles = Role::all();
        return view('admin.admin-manager.list-roles', compact('roles'));
    }

    public function deleteRole ($id)
    {
        $this->authorize('admin-manager');

        $role = Role::findOrFail($id);
        $role->permissions()->detach();
        $role->delete();
        Session::flash('success','Xóa vai trò thành công !');
        return redirect('/admin/admin-manager/list-roles'); 
    }

    public function addPermissionGroup ()
    {
        $this->authorize('admin-manager');

        return view('admin.admin-manager.add-permission-group');
    }

    public function savePermissionGroup(Request $request)
    {
        $this->authorize('admin-manager');

        $this->validate($request,
            [
                'iptGroupTitle' => 'required',
            ],
            [
                'iptGroupTitle.required' => 'Bạn phải nhập tên nhóm quyền',
            ]
        );

        $group = new \App\PermissionGroup;
        $group->title = $request->iptGroupTitle;

        $group->save();

        Session::flash('success','Thêm nhóm quyền thành công !');
        return redirect('/admin/admin-manager/list-permission-group');
    }

    public function listPermissionGroup()
    {
        $this->authorize('admin-manager');
        $list_group = \App\PermissionGroup::all();

        return view('admin.admin-manager.list-permission-group',compact('list_group'));
    }

    public function editPermissionGroup ($id)
    {
        $group = \App\PermissionGroup::find($id);

        return view('admin.admin-manager.edit-permission-group', compact('group'));
    }

    public function saveEditPermissionGroup ($id, Request  $request)
    {
        $this->authorize('admin-manager');

        $this->validate($request,
            [
                'iptGroupTitle' => 'required',
            ],
            [
                'iptGroupTitle.required' => 'Bạn phải nhập tên nhóm quyền',
            ]
        );
        $group = \App\PermissionGroup::find($id);

        $group->title = $request->iptGroupTitle;

        $group->save();

        Session::flash('success','Sửa nhóm quyền thành công !');
        return redirect('/admin/admin-manager/list-permission-group');
    }

    public function getAddPermission ()
    {
        $this->authorize('admin-manager');

        $permission_group = \App\PermissionGroup::all();
        return view('admin.admin-manager.add-permission', compact('permission_group'));
    }           

    public function postAddPermission (Request $request)
    {
        $this->authorize('admin-manager');

        $this->validate($request, [
            'iptTitle' => 'required|unique:permissions,title',
            'iptName' => 'required|regex:/^[a-z0-9_-]{5,32}$/',
        ],
        [
            'iptTitle.required' => 'Bạn phải nhập tên người dùng',
            'iptTitle.unique' => 'Tên quyền đã tồn tại',
            'iptName.required' => 'Bạn phải nhập mã quyền',
            'iptName.regex' => 'Tên người dùng phải từ 5-32 ký tự, gồm các chữ cái thường từ a-z, dấu gạch ngang hoặc gạch dưới',
        ]);

        $permission = new Permission;
        $permission->title = $request->iptTitle;
        $permission->name = $request->iptName;
        $permission->group_id = $request->sltPermissionGroup;
        $permission->save();

        Session::flash('success','Thêm quyền thành công !');
        return redirect('/admin/admin-manager/list-permissions');
    }

    public function getEditPermission ($id)
    {
        $permission = Permission::find($id);
        $permission_group = \App\PermissionGroup::all();
        return view('admin.admin-manager.edit-permission', compact('permission','permission_group'));
    }

    public function postEditPermission ($id, Request $request)
    {
        $this->validate($request, [
            'iptTitle' => [
                'required',
                Rule::unique('permissions','title')->ignore($id),
            ],
            'iptName' => [
                'required',
                'regex:/^[a-z0-9_-]{5,32}$/',
                Rule::unique('permissions','name')->ignore($id),
            ],
        ],
        [
            'iptTitle.required' => 'Bạn phải nhập tên người dùng',
            'iptTitle.unique' => 'Tên quyền đã tồn tại',
            'iptName.required' => 'Bạn phải nhập mã quyền',
            'iptName.unique' => 'Mã quyền đã tồn tại',
            'iptName.regex' => 'Tên người dùng phải từ 5-32 ký tự, gồm các chữ cái thường từ a-z, dấu gạch ngang hoặc gạch dưới',
        ]);

        $permission = Permission::find($id);
        $permission->title = $request->iptTitle;
        $permission->name = $request->iptName;
        $permission->group_id = $request->sltPermissionGroup;
        $permission->save();

        Session::flash('success','Sửa quyền thành công !');
        return redirect('/admin/admin-manager/list-permissions');
    }
    public function getListPermissions()
    {
        $this->authorize('admin-manager');
        $permissions = Permission::all();
        return view('admin.admin-manager.list-permissions', compact('permissions'));
    }

    public function deletePermission($id)
    {
        $this->authorize('admin-manager');

        $permission = Permission::findOrFail($id);
        $permission->roles()->detach();
        $permission->delete();
        Session::flash('success','Xóa quyền thành công !');
        return redirect('/admin/admin-manager/list-permissions'); 
    }

    public function editAdmin()
    {
        $this->authorize('admin-manager');

        return view('admin.superadmin.edit');
    }

    public function postEditAdmin(Request $request) 
    {
        $this->authorize('admin-manager');

        $this->validate($request, [
          'email' => 'required|email',
      ],
      [
          'email.required' => 'Bạn chưa nhập email',
          'email.email' => 'Sai cú pháp email',
      ]);

        $admin = User::find(1);
        $admin->email = $request->email;
        if (($request->changePassword) == 'on') 
        {
            $this->validate($request,[
                'password' => 'required',
                'newPassword' => 'required|min:6|max:12',
                'password_confirmation' => 'same:newPassword',
            ],
            [
                'password.required' => 'Bạn phải nhập mật khẩu cũ',
                'newPassword.required' => 'Bạn chưa nhập mật khẩu mới',
                'newPassword.min' => 'Mật khẩu phải từ 6 ký tự trở lên',
                'newPassword.max' => 'Mật khẩu không được quá 12 ký tự',
                'password_confirmation.same' => 'Mật khẩu xác nhận không khớp',
            ]
        );
            if (Hash::check($request->password, $admin->password)) { 
                $admin->fill([
                    'password' => Hash::make($request->newPassword)
                ])->save();
            } else {
                Session::flash('error','Mật khẩu hiện tại sai.');
                return redirect()->route('admin.adminEdit');   
            }               
        }
        $admin->save();
        Session::flash('success','Cập nhật Admin thành công !');
        return redirect()->route('admin.adminEdit'); 
    }

    public function listCustomerAccount ()
    {
        $this->authorize('admin-manager');
        $customer_acc = \App\Customer::orderBy('id','desc')->get();

        // $trans = \App\Customer::find(3)->transactions;
        // dd($trans);

        return view('admin.admin-manager.list-customer-account', compact('customer_acc'));
    }

    public function lockCustomerAccount ($id)
    {
        $this->authorize('admin-manager');

        $customer = \App\Customer::find($id);

        $customer->active = 0;
        $customer->save();

        Session::flash('success','Đã khóa tài khoản thành công !');
        return back();

    }
    public function unLockCustomerAccount ($id)
    {
        $this->authorize('admin-manager');

        $customer = \App\Customer::find($id);

        $customer->active = 1;
        $customer->save();

        Session::flash('success','Mở khóa tài khoản thành công !');
        return back();

    }


    public function deleteCustomerAccount ()
    {
        $this->authorize('admin-manager');

        $customer = \App\Customer::find($id);

        $customer->delete();

        Session::flash('success','Xóa khóa tài khoản thành công !');
        return back();
    }

    public function listCustomerTransaction ($id)
    {
        $this->authorize('admin-manager');
        $customer = \App\Customer::find($id);
        $transactions = \App\Transaction::where('customer_id', $id)->get();
        $uploaded = \App\DonThuoc::where('customer_id', $id)->orderBy('created_at','desc')->get();

        return view('admin.admin-manager.list-customer-transaction', compact('transactions','customer','uploaded'));
    }

    public function listAllUpload ()
    {
        $uploads = \App\DonThuoc::orderBy('id','desc')->paginate(20);

        return view('admin.admin-manager.all-uploads',compact('uploads'));
    }

    public function confirmDonthuoc (Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $don_thuoc = \App\DonThuoc::find($id);

            if(!empty($don_thuoc)) {
                $don_thuoc->status = 1;
                $don_thuoc->save();
            }
            return 1;
        }

    }
    
}
