<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LandOnLgaDashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $accessibleLga = [];

        $admin = auth()->guard('admin')->user();

        if($admin->state){
            foreach ($admin->state->lgas as $lga) {
                $accessibleLga[] = $lga->id;
            }
        }
        
        if($admin->lga_id == $request->route('lga') || in_array($request->route('lga'), $accessibleLga)){
            return $next($request);
        }
        session()->flash('error',['Sorry you dont have access to the requested Local Government']);
        return back();
        
    }
}
