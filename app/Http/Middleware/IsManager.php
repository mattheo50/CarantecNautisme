<?php

namespace App\Http\Middleware;

use App\Models\web\AcnMember;
use Closure;

class IsManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $isManager = AcnMember::isUserManager(auth()->user()->MEM_NUM_MEMBER);

        if (!$isManager) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}