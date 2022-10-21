<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Students;
use App\Models\Lecturers;
use App\Models\Admin;

use App\Http\Resources\StudentsResource;
use App\Http\Resources\LecturersResource;
use App\Http\Resources\AdminResource;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password, [])) {
            $arr = [
                'success' => false,
                'message' => 'Email hoặc mật khẩu không đúng',
                'data' => []
              ];
              return response()->json($arr, 404);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'type_token' => 'Bearer'
        ], 200);
    }

    public function register(Request $request) {
        $messages = [
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min' => 'Mật khẩu phải nhiều hơn :min ký tự',
        ];

        $dataCreate = $request->all();
        $validator = Validator::make($dataCreate, [
            'email' => 'required|Email|unique:users',
            'password' => 'required|min:6',
        ], $messages);

        if($validator->fails()){
            $arr = [
              'success' => false,
              'message' => 'Lỗi kiểm tra dữ liệu',
              'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
         }
        
        $userRegister = User::create([
            'email' => $dataCreate['email'],
            'password' => Hash::make($dataCreate['password']),
            'role' => $dataCreate['role'],
        ]);

        return response()->json([
            'data' => $userRegister,
        ], 200);
    }

    public function user(Request $request) {
        $role = $request->user()->role;
        if($role == 0) {
            $userDetails = Students::where('id_user', $request->user()->id)->first();
            // $userDetails = Students::with('majors')->where('id', $request->user()->id)->first();
            
            // $className = ClassModel::find($userDetails->id_class);
            // $userDetails->class;
            // $userDetails->user;
            // $userDetails->majors;
            // $userDetails->course;
            $userDetailsRs = new StudentsResource($userDetails);

            return response()->json([
                'data' => $userDetailsRs,
            ], 200);
        } else if($role == 1) {
            $userDetails = Lecturers::with('user')->where('id_user',  $request->user()->id)->first();
            
            $userDetailsRs = new LecturersResource($userDetails);
            return response()->json([
                'data' => $userDetailsRs,
            ], 200);
        } else if($role == 2) {
            $userDetails = Admin::with('user')->where('id_user',  $request->user()->id)->first();
            $userDetailsRs = new AdminResource($userDetails);

            return response()->json([
                'data' => $userDetailsRs,
            ], 200);
        };

        return response()->json([
            'data' => $request->user()->role,
        ], 200);
    }

    public function logOut() {
        // Revoke all tokens...
        // auth()->user()->tokens()->delete();
        
        // // Revoke the token that was used to authenticate the current request...
        auth()->user()->currentAccessToken()->delete();
        
        // // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            'data' => [],
            'status' => true,
            'message' => 'Đăng xuất thành công'
        ], 200);
    }
}
