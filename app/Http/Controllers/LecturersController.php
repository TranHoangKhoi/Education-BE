<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Lecturers;
use App\Http\Resources\LecturersResource;
use Exception;

class LecturersController extends Controller
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
            $data  =  Lecturers::select(
                'lecturers.id','lecturers.name_id','lecturers.id_user','lecturers.phone','lecturers.address','lecturers.gender','lecturers.name'
            )
                 ->join('users','lecturers.id_user','=','users.id')
             ->where(function($query) use($input) {
                //Lọc theo  Email sinh viên
                    if(!empty($input['email'])){
                        $query->where('users.email', 'like', '%'.$input['email'].'%');
                     }
                     //lọc theo tên sinh viên
                     if(!empty($input['name'])){
                        $query->where('name', 'like', '%'.$input['name'].'%');
                     }
                     //lọc theo mã số sinh viên
                     if(!empty($input['nameID'])){
                        $query->where('name_id', 'like', '%'.$input['nameID'].'%');
                     }
                     //Lọc theo giới tính
                     if(!empty($input['gender'])){
                        $query->where('gender', $input['gender']);
                     }
                     //loc theo sdt
                     if(!empty($input['phone'])){
                        $query->where('phone', $input['phone']);
                     }

           })->orderBy('lecturers.id', 'asc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
        //    $resource = NotifyResource::collection($data)->response()->getdata(true);
           $resource =  LecturersResource::collection($data);
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
            'id_user' => 'required',
            'name_id' => 'required|unique:lecturers',
            'name' => 'required',
            // 'email' => 'required|Email|unique:lecturers',
            // 'password' => 'required|min:6',
            'phone' => 'required|min:10',
            'address' => 'required',
            'gender' => 'required',
        ]);

        if($validator->fails()){
            $arr = [
              'success' => false,
              'message' => 'Lỗi kiểm tra dữ liệu',
              'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
         }

        $lecturers = Lecturers::create(
            [
                'id_user' => $request->id_user,
                'name_id' => mb_strtoupper( $request->name_id),
                'name' => mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8") ,
                'phone'=>$request->phone,
                'address'=>  mb_convert_case($request->address, MB_CASE_TITLE, "UTF-8") ,
                'gender'=>$request->gender,
            ]
        );

        $lecturersResource = new LecturersResource($lecturers);

        return response()->json([
            'data' => $lecturersResource,
            'success' => true,
            'message' => 'Thêm giảng viên thành công',
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
        $lecturers =  Lecturers::find($id);
        if($lecturers) {
            $lecturersResource = new LecturersResource($lecturers);

            return response()->json([
                'data' => $lecturersResource,
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
        $lecturers =  Lecturers::find($id);
        // dd($request->all());
        if($lecturers) {
            // dd($student);
                $validator = Validator::make($request->all(), [
                    'id_user' => 'required',
                    'name_id' => 'required',
                    'name' => 'required',
                    // 'email' => 'required|Email|unique:lecturers',
                    // 'password' => 'required|min:6',
                    'phone' => 'required|min:10',
                    'address' => 'required',
                    'gender' => 'required',
                ]);
            if($validator->fails()){
                $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
                ];
                return response()->json($arr, 200);
            }

            // $student = Students::save($dataUpdate);
            $lecturers->update(
                [
                    'id_user' => $request->id_user,
                    'name_id' => mb_strtoupper( $request->name_id),
                    'name' => mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8") ,
                    'phone'=>$request->phone,
                    'address'=>  mb_convert_case($request->address, MB_CASE_TITLE, "UTF-8") ,
                    'gender'=>$request->gender,
                ]

            );
            $lecturersResource = new LecturersResource($lecturers);

            return response()->json([
                'data' => $lecturersResource,
                'status' => true,
                'message' => 'Update data Sucess'
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
        $lecturers = Lecturers::find($id);
        if($lecturers) {
            $lecturers->delete();
            return response()->json([
                'data' => [],
                'status' => true,
                'message' => 'Đã xóa giảng viên'
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
