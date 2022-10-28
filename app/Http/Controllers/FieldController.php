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
    public function index(Request $request)
    {
        $input = $request->all();
        $input['limit'] = $request->limit;
        try{
            $data = Field::where(function($query) use($input) {
                if(!empty($input['field_type'])){
                    $query->where('field_type', 'like', '%'.$input['field_type'].'%');
                }

            })->orderBy('created_at', 'desc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
        }
        catch(Exception $e){
            return response()->json([
                       'status' => 'Error',
                       'message' => $e->getMessage()
                             ],400);
        }
        return response()->json([
                'data' => $data,
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
            'field_type' => 'required|max:255|unique:field',
        ];
        $messages = [
            'field_type.required' => ':atribuite không được để trống !',
            'field_type.max' => ':attribute tối đa 255 ký tự !',
            'field_type.unique' => ':attribute đã tồn tại !',
        ];

        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), $rules, $messages,);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            $data = Field::create([
                'field_type' => mb_strtoupper(mb_substr($request->field_type, 0, 1)).mb_substr($request->field_type, 1) ,


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



        try {
            $validator = Validator::make($request->all(), $rules, $messages,);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = Field::find($id);
            if(!empty($data)){
                 $data->update([
                'field_type' => mb_strtoupper(mb_substr($request->field_type, 0, 1)).mb_substr($request->field_type, 1),
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
            'data'=>$data,
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
    public function destroy($id)
    {
        $data = Field::find($id);
        if($data) {
            $data->delete();
            return response()->json([
                'data' => [],
                'status' => true,
                'message' => 'Đã xóa '
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
