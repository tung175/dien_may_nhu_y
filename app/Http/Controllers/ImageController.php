<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Product;

class ImageController extends Controller
{
  //
  public function store(Request $request)
  {
    $path = public_path('tmp/uploads');

    if (!file_exists($path)) {
      mkdir($path, 0777, true);
    }

    $file = $request->file('image');

    $name = uniqid() . '_' . trim($file->getClientOriginalName());

    $file->move($path, $name);

    return ['name' => $name];
  } 

  public function getImages(Product $product)
  {
    $images = $product->images;
    return ['media' => $images];
  }

  public function uploadImages(Request $request) {
    if ($request->file()) {
      $file_name = uniqid() . '_' . trim($request->images->getClientOriginalName());
      $file_path = $request->file('images')->storeAs('images/products', $file_name, 'public');

      $image = new Image();
      $image->product_id = $request->product_id;
      $image->name = $file_name;
      $image->save();
    }
  }

  public function deleteImages(Request $request) {
    $image = Image::find($request->id);
    unlink(storage_path('app/public/images/products/' . $image->name));
    $image->delete();
  }
}
