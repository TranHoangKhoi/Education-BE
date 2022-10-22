<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DetailScoresResource;

use Illuminate\Http\Request;
use App\Models\DetailScores;

class DetailScoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listDetailsScore = DetailScores::paginate(10);

        $detailsResource = DetailScoresResource::collection($listDetailsScore)->response()->getdata(true);

        return response()->json([
            'data' => $detailsResource,
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
            'id_score' => 'required',
            'title' => 'required',
            'score' => 'required',
            'percent' => 'required',
        ]);

        if($validator->fails()){
            $arr = [
              'success' => false,
              'message' => 'Lỗi kiểm tra dữ liệu',
              'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
         }

        $detailsScore = DetailScores::create($dataCreate);

        $detailsScoreResource = new DetailScoresResource($detailsScore);

        return response()->json([
            'data' => $detailsScoreResource,
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
        $listDetailsScore = DetailScores::where('id_score', $id)->paginate(10);
        $detailsScoreResource = DetailScoresResource::collection($listDetailsScore)->response()->getdata(true);

        if(!empty($detailsScoreResource['data'])) {
            return response()->json([
                'data' => $detailsScoreResource,
                'success' => true,
                'message' => 'Tìm dữ liệu thành công',
            ]);
        } else {
            return response()->json([
                'data' => [],
                'success' => false,
                'message' => 'Id not found',
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
        $detailsScore =  DetailScores::find($id);
        // dd($request->all());
        if($detailsScore) {
            $dataUpdate = $request->all();

            $validator = Validator::make($dataUpdate, [
                'id_score' => 'required',
                'title' => 'required',
                'score' => 'required',
                'percent' => 'required',
            ]);

            if($validator->fails()){
                $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
                ];
                return response()->json($arr, 200);
            }

            $detailsScore->update($dataUpdate);

            $detailsScoreResource = new DetailScoresResource($detailsScore);
    
            return response()->json([
                'data' => $detailsScoreResource,
                'status' => true,
                'message' => 'Get data Sucess'
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
        $detailsScore = DetailScores::find($id);
        if($detailsScore) {
            $caseScoreResource = new DetailScoresResource($detailsScore);
            $detailsScore->delete();
            return response()->json([
                'data' => $caseScoreResource,
                'status' => true,
                'message' => 'Đã xóa dữ liệu'
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
