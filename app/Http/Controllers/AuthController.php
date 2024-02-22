<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],
        [
            'email.required' => 'Tài khoản và mật khẩu không được để trống',
            'password.required' => 'Tài khoản và mật khẩu không được để trống',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $token = Auth::user()->createToken('MyApp')->plainTextToken;
            return response()->json([
                "id" => Auth::user()->id,
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
                "role" => Auth::user()->getRoleNames()[0],
                "check_first_login" => Auth::user()->check_first_login,
                "token" => $token,
            ], 200);
        } 

        return response()->json([
            'errors' => [
                'Tài khoản hoặc mật khẩu không chính xác',
            ],
        ], 401);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ],
        [
            'name.required' => 'Tên không được để trống',
            'name.max' => 'Tên không được quá 255 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không được quá 255 ký tự',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "role" => $user->getRoleNames()[0],
            "token" => $token
        ], 200);
    }

    public function changePasswordFirstLogin(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user->check_first_login == 1) {
            return \response()->json([
                'errors' => [
                    'Tài khoản đã được tạo mật khẩu mới trước đó',
                ],
            ], 403);
        }
        $user->password = bcrypt($request->password);
        $user->check_first_login = 1;
        $user->save();
        return \response()->json([
            "role" => $user->getRoleNames()[0]
        ], 200);
    }

    public function changePassword(Request $request) {
        $user = User::where('email', Auth::user()->email)->first();
        if (password_verify($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return \response()->json([
                "message" => "Đổi mật khẩu thành công"
            ], 200);
        } else {
            return \response()->json([
                'errors' => [
                    'Mật khẩu cũ không chính xác',
                ],
            ], 403);
        }
    }
}
