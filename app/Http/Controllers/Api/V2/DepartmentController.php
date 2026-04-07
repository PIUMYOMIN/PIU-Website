<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Department::all(),
        ]);
    }
}

