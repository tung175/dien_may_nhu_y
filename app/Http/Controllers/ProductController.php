<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use Illuminate\Support\Facades\File;
use App\Models\Post;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('brand', 'category', 'type', 'colors', 'images')->orderBy('id', 'desc')->get();
        $i = 1;
        foreach ($products as $product) {
            $product['stt'] = $i;
            $i++;
        }
        
        return response()->json($products);
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
        if (auth()->user()->can('create-product')) {
            $request->validate(
                [
                    'code' => 'required|unique:products|max:255',
                    'name' => 'required|unique:products|max:255',
                    'category_id' => 'required',
                    'brand_id' => 'required',
                    'type_id' => 'required',
                    'image' => 'required|mimes:jpg,jpeg,png,bmp|max:20000',
                    'description' => 'required',
                    'color_ids' => 'required',
                    'price' => 'required',
                    'warranty' => 'required',
                    'images' => 'required',
                    'info_product' => 'required|max:65535',
                    'clip' => 'required',
                ],
                [
                    'code.required' => 'Mã sản phẩm không được để trống',
                    'code.unique' => 'Mã sản phẩm đã tồn tại',
                    'code.max' => 'Mã sản phẩm không được quá 255 ký tự',
                    'name.required' => 'Tên màu không được để trống',
                    'name.unique' => 'Tên màu đã tồn tại',
                    'name.max' => 'Tên màu không được quá 255 ký tự',
                    'image.required' => 'Ảnh sản phẩm không được để trống',
                    'image.mimes' => 'File không đúng định dạng (định dạng yêu cầu là jpg, jpeg, png, bmp)',
                    'image.max' => 'Kích thước file vượt quá 20MB',
                    'category_id.required' => 'Danh mục sản phẩm không được để trống',
                    'brand_id.required' => 'Thương hiệu sản phẩm không được để trống',
                    'type_id.required' => 'Loại sản phẩm không được để trống',
                    'color_ids.required' => 'Màu sản phẩm không được để trống',
                    'description.required' => 'Mô tả sản phẩm không được để trống',
                    'price.required' => 'Giá sản phẩm không được để trống',
                    'warranty.required' => 'Bảo hành sản phẩm không được để trống',
                    'images.required' => 'Ảnh sản phẩm không được để trống',
                    'info_product.required' => 'Thông tin sản phẩm không được để trống',
                    'clip.required' => 'Link clip sản phẩm không được để trống',
                ]
            );

            $product = new Product();

            if ($request->file()) {
                $file_name = time() . '_' . $request->image->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('images/products', $file_name, 'public');

                $product->code = $request->code;
                $product->name = $request->name;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->type_id = $request->type_id;
                $product->description = $request->description;
                $product->image = '/storage/' . $file_path;
                $product->price = $request->price;
                $product->warranty = $request->warranty;
                $product->created_at = date('Y-m-d H:i:s');

                $product->save();

                $colors = Color::find(explode(',', $request->color_ids));
                $product->colors()->attach($colors);

                $images = explode(',', $request->images);

                foreach ($images as $image) {
                    $from = public_path('tmp/uploads/' . $image);
                    $to = storage_path('app/public/images/products/' . $image);

                    File::move($from, $to);
                    $product->images()->create([
                        'name' => $image,
                    ]);
                }
            
                File::cleanDirectory(public_path('/tmp/uploads'));

                $post = new Post();
                $post->product_id = $product->id;
                $post->info_product = $request->info_product;
                $post->path = $request->clip;
                $post->created_at = date('Y-m-d H:i:s');
                $post->save();

                return response()->json([
                    'message' => 'Thêm thành công',
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Bạn không có quyền thêm sản phẩm'
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
        $product = Product::with('brand', 'category', 'type', 'colors', 'images', 'post')->find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        if (auth()->user()->can('edit-product')) {
            if ($request->file()) {
                $request->validate(
                    [
                        'code' => 'required|max:255',
                        'name' => 'required|max:255',
                        'category_id' => 'required',
                        'brand_id' => 'required',
                        'type_id' => 'required',
                        'image' => 'mimes:jpg,jpeg,png,bmp|max:20000',
                        'description' => 'required',
                        'price' => 'required',
                        'warranty' => 'required',
                        'info_product' => 'required',
                        'clip' => 'required',
                    ],
                    [
                        'code.required' => 'Mã sản phẩm không được để trống',
                        'code.max' => 'Mã sản phẩm không được quá 255 ký tự',
                        'name.required' => 'Tên màu không được để trống',
                        'name.max' => 'Tên màu không được quá 255 ký tự',
                        'image.mimes' => 'File không đúng định dạng (định dạng yêu cầu là jpg, jpeg, png, bmp)',
                        'image.max' => 'Kích thước file vượt quá 20MB',
                        'category_id.required' => 'Danh mục sản phẩm không được để trống',
                        'brand_id.required' => 'Thương hiệu sản phẩm không được để trống',
                        'type_id.required' => 'Loại sản phẩm không được để trống',
                        'description.required' => 'Mô tả sản phẩm không được để trống',
                        'price.required' => 'Giá sản phẩm không được để trống',
                        'warranty.required' => 'Bảo hành sản phẩm không được để trống',
                        'info_product.required' => 'Thông tin sản phẩm không được để trống',
                        'clip.required' => 'Clip không được để trống',
                    ]);
            } else {
                $request->validate(
                    [
                        'code' => 'required|max:255',
                        'name' => 'required|max:255',
                        'category_id' => 'required',
                        'brand_id' => 'required',
                        'type_id' => 'required',
                        'description' => 'required',
                        'price' => 'required',
                        'warranty' => 'required',
                        'info_product' => 'required',
                        'clip' => 'required',
                    ],
                    [
                        'code.required' => 'Mã sản phẩm không được để trống',
                        'code.max' => 'Mã sản phẩm không được quá 255 ký tự',
                        'name.required' => 'Tên màu không được để trống',
                        'name.max' => 'Tên màu không được quá 255 ký tự',
                        'category_id.required' => 'Danh mục sản phẩm không được để trống',
                        'brand_id.required' => 'Thương hiệu sản phẩm không được để trống',
                        'type_id.required' => 'Loại sản phẩm không được để trống',
                        'description.required' => 'Mô tả sản phẩm không được để trống',
                        'price.required' => 'Giá sản phẩm không được để trống',
                        'warranty.required' => 'Bảo hành sản phẩm không được để trống',
                        'info_product.required' => 'Thông tin sản phẩm không được để trống',
                        'clip.required' => 'Clip không được để trống',
                    ]);
            }

            $product = Product::find($id);

            if ($request->file()) {
                $file_name = time() . '_' . $request->image->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('images/products', $file_name, 'public');

                $product->code = $request->code;
                $product->name = $request->name;
                $product->price = $request->price;
                $product->warranty = $request->warranty;
                $product->description = $request->description;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->type_id = $request->type_id;
                $product->colors()->sync(explode(',', $request->color_ids));

                if ($product->image) {
                    unlink(storage_path($this->removeChar($product->image)));
                }
                $product->image = '/storage/' . $file_path;
                $product->updated_at = date('Y-m-d H:i:s');

                $product->save();

                $post = $product->post()->first();
                $post->info_product = $request->info_product;
                $post->path = $request->clip;
                $post->updated_at = date('Y-m-d H:i:s');
                $post->save();

                return response()->json([
                    'message' => 'Cập nhật thành công',
                ], 200);
            } else {
                $product->code = $request->code;
                $product->name = $request->name;
                $product->price = $request->price;
                $product->warranty = $request->warranty;
                $product->description = $request->description;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->type_id = $request->type_id;
                $product->colors()->sync(explode(',', $request->color_ids));
                $product->updated_at = date('Y-m-d H:i:s');

                $product->save();

                $post = $product->post()->first();
                $post->info_product = $request->info_product;
                $post->path = $request->clip;
                $post->updated_at = date('Y-m-d H:i:s');
                $post->save();

                return response()->json([
                    'message' => 'Cập nhật thành công',
                ], 200);
            }
        }
        return response()->json([
            'message' => 'Bạn không có quyền cập nhật sản phẩm'
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
        if (auth()->user()->can('delete-product')) {
            $ids = explode(',', $ids);
            foreach ($ids as $id) {
                $product = Product::find($id);
                if ($product->image) {
                    unlink(storage_path($this->removeChar($product->image)));
                }
                $images = $product->images;
                foreach ($images as $image) {
                    unlink(storage_path('app/public/images/products/' . $image->name));
                }
                $product->delete();
            }
            return response()->json([
                'message' => 'Xóa thành công'
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa sản phẩm'
        ], 401);
    }

    public function filterProducts(Request $request) {
        if ($request->category_id) {
            $products = Product::with('category')->where('category_id', $request->category_id)->orderBy('id', 'desc');
            if ($request->brand_id) {
                $products = $products->whereIn('brand_id', explode(',', $request->brand_id));
            }
            if ($request->type_id) {
                $products = $products->whereIn('type_id', explode(',', $request->type_id));
            }
            if ($request->rangeprice) {
                $products = $products->whereBetween('price', explode(',', $request->rangeprice));
            }
            if ($request->warranty) {
                $products = $products->whereIn('warranty', explode(',', $request->warranty));
            }
        }
        return \response()->json($products->get());
    }

    public function searchProducts(Request $request) {
        $products = Product::with('brand', 'category', 'type')
            ->where('name', 'like', '%' . $request->keyword . '%')
            ->orWhere( function($query) use ($request){
                $query->whereHas('category', function($q) use ($request){
                    $q->where('name', 'LIKE', '%' . $request->keyword . '%');
                })->orWhereHas('brand', function($q) use ($request){
                    $q->where('name', 'LIKE', '%' . $request->keyword . '%');
                })->orWhereHas('type', function($q) use ($request){
                    $q->where('name', 'LIKE', '%' . $request->keyword . '%');
                });
            })->orderBy('id', 'desc')->get();
        return \response()->json($products);
    }

    public function removeChar($str) {
        $res = str_ireplace('/storage', 'app/public', $str);
  
        // returning the result 
        return $res;
    }
}
