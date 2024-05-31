<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\RouteAddons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Section;
use App\Models\StationInfomation;
use App\Models\StationInfoLine;
use Illuminate\Support\Facades\DB;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>',
    ];

    public static function avaliableStation()
    {
        $sql = 'select s.id,s.name,s.piername,s.nickname from stations s join routes r on s.id = r.station_from_id left join sections sec on s.section_id = sec.id where r.isactive ="Y" group by s.id,s.name,s.piername,s.nickname order by sec.sort ASC,s.sort ASC';
        $stationFroms = DB::select($sql);

        $sql = 'select s.id,s.name,s.piername,s.nickname from stations s join routes r on s.id = r.station_to_id left join sections sec on s.section_id = sec.id where r.isactive ="Y" group by s.id,s.name,s.piername,s.nickname order by sec.sort ASC,s.sort ASC';
        $stationTos = DB::select($sql);

        return [
            'station_from' => json_decode(json_encode($stationFroms), true),
            'station_to' => json_decode(json_encode($stationTos), true),
        ];
    }

    public function index()
    {
        //$stations = Station::where('status', 'CO')->with(['image'])->orderBy('section_id', 'ASC')->orderBy('sort', 'ASC')->get();
        $sections = Section::with(['stations'])->orderBy('sort', 'ASC')->get();
        //$info = StationInfomation::where('status', 'Y')->get();
        $status = $this->_Status;

        //dd($sections);
        return view('pages.stations.index', ['sections' => $sections, 'status' => $status]);
    }

    public function create()
    {
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
        $info = StationInfomation::where('status', 'Y')->get();

        return view('pages.stations.create', ['sections' => $sections, 'info' => $info]);
    }

    public function edit(string $id = null)
    {

        $station = Station::where('id', $id)->with(['image'])->first();
        $maxSeq = $this->getMaxSortBySection($station->section_id);

        $station->info_line;
        $sections = Section::orderBy('created_at', 'DESC')->get();
        $info = StationInfomation::where('status', 'Y')->get();

        return view('pages.stations.edit', ['station' => $station, 'sections' => $sections, 'info' => $info, 'maxSeq' => $maxSeq]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'piername' => 'string|nullable',
            'nickname' => 'required|string|unique:stations',
            'section_id' => 'required|string',
            'thai_name' => 'required|string'
        ]);

        //dd($request);

        $maxSeq = $this->getMaxSortBySection($request->section);
        $station = Station::create($request->all());
        $station->sort = $maxSeq+1;
        $station->save();

        if ($station) {
            /*
            if ($request->station_info_from_list != '')
                $this->storeInfoLine($station->id, $request->station_info_from_list, 'from');
            if ($request->station_info_to_list != '')
                $this->storeInfoLine($station->id, $request->station_info_to_list, 'to');
            */


            //check has image
            if ($request->hasFile('image_file')) {
                $imageHelper = new ImageHelper();
                $image = $imageHelper->upload($request->image_file, 'station');

                $station->image_id = $image->id;
                $station->save();

            }
            return redirect()->route('stations-index')->withSuccess(sprintf('Create Station "%s"', $request->name));
        } else
            return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
    }

    private function storeInfoLine(string $station_id = null, string $info = null, string $type = null)
    {
        $_info = preg_split('/\,/', $info);

        foreach ($_info as $item) {
            StationInfoLine::create([
                'station_id' => $station_id,
                'station_infomation_id' => $item,
                'type' => $type,
            ]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'piername' => 'nullable|string',
            'nickname' => 'required|string',
            'section_id' => 'required|string',
            'sort' => 'required|integer',
            'thai_name' => 'required|string'
        ]);

        $station = Station::find($request->id);
        $oldStation = clone $station;

        if (isset($station)) {
            $oldSort = $station->sort;
            $station->update($request->all());

            if ($station->save()) {
                //check update sort
                if ($oldSort != $request->sort) {
                    $maxSeq = $this->getMaxSortBySection($request->section_id,($request->sort>$oldSort?'ASC':'DESC'));
                }
                //check has image
                $imageHelper = new ImageHelper();
                if ($request->isremoveimage == 'Y') {
                    $imageHelper->delete($station->image_id);
                    $station->image_id = null;
                    $station->save();
                }

                if ($request->hasFile('image_file')) {
                    $image = $imageHelper->upload($request->image_file, 'station');

                    $station->image_id = $image->id;
                    $station->save();

                }

                //update route info
                $routeFroms = DB::table('routes')->select('id')->where('station_from_id',$station->id);
                $routeTos = DB::table('routes')->select('id')->where('station_to_id',$station->id);

                //Log::debug($oldStation);
                //Log::debug($station);
                if($oldStation->master_from != $station->master_from){
                    Route::where('station_from_id',$station->id)->update(['master_from'=>$station->master_from]);
                }
                if($oldStation->master_to != $station->master_to){
                    Route::where('station_to_id',$station->id)->update(['master_to'=>$station->master_to]);
                }

                $shuttle_bus = [];
                if($oldStation->shuttle_bus_price != $station->shuttle_bus_price){
                    $shuttle_bus['price'] = $station->shuttle_bus_price;
                }
                if($oldStation->shuttle_bus_mouseover != $station->shuttle_bus_mouseover){
                    $shuttle_bus['mouseover'] = $station->shuttle_bus_mouseover;
                }
                if($oldStation->shuttle_bus_text != $station->shuttle_bus_text){
                    $shuttle_bus['message'] = $station->shuttle_bus_text;
                }

                if(sizeof($shuttle_bus)>0){
                    RouteAddons::whereIn('route_id',$routeFroms)->where('type','shuttle_bus')->where('subtype','from')->update($shuttle_bus);

                    RouteAddons::whereIn('route_id',$routeTos)->where('type','shuttle_bus')->where('subtype','to')->update($shuttle_bus);
                }


                $private_taxi = [];
                if($oldStation->private_taxi_price != $station->private_taxi_price){
                    $private_taxi['price'] = $station->private_taxi_price;
                }
                if($oldStation->private_taxi_mouseover != $station->private_taxi_mouseover){
                    $private_taxi['mouseover'] = $station->private_taxi_mouseover;
                }
                if($oldStation->private_taxi_text != $station->private_taxi_text){
                    $private_taxi['message'] = $station->private_taxi_text;
                }

                if(sizeof($private_taxi)>0){
                    RouteAddons::whereIn('route_id',$routeFroms)->where('type','private_taxi')->where('subtype','from')->update($private_taxi);

                    RouteAddons::whereIn('route_id',$routeTos)->where('type','private_taxi')->where('subtype','to')->update($private_taxi);
                }


                $longtail  = [];
                if($oldStation->longtail_boat_price != $station->longtail_boat_price){
                    $longtail['price'] = $station->longtail_boat_price;
                }
                if($oldStation->longtail_boat_mouseover != $station->longtail_boat_mouseover){
                    $longtail['mouseover'] = $station->longtail_boat_mouseover;
                }
                if($oldStation->longtail_boat_text != $station->longtail_boat_text){
                    $longtail['message'] = $station->longtail_boat_text;
                }

                if(sizeof($longtail)>0){
                    RouteAddons::whereIn('route_id',$routeFroms)->where('type','longtail_boat')->where('subtype','from')->update($longtail);

                    RouteAddons::whereIn('route_id',$routeTos)->where('type','longtail_boat')->where('subtype','to')->update($longtail);
                }


                return redirect()->route('stations-index')->withSuccess('Station updated...');
            } else
                return redirect()->route('stations-index')->withFail('Something is wrong. Please try again.');
        }

        return redirect()->route('stations-index')->withFail('Station record not exist. Please check.');
    }

    private function clearAllInfoLine(string $station_id = null)
    {
        StationInfoLine::where('station_id', $station_id)->delete();
    }

    public function destroy(string $id = null)
    {
        $station = Station::where('id', $id)->with(['stationFrom', 'image'])->first();

        //Check use on routes
        if (sizeof($station->stationFrom) > 0) {
            //$station->status = 'VO';
            $station->isactive = 'N';
            $station->save();

            return redirect()->route('stations-index')->withSuccess('this station used in other Route, just disable this Station');
        } else {
            //check has image
            if (isset($station->image->path)) {
                $imageHelper = new ImageHelper();
                $imageHelper->delete($station->image_id);
            }

            //StationInfomation::where('station_id',$id)->delete();
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


    private function getMaxSortBySection($section_id,$sort = 'DESC')
    {
        $stations = Station::where('section_id', $section_id)
            ->with('section')
            ->orderBy('sort', 'ASC')
            ->orderBy('updated_at', $sort)
            ->get();


        foreach ($stations as $index => $station) {
            //$sectionSeq = $station->section->sort;
            //$sectionSeq = $sectionSeq*10;

            $station->sort = ($index + 1);
            $station->save();
        }

        return sizeof($stations);
    }

    public function updateStatus($id) {
        $station = Station::find($id);
        $station->isactive = $station->isactive == 'Y' ? 'N' : 'Y';

        if($station->save()) {
            return response()->json(['result' => true, 'station' => $station->name], 200);
        }
        return response()->json(['result' => false, 'station' => $station->name], 200);
    }
}
