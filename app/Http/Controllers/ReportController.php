<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Report;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function report(Request $request)
    {
        try {
            $reported_data = User::select('id', 'user_type_id')->where('id', $request->reported_id)->first();
            $reported = $reported_data['user_type_id'];

            if ($reported == '2') {
                return response()->json([
                    'success' => false,
                    'message' => "Staff cannot be reported!"
                ], 500);
            } else {
                $validator = Validator::make($request->all(), [
                    'reporter_id'             => 'required',
                    'reported_id'             => 'required',
                    'report'               => 'required|string'
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                $data = Report::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'reporter_id'     => $request->reporter_id,
                        'reported_id'   => $request->reported_id,
                        'report'       => $request->report,
                    ]
                );


                return response()->json([
                    'success' => true,
                    'data' => $data
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
