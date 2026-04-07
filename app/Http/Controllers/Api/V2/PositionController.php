<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Position::all(),
        ]);
    }
}

