<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\StationInfomation;
use App\Models\StationInfoLine;
use App\Models\Station;

class StationInfomationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $InfoType = [
        'from' => 'Master Info From',
        'to' => 'Master Info To'
    ];
    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>'
    ];

    public function index() {
        $info = StationInfomation::where('status', 'Y')->get();
        $info_status = $this->_Status;
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();

        return view('pages.station_infomations.index', ['s_info' => $info, 'info_status' => $info_status, 'stations' => $stations]);
    }

    public function create() {
        return view('pages.station_infomations.create');
    }

    public function edit(string $id = null) {
        $info = StationInfomation::find($id);

        if(is_null($info) || $info->status != 'Y') 
            return redirect()->route('stations-info-index')->withFail('This station infomation not exist.');

        return view('pages.station_infomations.edit', ['info' => $info]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'detail' => 'required'
        ]);
        
        //if(!$this->checkInfoName($request->name, $request->type)) 
            //return redirect()->route('stations-info-index')->withFail('Station infomation name is exist. Pleast check.');

        $info = StationInfomation::create([
            'name' => $request->name,
            'text' => $request->detail
        ]);

        if($info) {
            if($request->station_id !== '') $this->setInfoToStation($info->id, $request->station_id, $request->master_info);
            return redirect()->route('stations-info-index')->withSuccess('Station infomation created...');
        }
        else return redirect()->route('stations-info-index')->withFail('Something is wrong. Please try again.');
    }

    private function setInfoToStation($info_id, $station_id, $master_info) {
        StationInfoLine::create([
            'station_id' => $station_id,
            'station_infomation_id' => $info_id,
            'type' => $master_info
        ]);
    }

    private function checkInfoName(string $name = null, string $type = null, string $info_id = null) {
        $info = StationInfomation::where('name', $name)->where('type', $type)->where('status', 'Y')->where('id', '!=', $info_id)->first();
        if(isset($info)) return false;
        return true;
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'detail' => 'required'
        ]);

        if(!$this->checkInfoName($request->name, $request->type, $request->station_info_id)) return redirect()->route('stations-info-index')->withFail('Station infomation name is exist. Pleast check.');

        $info = StationInfomation::find($request->station_info_id);
        $info->name = $request->name;
        $info->type = $request->type;
        $info->text = $request->detail;

        if($info->save()) return redirect()->route('stations-info-index')->withSuccess('Station infomation updated...');
        else return redirect()->route('stations-info-index')->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        if($id) {
            $info = StationInfomation::find($id);
            $info_use = $info->type === 'from' ? $info->info_from : $info->info_to;

            if(isset($info_use)) 
                return redirect()->route('stations-info-index')->withWarning('Station infomation is in use. Can not delete this item...');

            $info->status = 'N';
            if($info->save()) return redirect()->route('stations-info-index')->withSuccess('Station infomation deleted...');
            else return redirect()->route('stations-info-index')->withFail('Something is wrong. Please try again.');
        }
        return redirect()->route('stations-info-index')->withFail('Something is wrong. Please try again.');
    }

    public function createStationInfo(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'detail' => 'required'
        ]);

        // Log::debug($request);
        
        if(!$this->checkInfoName($request->name, $request->type))
            return response()->json(['message' => 'Station infomation name is exist. Pleast check.', 'status' => 'dupplicate']);

        $info = StationInfomation::create([
            'name' => $request->name,
            'text' => $request->detail
        ]);

        if($info) {
            $result = $this->createStationInfoLine($request->station_id, $info->id, $request->station_type);
            if($result) return response()->json(['status' => 'success']);
        }
        return response()->json(['message' => 'Something is wrong. Please try again.', 'status' => 'fail']);
    }

    private function createStationInfoLine($station_id, $station_info_id, $type) {
        $info_line = StationInfoLine::create([
            'station_id' => $station_id,
            'station_infomation_id' => $station_info_id,
            'type' => $type
        ]);

        if($info_line) return true;
        return false;
    }

    public function getStationInfo() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->with('info_line')->get();
        // $info = StationInfoLine::where('station_id', $station_id)->where('type', $type)->with('info')->get();
        return response()->json(['data' => $stations, 'status' => 'success']);
    }
}
