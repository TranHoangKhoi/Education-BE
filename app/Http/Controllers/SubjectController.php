<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Subject;
use App\Http\Resources\SubjectRecource;
use Exception;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
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
            $data  =  Subject::select(
                'subject.id','name_id_subject','name','subject.id_major','subject.id_semester',
                'subject.id_class','subject.type','subject.created_at','subject.updated_at'
                )
            ->join('majors','subject.id_major','=','majors.id')
             ->leftjoin('semester','subject.id_semester','=','semester.id')
            ->leftjoin('class','subject.id_class','=','class.id')
             ->leftjoin('subject_type','subject.type','=','subject_type.id')

            ->where(function($query) use($input) {
                //Lọc theo tên của Môn học
                    if(!empty($input['name'])){
                        $query->where('name', 'like', '%'.$input['name'].'%');
                     }
                     //Lọc theoe Mã môn học
                     if(!empty($input['nameId'])){
                        $query->where('name_id_subject', 'like', '%'.$input['nameId'].'%');
                     }
                     //Lọc theo tên Chuyên ngành
                     if(!empty($input['nameMajor'])){
                        $query->where('majors.name_major', 'like', '%'.$input['nameMajor'].'%');
                     }
                     //Lọc theo tên Lớp
                     if(!empty($input['nameClass'])){
                        $query->where('class.name_class', 'like', '%'.$input['nameClass'].'%');
                     }
                     //Lọc theo Loại môn học
                     if(!empty($input['subjectType'])){
                        $query->where('subject_type.type_name', 'like', '%'.$input['subjectType'].'%');
                     }
                     //Lọc theo Kì
                     if(!empty($input['nameSemester'])){
                        $query->where('semester.name_id', 'like', '%'.$input['nameSemester'].'%');
                     }

           })->orderBy('subject.created_at', 'desc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
        //    $resource = NotifyResource::collection($data)->response()->getdata(true);
           $resource =  SubjectRecource::collection($data);
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
        // $dataCreate = $request->all();
        $validator = Validator::make($request->all(), [
            'id_semester' => 'required',
            'id_class' => 'required',
            'id_major' => 'required',
            'subject_type' => 'required',
            'name_id_subject' => 'required|unique:subject',
            'name' => 'required|min:6|unique:subject',
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

        $data = Subject::create([
            'id_semester' => $request->id_semester,
            'id_class' => $request->id_class,
            'id_major' => $request->id_major,
            'subject_type' => $request->subject_type,
            'name_id_subject' => strtoupper($request->name_id_subject) ,
            'name' => mb_strtoupper(mb_substr($request->name, 0, 1)).mb_substr($request->name, 1) ,
            'credit' => $request->credit,
        ]

        );

        $subjectResource = new SubjectRecource($data);

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

            // $dataUpdate = $request->all();
            // dd($student);

            $validator = Validator::make($request->all(), [
                'id_semester' => 'required',
                'id_class' => 'required',
                'id_major' => 'required',
                'subject_type' => 'required',
                'name_id_subject' => 'required',
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
            $subject->update(
                [
                    'id_semester' => $request->id_semester,
                    'id_class' => $request->id_class,
                    'id_major' => $request->id_major,
                    'subject_type' => $request->subject_type,
                    'name_id_subject' => strtoupper($request->name_id_subject) ,
                    'name' => mb_strtoupper(mb_substr($request->name, 0, 1)).mb_substr($request->name, 1) ,
                    'credit' => $request->credit,
                ]
            );

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
                'message' => 'Đã xóa Môn học'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => false,
                'message' => 'id not found'
            ]);
        }
    }
    public function loadListSubjectByClass($id) {
        if($id) {
            $data = Subject::with('class')->where('id_class','=', $id)->get();
            // $score->subject();
            return response()->json([
                'data' => $data,
                // 'data' => date('Y-m-d H:i:s'),
                'status' => true,
                'message' => 'Get data Success'
            ]);
        }
    }
}
