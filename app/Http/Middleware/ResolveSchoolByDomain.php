<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\School;

class ResolveSchoolByDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $domain =
            $request->header('X-Tenant-Domain')
            ?? $request->getHost();

        $school = School::where('domain', $domain)
            ->where('active', true)
            ->first();

        if (! $school) {
            return response()->json([
                'message' => 'Invalid school domain'
            ], 404);
        }

        // Bind school globally
        app()->instance('school', $school);
        return $next($request);
    }
}
