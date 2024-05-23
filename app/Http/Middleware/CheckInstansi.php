<?php

namespace App\Http\Middleware;

use App\Models\Instansi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CheckInstansi
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
        $instansi = $request->route('instansi');
        if (!Instansi::where('nama_instansi', $instansi)->exists()) {
            return redirect()->back()->with('fail', 'Instansi tidak ditemukan');
        }

        View::share('instansi', $instansi);

        $request->attributes->set('instansi', $instansi);

        return $next($request);
    }
}
