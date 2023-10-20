<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TimeTable;
use App\Models\Image;

class TimeTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $Path = '/assets/images/time_table';

    public function index() {
        $time_tables = TimeTable::where('status', 'CO')->with('image')->get();

        return view('pages.time_table.index', ['time_tables' => $time_tables]);
    }

    public function store(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $image_id = $this->storeImage($request->file_picture);
        if($request->sort == '') $_sort = TimeTable::max('sort');

        $time_table = TimeTable::create([
            'detail' => $request->detail,
            'image_id' => $image_id,
            'sort' => $request->sort != '' ? $request->sort : $_sort+1
        ]);

        if($time_table) return redirect()->route('time-table-index')->withSuccess('Time table created.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    private function storeImage($image) {
        $slug_image = time().'.'.$image->getClientOriginalExtension();

        $img = Image::create([
            'path' => $this->Path,
            'name' => $slug_image
        ]);

        if($img) {
            $image->move(public_path($this->Path), $slug_image);
            return $img->id;
        }
    }
}
