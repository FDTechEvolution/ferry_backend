<?php

namespace App\Http\Controllers;

use App\Models\Route;
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
        $sql = 'select s.id,s.name,s.piername,s.nickname from stations s join routes r on s.id = r.station_from_id left join sections sec on s.section_id = sec.id where r.isactive ="Y" group by s.id,s.name,s.piername,s.nickname order by sec.name ASC,s.name ASC';
        $stationFroms = DB::select($sql);

        $sql = 'select s.id,s.name,s.piername,s.nickname from stations s join routes r on s.id = r.station_to_id left join sections sec on s.section_id = sec.id where r.isactive ="Y" group by s.id,s.name,s.piername,s.nickname order by sec.name ASC,s.name ASC';
        $stationTos = DB::select($sql);

        return [
            'station_from' => json_decode(json_encode($stationFroms), true),
            'station_to' => json_decode(json_encode($stationTos), true),
        ];
    }

    public function index()
    {
        //$stations = Station::where('status', 'CO')->with(['image'])->orderBy('section_id', 'ASC')->orderBy('sort', 'ASC')->get();
        $sections = Section::where('isactive', 'Y')->with(['stations'])->orderBy('seq', 'ASC')->get();
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

    public function sectionCreate()
    {
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();

        return view('pages.stations.section_create', ['sections' => $sections]);
    }

    public function sectionManage()
    {
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();

        return view('pages.stations.section_manage', ['sections' => $sections]);
    }

    public function edit(string $id = null)
    {

        $station = Station::where('id', $id)->with(['image'])->first();
        $maxSeq = $this->getMaxSortBySection($station->section_id);

        $station->info_line;
        $sections = Section::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();
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
        ]);

        $station = Station::find($request->id);

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

                /*
                $this->clearAllInfoLine($station->id);
                if ($request->station_info_from_list != '')
                    $this->storeInfoLine($station->id, $request->station_info_from_list, 'from');
                if ($request->station_info_to_list != '')
                    $this->storeInfoLine($station->id, $request->station_info_to_list, 'to');
                */
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

    private function getMaxSortBySection($section_id,$sort = 'DESC')
    {
        $stations = Station::where('section_id', $section_id)
            ->orderBy('sort', 'ASC')
            ->orderBy('updated_at', $sort)
            ->get();


        foreach ($stations as $index => $station) {
            $station->sort = ($index + 1);
            $station->save();
        }

        return sizeof($stations);
    }
}