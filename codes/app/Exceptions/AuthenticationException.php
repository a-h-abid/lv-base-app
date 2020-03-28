<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthenticationException extends Exception
{
    /**
     * All of the guards that were checked.
     *
     * @var array
     */
    protected $guards;

    /**
     * Redirect to named route on unauthenticated
     *
     * @var string
     */
    protected $redirectRoute = 'home';

    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct($message = 'Unauthenticated.', array $guards = [])
    {
        parent::__construct($message);

        $this->guards = $guards;

        // Get the 1st match for unauthenticated route redirecct
        foreach ($this->guards as $guard) {
            $redirectRoute = config('auth.guards.'.$guard.'.unauthenticatedRedirectRouteName');
            if ($redirectRoute) {
                $this->redirectRoute = $redirectRoute;
                break;
            }
        }
    }

    /**
     * Get the guards that were checked.
     *
     * @return array
     */
    public function guards()
    {
        return $this->guards;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        Log::info('AuthenticationException on Full URL: '. $request->method().' '.$request->fullUrl());

        return redirect()->route($this->redirectRoute);
    }
}
