<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Type;
class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::with('category')->orderBy('id', 'desc')->get();
        $i = 1;
        foreach ($types as $type) {
            $type['stt'] = $i;
            $i++;
        }
        return response()->json($types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->can('create-type')) {
            $request->validate([
                'name' => 'required|unique:types|max:255',
                'category_id' => 'required'
            ],
            [
                'name.required' => 'Tên loại sản phẩm không được để trống',
                'name.unique' => 'Tên loại sản phẩm đã tồn tại',
                'name.max' => 'Tên loại sản phẩm không được quá 255 ký tự',
                'category_id.required' => 'Danh mục không được để trống'
            ]);
    
            $type = new Type(); 
            $type->name = $request->name;
            $type->category_id = $request->category_id;
            $type->created_at = date('Y-m-d H:i:s');
            $type->save();

            return response()->json([
                'message' => 'Thêm thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền thêm loại sản phẩm'
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
        $type = Type::with('category')->where('id', $id)->first();
        return response()->json($type);
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
        if(auth()->user()->can('edit-type')) {
            $request->validate([
                'name' => 'required|unique:types|max:255',
                'category_id' => 'required'
            ],
            [
                'name.required' => 'Tên loại sản phẩm không được để trống',
                'name.unique' => 'Tên loại sản phẩm đã tồn tại',
                'name.max' => 'Tên loại sản phẩm không được quá 255 ký tự',
                'category_id.required' => 'Danh mục không được để trống'
            ]);
    
            $type = Type::find($id);
            $type->name = $request->name;
            $type->category_id = $request->category_id;
            $type->updated_at = date('Y-m-d H:i:s');
            $type->save();

            return response()->json([
                'message' => 'Cập nhật thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền cập nhật loại sản phẩm'
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
        if(auth()->user()->can('delete-type')) {
            $ids = explode(',', $ids);
            $type = Type::whereIn('id', $ids)->delete();
            return response()->json([
                'message' => 'Xóa thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa loại sản phẩm'
        ], 401);        
    }
}
