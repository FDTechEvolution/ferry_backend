<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Activity;
use App\Models\Image;
use App\Models\Icon;

class ActivitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $PathImage = '/assets/images/activity';
    protected $Type = 'activity';

    public function index() {
        $activity = Activity::where('status', 'CO')->get();

        return view('pages.activities.index', ['activities' => $activity]);
    }

    public function create() {
        $icons = Icon::where('type', $this->Type)->get();

        return view('pages.activities.create', ['icons' => $icons]);
    }

    public function edit(string $id = null) {
        $activity = Activity::find($id);

        if(is_null($activity) || $activity->status != 'CO') 
            return redirect()->route('activity-index')->withFail('This activity not exist.');
            
        $activity->image;
        return view('pages.activities.edit', ['activity' => $activity]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        if(!$this->checkNameDupplicate($request->name))
            return redirect()->back()->withFail('Activity name is exist. Please check.');

        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
        }

        $activity = Activity::create([
            'name' => $request->name,
            'price' => $request->price,
            'detail' => $request->detail,
            'image_id' => $image_id
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
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        if(!$this->checkNameDupplicate($request->name, $request->id))
            return redirect()->back()->withFail('Activity name is exist. Please check.');

        $activity = Activity::find($request->id);
        $current_image = null;
        if($request->current_image == '')
            $this->removeImage($activity->image_id);
        else
            $current_image = $request->current_image;

        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
            if($current_image != null) {
                $this->removeImage($activity->image_id);
            }
        }

        $activity->name = $request->name;
        $activity->price = $request->price;
        $activity->detail = $request->detail;
        $activity->image_id = $image_id != null ? $image_id : $current_image;

        if($activity->save())
            return redirect()->route('activity-index')->withSuccess(sprintf('Update Activity "%s"', $request->name));
        else
            return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        $activity = Activity::find($id);
        $activity->status = 'VO';

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
        Log::debug($image);
        if($image) {
            unlink(public_path().$image->path.'/'.$image->name);
            $image->delete();
        }
    }
}
