<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $checkExistProduct = Cart::where('product_id', $request->product_id)->where('cart_id', $request->cart_id)->first();
        if ($checkExistProduct) {
            $checkExistProduct->quantity = $checkExistProduct->quantity + 1;
            $checkExistProduct->save();
            return response()->json([
                'message' => 'Thêm sản phẩm thành công',
            ], 200);
        } else {
            $cart = new Cart();
            $cart->product_id = $request->product_id;
            $cart->cart_id = $request->cart_id;
            $cart->created_at = date('Y-m-d H:i:s');
            $cart->save();
            return response()->json([
                'message' => 'Thêm sản phẩm thành công',
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $cart = Cart::find($id);
        if ($request->quantity == '-1') {
            $cart->quantity = $cart->quantity > 1 ? $cart->quantity - 1 : 1;
        } else if ($request->quantity == '+1') {
            $cart->quantity = $cart->quantity < 5 ? $cart->quantity + 1 : $cart->quantity;
        }
        $cart->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
    }

    public function getCart(Request $request)
    {
        $cart = Cart::with('product')->where('cart_id', $request->cart_id)->orderBy('id', 'desc')->get();
        return response()->json($cart);
    }

}
