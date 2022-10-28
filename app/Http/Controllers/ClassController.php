<?php


namespace App\Http\Controllers;

use App\Http\Resources\ClassResource;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
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
            // $data  =  ClassModel::select()->join('majors','class.id_major','=','majors.id')
            //  ->leftjoin('course','class.id_course','=','course.id')
             $data = ClassModel::select(
                'class.id','class.id_major','class.id_course','class.created_at','class.updated_at'
                )
             ->join('majors','class.id_major','=','majors.id')
             ->join('course','class.id_course','=','course.id')
            ->where(function($query) use($input) {
                //lọc theo tên lớp
                    if(!empty($input['nameClass'])){
                        $query->where('name_class', 'like', '%'.$input['nameClass'].'%');
                     }
                     //lọc theo tên chuyên ngành
                     if(!empty($input['nameMajor'])){
                        $query->where('majors.name_major', 'like', '%'.$input['nameMajor'].'%');
                     }
                     //lọc theo Mã chuyên ngành
                     if(!empty($input['nameIdMajor'])){
                        $query->where('majors.name_id', 'like', '%'.$input['nameIdMajor'].'%');
                     }
                     //lọc theo Khóa
                     if(!empty($input['nameCourse'])){
                        $query->where('course.name_id', 'like', '%'.$input['nameCourse'].'%');
                     }

           })->orderBy('class.created_at', 'desc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
        //    $resource = NotifyResource::collection($data)->response()->getdata(true);
           $resource =  ClassResource::collection($data);
       } catch (Exception $e) {
            return response()->json([
                'status' => 'Error',
            'message' => $e->getMessage()
         ],400);
       }
       return response()->json([
                'data' => $resource,
                'success' => true,
                'message' => 'Lấy dữ liệu thành công',
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
        $rules = [
            'id_course'=>'required',
            'id_major'=>'required',
            'name_class' => 'required|max:255|unique:class',
        ];
        $messages = [
            'name_class.required' => ':atribuite không được để trống !',
            'name_class.max' => ':attribute tối đa 255 ký tự !',
            'name_class.unique' => ':attribute  a đã tồn tại !',
            'id_course'=>'atribuite không được để trống !',
            'id_major'=>'atribuite không được để trống !',
        ];

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), $rules,$messages);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            $data = ClassModel::create([
                'id_course'=>$request->id_course,
                'id_major'=>$request->id_major,
                'name_class' => mb_strtoupper($request->name_class),

            ]);
            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);

        }
        return response()->json([
            'data'=>$data,
            'status' => 'success',
            'message' =>'Lớp '. $data->name_class . ' đã được tạo thành công !',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = ClassModel::find($id);

            if(empty($data)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lớp này không tồn tại, vui lòng kiểm tra lại'

                ],400);
            }
            return response()->json([
                'data' => $data
            ],200);

        } catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'id_course'=>'required',
            'id_major'=>'required',
            'name_class' => 'required|max:255',
        ];
        $messages = [
            'name_class.required' => ':atribuite không được để trống !',
            'name_class.max' => ':attribute tối đa 255 ký tự !',
            'name_class.unique' => ':attribute đã tồn tại !',
            'id_course'=>'atribuite không được để trống !',
            'id_major'=>'atribuite không được để trống !',
        ];
        try {
            $validator = Validator::make($request->all(), $rules,$messages);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = ClassModel::find($id);
            if(!empty($data)){
                $data = ClassModel::create([
                    'id_course'=>$request->id_course,
                    'id_major'=>$request->id_major,
                    'name_class' => mb_strtoupper($request->name_class),
                ]);
            }



        } catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);

        }
        return response()->json([
            'status' => 'success',
            'message' =>'Lớp học đã được cập nhật thành !',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassModel  $classModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ClassModel::find($id);
        if($data) {
            $data->delete();
            return response()->json([
                'data' => [],
                'status' => true,
                'message' => 'Đã xóa Lớp này'
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
