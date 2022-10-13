<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Subject;
use App\Http\Resources\SubjectRecource;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listSubject = Subject::paginate(10);

        $subjectResource = SubjectRecource::collection($listSubject)->response()->getdata(true);

        return response()->json([
            'data' => $subjectResource,
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
            'id_semester' => 'required',
            'id_class' => 'required',
            'id_major' => 'required',
            'subject_type' => 'required',
            'name_id' => 'required',
            'name' => 'required|min:6',
            'credit' => 'required',
        ]);

        if($validator->fails()){
            $arr = [
              'success' => false,
              'message' => 'Lỗi kiểm tra dữ liệu',
              'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
         }

        $subject = Subject::create($dataCreate);

        $subjectResource = new SubjectRecource($subject);

        return response()->json([
            'data' => $subjectResource,
            'success' => true,
            'message' => 'Thêm môn học thành công',
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
        $subject =  Subject::find($id);
        if($subject) {
            $subjectResource = new SubjectRecource($subject);
    
            return response()->json([
                'data' => $subjectResource,
                'status' => true,
                'message' => 'Get data success'
            ]); 
        } else {
            return response()->json([
                'data' => [],
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
        $subject =  Subject::find($id);
        // dd($request->all());
        if($subject) {
            // $studentsResource = new Stu dentsResource($student);

            $dataUpdate = $request->all();
            // dd($student);

            $validator = Validator::make($dataUpdate, [
                'id_semester' => 'required',
                'id_class' => 'required',
                'id_major' => 'required',
                'subject_type' => 'required',
                'name_id' => 'required',
                'name' => 'required|min:6',
                'credit' => 'required',
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
            $subject->update($dataUpdate);

            $subjectResource = new SubjectRecource($subject);

            // return response()->json([
            //     'data' => $subjectResource,
            // ]);
    
            return response()->json([
                'data' => $subjectResource,
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
        $subject = Subject::find($id);
        if($subject) {
            $subject->delete();
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
