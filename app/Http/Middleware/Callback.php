<?php

namespace App\Http\Middleware;
use App\Http\Controllers\API\BaseController as BaseController;
use Closure;
use Validator;

class Callback extends BaseController
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
        $header="XQBYYALM4KCLX8XK5PQEIKWZPUUPI1";
        $token = $request->header('Authentication');
        if($token != $header){
            return response()->json(['message' => "Authentication Key not Found"], 401);
        }
        return $next($request);
    }
}
