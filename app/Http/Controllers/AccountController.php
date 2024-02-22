<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superadmin')->orWhere('name', 'user');
        })->get();
        $i = 1;
        foreach ($users as $user) {
            $user['stt'] = $i;
            $i++;
        }
        $roles = Role::all()->where('name', '!=', 'superadmin')->where('name', '!=', 'user')->pluck('name');
        return \response()->json([
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->can('create-user')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role_selected' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.max' => 'Tên không được quá 255 ký tự',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.max' => 'Email không được quá 255 ký tự',
                'email.unique' => 'Email đã tồn tại',
                'role_selected.required' => 'Vui lòng chọn vai trò',
            ]);
            $acc = new User();
            $acc->name = $request->name;
            $acc->created_at = date('Y-m-d H:i:s');
            $acc->email = $request->email;
            $password = Str::random(8);
            $acc->password = bcrypt($password);
            $acc->save();
            $acc->assignRole($request->role_selected);
            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ];
            Mail::to($acc->email)->send(new \App\Mail\Register($details));
            return response()->json([
                'message' => 'Thêm thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền thêm tài khoản',
        ], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acc = User::find($id);
        $permissions = $acc->getPermissionsViaRoles();
        $roles = Role::where('name', '!=', 'superadmin')->where('name', '!=', 'user')->get();
        return \response()->json([
            'acc' => $acc,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->can('edit-user')) {
            $request->validate([
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.max' => 'Tên không được quá 255 ký tự',
            ]);
            $acc = User::find($id);
            $acc->name = $request->name;
            $acc->updated_at = date('Y-m-d H:i:s');
            $acc->removeRole($acc->roles->first()->name);
            $acc->assignRole($request->role);
            $acc->save();
            return response()->json([
                'message' => 'Sửa thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền sửa tài khoản',
        ], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        if (auth()->user()->can('delete-user')) {
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                $user = User::find($id);
                $user->delete();
            }
            return response()->json([
                'message' => 'Xóa thành công'
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa tài khoản'
        ], 401);
    }
}
