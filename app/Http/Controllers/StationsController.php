<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Section;
use App\Models\StationInfomation;
use App\Models\StationInfoLine;

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

    public function index()
    {
        $stations = Station::where('status', 'CO')->orderBy('section_id', 'ASC')->orderBy('sort', 'ASC')->get();
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        $info = StationInfomation::where('status', 'Y')->get();
        $status = $this->_Status;

        return view('pages.stations.index', ['stations' => $stations, 'sections' => $sections, 'status' => $status, 'info' => $info]);
    }

    public function create() {
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        $info = StationInfomation::where('status', 'Y')->get();

        return view('pages.stations.create', ['sections' => $sections, 'info' => $info]);
    }

    public function sectionCreate() {
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        
        return view('pages.stations.section_create', ['sections' => $sections]);
    }

    public function sectionManage() {
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        
        return view('pages.stations.section_manage', ['sections' => $sections]);
    }

    public function edit(string $id = null) {
        $station = Station::find($id);
        $station->info_line;
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        $info = StationInfomation::where('status', 'Y')->get();

        return view('pages.stations.edit', ['station' => $station, 'sections' => $sections, 'info' => $info]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'pier' => 'string|nullable',
            'nickname' => 'required|string',
            'section' => 'required|string',
            'sort' => 'required|integer'
        ]);

        /*
        if (!$this->checkStationName($request->name))
            return redirect()->route('stations-index')->withFail('Station name is exist. Please check.');
        */
        if (!$this->checkNickname($request->nickname))
            return redirect()->route('stations-index')->withFail('Station nickname is exist. Please check.');

        $station = Station::create([
            'name' => $request->name,
            'piername' => $request->pier,
            'nickname' => $request->nickname,
            'isactive' => isset($request->isactive) ? 'Y' : 'N',
            'section_id' => $request->section,
            'sort' => $request->sort
        ]);

        if ($station) {
            if($request->station_info_from_list != '') $this->storeInfoLine($station->id, $request->station_info_from_list, 'from');
            if($request->station_info_to_list != '') $this->storeInfoLine($station->id, $request->station_info_to_list, 'to');
            return redirect()->route('stations-index')->withSuccess(sprintf('Create Station "%s"',$request->name));
        }
        else
            return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
    }

    private function storeInfoLine(string $station_id = null, string $info = null, string $type = null) {
        $_info = preg_split('/\,/', $info);

        foreach($_info as $item) {
            StationInfoLine::create([
                'station_id' => $station_id,
                'station_infomation_id' => $item,
                'type' => $type
            ]);
        }
    }

    private function checkStationName(string $name = null, string $station_id = null)
    {
        $station = Station::where('name', $name)->where('id', '!=', $station_id)->where('status', 'CO')->first();
        if (isset($station))
            return false;
        return true;
    }

    private function checkNickname(string $nickname = null, string $station_id = null)
    {
        $station = Station::where('nickname', $nickname)->where('id', '!=', $station_id)->where('status', 'CO')->first();
        if (isset($station))
            return false;
        return true;
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'pier' => 'string',
            'nickname' => 'required|string',
            'section' => 'required|string',
            'sort' => 'required|integer',
            'info_from' => 'string|nullable',
            'info_to' => 'string|nullable'
        ]);

        if (!$this->checkStationName($request->name, $request->id))
            return redirect()->route('stations-index')->withFail('Station name is exist. Please check.');

        if (!$this->checkNickname($request->nickname, $request->id))
            return redirect()->route('stations-index')->withFail('Station nickname is exist. Please check.');

        $station = Station::find($request->id);
        if (isset($station)) {
            $station->name = $request->name;
            $station->piername = $request->pier;
            $station->nickname = $request->nickname;
            $station->section_id = $request->section;
            $station->station_infomation_from_id = $request->info_from;
            $station->station_infomation_to_id = $request->info_to;
            $station->sort = $request->sort;
            $station->isactive = isset($request->isactive) ? 'Y' : 'N';

            if ($station->save()) {
                $this->clearAllInfoLine($station->id);
                if($request->station_info_from_list != '') $this->storeInfoLine($station->id, $request->station_info_from_list, 'from');
                if($request->station_info_to_list != '') $this->storeInfoLine($station->id, $request->station_info_to_list, 'to');
                return redirect()->route('stations-index')->withSuccess('Station updated...');
            }
            else
                return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
        }

        return redirect()->route('stations-index')->withFail('Station record not exist. Please check.');
    }

    private function clearAllInfoLine(string $station_id = null) {
        StationInfoLine::where('station_id', $station_id)->delete();
    }

    public function destroy(string $id = null)
    {
        $station = Station::find($id);

        //Check used
        if (false) {
            $station->status = 'VO';
            $station->isactive = 'N';

            if ($station->save()){
                return redirect()->route('stations-index')->withSuccess('Station deleted...');
            }else{
                return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
            }
        } else {
            $station->forceDelete();

            return redirect()->route('stations-index')->withSuccess('Station deleted...');
        }
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        if ($this->checkSectionName($request->name)) {
            $section = Section::create(['name' => $request->name]);
            if ($section)
                return redirect()->route('manage-section')->withSuccess('Section created...');
            else
                return redirect()->route('create-section')->withFail('Something is wrong. Please try again.');
        }
        return redirect()->route('create-section')->withFail('Section name is exist.');
    }

    public function updateSection(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        if ($this->checkSectionName($request->name, $request->section_id)) {
            $section = Section::find($request->section_id);
            if (isset($section)) {
                $section->name = $request->name;
                if ($section->save())
                    return redirect()->route('manage-section')->withSuccess('Section created...');
                else
                    return redirect()->route('manage-section')->withFail('Something is wrong. Please try again.');
            }
            return redirect()->route('manage-section')->withFail('Section record not exist. Please check again.');
        }
        return redirect()->route('manage-section')->withFail('Section name is exist.');
    }

    public function destroySection(string $id = null)
    {
        $section = Section::find($id);
        $_station = $section->station;
        if (!isset($_station)) {
            $section->isactive = 'N';
            if ($section->save())
                return redirect()->route('manage-section')->withSuccess('Section deleted...');
            else
                return redirect()->route('manage-section')->withFail('Something is wrong. Please try again.');
        }
        return redirect()->route('manage-section')->withWarning('Section is in use. Can not delete this item...');
    }

    private function checkSectionName(string $name = null, string $section_id = null)
    {
        $section = Section::where('name', $name)->where('id', '!=', $section_id)->where('isactive', 'Y')->first();
        if (isset($section))
            return false;
        return true;
    }
}