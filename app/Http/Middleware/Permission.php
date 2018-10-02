<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Permission
{
    public function handle($request, Closure $next, $permission)
    {
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        foreach ($permissions as $permission) {

            $parts = explode('.', $permission);
            $guard = $parts[0] ?? null;
            $ability = '';

            foreach ($parts as $part) {
                $ability .= $ability ? '.' . $part : $part;
                try {
                    if (app('auth')->user()->hasPermissionTo($ability, $guard)) {
                        return $next($request);
                    }
                } catch (PermissionDoesNotExist $e) {}
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
