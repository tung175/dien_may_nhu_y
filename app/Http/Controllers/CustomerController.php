<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use Twilio\Rest\Client;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return response()->json($customers);
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
        $customer = Customer::where('phone', $request->phone)->first();

        if ($customer && !$request->otp) {
            $password = $this->generateRandomString(4);
            $receiverNumber = $request->phone;
            $receiverNumber = substr_replace($receiverNumber, '+84', 0, 1);
            $message = "Ma xac nhan dung de dang nhap lich su mua hang tai DienMayNhuY la " . $password;
            $customer->password = $password;
            $customer->save();
            try {
    
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_TOKEN");
                $twilio_number = getenv("TWILIO_FROM");
    
                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $message]);
    
                return response()->json([('SMS Sent Successfully.')]);
    
            } catch (Exception $e) {
                return response()->json(["Error: ". $e->getMessage()]);
            }
        } else if (!$customer && !$request->otp) {
            return response()->json(['Error: Khong ton tai khach hang'], 404);
        }

        if ($request->otp) {
            $customer = Customer::where('phone', $request->phone)->where('password', $request->otp)->first();
            if ($customer) {
                return response()->json(['success' => 'Đăng nhập thành công']);
            } else {
                return response()->json(['error' => 'Sai mã xác nhận'], 404);
            }
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
        //
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
