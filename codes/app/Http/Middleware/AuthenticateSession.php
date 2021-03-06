<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class AuthenticateSession
{
    /**
     * The authentication factory implementation.
     *
     * @var \Illuminate\Auth\SessionGuard
     */
    protected $auth;

    /**
     * @var string
     */
    protected $guard;

    /**
     * @var string
     */
    protected $passwordHashField;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->hasSession() || ! $request->user()) {
            return $next($request);
        }

        $this->guard = $request->user()->getGuardName();
        $this->passwordHashField = $request->user()->getPasswordHashFieldName();

        if ($this->auth->viaRemember()) {
            $passwordHash = explode('|', $request->cookies->get($this->auth->getRecallerName()))[2];

            if ($passwordHash != $request->user()->getAuthPassword()) {
                $this->logout($request);
            }
        }

        if (! $request->session()->has($this->passwordHashField)) {
            $this->storePasswordHashInSession($request);
        }

        if ($request->session()->get($this->passwordHashField) !== $request->user()->getAuthPassword()) {
            $this->logout($request);
        }

        return tap($next($request), function () use ($request) {
            $this->storePasswordHashInSession($request);
        });
    }

    /**
     * Store the user's current password hash in the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function storePasswordHashInSession($request)
    {
        if (! $request->user()) {
            return;
        }

        $request->session()->put([
            $this->passwordHashField => $request->user()->getAuthPassword(),
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function logout($request)
    {
        if ($request->user()) {
            $request->session()->forget($request->user()->getPasswordHashFieldName());
        }

        $this->auth->guard($this->guard)->logoutCurrentDevice();

        $request->session()->flush();

        throw new AuthenticationException('Unauthenticated.', [$this->guard]);
    }
}
