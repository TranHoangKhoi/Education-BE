<?php

namespace App\Http\Controllers;

use App\Models\NotificationCate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotifyCateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = NotificationCate::all();
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
            'name_cate' => 'required|max:255',
        ];
        $messages = [
            'name_cate.required' => ':atribuite không được để trống !',
            'name_cate.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'name_cate' => 'Tên mã không được để trống'
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

            $data = NotificationCate::create([
                'name_cate'=>$request->name_cate
                // 'slug' => Str::slug($request->name_cate)

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
            'message' =>'Danh mục thông báo '. $data->name_cate . ' đã được tạo thành công !',
        ]);


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationCate  $notificationCate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = NotificationCate::find($id);

            if(empty($data)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Danh mục này không tồn tại, vui lòng kiểm tra lại'

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
     * @param  \App\Models\NotificationCate  $notificationCate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name_cate' => 'required|max:255',
        ];
        $messages = [
            'name_cate.required' => ':atribuite không được để trống !',
            'name_cate.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'name_cate' => 'Tên mã không được để trống'
        ];

        try {
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = NotificationCate::find($id);
            if(!empty($data)){
                 $data->update([
                    'name_cate' => $request->name_cate,
                    // 'slug' => Str::slug($request->name_cate),
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
            'message' =>'Danh mục thông báo đã được cập nhật thành !',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationCate  $notificationCate
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationCate $notificationCate)
    {
        //
    }
}
