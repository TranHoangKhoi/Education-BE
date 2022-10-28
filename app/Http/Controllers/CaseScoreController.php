<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Resources\CaseScoreResource;
use App\Models\CaseScore;

class CaseScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCase = CaseScore::paginate(10);

        $caseResource = CaseScoreResource::collection($listCase)->response()->getdata(true);

        return response()->json([
            'data' => $caseResource,
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
            'title' => 'required',
            // 'name_field' => 'required',
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

        $caseScore = CaseScore::create($dataCreate);

        $caseScoreResource = new CaseScoreResource($caseScore);

        return response()->json([
            'data' => $caseScoreResource,
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
        $listCase = CaseScore::where('id_subject', $id)->paginate(10);
        $caseResource = CaseScoreResource::collection($listCase)->response()->getdata(true);

        if(!empty($caseResource['data'])) {
            return response()->json([
                'data' => $caseResource,
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
        $caseScore =  CaseScore::find($id);
        // dd($request->all());
        if($caseScore) {

            $dataUpdate = $request->all();

            $validator = Validator::make($dataUpdate, [
                'id_subject' => 'required',
                'title' => 'required',
                // 'name_field' => 'required',
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

            $caseScore->update($dataUpdate);

            $caseScoreResource = new CaseScoreResource($caseScore);

            return response()->json([
                'data' => $caseScoreResource,
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
        $caseScore = CaseScore::find($id);
        if($caseScore) {
            $caseScoreResource = new CaseScoreResource($caseScore);
            $caseScore->delete();
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
