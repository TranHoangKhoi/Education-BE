<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listAdmin = Admin::paginate(10);
        // $listStudents->class;
        // // $listStudents->user;
        // $listStudents->majors;
        // $listStudents->course;

        $adminsResource = AdminResource::collection($listAdmin)->response()->getdata(true);

        return response()->json([
            'data' => $adminsResource,
            'success' => true,
            'message' => 'Lấy dữ liệu thành công',
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataCreate = $request->all();
        $validator = Validator::make($dataCreate, [
            'id_user' => 'required|unique:admin',
            'name' => 'required',
            'name_id' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if($validator->fails()){
            $arr = [
              'success' => false,
              'message' => 'Lỗi kiểm tra dữ liệu',
              'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
         }

        $admin = Admin::create($dataCreate);

        $adminResource = new AdminResource($admin);

        return response()->json([
            'data' => $adminResource,
            'success' => true,
            'message' => 'Thêm admin thành công',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin =  Admin::where('id_user', $id)->first();
        if($admin) {
            $adminResource = new AdminResource($admin);
    
            return response()->json([
                'data' => $adminResource,
                'status' => true,
                'message' => 'Get data success'
            ]); 
        } else {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'id not found'
            ]); 
        }
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
        $admin =  Admin::where('id_user', $id)->first();
        // dd($request->all());
        if($admin) {
            // $studentsResource = new Stu dentsResource($student);

            $dataUpdate = $request->all();
            // dd($admin->id);

            $validator = Validator::make($dataUpdate, [
                'id_user' => 'required|unique:admin,id_user,'.$admin->id,
                // 'email' => 'required|Email|unique:students,email,'.$id,

                'name' => 'required',
                'name_id' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);

            if($validator->fails()){
                $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
                ];
                return response()->json($arr, 200);
            }

            $admin->update($dataUpdate);

            $adminResource = new AdminResource($admin);
    
            return response()->json([
                'data' => $adminResource,
                'status' => true,
                'message' => 'Update data cucess'
            ]); 
        } else {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'id not found'
            ]); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        {
            $admin =  Admin::where('id_user', $id)->first();
            if($admin) {
                $admin->delete();
                return response()->json([
                    'data' => [],
                    'status' => true,
                    'message' => 'Đã xóa sinh viên'
                ], 200); 
            } else {
                return response()->json([
                    'data' => [],
                    'status' => false,
                    'message' => 'id not found'
                ]); 
            }
        }
    }
}
