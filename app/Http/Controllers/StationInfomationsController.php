<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\StationInfomation;

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

        return view('pages.station_infomations.index', ['s_info' => $info, 'info_status' => $info_status]);
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
        
        if(!$this->checkInfoName($request->name, $request->type)) return redirect()->route('stations-info-index')->withFail('Station infomation name is exist. Pleast check.');

        $info = StationInfomation::create([
            'name' => $request->name,
            'text' => $request->detail
        ]);

        if($info) return redirect()->route('stations-info-index')->withSuccess('Station infomation created...');
        else return redirect()->route('stations-info-index')->withFail('Something is wrong. Please try again.');
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
}
