<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        //Log::debug('get', [$url, $query]);
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
        $query = ['fillter' => 'all'];
        if ($departStationId !== null && $departStationId !== '') {
            $query['departure'] = $departStationId;
        }
        if ($destStationId !== null && $destStationId !== '') {
            $query['destination'] = $destStationId;
        }

        return $this->get('back/agent-route', $query);
    }

    public function updateSubRoute($agent_sub_route_id, $data)
    {
        return $this->post('back/agent-route/' . $agent_sub_route_id, $data);
    }

    public function getDepartStation(): Response
    {
        return $this->get('station/departure');
    }

    public function getDestStation($departStationId = null): Response
    {
        return $this->get('station/destination', ['depart_station' => $departStationId]);
    }
}
