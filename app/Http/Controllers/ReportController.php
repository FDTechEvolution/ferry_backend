<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Section;
use App\Models\Station;
use App\Models\BookingRoutes;
use App\Models\Route;
use App\Models\BookingExtras;
use App\Models\Partners;

class ReportController extends Controller
{
    private function getSection() {
        return Section::with('stations')->orderBy('sort', 'ASC')->get();
    }

    private function getPartner() {
        return Partners::where('isactive', 'Y')->orderBy('name', 'ASC')->get();
    }


    public function index(){
        $sections = $this->getSection();
        $partners = $this->getPartner();

        return view('pages.report.index', ['sections' => $sections, 'partners' => $partners, 'reports' => []]);
    }
}
