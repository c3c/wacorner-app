<?php

namespace App\Http\Middleware;

use Closure;

class Ativo
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
        $usuario = auth()->user();

        if( $usuario->ativo() ) {
            return $next($request);
        }
        return redirect('admin/venda/expirado');
    }
}
