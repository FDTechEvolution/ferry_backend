<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\BookingHelper;
use App\Helpers\PaymentHelper;
use App\Models\Addon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddonBookingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'departdate' => 'required|date',
            'fullname' => 'required',
            'email' => 'required|email',
            'mobile' => 'nullable|string',
            'addon_id' => 'required|array|min:1',
            'addon_id.*' => 'required|uuid',
            'addon_qty' => 'nullable|array',
            'addon_qty.*' => 'nullable|integer|min:1',
            'book_channel' => 'nullable|string',
            'adult_passenger' => 'nullable|integer|min:0',
            'child_passenger' => 'nullable|integer|min:0',
            'infant_passenger' => 'nullable|integer|min:0',
        ]);

        $addonIds = array_values($request->addon_id);
        $addonQtys = array_values($request->addon_qty ?? []);

        $addons = [];
        $totalAmount = 0;

        foreach ($addonIds as $index => $addonId) {
            $addon = Addon::query()
                ->where('id', $addonId)
                ->where('status', 'CO')
                ->where('isactive', 'Y')
                ->first();

            if (! $addon) {
                return response()->json([
                    'result' => false,
                    'message' => 'Addon not found or inactive.',
                    'addon_id' => $addonId,
                ], 422);
            }

            $qty = isset($addonQtys[$index]) ? max(1, (int) $addonQtys[$index]) : 1;
            $lineAmount = (float) $addon->amount * $qty;
            $totalAmount += $lineAmount;

            $addons[] = [
                'addon_id' => $addon->id,
                'qty' => $qty,
                'amount' => $lineAmount,
            ];
        }

        $customers = $this->buildCustomers($request);

        $adult = (int) ($request->adult_passenger ?? 1);
        $child = (int) ($request->child_passenger ?? 0);
        $infant = (int) ($request->infant_passenger ?? 0);
        if ($adult + $child + $infant < 1) {
            $adult = 1;
        }

        $data = [
            'booking' => [
                'departdate' => $request->departdate,
                'adult_passenger' => $adult,
                'child_passenger' => $child,
                'infant_passenger' => $infant,
                'totalamt' => $totalAmount,
                'extraamt' => $totalAmount,
                'amount' => 0,
                'ispayment' => 'N',
                'user_id' => null,
                'trip_type' => 'addon',
                'book_channel' => $request->book_channel ?: 'ONLINE',
                'status' => 'DR',
                'type' => 'addon',
                'ref_ticketno' => $request->ref_ticketno,

            ],
            'customers' => $customers,
            'addons' => $addons,
        ];

        $booking = BookingHelper::createAddonBooking($data);

        if (! $booking) {
            return response()->json([
                'result' => false,
                'message' => 'Unable to create addon booking.',
            ], 500);
        }

        PaymentHelper::createPaymentFromBooking($booking->id);

        return response()->json([
            'result' => true,
            'booking' => $booking->bookingno,
            'email' => $request->email,
            'type' => 'addon',
            'totalamt' => $totalAmount,
        ], 200);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function buildCustomers(Request $request): array
    {
        $fullname = $request->fullname;
        $type = $request->passenger_type;
        $titlename = $request->titlename;
        $birthDay = $request->birth_day;

        if (! is_array($fullname)) {
            return [[
                'title' => $request->titlename ? strtoupper($request->titlename) : null,
                'fullname' => $fullname,
                'type' => $request->passenger_type ? strtoupper($request->passenger_type) : 'ADULT',
                'passportno' => $request->passportno,
                'email' => $request->email,
                'mobile_code' => $request->mobile_code,
                'mobile' => $request->mobile,
                'mobile_th' => $request->th_mobile,
                'fulladdress' => $request->address,
                'birthday' => $request->birth_day,
                'country' => $request->country,
            ]];
        }

        $customers = [];
        foreach ($fullname as $key => $name) {
            $customers[] = [
                'title' => isset($titlename[$key]) ? strtoupper($titlename[$key]) : null,
                'fullname' => $name,
                'type' => isset($type[$key]) ? strtoupper($type[$key]) : 'ADULT',
                'passportno' => $key === 0 ? $request->passportno : null,
                'email' => $key === 0 ? $request->email : null,
                'mobile_code' => $key === 0 ? $request->mobile_code : null,
                'mobile' => $key === 0 ? $request->mobile : null,
                'mobile_th' => $key === 0 ? $request->th_mobile : null,
                'fulladdress' => $key === 0 ? $request->address : null,
                'birthday' => is_array($birthDay) ? ($birthDay[$key] ?? null) : ($key === 0 ? $birthDay : null),
                'country' => $key === 0 ? $request->country : null,
            ];
        }

        return $customers;
    }
}
