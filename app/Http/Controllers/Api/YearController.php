<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Year;

class YearController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Year::all(),
        ]);
    }
}

