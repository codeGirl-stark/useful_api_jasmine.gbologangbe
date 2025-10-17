<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserModule;

class CheckModuleActive
{
    public function handle(Request $request, Closure $next, $module_id)
    {
        $user = $request->user();

        // Vérifier si le module est actif pour cet utilisateur
        $userModule = UserModule::where('user_id', $user->id)
                                ->where('module_id', $module_id)
                                ->first();

        if ($userModule && !$userModule->active) {
            return response()->json([
                'error' => 'Module inactive. Please activate this module to use it.'
            ], 403);
        }

        return $next($request);
    }
}

