<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::with('products')->orderBy('id', 'desc')->get();
        $i = 1;
        foreach ($colors as $color) {
            $color['stt'] = $i;
            $i++;
        }
        return response()->json($colors);
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
        if (auth()->user()->can('create-color')) {
            $request->validate(
                [
                    'name' => 'required|unique:colors|max:255',
                    'image' => 'required|mimes:jpg,jpeg,png,bmp|max:20000'
                ],
                [
                    'name.required' => 'Tên màu không được để trống',
                    'name.unique' => 'Tên màu đã tồn tại',
                    'name.max' => 'Tên màu không được quá 255 ký tự',
                    'image.required' => 'Ảnh màu không được để trống',
                    'image.mimes' => 'File không đúng định dạng (định dạng yêu cầu là jpg, jpeg, png, bmp)',
                    'image.max' => 'Kích thước file vượt quá 20MB'
                ]
            );

            $color = new Color();

            if ($request->file()) {
                $file_name = time() . '_' . $request->image->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('images/colors', $file_name, 'public');

                $color->name = $request->name;
                $color->image = '/storage/' . $file_path;
                $color->created_at = date('Y-m-d H:i:s');

                $color->save();

                return response()->json([
                    'message' => 'Thêm thành công',
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Bạn không có quyền thêm màu sắc'
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
        $color = Color::where('id', $id)->first();
        return response()->json($color);
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
        if (auth()->user()->can('edit-color')) {
            if ($request->file()) {
                $request->validate(
                    [
                        'name' => 'required|unique:colors,name,' . $id . '|max:255',
                        'image' => 'mimes:jpg,jpeg,png,bmp|max:20000'
                    ],
                    [
                        'name.required' => 'Tên màu không được để trống',
                        'name.unique' => 'Tên màu đã tồn tại',
                        'name.max' => 'Tên màu không được quá 255 ký tự',
                        'image.mimes' => 'File không đúng định dạng (định dạng yêu cầu là jpg, jpeg, png, bmp)',
                        'image.max' => 'Kích thước file vượt quá 20MB'
                    ]
                );
            } else {
                $request->validate(
                    [
                        'name' => 'required|unique:colors,name,' . $id . '|max:255',
                    ],
                    [
                        'name.required' => 'Tên màu không được để trống',
                        'name.unique' => 'Tên màu đã tồn tại',
                        'name.max' => 'Tên màu không được quá 255 ký tự',
                    ]
                );
            }

            $color = Color::find($id);

            if ($request->file()) {
                $file_name = time() . '_' . $request->image->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('images/colors', $file_name, 'public');

                $color->name = $request->name;

                if ($color->image) {
                    unlink(storage_path($this->removeChar($color->image)));
                }
                $color->image = '/storage/' . $file_path;
                $color->updated_at = date('Y-m-d H:i:s');

                $color->save();

                return response()->json([
                    'message' => 'Cập nhật thành công',
                ], 200);
            } else {
                $color->name = $request->name;
                $color->updated_at = date('Y-m-d H:i:s');

                $color->save();

                return response()->json([
                    'message' => 'Cập nhật thành công',
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Bạn không có quyền cập nhật màu sắc'
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
        if (auth()->user()->can('delete-color')) {
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                $color = Color::find($id);
                if ($color->image) {
                    unlink(storage_path($this->removeChar($color->image)));
                }
                $color->delete();
            }
            return response()->json([
                'message' => 'Xóa thành công'
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa thương hiệu'
        ], 401);
    }

    public function removeChar($str)
    {
        $res = str_ireplace('/storage', 'app/public', $str);
        return $res;
    }
}
