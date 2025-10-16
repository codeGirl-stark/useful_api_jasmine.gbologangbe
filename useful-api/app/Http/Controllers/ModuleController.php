<?php

namespace App\Http\Controllers;

use App\Models\Modules;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Modules::all();
        return response()->json($modules, 200);
    }
}
