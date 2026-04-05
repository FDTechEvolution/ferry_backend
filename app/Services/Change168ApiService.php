<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Change168ApiService
{
    public function request(): PendingRequest
    {
        $config = config('services.change_168', []);

        return Http::withHeaders([
            'X-API-KEY' => (string) ($config['api_key'] ?? ''),
            'Accept' => 'application/json',
        ])
            ->baseUrl((string) ($config['base_url'] ?? ''))
            ->timeout(30);
    }

    public function get(string $url, array|string|null $query = null): Response
    {
        return $this->request()->get($url, $query);
    }



    public function post(string $url, array $data = []): Response
    {
        return $this->request()->asJson()->post($url, $data);
    }

    public function put(string $url, array $data = []): Response
    {
        return $this->request()->asJson()->put($url, $data);
    }

    public function patch(string $url, array $data = []): Response
    {
        return $this->request()->asJson()->patch($url, $data);
    }

    public function delete(string $url, array $query = []): Response
    {
        return $this->request()->delete($url, $query);
    }




    /**
     * GET /back/agent-route (query key matches upstream API: fillter).
     */
    public function getAgentRoutes($departStationId = null, $destStationId = null): Response
    {
        return $this->get('back/agent-route', ['fillter' => 'all', 'departStationId' => $departStationId, 'destStationId' => $destStationId]);
    }
}
