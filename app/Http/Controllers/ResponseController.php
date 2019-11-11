<?php

namespace App\Http\Controllers;

class ResponseController extends Controller
{

    public static function sendSuccess($data, $message, $code=200)
    {
        $response = [
            'success' => 'true',
            'data'    => $data,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }

    public static function sendError($data,$message,$code=404)
    {
        $response = [
            'success' => 'false',
            'data'    => $data,
            'message' => $message,
        ];
        
        return response()->json($response, $code);
    }

}
