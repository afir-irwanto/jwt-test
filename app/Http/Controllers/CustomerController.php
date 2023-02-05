<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = User::select('id', 'user_type_id', 'email','deleted_at')->where('user_type_id', '=', '1')->withTrashed()->get();

            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_type_id'  => 'required',
                'email'         => 'required|email|unique:users',
                'password'      => 'required|string|min:6|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'user_type_id'  => $request->user_type_id,
                    'email'         => $request->email,
                    'password'      => bcrypt($request->password),
                ]
            );

            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $customer)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_type_id'  => 'required',
                'email'         => 'required|email|unique:users',
                'password'      => 'required|string|min:6|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data = User::where('id', $customer)->update([
                'user_type_id'  => $request->user_type_id,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
            ]);

            $show = User::find($customer);

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully!',
                'data' => $show
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = User::where('id', $id)->first();

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($customer)
    {
        try {
            $user = User::find($customer);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
