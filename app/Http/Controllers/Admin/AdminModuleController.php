<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;

class AdminModuleController extends Controller
{
    public function index()
    {
        return view('admin.modules.index', [
            'modules' => Module::all(),
        ]);
    }
}
