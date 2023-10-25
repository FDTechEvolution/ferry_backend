<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\RouteMap;
use App\Models\Image;

class RouteMapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $ImagePath = '/assets/images/route_map';
    protected $BannerPath = '/assets/images/route_map/banner';
    protected $ThumbPath = '/assets/images/route_map/thumb';

    public function index() {
        $route_maps = RouteMap::where('status', 'CO')->orderBy('sort', 'ASC')->with('banner', 'thumb')->get();

        return view('pages.route_map.index', ['route_maps' => $route_maps]);
    }

    public function store(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_banner' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_thumb' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $banner_id = null;
        $thumb_id = null;

        $image_id = $this->storeImage($request->file_picture, $this->ImagePath);
        if($request->hasFile('file_banner'))
            $banner_id = $this->storeImage($request->file_banner, $this->BannerPath);

        if($request->hasFile('file_thumb'))
            $thumb_id = $this->storeImage($request->file_thumb, $this->ThumbPath);

        if($request->sort == '')
            $_sort = RouteMap::where('status', 'CO')->max('sort');

        $route_map = RouteMap::create([
            'detail' => $request->detail,
            'sort' => $request->sort != '' ? $request->sort : $_sort+1,
            'image_id' => $image_id,
            'image_banner_id' => $banner_id,
            'image_thumb_id' => $thumb_id
        ]);

        if($route_map) return redirect()->route('route-map-index')->withSuccess('Route map created.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_banner' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_thumb' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        Log::debug($request);

        $image_id = null;
        $banner_id = null;
        $thumb_id = null;

        $route_map = RouteMap::find($request->route_map_id);
        $route_map->image;
        $route_map->banner;
        $route_map->thumb;
        
        // check upload new image
        if($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file_picture, $this->ImagePath);
            $this->destroyImage($route_map->image_id, $route_map->image);
        }
        if($request->hasFile('file_banner')) {
            $banner_id = $this->storeImage($request->file_banner, $this->BannerPath);
            if($route_map->image_banner_id != null) $this->destroyImage($route_map->image_banner_id, $route_map->banner);
        }
        if($request->hasFile('file_thumb')) {
            $thumb_id = $this->storeImage($request->file_thumb, $this->ThumbPath);
            if($route_map->image_thumb_id != null) $this->destroyImage($route_map->image_thumb_id, $route_map->thumb);
        }
        // end check upload new image

        // check remove image
        if(!$request->_banner && $banner_id == null) $this->destroyImage($route_map->image_banner_id, $route_map->banner);
        if(!$request->_thumb && $thumb_id == null) $this->destroyImage($route_map->image_thumb_id, $route_map->thumb);
        // end check remove image

        if($request->sort == '')
            $_sort = RouteMap::where('status', 'CO')->max('sort');

        $route_map->detail = $request->detail;
        $route_map->sort = $request->sort != '' ? $request->sort : $_sort+1;
        if($image_id != null) $route_map->image_id = $image_id;
        $route_map->image_banner_id = $this->checkImageUpload($request->_banner, $banner_id, $route_map->image_banner_id);
        $route_map->image_thumb_id = $this->checkImageUpload($request->_thumb, $thumb_id, $route_map->image_thumb_id);

        if($route_map->save()) return redirect()->route('route-map-index')->withSuccess('Route map updated.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    function checkImageUpload($_image, $image_id, $current_id) {
        if($image_id != null) return $image_id;
        if(!$_image && $image_id == null) return null;
        return $current_id;
    }

    public function destroy(string $id = null) {
        $route_map = RouteMap::find($id);

        $this->destroyImage($route_map->image_id, $route_map->image);
        if($route_map->image_banner_id != '') $this->destroyImage($route_map->image_banner_id, $route_map->banner);
        if($route_map->image_thumb_id != '') $this->destroyImage($route_map->image_thumb_id, $route_map->thumb);

        if($route_map->delete()) return redirect()->route('route-map-index')->withSuccess('Route map deleted.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
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

    private function destroyImage($image_id, $_image) {
        $image = Image::find($image_id)->delete();
        if($image) {
            unlink(public_path().$_image->path.'/'.$_image->name);
        }
    }

    public function updateShowInHomepage(string $id = null) {
        $route_map = RouteMap::find($id);
        $route_map->isactive = $route_map->isactive == 'Y' ? 'N' : 'Y';

        if($route_map->save()) return response()->json(['msg' => 'news show in homepage updated.', 'status' => 'success']);
        else return response()->json(['msg' => 'Something is wrong. Please try again.', 'status' => 'fail']);
    }
}
