<?php

namespace App\Http\Presenter;

class BaseResponse {
    public static function basicResponse($statusCode, $message, $result) {
        $response = [
            'status' => strval($statusCode),
            'message' => $message,
            'result' => $result
        ];

        return response()->json($response, $statusCode);
    } 
}