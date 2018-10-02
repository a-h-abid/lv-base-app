<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class ApiCommonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceOf JsonResponse) {
            $data = $response->getData(true);

            $data['code'] = $response->getStatusCode();
            $data['success'] = $data['code'] >= 200 && $data['code'] < 400 ? true : false;
            $data['message'] = $data['message'] ?? $response::$statusTexts[$data['code']] ?? '--';

            $response->setData($data);
        }

        return $response;
    }
}
