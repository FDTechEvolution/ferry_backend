<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Section;

class StationsController extends Controller
{
    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $stations = Station::where('status', 'CO')->orderBy('sort', 'ASC')->get();
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        $status = $this->_Status;

        return view('pages.stations.index', ['stations' => $stations, 'sections' => $sections, 'status' => $status]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'pier' => 'string',
            'nickname' => 'required|string',
            'section' => 'required|string',
            'sort' => 'required|integer'
        ]);

        $station = Station::create([
            'name' => $request->name,
            'piername' => $request->pier,
            'nickname' => $request->nickname,
            'isactive' => isset($request->isactive) ? 'Y' : 'N',
            'section_id' => $request->section,
            'sort' => $request->sort
        ]);

        if($station) return redirect()->route('stations-index')->withSuccess('Station created...');
        else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'pier' => 'string',
            'nickname' => 'required|string',
            'section' => 'required|string',
            'sort' => 'required|integer'
        ]);

        $station = Station::find($request->edit_id);
        if(isset($station)) {
            $station->name = $request->name;
            $station->piername = $request->pier;
            $station->nickname = $request->nickname;
            $station->section_id = $request->section;
            $station->sort = $request->sort;
            $station->isactive = isset($request->isactive) ? 'Y' : 'N';

            if($station->save()) return redirect()->route('stations-index')->withSuccess('Station updated...');
            else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
        }

        return redirect()->route('stations-index')->withFail('Station record not exist. Please check again.');
    }

    public function destroy(string $id = null) {
        $station = Station::find($id);
        $station->status = 'VO';
        $station->isactive = 'N';
        if($station->save()) return redirect()->route('stations-index')->withSuccess('Station deleted...');
        else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
    }

    public function storeSection(Request $request) {
        $request->validate([
            'name' => 'required|string',
        ]);

        if($this->checkSectionName($request->name)) {
            $section = Section::create(['name' => $request->name]);
            if($section) return redirect()->route('stations-index')->withSuccess('Section created...');
            else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
        }
        return redirect()->route('stations-index')->withFail('Section name is exist.');
    }

    public function updateSection(Request $request) {
        $request->validate([
            'name' => 'required|string',
        ]);

        if($this->checkSectionName($request->name)) {
            $section = Section::find($request->section_id);
            if(isset($section)) {
                $section->name = $request->name;
                if($section->save()) return redirect()->route('stations-index')->withSuccess('Section created...');
                else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
            }
            return redirect()->route('stations-index')->withFail('Section record not exist. Please check again.');
        }
        return redirect()->route('stations-index')->withFail('Section name is exist.');
    }

    public function destroySection(string $id = null) {
        $section = Section::find($id);
        $section->isactive = 'N';
        if($section->save()) return redirect()->route('stations-index')->withSuccess('Section deleted...');
        else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
    }

    private function checkSectionName($name) {
        $section = Section::where('name', $name)->where('isactive', 'Y')->first();
        if(isset($section)) return false;
        return true;
    }
}
