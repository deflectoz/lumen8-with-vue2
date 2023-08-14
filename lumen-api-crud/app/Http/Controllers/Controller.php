<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function successResponse($data = null)
    {
        return response()->json(
            [
                'message' => 'Success',
                'data' => $data

            ],
            200
        );
    }
}
