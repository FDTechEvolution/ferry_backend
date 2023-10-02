<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Section;

class StationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>'
    ];

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

        if($this->checkStationName($request->name)) {
            if($this->checkNickname($request->nickname)) {
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
            return redirect()->route('stations-index')->withFail('Station name is exist. Please check.');
        }
        return redirect()->route('stations-index')->withFail('Station nickname is exist. Please check.');
    }

    private function checkStationName(string $name = null, string $station_id = null) {
        $station = Station::where('name', $name)->where('id', '!=', $station_id)->where('status', 'CO')->first();
        if(isset($station)) return false;
        return true;
    }

    private function checkNickname(string $nickname = null, string $station_id = null) {
        $station = Station::where('nickname', $nickname)->where('id', '!=', $station_id)->where('status', 'CO')->first();
        if(isset($station)) return false;
        return true;
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'pier' => 'string',
            'nickname' => 'required|string',
            'section' => 'required|string',
            'sort' => 'required|integer'
        ]);

        if($this->checkStationName($request->name, $request->edit_id)) {
            if($this->checkNickname($request->nickname, $request->edit_id)) {
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

                return redirect()->route('stations-index')->withFail('Station record not exist. Please check.');
            }
        }
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

        if($this->checkSectionName($request->name, $request->section_id)) {
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
        $_station = $section->station;
        if(!isset($_station)) {
            $section->isactive = 'N';
            if($section->save()) return redirect()->route('stations-index')->withSuccess('Section deleted...');
            else return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
        }
        return redirect()->route('stations-index')->withWarning('Section is in use. Can not delete this item...');
    }

    private function checkSectionName(string $name = null, string $section_id = null) {
        $section = Section::where('name', $name)->where('id', '!=', $section_id)->where('isactive', 'Y')->first();
        if(isset($section)) return false;
        return true;
    }
}
