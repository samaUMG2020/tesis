<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\escuela\seguridad\Rol;

class Director
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
        $rol = Rol::find(Auth::user()->rol_id);
        if (mb_strtolower($rol->nombre) == 'director')
            return redirect()->route('home')->with('info', '¡Usted no tiene autorización para realizar esta acción!');
        else
            return $next($request);
    }
}
