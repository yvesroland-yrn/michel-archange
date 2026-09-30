<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareMessagesNonLus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasPermission('contacts')) {
            View::share('messagesNonLus', Contact::where('lu', false)->count());
        } else {
            View::share('messagesNonLus', 0);
        }

        return $next($request);
    }
}
