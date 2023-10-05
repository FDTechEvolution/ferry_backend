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
        $meals = Addon::where('type', $this->Type)->where('status', 'CO')->with('image')->get();
        return view('pages.meals.index', ['meals' => $meals]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        if($this->checkNameDupplicate($request->name)) {
            $image_id = null;
            // $icon_id = null;
            if ($request->hasFile('file_picture')) {
                $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
            }
            // if($request->hasFile('file_icon')) {
            //     $icon_id = $this->storeImage($request->file('file_icon'), $this->PathIcon);
            // }

            $addon = Addon::create([
                'code' => Str::random(6),
                'name' => $request->name,
                'type' => $this->Type,
                'isactive' => true,
                'amount' => $request->price,
                'description' => $request->detail,
                'image_id' => $image_id,
                'image_icon' => $request->icon,
                'is_route_station' => isset($request->route_station) ? 'Y' : 'N',
                'is_main_menu' => isset($request->main_menu) ? 'Y' : 'N',
            ]);

            if($addon) return redirect()->route('meals-index')->withSuccess('Meal created...');
            else return redirect()->route('meals-index')->withFail('Something is wrong. Please try again.');
        }

        return redirect()->route('meals-index')->withFail('Meal name is exist.');
    }

    private function checkNameDupplicate($name) {
        $meal = Addon::where('name', $name)->where('type', $this->Type)->where('status', 'CO')->first();
        if(isset($meal)) return false;
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

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $meal = Addon::find($request->id);
        $image = $meal->image;
        $icon = $meal->icon;
        
        $image_id = null;
        $icon_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
            if($meal->image_id != '') $this->isDeleteImage($meal->id, $meal->image_id, $image->path, $image->name, 'image');
        }
        // if($request->hasFile('file_icon')) {
        //     $icon_id = $this->storeImage($request->file('file_icon'), $this->PathIcon);
        //     if($meal->image_icon_id != '') $this->isDeleteImage($meal->id, $meal->image_icon_id, $image->path, $image->name, 'icon');
        // }

        if(!$request->_image && $image_id == null) $this->isDeleteImage($meal->id, $meal->image_id, $image->path, $image->name, 'image');
        // if(!$request->_icon && $icon_id == null) $this->isDeleteImage($meal->id, $meal->image_icon_id, $icon->path, $icon->name, 'icon');

        $meal->name = $request->name;
        $meal->amount = $request->price;
        $meal->description = $request->detail;
        if($image_id != null) $meal->image_id = $image_id;
        $meal->image_icon = $request->icon;
        $meal->is_route_station = isset($request->route_station) ? 'Y' : 'N';
        $meal->is_main_menu = isset($request->main_menu) ? 'Y' : 'N';
        // if($icon_id != null) $meal->image_icon_id = $icon_id;

        if($meal->save()) return redirect()->route('meals-index')->withSuccess('Meal updated...');
        else return redirect()->route('meals-index')->withFail('Something is wrong. Please try again.');
    }

    private function isDeleteImage($meal_id, $image_id, $path, $name, $type) {
        $image = Image::find($image_id)->delete();
        if($image) {
            unlink(public_path().$path.'/'.$name);
            $meal = Addon::find($meal_id);
            if($type == 'image') $meal->image_id = NULL;
            if($type == 'icon') $meal->image_icon_id = NULL;
            $meal->save();
        }
    }

    public function destroy(string $id = null) {
        $meal = Addon::find($id);
        $meal->status = 'VO';
        if($meal->save()) return redirect()->route('meals-index')->withSuccess('Meal deleted...');
        return redirect()->route('meals-index')->withFail('Something is wrong. Please try again.');
    }

    public function uploadIcon(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'file_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        if($request->hasFile('file_icon')) {
            $json_icon = file_get_contents(public_path('/assets/images/meal/icon.json'));
            $current_icon = json_decode($json_icon, true);

            $checkName = true;
            foreach($current_icon as $icon) {
                if($icon['name'] == $request->name) $checkName = false;
            }

            if($checkName) {
                $slug_image = $this->storeIcon($request->file('file_icon'), $this->PathIcon);
                $new_icon = [
                    "name" => $request->name,
                    "path" => '..'.$this->PathIcon.'/',
                    "icon" => $slug_image
                ];

                array_push($current_icon, $new_icon);
                $update_icon = json_encode($current_icon, JSON_PRETTY_PRINT);
                file_put_contents(public_path('/assets/images/meal/icon.json'), stripslashes($update_icon));

                return response(['message' => 'Icon uploaded.', 'status' => 'success']);
            }
            return response(['message' => 'Icon Name is exist.', 'status' => 'fail']);
        }

        return response(['message' => 'No icon upload.', 'status' => 'fail']);
    }

    public function destroyIcon(Request $request) {
        $json_icon = file_get_contents(public_path('/assets/images/meal/icon.json'));
        $current_icon = json_decode($json_icon, true);
        $is_icon = $current_icon[$request->key];

        if(!$this->iconCheckUsed($is_icon['icon'])) return response(['message' => 'Icon has use. Can not delete this icon.', 'status' => 'fail']);

        array_splice($current_icon, $request->key, 1);
        $update_icon = json_encode($current_icon, JSON_PRETTY_PRINT);
        file_put_contents(public_path('/assets/images/meal/icon.json'), stripslashes($update_icon));
        unlink(public_path().$this->PathIcon.'/'.$is_icon['icon']);

        return response(['message' => 'Icon deleted.', 'status' => 'success']);
    }

    private function storeIcon($image, $path) {
        $slug_image = time().'.'.$image->getClientOriginalExtension();

        $image->move(public_path($path), $slug_image);
        return $slug_image;
    }

    private function iconCheckUsed($icon) {
        $meal = Addon::where('image_icon', $icon)->first();
        if(isset($meal)) return false;
        return true;
    }
}
