<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Lecturers;
use App\Http\Resources\LecturersResource;

class LecturersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listLecturers = Lecturers::paginate(1);

        $lecturersResource = LecturersResource::collection($listLecturers)->response()->getdata(true);

        return response()->json([
            'data' => $lecturersResource,
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

        $lecturers = Lecturers::create($dataCreate);

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
            $dataUpdate = $request->all();
            // dd($student);

            $validator = Validator::make($dataUpdate, [
                'name_id' => 'required',
                'name' => 'required',
                // 'email' => 'required|Email|unique:lecturers,email,'.$id,
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
            $lecturers->update($dataUpdate);

            $lecturersResource = new LecturersResource($lecturers);

            // return response()->json([
            //     'data' => $studentsResource,
            // ]);
    
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
