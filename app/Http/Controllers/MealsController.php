<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Addon;
use App\Models\Image;

class MealsController extends Controller
{
    protected $Type = 'MEAL';
    protected $PathImage = '/assets/images/meal';
    protected $PathIcon = '/assets/images/meal/icon';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $meals = Addon::where('type', $this->Type)->where('isactive', true)->with('image', 'icon')->get();
        return view('pages.meals.index', ['meals' => $meals]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'detail' => 'string',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $image_id = null;
        $icon_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
        }
        if($request->hasFile('file_icon')) {
            $icon_id = $this->storeImage($request->file('file_icon'), $this->PathIcon);
        }

        $addon = Addon::create([
            'code' => Str::random(6),
            'name' => $request->name,
            'type' => $this->Type,
            'isactive' => true,
            'amount' => $request->price,
            'description' => $request->detail,
            'image_id' => $image_id,
            'image_icon_id' => $icon_id
        ]);

        if($addon) return redirect()->route('meals-index')->withSuccess('Meal created...');
        else return redirect()->route('meals-index')->withFail('Something is wrong. Please try again.');
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

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'detail' => 'string',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $meal = Addon::find($request->id);
        $image = $meal->image;
        $icon = $meal->icon;
        
        $image_id = null;
        $icon_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
            if($meal->image_id != '') unlink(public_path().$image->path.'/'.$image->name);
        }
        if($request->hasFile('file_icon')) {
            $icon_id = $this->storeImage($request->file('file_icon'), $this->PathIcon);
            if($meal->image_icon_id != '') unlink(public_path().$icon->path.'/'.$icon->name);
        }

        $meal->name = $request->name;
        $meal->amount = $request->price;
        $meal->description = $request->detail;
        if($image_id != null) $meal->image_id = $image_id;
        if($icon_id != null) $meal->image_icon_id = $icon_id;

        if($meal->save()) return redirect()->route('meals-index')->withSuccess('Meal updated...');
        else return redirect()->route('meals-index')->withFail('Something is wrong. Please try again.');
    }

    private function isDeleteImage() {
        
    }
}
