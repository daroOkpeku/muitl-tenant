<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant;
class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // $request->getHost()
       
        $tenant = Tenant::where('domain', $request->root())->first();

        if (!$tenant || $tenant->name =! 'user') {
            abort(404, 'Tenant not found');
        }

        app()->instance(Tenant::class, $tenant);
        return $next($request);
    }
}
