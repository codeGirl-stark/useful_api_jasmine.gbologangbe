<?php

namespace App\Http\Controllers;

use App\Models\User_modules;
use App\Models\Modules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleActivationController extends Controller
{
   public function activate(Request $request, $id) 
    {
        $user = Auth::user(); 
        $module = Modules::find($id);

        if (!$module) {
            return response()->json(['message' => 'Module not found'], 404);
        }

        User_modules::updateOrCreate(
            ['user_id' => $user->id, 'module_id' => $id],
            ['active' => true] 
        );

        return response()->json(['message' => 'Module activated'], 200);
    }

    
    public function deactivate(Request $request, $id)
    {
       
        $user = Auth::user(); 
        
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        
        $module = Modules::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found'], 404);
        }

        
        $userModule = User_modules::where('user_id', $user->id)
                                  ->where('module_id', $id)
                                  ->first();

       
        if (!$userModule || $userModule->active == false) {
            
            if (!$userModule) {
                 User_modules::create([
                    'user_id' => $user->id, 
                    'module_id' => $id, 
                    'active' => false
                ]);
            }
            
            return response()->json(['message' => 'Module is already deactivated'], 200);
        }

        
        $userModule->active = false;
        $userModule->save();

        return response()->json(['message' => 'Module deactivated successfully'], 200);
    }
}
