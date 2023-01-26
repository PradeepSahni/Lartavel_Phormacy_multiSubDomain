<?php

namespace App\Http\Middleware;

use Closure;

class CheckPharmacy
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
        
        if(!session()->has('phrmacy'))
        {
            return redirect('admin-login')->with('msg','<div class="alert alert-danger""> You are <strong>logged Out</strong>!</div>'); 
        }
        $request->merge(['role_type' =>session()->get('phrmacy')->roll_type]);
        return $next($request);
    }
}
