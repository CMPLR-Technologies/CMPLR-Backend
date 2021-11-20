<?php

namespace App\Http\Misc\Traits;

trait WebServiceResponse
{
    public function success_response($response, $code = 200)
    {
        return $this->general_response($status_code = $code, $msg = "Success", $data = $response);
    }

    public function error_response($msg, $error, $code = 400)
    {
        return $this->general_response($code, $msg, $error, 'error');
    }

    private function general_response($status_code = 200, $msg = "", $data = "", $type = 'response')
    {
        return response()->json([
            "meta"  => [
                "status_code"   => $status_code,
                "msg"  => $msg
            ],
            $type => $data,
        ], $status_code);
    }
}