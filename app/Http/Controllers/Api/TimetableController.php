<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TimeTable;

class TimetableController extends Controller
{
    public function getTimetable() {
        $tt = TimeTable::where('isactive', 'Y')->with('image')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => $tt], 200);
    }
}
