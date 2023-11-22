<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Addon;
use App\Models\Activity;
use App\Models\Image;
use App\Models\Icon;

class ActivitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $PathImage = '/image/activity';
    protected $PathIcon = '/icon/activity';
    protected $Type = 'activity';
    protected $AddonType = 'ACTV';

    public static function getActivities($isactive = 'Y')
    {
        $activites = Activity::where('status', 'CO')
            ->get();
        
        return $activites;
    }



    public function index() {
        // $activity = Activity::where('status', 'CO')->get();
        $activity = Addon::where('type', $this->AddonType)->where('status', 'CO')->get();

        return view('pages.activities.index', ['activities' => $activity]);
    }

    public function create() {
        $icons = Icon::where('type', $this->Type)->get();

        return view('pages.activities.create', ['icons' => $icons]);
    }

    public function edit(string $id = null) {
        $activity = Addon::find($id);

        if(is_null($activity) || $activity->status != 'CO') 
            return redirect()->route('activity-index')->withFail('This activity not exist.');

        $activity->image;
        $activity->icon;

        return view('pages.activities.edit', ['activity' => $activity]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $image_id = null;
        $icon_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
        }
        if($request->hasFile('file_icon')) {
            $icon_id = $this->storeImage($request->file('file_icon'), $this->PathIcon);
        }

        $activity = Addon::create([
            'name' => $request->name,
            'code' => Str::random(6),
            'amount' => $request->price,
            'type' => $this->AddonType,
            'description' => $request->detail,
            'isactive' => 'Y',
            'image_id' => $image_id,
            'image_icon_id' => $icon_id,
            'is_route_station' => isset($request->route_station) ? 'Y' : 'N',
            'is_main_menu' => isset($request->main_menu) ? 'Y' : 'N',
        ]);

        if($activity) 
            return redirect()->route('activity-index')->withSuccess(sprintf('Create Activity "%s"', $request->name));
        else 
            return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $activity = Addon::find($request->id);
        $current_image = null;
        $current_icon = null;
        if($request->current_image == '') $this->removeImage($activity->image_id);
        else $current_image = $request->current_image;

        if($request->current_icon == '') $this->removeImage($activity->image_icon_id);
        else $current_icon = $request->current_icon;

        $image_id = null;
        $icon_id = null;
        if($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
            if($current_image != null) $this->removeImage($activity->image_id);
        }

        if($request->hasFile('file_icon')) {
            $icon_id = $this->storeImage($request->file('file_icon'), $this->PathIcon);
            if($current_icon != null) $this->removeImage($activity->image_icon_id);
        }

        $activity->name = $request->name;
        $activity->amount = $request->price;
        $activity->description = $request->detail;
        $activity->image_id = $image_id ?: $current_image;
        $activity->image_icon_id = $icon_id ?: $current_icon;
        $activity->is_route_station = isset($request->route_station) ? 'Y' : 'N';
        $activity->is_main_menu = isset($request->main_menu) ? 'Y' : 'N';

        if($activity->save())
            return redirect()->route('activity-index')->withSuccess(sprintf('Update Activity "%s"', $request->name));
        else
            return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        $activity = Addon::find($id);
        $activity->status = 'VO';
        $activity->isactive = 'N';

        if($activity->save())
            return redirect()->route('activity-index')->withSuccess(sprintf('Deleted Activity "%s"', $activity->name));
        else
            return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    private function checkNameDupplicate(string $name = null, string $activity_id = null) {
        $activity = Activity::where('name', $name)->where('id', '!=', $activity_id)->first();
        if(isset($activity)) return false;
        return true;
    }

    private function storeImage($image, $path) {
        $slug_image = time().'.'.$image->getClientOriginalExtension();

        $img = Image::create([
            'path' => $path,
            'name' => $slug_image
        ]);

        if($img) {
            $image->move(public_path($path), $slug_image);
            return $img->id;
        }
    }

    private function removeImage($image_id) {
        $image = Image::find($image_id);
        if($image) {
            unlink(public_path().$image->path.'/'.$image->name);
            $image->delete();
        }
    }
}
