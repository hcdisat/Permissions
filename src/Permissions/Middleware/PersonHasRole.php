<?php namespace CVA\Permissions\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class PersonHasRole
{

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * PersonHasRole constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if( !$this->auth->user()->can($role))
        {
            if( $request->ajax() )
            {
                return response('Unauthorized', 401);
            }

            abort(401, 'Unauthorized');
        }

        return $next($request);
    }
}
