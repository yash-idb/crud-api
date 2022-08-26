<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;

class Pinsearch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $header="XQBYYALM4KCLX8XK5PQEIKWZPUUPI1";
        $token = $request->header('Authentication');
        if($token != $header)
        {
            return response()->json(['Status'=>401,'Message' => "Authentication Key not Found"]);
        }
        
            return $next($request);
    
       
    
}
}
