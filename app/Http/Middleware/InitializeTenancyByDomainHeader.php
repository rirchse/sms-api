<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stancl\Tenancy\Database\Models\Domain;

class InitializeTenancyByDomainHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->header('X-Tenant-Domain');

        if (!$domain) {
            return response()->json(['message' => 'Tenant domain missing'], 400);
        }

        $domainModel = Domain::where('domain', $domain)->first();

        if (!$domainModel) {
            return response()->json(['message' => 'Invalid tenant domain'], 404);
        }

        tenancy()->initialize($domainModel->tenant);
        return $next($request);
    }
}
