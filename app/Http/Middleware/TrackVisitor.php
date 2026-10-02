<?php

namespace App\Http\Middleware;

use App\Models\Admin\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        $visitorKey = $request->cookie('bd_visitor_key') ?: hash('sha256', Str::uuid()->toString());
        $response = $next($request);

        if ($request->isMethod('GET') && $response->isSuccessful()) {
            $visitor = Visitor::firstOrNew([
                'visitor_key' => $visitorKey,
                'visit_date' => now()->toDateString(),
            ]);
            $visitor->ip_address = $request->ip();
            $visitor->user_agent = Str::limit((string) $request->userAgent(), 512, '');
            $visitor->hits = $visitor->exists ? $visitor->hits + 1 : 1;
            $visitor->save();
        }

        return $response->cookie('bd_visitor_key', $visitorKey, 60 * 24 * 365);
    }
}
