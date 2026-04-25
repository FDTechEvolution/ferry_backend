<?php

namespace App\Http\Controllers\Change;

use App\Http\Controllers\Controller;
use App\Services\Change168ApiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChangeRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Change168ApiService $change168)
    {
        $departStationId = $this->normalizeStationQueryId($request->query('depart_station_id'));
        $destStationId = $this->normalizeStationQueryId($request->query('dest_station_id'));

        $departStations = [];
        $destStations = [];
        $stationsOk = true;
        $stationsError = null;

        try {
            $depRes = $change168->getDepartStation();
            if ($depRes->successful()) {
                $departStations = $this->normalizeStationRows($depRes->json('data'));
            } else {
                $stationsOk = false;
                $stationsError = 'โหลดสถานีต้นทางไม่สำเร็จ (HTTP '.$depRes->status().')';
                Log::warning('168change departure-stations request failed', [
                    'status' => $depRes->status(),
                    'body' => $depRes->body(),
                ]);
            }
        } catch (ConnectionException $e) {
            $stationsOk = false;
            $stationsError = $e->getMessage();
            Log::warning('168change departure-stations connection failed', [
                'message' => $e->getMessage(),
            ]);
        }

        if ($departStationId !== null) {
            $departIds = collect($departStations)->pluck('id')->map(fn ($id) => (string) $id)->all();
            if (! in_array((string) $departStationId, $departIds, true)) {
                $departStationId = null;
                $destStationId = null;
            }
        }

        if ($departStationId !== null) {
            try {
                $destRes = $change168->getDestStation($departStationId);
                if ($destRes->successful()) {
                    $destStations = $this->normalizeStationRows($destRes->json('data'));
                } else {
                    if ($stationsOk) {
                        $stationsOk = false;
                        $stationsError = 'โหลดสถานีปลายทางไม่สำเร็จ (HTTP '.$destRes->status().')';
                    }
                    Log::warning('168change destination-stations request failed', [
                        'status' => $destRes->status(),
                        'body' => $destRes->body(),
                    ]);
                }
            } catch (ConnectionException $e) {
                if ($stationsOk) {
                    $stationsOk = false;
                    $stationsError = $e->getMessage();
                }
                Log::warning('168change destination-stations connection failed', [
                    'message' => $e->getMessage(),
                ]);
            }
        } else {
            $destStationId = null;
        }

        if ($destStationId !== null && $departStationId !== null) {
            $validDest = collect($destStations)->pluck('id')->map(fn ($id) => (string) $id)->contains((string) $destStationId);
            if (! $validDest) {
                $destStationId = null;
            }
        }

        $viewData = [
            'departStations' => $departStations,
            'destStations' => $destStations,
            'stationsOk' => $stationsOk,
            'stationsError' => $stationsError,
            'departStationId' => $departStationId,
            'destStationId' => $destStationId,
        ];

        try {
            $response = $change168->getAgentRoutes($departStationId, $destStationId);
        } catch (ConnectionException $e) {
            Log::warning('168change agent-route connection failed', [
                'message' => $e->getMessage(),
            ]);

            return view('pages.change-route.index', $viewData + [
                'routes' => [],
                'agentRoutesOk' => false,
                'agentRoutesStatus' => null,
                'agentRoutesError' => $e->getMessage(),
            ]);
        }

        if (! $response->successful()) {
            Log::warning('168change agent-route request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        return view('pages.change-route.index', $viewData + [
            'routes' => $response->successful() ? ($response->json()['data'] ?? []) : [],
            'agentRoutesOk' => $response->successful(),
            'agentRoutesStatus' => $response->status(),
            'agentRoutesError' => null,
        ]);
    }

    private function normalizeStationQueryId(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $s = is_string($value) ? trim($value) : (string) $value;

        return $s === '' ? null : $s;
    }

    /**
     * @param  mixed  $data
     * @return array<int, array{id: string, name: string, nickname: string|null}>
     */
    private function normalizeStationRows($data): array
    {
        if (! is_array($data)) {
            return [];
        }

        $out = [];
        foreach ($data as $row) {
            if (! is_array($row)) {
                continue;
            }
            $id = $row['id'] ?? $row['station_id'] ?? null;
            if ($id === null || $id === '') {
                continue;
            }
            $nickname = $row['nickname'] ?? null;
            $out[] = [
                'id' => (string) $id,
                'name' => (string) ($row['name'] ?? ''),
                'nickname' => $nickname !== null && $nickname !== '' ? (string) $nickname : null,
            ];
        }

        return $out;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_sub_route_id' => ['required'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'child_price' => ['nullable', 'numeric', 'min:0'],
            'infant_price' => ['nullable', 'numeric', 'min:0'],
            'depart_station_id' => ['nullable'],
            'dest_station_id' => ['nullable'],
        ]);

        $agentSubRouteId = (string) $validated['agent_sub_route_id'];
        $payload = [
            'price' => $validated['price'] ?? null,
            'child_price' => $validated['child_price'] ?? null,
            'infant_price' => $validated['infant_price'] ?? null,
        ];

        try {
            $response = app(Change168ApiService::class)->updateSubRoute($agentSubRouteId, $payload);
        } catch (ConnectionException $e) {
            Log::warning('168change update sub-route connection failed', [
                'agent_sub_route_id' => $agentSubRouteId,
                'message' => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'บันทึกราคาไม่สำเร็จ: '.$e->getMessage(),
                ], 500);
            }

            return redirect()->route('changeRoute.index', [
                'depart_station_id' => $validated['depart_station_id'] ?? null,
                'dest_station_id' => $validated['dest_station_id'] ?? null,
            ])->with('error', 'บันทึกราคาไม่สำเร็จ: '.$e->getMessage());
        }

        if (! $response->successful()) {
            Log::warning('168change update sub-route request failed', [
                'agent_sub_route_id' => $agentSubRouteId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'message' => 'บันทึกราคาไม่สำเร็จ (HTTP '.$response->status().')',
                ], $response->status());
            }

            return redirect()->route('changeRoute.index', [
                'depart_station_id' => $validated['depart_station_id'] ?? null,
                'dest_station_id' => $validated['dest_station_id'] ?? null,
            ])->with('error', 'บันทึกราคาไม่สำเร็จ (HTTP '.$response->status().')');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'บันทึกราคาเรียบร้อยแล้ว',
            ]);
        }

        return redirect()->route('changeRoute.index', [
            'depart_station_id' => $validated['depart_station_id'] ?? null,
            'dest_station_id' => $validated['dest_station_id'] ?? null,
        ])->with('success', 'บันทึกราคาเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
