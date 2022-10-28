<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scores;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ScoresResource;

class ScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listScores = Scores::paginate(10);

        $scoreResource = ScoresResource::collection($listScores)->response()->getdata(true);

        return response()->json([
            'data' => $scoreResource,
            'success' => true,
            'message' => 'Lấy dữ liệu thành công',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataCreate = $request->all();
        $validator = Validator::make($dataCreate, [
            'id_subject' => 'required',
            'id_student' => 'required|unique:scores,id_student,'.$dataCreate['id_student'],
        ]);

        if($validator->fails()){
            $arr = [
              'success' => false,
              'message' => 'Lỗi kiểm tra dữ liệu',
              'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
         }

        $score = Scores::create($dataCreate);

        $scoresResource = new ScoresResource($score);

        return response()->json([
            'data' => $scoresResource,
            'success' => true,
            'message' => 'Thêm dữ liệu thành công',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $score =  Scores::find($id);
        if($score) {
            $scoreResource = new ScoresResource($score);
            return response()->json([
                'data' => $scoreResource,
                'status' => true,
                'message' => 'Get data success'
            ]);
        } else {
            return response()->json([
                'data' => [],
                'status' => false,
                'message' => 'id not found'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $score =  Scores::find($id);
        // dd($request->all());
        if($score) {
            // $studentsResource = new Stu dentsResource($student);

            $dataUpdate = $request->all();
            // dd($student);

            $validator = Validator::make($dataUpdate, [
                'id_subject' => 'required',
                'id_student' => 'required|unique:scores,id_student,'.$id,
            ]);

            if($validator->fails()){
                $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
                ];
                return response()->json($arr, 200);
            }

            // $student = Students::save($dataUpdate);
            $score->update($dataUpdate);

            $scoreResource = new ScoresResource($score);

            // return response()->json([
            //     'data' => $studentsResource,
            // ]);

            return response()->json([
                'data' => $scoreResource,
                'status' => true,
                'message' => 'Get data Success'
            ]);
        } else {
            return response()->json([
                'data' => '',
                'status' => false,
                'message' => 'id not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $score = Scores::find($id);
        if($score) {
            $score->delete();
            return response()->json([
                'data' => [],
                'status' => true,
                'message' => 'Đã xóa dữ liệu'
            ], 200);
        } else {
            return response()->json([
                'data' => [],
                'status' => false,
                'message' => 'id not found'
            ], 404);
        }
    }
    public function loadListScoreByIdStudent($id) {
        if($id) {
            $score = Scores::with('subject')->with('detailsScore')->where('id_student', $id)->get();
            // $score->subject();
            return response()->json([
                'data' => $score,
                // 'data' => date('Y-m-d H:i:s'),
                'status' => true,
                'message' => 'Get data Success'
            ]);
        }
    }
}
