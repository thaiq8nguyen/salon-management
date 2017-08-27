<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfCompletedRegistration
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
        if($request->session()->exists('completed_registration')){
            return $next($request);
        }

        return redirect('/');
    }
}
