<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationController extends Controller
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
            $data = Information::where(function($query) use($input) {
                if(!empty($input['email'])){
                    $query->where('email', 'like', '%'.$input['email'].'%');
                }
                if(!empty($input['phone'])){
                    $query->where('phone', 'like', '%'.$input['phone'].'%');
                }
                if(!empty($input['address'])){
                    $query->where('address', 'like', '%'.$input['address'].'%');
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
            'phone' => 'required|max:255|unique:information',
            'address' => 'required|max:255|unique:information',
            'email' => 'required|max:255|unique:information'
        ];
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), $rules, );
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            $data = Information::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,

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
            'message' =>'Thông tin đã được tạo thành công !',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $Information
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Information::find($id);

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
     * @param  \App\Models\Information  $Information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'email' => 'required|max:255'
        ];



        try {
            $validator = Validator::make($request->all(), $rules,);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = Information::find($id);
            if(!empty($data)){
                 $data->update([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
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
     * @param  \App\Models\Information  $Information
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Information::find($id);
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
