<?php namespace ITeam\Permissions\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class PersonHasPermission
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * PersonHasPermission constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if( !$this->auth->user()->has($permissions) )
        {
            if( $request->ajax() )
            {
                return response('Unauthorized.', 403);
            }

            abort(403, 'Unauthorized action');
        }
        return $next($request);
    }
}
