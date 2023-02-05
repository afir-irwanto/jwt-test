<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function cust_to_cust(Request $request)
    {
        try {

            $sender_id = User::select('id', 'user_type_id')->where('id', $request->sender_id)->first();
            $sender = $sender_id['user_type_id'];
            $receiver_id = User::select('id', 'user_type_id')->where('id', $request->receiver_id)->first();
            $receiver = $receiver_id['user_type_id'];

            if ($sender != 1) {
                return response()->json([
                    'success' => false,
                    'message' => "Sender is not Customer"
                ], 500);
            } elseif ($receiver != 1) {
                return response()->json([
                    'success' => false,
                    'message' => "Receiver is not Customer"
                ], 500);
            } else {
                $validator = Validator::make($request->all(), [
                    'sender_id'             => 'required',
                    'receiver_id'             => 'required',
                    'message'               => 'required|string'
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                $data = Message::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'sender_id'     => $request->sender_id,
                        'receiver_id'   => $request->receiver_id,
                        'message'       => $request->message,
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


    public function own_chat($customer)
    {
        try {
            $data = Message::select('id', 'sender_id', 'receiver_id', 'message')->where('sender_id', $customer)->orWhere('receiver_id', $customer)->get();

            if (isset($data)) {
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

    public function all_chat()
    {
        try {
            $data = Message::all();

            return response()->json([
                'success' => true,
                'user' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function staff_to_staff(Request $request)
    {
        try {

            $sender_id = User::select('id', 'user_type_id')->where('id', $request->sender_id)->first();
            $sender = $sender_id['user_type_id'];
            $receiver_id = User::select('id', 'user_type_id')->where('id', $request->receiver_id)->first();
            $receiver = $receiver_id['user_type_id'];

            if ($sender != 2) {
                return response()->json([
                    'success' => false,
                    'message' => "Sender is not Staff"
                ], 500);
            } elseif ($receiver != 2) {
                return response()->json([
                    'success' => false,
                    'message' => "Receiver is not Staff"
                ], 500);
            } else {
                $validator = Validator::make($request->all(), [
                    'sender_id'             => 'required',
                    'receiver_id'             => 'required',
                    'message'               => 'required|string'
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                $data = Message::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'sender_id'     => $request->sender_id,
                        'receiver_id'   => $request->receiver_id,
                        'message'       => $request->message,
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

    public function staff_to_cust(Request $request)
    {
        try {

            $sender_id = User::select('id', 'user_type_id')->where('id', $request->sender_id)->first();
            $sender = $sender_id['user_type_id'];
            $receiver_id = User::select('id', 'user_type_id')->where('id', $request->receiver_id)->first();
            $receiver = $receiver_id['user_type_id'];

            if ($sender != 2) {
                return response()->json([
                    'success' => false,
                    'message' => "Sender is not Staff"
                ], 500);
            } elseif ($receiver != 1) {
                return response()->json([
                    'success' => false,
                    'message' => "Receiver is not Customer"
                ], 500);
            } else {
                $validator = Validator::make($request->all(), [
                    'sender_id'             => 'required',
                    'receiver_id'             => 'required',
                    'message'               => 'required|string'
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }

                $data = Message::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'sender_id'     => $request->sender_id,
                        'receiver_id'   => $request->receiver_id,
                        'message'       => $request->message,
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
