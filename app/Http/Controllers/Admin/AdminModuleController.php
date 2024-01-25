<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Validation\Rule;

class AdminModuleController extends Controller
{
    public function index()
    {
        return view('admin.modules.index', [
            'modules' => Module::all(),
        ]);
    }

    public function create()
    {
        return view('admin.modules.create');
    }

    public function store()
    {
        $formData = request()->validate([
            'name' => 'required',
            'module_code' => 'required|unique:modules,module_code',
            'credit' => 'required'
        ]);

        Module::create($formData);

        return redirect('admin/modules');
    }

    public function edit(Module $module)
    {
       return view('admin.modules.edit',[
        'module' => $module,
       ]);
    }

    public function update(Module $module)
    {
        $formData = request()->validate([
            'name' => 'required',
            'module_code' => ['required',Rule::unique('modules','module_code')->ignore($module)],
            'credit' => 'required'
        ]);

        $module->update($formData);

        return redirect('admin/modules');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->back();
    }
}