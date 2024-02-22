<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Brand;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::with('category')->orderBy('id', 'desc')->get();
        $i = 1;
        foreach ($brands as $brand) {
            $brand['stt'] = $i;
            $i++;
        }
        return response()->json($brands);
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
        if (auth()->user()->can('create-brand')) {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255', Rule::unique('brands')->where(function ($query) use ($request) {
                        return $query->where('name', $request->name)->where('category_id', $request->category_id);
                    })],
                    'category_id' => 'required',
                    'image' => 'required|mimes:jpg,jpeg,png,bmp|max:20000'
                ],
                [
                    'name.required' => 'Tên thương hiệu không được để trống',
                    'name.string' => 'Tên thương hiệu phải là chuỗi ký tự',
                    'name.max' => 'Tên thương hiệu không được quá 255 ký tự',
                    'name.unique' => 'Tên thương hiệu đã tồn tại trong danh mục này',
                    'category_id.required' => 'Danh mục không được để trống',
                    'image.required' => 'Logo không được để trống',
                    'image.mimes' => 'File không đúng định dạng (định dạng yêu cầu là jpg, jpeg, png, bmp)',
                    'image.max' => 'Kích thước file vượt quá 20MB'
                ]
            );

            $brand = new Brand();

            if ($request->file()) {
                $file_name = time() . '_' . $request->image->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('images/brands', $file_name, 'public');

                $brand->name = $request->name;
                $brand->category_id = $request->category_id;
                $brand->image = '/storage/' . $file_path;
                $brand->created_at = date('Y-m-d H:i:s');

                $brand->save();

                return response()->json([
                    'message' => 'Thêm thành công',
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Bạn không có quyền thêm thương hiệu'
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
        $brand = Brand::with('category')->find($id);
        return response()->json($brand);
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
        if (auth()->user()->can('edit-brand')) {
            if ($request->file()) {
                $request->validate(
                    [
                        'name' => ['string', 'max:255', Rule::unique('brands')->ignore($id)->where(function ($query) use ($request) {
                            return $query->where('name', $request->name)->where('category_id', $request->category_id);
                        })],

                        'image' => 'mimes:jpg,jpeg,png,bmp|max:20000'
                    ],
                    [
                        'name.string' => 'Tên thương hiệu phải là chuỗi ký tự',
                        'name.max' => 'Tên thương hiệu không được quá 255 ký tự',
                        'name.unique' => 'Tên thương hiệu đã tồn tại trong danh mục này',
                        'image.mimes' => 'File không đúng định dạng (định dạng yêu cầu là jpg, jpeg, png, bmp)',
                        'image.max' => 'Kích thước file vượt quá 20MB'
                    ]
                );
            } else {
                $request->validate(
                    [
                        'name' => ['string', 'max:255', Rule::unique('brands')->ignore($id)->where(function ($query) use ($request) {
                            return $query->where('name', $request->name)->where('category_id', $request->category_id);
                        })],
                    ],
                    [
                        'name.string' => 'Tên thương hiệu phải là chuỗi ký tự',
                        'name.max' => 'Tên thương hiệu không được quá 255 ký tự',
                        'name.unique' => 'Tên thương hiệu đã tồn tại trong danh mục này',
                    ]
                );
            }

            $brand = Brand::find($id);

            if ($request->file()) {
                $file_name = time() . '_' . $request->image->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('images/brands', $file_name, 'public');

                $brand->name = $request->name;
                $brand->category_id = $request->category_id;

                if ($brand->image) {
                    unlink(storage_path($this->removeChar($brand->image)));
                }
                $brand->image = '/storage/' . $file_path;
                $brand->updated_at = date('Y-m-d H:i:s');

                $brand->save();

                return response()->json([
                    'message' => 'Cập nhật thành công',
                ], 200);
            } else {
                $brand->name = $request->name;
                $brand->category_id = $request->category_id;
                $brand->updated_at = date('Y-m-d H:i:s');

                $brand->save();

                return response()->json([
                    'message' => 'Cập nhật thành công',
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Bạn không có quyền cập nhật thương hiệu'
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
        if (auth()->user()->can('delete-brand')) {
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                $brand = Brand::find($id);
                if ($brand->image) {
                    unlink(storage_path($this->removeChar($brand->image)));
                }
                $brand->delete();
            }
            return response()->json([
                'message' => 'Xóa thành công'
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa thương hiệu'
        ], 401);
    }

    public function removeChar($str) {
        $res = str_ireplace('/storage', 'app/public', $str);
  
        // returning the result 
        return $res;
    }
}
