<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Http\Resources\AdminResource;
use Exception;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $input['limit'] = $request->limit;
       try {
            $data  =  Admin::select(
                'admin.id','admin.name','admin.name_id','admin.id_user','admin.phone','admin.address'
                )
            ->join('users','admin.id_user','=','users.id')
            ->where(function($query) use($input) {
                //Lọc theo  Email
                    if(!empty($input['email'])){
                            $query->where('users.email', 'like', '%'.$input['email'].'%');
                      }
                            //lọc theo tên
                     if(!empty($input['name'])){
                        $query->where('name', 'like', '%'.$input['name'].'%');
                     }
                     //lọc theo mã số sinh viên
                     if(!empty($input['nameID'])){
                        $query->where('name_id', 'like', '%'.$input['nameID'].'%');
                     }
                     //loc theo sdt
                     if(!empty($input['phone'])){
                        $query->where('phone', $input['phone']);
                     }
                     //loc theo dia chi
                     if(!empty($input['address'])){
                        $query->where('address','%' .$input['address'].'%');
                     }

           })->orderBy('admin.id', 'desc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
        //    $resource = NotifyResource::collection($data)->response()->getdata(true);
           $resource =  AdminResource::collection($data);
       } catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => $e->getMessage()
         ],400);
       }
       return response()->json([
                'data' => $resource,
                'success' => true,
                'message' => 'Lấy dữ liệu thành công!',
        ],200);

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_user' => 'required|unique:admin',
            'name' => 'required',
            'name_id' => 'required|unique:admin',
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

        $admin = Admin::create(
            [
                'id_user' => $request->id_user,
                'name_id' => mb_strtoupper( $request->name_id),
                'name' => mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8") ,
                'phone'=>$request->phone,
                'address'=>  mb_convert_case($request->address, MB_CASE_TITLE, "UTF-8") ,
                'role' =>$request->role,
            ]
        );

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

            $admin->update();

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
