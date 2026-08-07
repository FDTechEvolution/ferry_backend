<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RentABikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $PathImage = '/image/rent-a-bike';

    protected $AddonType = 'BIKE';

    public function index()
    {
        $items = Addon::where('type', $this->AddonType)
            ->where('status', 'CO')
            ->with('image')
            ->get();

        return view('pages.rent-a-bike.index', ['items' => $items]);
    }

    public function create()
    {
        return view('pages.rent-a-bike.create');
    }

    public function edit(?string $id = null)
    {
        $item = Addon::find($id);

        if (is_null($item) || $item->status != 'CO' || $item->type != $this->AddonType) {
            return redirect()->route('rent-a-bike-index')->withFail('This item does not exist.');
        }

        $item->image;

        return view('pages.rent-a-bike.edit', ['item' => $item]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048|nullable',
        ]);

        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
        }

        $item = Addon::create([
            'name' => $request->name,
            'code' => Str::random(6),
            'amount' => $request->price,
            'type' => $this->AddonType,
            'description' => $request->detail,
            'isactive' => 'Y',
            'image_id' => $image_id,
            'is_route_station' => 'N',
            'is_main_menu' => 'N',
        ]);

        if ($item) {
            return redirect()->route('rent-a-bike-index')->withSuccess(sprintf('Created "%s"', $request->name));
        }

        return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048|nullable',
        ]);

        $item = Addon::find($request->id);

        if (is_null($item) || $item->type != $this->AddonType) {
            return redirect()->route('rent-a-bike-index')->withFail('This item does not exist.');
        }

        $current_image = null;
        if ($request->current_image == '') {
            $this->removeImage($item->image_id);
        } else {
            $current_image = $request->current_image;
        }

        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file('file_picture'), $this->PathImage);
            if ($current_image != null) {
                $this->removeImage($item->image_id);
            }
        }

        $item->name = $request->name;
        $item->amount = $request->price;
        $item->description = $request->detail;
        $item->image_id = $image_id ?: $current_image;

        if ($item->save()) {
            return redirect()->route('rent-a-bike-index')->withSuccess(sprintf('Updated "%s"', $request->name));
        }

        return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    public function destroy(?string $id = null)
    {
        $item = Addon::find($id);

        if (is_null($item) || $item->type != $this->AddonType) {
            return redirect()->route('rent-a-bike-index')->withFail('This item does not exist.');
        }

        $item->status = 'VO';
        $item->isactive = 'N';

        if ($item->save()) {
            return redirect()->route('rent-a-bike-index')->withSuccess(sprintf('Deleted "%s"', $item->name));
        }

        return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    private function storeImage($image, $path)
    {
        $slug_image = time().'.'.$image->getClientOriginalExtension();

        $img = Image::create([
            'path' => $path,
            'name' => $slug_image,
        ]);

        if ($img) {
            $image->move(public_path($path), $slug_image);

            return $img->id;
        }
    }

    private function removeImage($image_id)
    {
        $image = Image::find($image_id);
        if ($image) {
            $file = public_path().$image->path.'/'.$image->name;
            if (file_exists($file)) {
                unlink($file);
            }
            $image->delete();
        }
    }
}
