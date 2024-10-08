<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAccess
{

    protected $allowedTokens = [
        'strongtoken1',
        'strongtoken2',
        'strongtoken3',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('token');

        if ($token && in_array($token, $this->allowedTokens)) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
