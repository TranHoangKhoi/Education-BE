<?php

namespace App\Http\Controllers;

use App\Models\Notify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try {
           $data = Notify::all();
            return response()->json([
                'data'=> $data
            ],200);
       } catch (Exception $e) {
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
            'title' => 'required|max:255',
        ];
        $messages = [
            'title.required' => ':atribuite không được để trống !',
            'title.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'title' => 'Tên mã không được để trống'
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

            $data = Notify::create([
                'title'=>$request->title,
                'id_cate' => $request -> id_cate,
                'content' => $request -> content,
                // 'slug' => Str::slug($request->title)

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
            'message' =>'Thông báo '. $data->title . ' đã được tạo thành công !',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function show(Notify $notify)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:255',
            'content' => 'required',
            'id_cate' => 'required',
        ];
        $messages = [
            'title.required' => ':atribuite không được để trống !',
            'title.max' => ':attribute tối đa 255 ký tự !',
        ];

        $attributes = [
            'title' => 'Tiêu đề không được để trống'
        ];

        try {
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = Notify::find($id);
            if(!empty($data)){
                 $data->update([
                    'title' => $request->title,
                    // 'slug' => Str::slug($request->title),
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
     * @param  \App\Models\Notify  $notify
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Notify::find($id);
        if($subject) {
            $subject->delete();
            return response()->json([
                'data' => [],
                'status' => true,
                'message' => 'Đã xóa thông báo này'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => false,
                'message' => 'Thông báo không tồn tại'
            ]);
        }
    }
}
