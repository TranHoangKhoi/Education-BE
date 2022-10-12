<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Field::all();
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
            'field_type' => 'required|max:255',
        ];
        $messages = [
            'field_type.required' => ':atribuite không được để trống !',
            'field_type.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'field_type' => 'Tên mã không được để trống'
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

            $data = Field::create([
                'field_type' => $request->field_type,
                // 'slug' => Str::slug($request->field_type)

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
            'message' =>'Lĩnh vực '. $data->field_type . ' đã được tạo thành công !',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $Field
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Field::find($id);

            if(empty($data)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lĩnh vực này không tồn tại, vui lòng kiểm tra lại'

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
     * @param  \App\Models\Field  $Field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'field_type' => 'required|max:255',
        ];
        $messages = [
            'field_type.required' => ':atribuite không được để trống !',
            'field_type.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'field_type' => 'Tên mã không được để trống'
        ];

        try {
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = Field::find($id);
            if(!empty($data)){
                 $data->update([
                    'field_type' => $request->field_type,
                    // 'slug' => Str::slug($request->field_type),
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
            'message' =>'Lĩnh vực đã được cập nhật thành !',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $Field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $Field)
    {

    }
}
