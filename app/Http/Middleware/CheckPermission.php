<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckPermission{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail(Auth::user()->id);
        
        if ($user->hasPermission($permission)) {
            return $next($request);
        }

        Log::warning('Unauthorized access attempt', [
            'user_id' => Auth::id(),
            'permission' => $permission,
            'request_path' => $request->path(),
            'request_method' => $request->method(),
        ]);

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
