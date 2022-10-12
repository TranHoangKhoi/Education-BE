<?php

namespace App\Http\Controllers;

use App\Models\SubjectType;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = SubjectType::all();
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
            'type' => 'required|max:255',
        ];
        $messages = [
            'type.required' => ':atribuite không được để trống !',
            'type.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'type' => 'Loại không được để trống'
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

            $data = SubjectType::create([
                'type' => $request->type,
                // 'slug' => Str::slug($request->type)

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
            'message' =>'Loại'. $data->type . ' đã được tạo thành công !',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubjectType  $SubjectType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = SubjectType::find($id);

            if(empty($data)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Loại này không tồn tại, vui lòng kiểm tra lại'

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
     * @param  \App\Models\SubjectType  $SubjectType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'type' => 'required|max:255',
        ];
        $messages = [
            'type.required' => ':atribuite không được để trống !',
            'type.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'type' => 'loại không được để trống'
        ];

        try {
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = SubjectType::find($id);
            if(!empty($data)){
                 $data->update([
                    'type' => $request->type,
                    // 'slug' => Str::slug($request->type),
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
            'message' =>'Loại đã được cập nhật thành '.$request->type.'!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubjectType  $SubjectType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubjectType $SubjectType)
    {
        //
    }
}

