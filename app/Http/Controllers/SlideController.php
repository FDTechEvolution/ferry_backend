<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $slides = Slide::where('status', 'CO')->where('type', 'BLOG')->orderBy('sort', 'ASC')->get();

        return view('pages.slide.index', ['slides' => $slides]);
    }

    public function create() {
        return view('pages.slide.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string|nullable',
            'file_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $slug = $this->createTitleSlug($request->title);
        $image_id = $this->storeImage($request->file_picture, $this->ImagePath);

        $slide = Slide::create([
            'title' => $request->title,
            'slug' => $slug,
            'sort' => 1,
            'image_id' => $image_id,
            'description' => $request->description,
            'type' => 'BLOG'
        ]);

        if($slide) {
            $this->updateSortList($slide->id);
            return redirect()->route('blog-index')->withSuccess('Content created.');
        }
        else return redirect()->route('blog-index')->withFail('Something is wrong. Please try again.');
    }

    private function createTitleSlug($title) {
        $_slug = '';
        $random = Str::random(6);
        $_blog = Slide::where('title', $title)->where('type', 'BLOG')->first();
        if(isset($_blog)) $_slug = Str::slug($title, '-').'-'.Str::lower($random);
        else $_slug = Str::slug($title, '-');

        return $_slug;
    }

    private function updateSortList($last_id) {
        $slide = Slide::where('id', '!=', $last_id)->where('type', 'BLOG')->get();
        foreach($slide as $item) {
            $item->sort = $item->sort+1;
            $item->save();
        }
    }

    public function edit($id) {
        $slide = Slide::where('id', $id)->where('status', 'CO')->with('image')->first();
        $max_sort = Slide::where('type', 'BLOG')->orderBy('sort', 'DESC')->first();

        // Log::debug($slide->toArray());

        if(isset($slide)) return view('pages.slide.edit', ['slide' => $slide, 'max_sort' => $max_sort->sort]);
        return redirect()->route('blog-index')->withFail('No blog.');
    }

    public function update(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'sort' => 'required|integer',
            'description' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $slide = Slide::find($request->slide_id);
        $slide->image;
        $oldSort = $slide->sort;

        $slug = $this->createTitleSlug($request->title);
        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file_picture, $this->ImagePath);
            $this->destroyImage($slide->image_id, $slide->image);
        }

        $slide->title = $request->title;
        $slide->slug = $slug;
        $slide->sort = $request->sort;
        $slide->description = $request->description;
        if($image_id != null) $slide->image_id = $image_id;

        if($slide->save()) {
            if ($oldSort != $request->sort) {
                $this->setBlogSort(($request->sort > $oldSort ? 'ASC' : 'DESC'));
            }
            return redirect()->route('blog-index')->withSuccess('Slide updated.');
        }
        else return redirect()->route('blog-index')->withFail('Something is wrong. Please try again.');
    }

    private function setBlogSort($sort = 'DESC')
    {
        $blogs = Slide::where('type', 'BLOG')->orderBy('sort', 'ASC')
            ->orderBy('updated_at', $sort)
            ->get();

        foreach ($blogs as $index => $blog) {
            $blog->sort = ($index + 1);
            $blog->save();
        }
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
