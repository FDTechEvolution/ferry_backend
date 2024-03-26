<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class SevenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin' , '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, Application','ip');

        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader && $this->starts_with($authorizationHeader, config('services.token.seven_token'))) {
            $token = substr($authorizationHeader, 7);
            $request->headers->set('Authorization', $token);
        }

        if($request->header('Authorization') == config('services.api.seven_key')) {
            $this->log($request, $response, 200);
            return $response;
        }

        $this->log($request, $response, 403);
        return response('Unauthorized', 403);
    }

    private function starts_with($string, $startString) {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    private function set_only_str($str) {
        return preg_replace('/\s+/', '', $str);
    }

    private function log($request, $response, $auth_code) {
        $url = $request->fullUrl();
        $method = $request->method();
        $request_body = json_decode($request->getContent(), true) ?: '';
        $ip = $request->ip();
        $status_code = $response->getStatusCode();
        $response_body = json_decode($response->getContent(), true) ?: '';

        $log = '['.$method.'] : ['.$auth_code.'] : '.$url.' ('.$ip.') | '.$status_code;
        Log::channel('api-seven')->info($log);
        Log::channel('api-seven')->info($request_body);
        Log::channel('api-seven')->info($response_body);
        Log::channel('api-seven')->info('---------------------------------------------------------------------------');
    }
}
