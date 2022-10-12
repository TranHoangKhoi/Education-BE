<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        try{
            $data = ClassModel::all();
            return response()->json([
                'data' => $data
            ],200);
        } catch(Exception $e){
            return response()->json([
               'status' => 'Error',
               'message' => $e->getMessage()
            ],400);
        }
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
            'name_id' => 'required|max:255',
        ];
        $messages = [
            'name_id.required' => ':atribuite không được để trống !',
            'name_id.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'name_id' => 'Tên mã không được để trống'
        ];

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            $data = ClassModel::create([
                'id_course'=>$request->id_course,
                'id_major'=>$request->id_major,
                'name_id' => $request->name_id
                // 'slug' => Str::slug($request->name_id)

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
            'status' => 'success',
            'message' =>'Lớp '. $data->name_id . ' đã được tạo thành công !',
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
            'name_id' => 'required|max:255',
        ];
        $messages = [
            'name_id.required' => ':atribuite không được để trống !',
            'name_id.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'name_id' => 'Tên mã không được để trống'
        ];

        try {
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = ClassModel::find($id);
            if(!empty($data)){
                 $data->update([
                    'id_course'=>$request->id_course,
                    'id_major'=>$request->id_major,
                    'name_id' => $request->name_id,
                    // 'slug' => Str::slug($request->name_id),
                    // 'updated_by' => auth('sanctum')->user()->id,
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
    public function destroy(ClassModel $classModel)
    {
        //
    }
}
