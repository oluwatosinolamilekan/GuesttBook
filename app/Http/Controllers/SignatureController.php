<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SignatureService;

class SignatureController extends Controller
{
    private $signature;

    public function __construct(SignatureService $signature)
    {
        $this->signature = $signature;
    }


    public function allGuest()
    {
        $results = $this->signature->allGuest();

        $response = [
            'code'=>200,
            'success' => true,
            'message' => 'All Guest',
            'data'    => $results,
        ];

        return response()->json($response);
    }

    public function createVisitor(Request $request)
    {
        try {
           
            $validateRequests = $this->validate($request, [
                'name' => 'required',
                'email' => 'nullable',
                'phone_number' => 'required',
                'purpose' => 'required',
                'address' => 'required',

            ]);

            if ($validateRequests) {

                $createGuest = $this->signature->createGuest($request);

                if($createGuest){
                    $response = [
                        'code' => 200,
                        'success' => true,
                        'message' => 'Guest was succesfully Created',
                        'data'    => $createGuest,
                    ];
                    return response()->json($response);
                }
            }

        } catch (\Exception $e) {
            // return 'Guest wasnt create because,'$e->getMessage();
            return $e->getMessage();
        }
    }

     public function signOutGuest(Request $request)
    {
        try {

            $validateRequest = $this->validate($request, [
                'code' => 'required',

            ]);

            if($validateRequest){
                 $sign_out = $this->signature->signOutWithCode($request);

                if ($sign_out = 'code not found') {
                    $response = [
                        'success' => false,
                        'message' => 'code not found',
                        'data'    => null,
                    ];
                }else{
                    $response = [
                        'success' => true,
                        // 'message' => '{$sign_out->name} ,'.'has sign out at'.'{$sign_out->flagged_at}',
                        'data'    => $sign_out,
                    ];
                }
                return response()->json($response);

            }

        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }

    public function showGuest($id)
    {
        $getGuest = $this->signature->showGuest($id);

        if (!$getGuest) {
           $response = [
                'data'    => null,
                //'message' => $message,
            ];
        
            return response()->json($response);
        }else{
            $response = [
                'success' => true,
                'data'    => $getGuest,
                //'message' => $message,
            ];
        
            return response()->json($response);
        }
    }

    public function signin(Request $request)
    {
       try {
            $validateRequest = $this->validate($request, [
                'code' => 'required',
            ]);

            if ($validateRequest) {

                $createGuest = $this->signature->signin($request);

                if($createGuest){
                     $response = [
                        'code' => 200,
                        'success' => true,
                        'message' => 'Guest was Signin succesfully',
                        'data'    => $createGuest,
                    ];
                    return response()->json($response);
                }
            }
           
       } catch (\Exception $e) {
            return $e->getMessage();
           
       }
    }

    public function signOutWithId(Request $request)
    {
        try {

            $validateRequest = $this->validate($request, [
                'id' => 'required',
            ]);

            if ($validateRequest) {

                $guest = $this->signature->signOutWithId($request);

                if($signOutWithId){
                     $response = [
                        'code' => 200,
                        'success' => true,
                        'message' => 'Guest was signout succesfully',
                        'data'    => $signOutWithId,
                    ];
                    return response()->json($response);
                }
            }
           
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function editGuest(Request $request, $id)
    {
        // try {

            // $validateRequest = $this->validate($request, [
            //     'name' => 'required',
            //     'email' => 'nullable',
            //     'phone_number' => 'nullable',
            //     'purpose' => 'required',
            //     'address' => 'required',
            // ]);

        $validateRequest = \Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'nullable',
                'phone_number' => 'nullable',
                'purpose' => 'required',
                'address' => 'required',
            ]);
            if ($validateRequest->fails()) {
                // return $this->validationErrors($validateRequest->getMessageBag()->all());
                return response()->json([
                    'message' => $validateRequest->getMessageBag()->all(),
                    'data' => null,
                ],404);
            }
            // dd($request->all());
            if ($validateRequest) {

                $guest = $this->signature->editGuest($request,$id);

                if($guest){
                     $response = [
                        'code' => 200,
                        'success' => true,
                        'message' => 'Guest Details succesfully Edited',
                        'data'    => $guest,
                    ];
                    return response()->json($response);
                }
            }else{
                return response()->json([
                    'message' => 'Failed',
                    'data' => null,
                ],404);
            }
           
            
        // } catch (\Exception $e) {
        //     return response()->json([
        //             'message' => $e->getMessage(),
        //             'data' => null,
        //         ],404);
        // }
    }


    public function deleteGuest($id)
    {
        try {
            
            $guest = $this->signature->delete($id);
            if ($guest) {
                $response = [
                        'code' => 200,
                        'success' => true,
                        'message' => 'Guest has been deleted',
                        'data'    => $guest,
                    ];
            }
            return response()->json($response);
        } catch (\Exception $e) {
            return $response = [
                        'code' => 404,
                        'success' => false,
                        'message' => $e->getMessage(),
                        'data'    => null,
                ];
            
        }
    }

}
