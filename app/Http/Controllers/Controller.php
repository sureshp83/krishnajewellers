<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * send response to user.
     *
     * @return json
     */
    public function toJson($result = [], $message = '', $status = 1)
    {
        
        return response()->json([
            'code' => $status,
            'data' => !empty($result) ? $result : new \stdClass(),
            'message' => $message,
        ]);
         
    }
}
