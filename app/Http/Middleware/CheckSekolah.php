<?php

namespace App\Http\Middleware;

use App\Models\Sekolah;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CheckSekolah
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
        $sekolah = $request->route('sekolah');

        if (!Sekolah::where('nama', $sekolah)->exists()) {
            return redirect()->back()->with('fail', 'Sekolah tidak ditemukan');
        }

        View::share('sekolah', $sekolah);

        $request->attributes->set('sekolah', $sekolah);

        return $next($request);
    }
}
