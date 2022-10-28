<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
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
    public function index(Request $request)
    {
        $input = $request->all();
        $input['limit'] = $request->limit;
        try{
            $data = NotificationCate::where(function($query) use($input) {
                if(!empty($input['nameCate'])){
                    $query->where('name_cate', 'like', '%'.$input['nameCate'].'%');
                }
            })->orderBy('created_at', 'desc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
            $resource= NotificationResource::collection($data);
        }
        catch(Exception $e){
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
            'name_cate' => 'required|max:255|unique:notification_categories',
        ];
        $messages = [
            'name_cate.required' => ':atribuite không được để trống !',
            'name_cate.max' => ':attribute tối đa 255 ký tự !',
            'name_cate.unique'=>':attribute đã tồn tại'
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

            $data = NotificationCate::create([
                'name_cate' => mb_strtoupper(mb_substr($request->name_cate, 0, 1)).mb_substr($request->name_cate, 1) ,


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
            'data'=> new NotificationResource($data) ,
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
            'name_cate' => 'required|max:255|unique:notification_categories',
        ];
        $messages = [
            'name_cate.required' => ':atribuite không được để trống !',
            'name_cate.max' => ':attribute tối đa 255 ký tự !',
            'name_cate.unique'=>':attribute đã tồn tại'
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
                'name_cate' => mb_strtoupper(mb_substr($request->name_cate, 0, 1)).mb_substr($request->name_cate, 1) ,

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
            'data' => new NotificationResource($data),
            'status' => 'success',
            'message' =>'Danh mục thông báo đã được cập nhật !',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationCate  $notificationCate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = NotificationCate::find($id);
        if($subject) {
            $subject->delete();
            return response()->json([
                'data' => [],
                'status' => true,
                'message' => 'Đã xóa danh mục này'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => false,
                'message' => 'Danh mục thông báo không tồn tại'
            ]);
        }
    }


    public function search($name) {
         $search = NotificationCate::all();
        //$data = $request->get('name_cate','id');

        $search = NotificationCate::where("name_cate", "like", "%".$name."%")
                         ->get();
        return response()->json([
            'data' => $search,
        ]);

    }

}
