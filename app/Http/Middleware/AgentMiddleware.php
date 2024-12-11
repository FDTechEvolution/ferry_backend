<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\ApiMerchants;
use Illuminate\Support\Facades\Cache;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');
        $code = explode(' ', $authorizationHeader);
        $merchant = ApiMerchants::where('code', $code[0])->first();
        if(isset($merchant)) {
            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin' , '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, Application','ip');

            if ($authorizationHeader && $this->starts_with($authorizationHeader, $merchant->code)) {
                $token = substr($authorizationHeader, strlen($code[0]) + 1);
                $request->headers->set('Authorization', $token);
            }

            if($request->header('Authorization') == $merchant->key) {
                $request->attributes->set('merchant', $merchant->id);
                $this->log($request, $response, 200);
                return $next($request);
            }
        }

        $this->log($request, null, 403);
        return response('Unauthorized', 403);
    }

    private function starts_with($string, $startString) {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    private function log($request, $response, $auth_code) {
        $url = $request->fullUrl();
        $method = $request->method();
        $request_body = json_decode($request->getContent(), true) ?: '';
        $ip = $request->ip();
        $status_code = $response !== null ? $response->getStatusCode() : 403;
        $response_body = $response !== null ? json_decode($response->getContent(), true) : '';

        $log = '['.$method.'] : ['.$auth_code.'] : '.$url.' ('.$ip.') | '.$status_code;
        Log::channel('api-agent')->info($log);
        Log::channel('api-agent')->info($request_body);
        Log::channel('api-agent')->info($response_body);
        Log::channel('api-agent')->info('---------------------------------------------------------------------------');
    }
}
