<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class CompanyAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->hasAnyRole(User::getCompanyRoles())) {
            return $next($request);
        }
        
        throw new AuthorizationException();
    }
}
