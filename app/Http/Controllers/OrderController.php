<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\Cart;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\Ward;
use DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('customer', 'orderDetails')->orderBy('id', 'desc')->get();
        $i = 1;
        foreach ($orders as $order) {
            $order['stt'] = $i;
            $i++;
        }
        return \response()->json($orders);
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
        $checkExistCustomer = Customer::where('phone', $request->form['phone'])->first();
        if ($checkExistCustomer) {
            $customer_id = $checkExistCustomer->id;
        } else {
            $customer = new Customer();
            $customer->name = $request->form['name'];
            $customer->gender = $request->form['gender'];
            $customer->phone = $request->form['phone'];
            $customer->password = $this->generateRandomString(4);
            $customer->created_at = date('Y-m-d H:i:s');
            $customer->save();
            $customer_id = $customer->id;
        }

        $order = new Order();
        $order->customer_id = $customer_id;
        if ($request->form['wayReceive'] == 'Giao tận nơi') {
            $province_name = Province::select('name')->where('id', $request->province_id)->first();
            $district_name = District::select('name')->where('id', $request->district_id)->first();
            $ward_name = Ward::select('name')->where('id', $request->ward_id)->first();
            $order->address = $request->form['address'] . ', ' . $ward_name['name'] . ', ' . $district_name['name'] . ', ' . $province_name['name'];
        } else {
            $order->address = 'Nhận tại siêu thị';
        }
        if ($request->form['otherPeopleReceive'] == true) {
            $order->otherpeople_name = $request->form['otherPeopleName'];
            $order->otherpeople_phone = $request->form['otherPeoplePhone'];
            $order->otherpeople_gender = $request->form['otherPeopleGender'];
        }
        $order->way_receive = $request->form['wayReceive'];
        $order->payment = $request->form['payment'];
        $order->note = $request->form['note'];
        $order->created_at = date('Y-m-d H:i:s');
        $order->save();
        
        foreach ($request->carts as $item) {
            $orderdetails = new OrderDetails();
            $orderdetails->order_id = $order->id;
            $orderdetails->product_id = $item['product_id'];
            $orderdetails->quantity = $item['quantity'];
            $orderdetails->save();
            Cart::where('id', $item['id'])->delete();
        }

        return response()->json([
            'message' => 'Đặt hàng thành công',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($year)
    {
        $order = DB::select('select month(o.created_at) as month, year(o.created_at) as year, sum(p.price*od.quantity) as total
        from orders o JOIN order_details od ON od.order_id = o.id
        join products p on p.id = od.product_id 
        WHERE year(o.created_at) = '.$year.'  
        AND o.status = 2
        GROUP by month(o.created_at), YEAR(o.created_at)');
        return \response()->json($order);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('delete-order')) {
            $ids = explode(',', $ids);
            $order = Order::whereIn('id', $ids)->delete();
            return response()->json([
                'message' => 'Xóa thành công',
            ], 200);
        }
        return response()->json([
            'message' => 'Bạn không có quyền xóa',
        ], 401);
    }

    public function handleOrder(Request $request)
    {
        $orders = Order::whereIn('id', $request->ids)->get();
        foreach ($orders as $order) {
            $order->status = $request->status;
            $order->save();
        } 
        return response()->json([
            'message' => 'Cập nhật thành công',
        ], 200);
    }

    function generateRandomString($length) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
