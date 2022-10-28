<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
use Symfony\Component\Console\Input\Input;

class CourseController extends Controller
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
            $data = Course::where(function($query) use($input) {
                if(!empty($input['name_id'])){
                    $query->where('name_id', 'like', '%'.$input['name_id'].'%');
                }

            })->orderBy('created_at', 'desc')->paginate(!empty($input['limit']) ? $input['limit'] : 10);
            // $resource = new RoleCollection($data);
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
            'name_id' => 'required|max:255|unique:course',
        ];
        $messages = [
            'name_id.required' => ':atribuite không được để trống !',
            'name_id.max' => ':attribute tối đa 255 ký tự !',
            'name_id.unique'=>':attibuite đã tồn tại!',
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
            // $input = $request->all();
            // if (Course::where('name_id', '=', $input['name_id'])->exists()) {
            //     return response()->json([
            //         'message' =>'Khóa đã tồn tại!',
            //     ]);
            //  }
             $data = Course::create([
                'name_id' =>mb_strtoupper($request->name_id) ,
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
            'data' => $data,
            'status' => 'success',
            'message' =>'Khóa '. $data->name_id . ' đã được tạo thành công !',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $Course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $data = Course::find($id);

            if(empty($data)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kì này không tồn tại, vui lòng kiểm tra lại'

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
     * @param  \App\Models\Course  $Course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name_id' => 'required|max:255|unique:course',
        ];
        $messages = [
            'name_id.required' => ':atribuite không được để trống !',
            'name_id.max' => ':attribute tối đa 255 ký tự !',
            'name_id.unique' => ':attribute đã tồn tại !',

        ];
        try {
            $validator = Validator::make($request->all(), $rules, $messages,);
            if($validator->fails()){
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }
            $data = Course::find($id);
            if(!empty($data)){
                 $data->update([
                    'name_id' => mb_strtoupper($request->name_id),
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
            'data' => $data,
            'status' => 'success',
            'message' =>'Kì đã được cập nhật thành '.$request->name_id.'!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $Course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Course::find($id);
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
