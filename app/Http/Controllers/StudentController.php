<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Http\Resources\StudentsResource;
use App\Http\Resources\StudentsCollection;


class StudentController extends Controller
{
    protected $students;

    public function __construct(Students $students) {
        $this->students = $students;
    }

    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $listStudents = Students::paginate(10);

        $studentsResource = StudentsResource::collection($listStudents)->response()->getdata(true);

        return response()->json([
            'data' => $studentsResource,
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
            'id_course' => 'required',
            'id_class' => 'required',
            'id_major' => 'required',
            'name_id' => 'required',
            'name' => 'required',
            'email' => 'required|Email|unique:students',
            'password' => 'required|min:6',
            'phone' => 'required|min:10',
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

        $student = Students::create($dataCreate);

        $studentsResource = new StudentsResource($student);

        return response()->json([
            'data' => $studentsResource,
            'success' => true,
            'message' => 'Thêm sinh viên thành công',
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
        
        $student =  Students::find($id);
        if($student) {
            $studentsResource = new StudentsResource($student);
    
            return response()->json([
                'data' => $studentsResource,
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
        $student =  Students::find($id);
        // dd($request->all());
        if($student) {
            // $studentsResource = new Stu dentsResource($student);

            $dataUpdate = $request->all();
            // dd($student);

            $validator = Validator::make($dataUpdate, [
                'id_course' => 'required',
                'id_class' => 'required',
                'id_major' => 'required',
                'name_id' => 'required',
                'name' => 'required',
                'email' => 'required|Email|unique:students,email,'.$id,
                // 'email' => 'required|Email',
                'password' => 'required|min:6',
                'phone' => 'required|min:10',
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
            $student->update($dataUpdate);

            $studentsResource = new StudentsResource($student);

            // return response()->json([
            //     'data' => $studentsResource,
            // ]);
    
            return response()->json([
                'data' => $studentsResource,
                'status' => true,
                'message' => 'Get data Sucess'
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
        $student = Students::find($id);
        if($student) {
            $student->delete();
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
