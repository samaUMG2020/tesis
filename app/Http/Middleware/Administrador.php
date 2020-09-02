<?php

namespace App\Http\Middleware;

use App\Models\escuela\seguridad\Rol;
use Closure;
use Illuminate\Support\Facades\Auth;

class Administrador
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
        if(mb_strtolower($rol->nombre) == 'administrador')
            return redirect()->route('home')->with('info','¡Usted no tiene autorización para realizar esta acción!');
        else
            return $next($request);
    }
}
