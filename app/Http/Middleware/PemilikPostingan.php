<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostingan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('ini middleware pemilik postingan');
        $currentUser = auth()->user();
        $post = Post::find($request->id);
        if ($currentUser->id != $post->author) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
