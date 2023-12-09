<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TimeTable;
use App\Models\Image;
use App\Helpers\ImageHelper;

class TimeTableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $Path = '/uploads/time_table';

    public function index() {
        $time_tables = TimeTable::where('status', 'CO')->orderBy('sort', 'ASC')->with('image')->get();

        return view('pages.time_table.index', ['time_tables' => $time_tables]);
    }

    public function edit(string $id = null) {
        $time = TimeTable::find($id);
        
        if(is_null($time) || $time->status != 'CO') 
            return redirect()->route('time-table-index')->withFail('This time table not exist.');

        $time->image;
        return view('pages.time_table.edit', ['time' => $time]);
    }

    public function store(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageHelper = new ImageHelper();
        $image = $imageHelper->upload($request->file_picture,'time_table');

        //$image_id = $this->storeImage($request->file_picture);
        if($request->sort == '') $_sort = TimeTable::where('status', 'CO')->max('sort');

        $time_table = TimeTable::create([
            'detail' => $request->detail,
            'image_id' => $image->id,
            'sort' => $request->sort != '' ? $request->sort : $_sort+1
        ]);

        if($time_table) return redirect()->route('time-table-index')->withSuccess('Time table created.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'detail' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $table = TimeTable::find($request->_id);
        $table->image;

        $image_id = null;
        if ($request->hasFile('file_picture')) {
            $image_id = $this->storeImage($request->file_picture);
            $this->destroyImage($table->image_id, $table->image);
        }
        if($request->sort == '') $_sort = TimeTable::where('status', 'CO')->max('sort');

        $table->detail = $request->detail;
        $table->sort = $request->sort != '' ? $request->sort : $_sort+1;
        if($image_id != null) $table->image_id = $image_id;

        if($table->save()) return redirect()->route('time-table-index')->withSuccess('Time table updated.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        $table = TimeTable::find($id);

        $this->destroyImage($table->image_id, $table->image);
        if($table->delete()) return redirect()->route('time-table-index')->withSuccess('Time table deleted.');
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

    private function destroyImage($image_id, $_image) {
        $image = Image::find($image_id)->delete();
        if($image) {
            unlink(public_path().$_image->path.'/'.$_image->name);
        }
    }


    public function updateShowInHomepage(string $id = null) {
        $table = TimeTable::find($id);
        $table->isactive = $table->isactive == 'Y' ? 'N' : 'Y';

        if($table->save()) return response()->json(['msg' => 'news show in homepage updated.', 'status' => 'success']);
        else return response()->json(['msg' => 'Something is wrong. Please try again.', 'status' => 'fail']);
    }
}
