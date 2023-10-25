<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Slide;
use App\Models\Image;

class SlideController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $ImagePath = '/uploads/slide';

    public function index() {
        $slides = Slide::where('status', 'CO')->orderBy('sort', 'ASC')->get();

        return view('pages.slide.index', ['slides' => $slides]);
    }

    public function store(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'link' => 'string|nullable',
            'file_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->sort == '')
            $_sort = Slide::where('status', 'CO')->max('sort');

        $image_id = $this->storeImage($request->file_picture, $this->ImagePath);

        $slide = Slide::create([
            'link' => $request->link,
            'sort' => $request->sort != '' ? $request->sort : $_sort+1,
            'image_id' => $image_id
        ]);

        if($slide) return redirect()->route('slide-index')->withSuccess('Slide created.');
        else return redirect()->route('slide-index')->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'link' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $slide = Slide::find($request->slide_id);
        $slide->image;

        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file_picture, $this->ImagePath);
            $this->destroyImage($slide->image_id, $slide->image);
        }
        if($request->sort == '') $_sort = Slide::where('status', 'CO')->max('sort');

        $slide->link = $request->link;
        $slide->sort = $request->sort != '' ? $request->sort : $_sort;
        if($image_id != null) $slide->image_id = $image_id;

        if($slide->save()) return redirect()->route('slide-index')->withSuccess('Slide updated.');
        else return redirect()->route('slide-index')->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        $slide = Slide::find($id);

        $this->destroyImage($slide->image_id, $slide->image);
        if($slide->delete()) return redirect()->route('slide-index')->withSuccess('Slide deleted.');
        else return redirect()->route('slide-index')->withFail('Something is wrong. Please try again.');
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
        $slide = Slide::find($id);
        $slide->isactive = $slide->isactive == 'Y' ? 'N' : 'Y';

        if($slide->save()) return response()->json(['msg' => 'Status show updated.', 'status' => 'success']);
        else return response()->json(['msg' => 'Something is wrong. Please try again.', 'status' => 'fail']);
    }
}
