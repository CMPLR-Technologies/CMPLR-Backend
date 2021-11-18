<?php

namespace App\Http\Misc\Traits;
use App\Http\Misc\Helpers\Success;
trait WebServiceResponse
{
    public function success_response($response,$code =200)
    {
        return $this->general_response($response, "Success", $code);
    }

    public function dummy_response($message)
    {
        return $this->general_response(['message' => $message], "", 200);
    }

    public function error_response($error, $code = 422)
    { 
        return $this->general_response("", $error, $code);
    }

    private function general_response($data = "", $msg = "", $status_code = 200)
    {
        return response()->json([
            "meta"  => [
                "status_code"   => $status_code,
                "msg"  => $msg
            ],
            "response" => $data,
        ], $status_code);
    }
}
