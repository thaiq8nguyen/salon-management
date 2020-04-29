<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message = '')
    {
        $response = [
            'success' => true,
            $result['name'] => $result['value'],
            "message" => $message
        ];

        return response()->json($response, 200);
    }

    public function sendError($errors, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $errors
        ];

        if(!empty($errorMessage))
        {
            $response['data'] = $errorMessage;
        }

        return response()->json($response, $code);
    }
}
