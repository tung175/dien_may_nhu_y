<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->where('name', '!=', 'superadmin')->where('name', '!=', 'user')->get();
        $i = 1;
        foreach ($roles as $role) {
            $role['stt'] = $i;
            $role['format_created_at'] = date('d/m/Y H:i:s', strtotime($role->created_at));
            $i++;
        }
        return \response()->json($roles);
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
        if (auth()->user()->can('create-role')) {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
                'permissions' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.max' => 'Tên không được quá 255 ký tự',
                'name.unique' => 'Tên đã tồn tại',
                'permissions.required' => 'Quyền không được để trống',
            ]);
            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
            $role->syncPermissions($request->permissions);
        
            return response()->json([
                'message' => 'Thêm thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền thêm',
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
        $role = Role::with('permissions')->find($id);
        return response()->json($role);
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
        if(auth()->user()->can('edit-role')) {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
                'permissions' => 'required',
            ],
            [
                'name.required' => 'Tên không được để trống',
                'name.max' => 'Tên không được quá 255 ký tự',
                'name.unique' => 'Tên đã tồn tại',
                'permissions.required' => 'Quyền không được để trống',
            ]);
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permissions);
            return response()->json([
                'message' => 'Cập nhật thành công',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        if (auth()->user()->can('delete-role')) {
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                $role = Role::find($id);
                $role->delete();
            }
            return response()->json([
                'message' => 'Xóa thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa',
        ], 401);
    }
}
