<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// user models
use App\Models\Api\User;

class UserCtrl extends Controller
{
    // Tạo tài khoản mới
    public function CreateNewUser(Request $request)
    {
        // Kiểm tra tài khoản đã tồn tại chưa
        if (User::where('email', '=', $request->email)->exists() || 
            User::where('name', '=', $request->name)->exists()) {
            // Gửi thông báo tài khoản đã tồn tại
            return response()->json([
                'alert' => "existed",
            ]);
        }
        // Nếu chưa tồn tại thì tạo tài khoản mới
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = md5($request->password);
        $user->role = "user";
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();
        // Trả về phản hồi từ server
        return response()->json([
            'alert' => "success",
            'data' => $user,
        ]);
    }

    // Đăng nhập
    public function Login(Request $request){
        // Lấy tài khoản theo tên và mật khẩu, mật khẩu được mã hóa theo md5
        $user = User::where('email', '=', $request->email)->where('password', '=', md5($request->password))->first();
        if ($user === null) {// Không có tài khoản nào
            // Thông báo tài khoản sai
            return response()->json([
                'alert' => "fail",
            ]);
        }
        // Thông báo phản hồi tài khoản đúng    
        return response()->json([
            'alert' => "success",
            'data' => $user,
        ]);
    }

    // Lấy dữ liệu tất cả tài khoản
    public function GetUsers(){
        $users = User::all();
        return response()->json([
            'alert' => 200,
            'data' => $users, 
        ]);
    }

    // Lấy dữ liệu tài khoản
    public function GetUser($id){
        $user = User::find($id);
        return response()->json([
            'alert' => 200,
            'data' => $user, 
        ]);
    }

    // Cập nhật tài khoản
    public function UpdateUser(Request $request){
        $user = User::where('id', $request->id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
        ]);
        $x = User::find($request->id);
        return response()->json([
            'alert' => "success",
            'data' => $x,
        ]);
    }
}
