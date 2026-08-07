<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\JsonResponse;

class AddonController extends Controller
{
    private const TYPE_ACTIVITY = 'ACTV';

    private const TYPE_MEAL = 'MEAL';

    private const TYPE_SHUTTLE_BUS_BOAT = 'SHBT';

    private const TYPE_RENT_A_BIKE = 'BIKE';

    public function getActivities(): JsonResponse
    {
        return $this->listByType(self::TYPE_ACTIVITY);
    }

    public function getActivity(string $id): JsonResponse
    {
        return $this->viewByType(self::TYPE_ACTIVITY, $id);
    }

    public function getMeals(): JsonResponse
    {
        return $this->listByType(self::TYPE_MEAL);
    }

    public function getMeal(string $id): JsonResponse
    {
        return $this->viewByType(self::TYPE_MEAL, $id);
    }

    public function getShuttleBusBoats(): JsonResponse
    {
        return $this->listByType(self::TYPE_SHUTTLE_BUS_BOAT);
    }

    public function getShuttleBusBoat(string $id): JsonResponse
    {
        return $this->viewByType(self::TYPE_SHUTTLE_BUS_BOAT, $id);
    }

    public function getRentABikes(): JsonResponse
    {
        return $this->listByType(self::TYPE_RENT_A_BIKE);
    }

    public function getRentABike(string $id): JsonResponse
    {
        return $this->viewByType(self::TYPE_RENT_A_BIKE, $id);
    }

    private function listByType(string $type): JsonResponse
    {
        $items = Addon::query()
            ->where('type', $type)
            ->where('status', 'CO')
            ->where('isactive', 'Y')
            ->with(['image', 'icon'])
            ->orderBy('name')
            ->get()
            ->map(fn (Addon $item) => $this->formatItem($item));

        return response()->json([
            'data' => $items,
            'status' => 'success',
        ]);
    }

    private function viewByType(string $type, string $id): JsonResponse
    {
        $item = Addon::query()
            ->where('id', $id)
            ->where('type', $type)
            ->where('status', 'CO')
            ->where('isactive', 'Y')
            ->with(['image', 'icon'])
            ->first();

        if (! $item) {
            return response()->json([
                'result' => false,
                'data' => null,
                'status' => 'fail',
                'message' => 'Not found',
            ], 404);
        }

        return response()->json([
            'result' => true,
            'data' => $this->formatItem($item),
            'status' => 'success',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function formatItem(Addon $item): array
    {
        return [
            'id' => $item->id,
            'code' => $item->code,
            'name' => $item->name,
            'type' => $item->type,
            'amount' => $item->amount,
            'description' => $item->description,
            'departure_time' => $item->departure_time,
            'is_route_station' => $item->is_route_station,
            'is_main_menu' => $item->is_main_menu,
            'image' => $this->formatImage($item->image),
            'icon' => $this->formatImage($item->icon),
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    /**
     * @param  mixed  $image
     * @return array<string, mixed>|null
     */
    private function formatImage($image): ?array
    {
        if (! $image || empty($image->path) || empty($image->name)) {
            return null;
        }

        $relative = trim($image->path, '/').'/'.$image->name;

        return [
            'id' => $image->id,
            'path' => $image->path,
            'name' => $image->name,
            'url' => asset($relative),
        ];
    }
}
