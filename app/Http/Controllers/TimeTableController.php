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
            'title' => 'string|nullable',
            'file_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imageHelper = new ImageHelper();
        $image = $imageHelper->upload($request->file_picture,'time_table');

        //$image_id = $this->storeImage($request->file_picture);
        if($request->sort == '') $_sort = TimeTable::where('status', 'CO')->max('sort');

        $time_table = TimeTable::create([
            'title' => $request->title,
            'image_id' => $image->id,
            'sort' => $request->sort != '' ? $request->sort : $_sort+1
        ]);

        if($time_table) return redirect()->route('time-table-index')->withSuccess('Time table created.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    public function update(Request $request) {
        $request->validate([
            'sort' => 'integer|nullable',
            'title' => 'string|nullable',
            'file_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable'
        ]);

        $table = TimeTable::where('id',$request->_id)->first();

        if ($request->hasFile('file_picture')) {
            $imageHelper = new ImageHelper();

            //upload new file
            $image = $imageHelper->upload($request->file_picture,'time_table');

            //remove old file
            $imageHelper->delete($table->image_id);

            $table->image_id = $image->id;
        }

        if($request->sort == '') $_sort = TimeTable::where('status', 'CO')->max('sort');

        $table->title = $request->title;
        $table->sort = $request->sort != '' ? $request->sort : $_sort+1;

        if($table->save()) return redirect()->route('time-table-index')->withSuccess('Time table updated.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        $timeTable = TimeTable::where('id',$id)->first();
        //dd($timeTable);
        //remove image
        $imageHelper = new ImageHelper();
        $imageHelper->delete($timeTable->image_id);

        if($timeTable->delete()) return redirect()->route('time-table-index')->withSuccess('Time table deleted.');
        else return redirect()->route('time-table-index')->withFail('Something is wrong. Please try again.');
    }

    public function updateShowInHomepage(string $id = null) {
        $table = TimeTable::find($id);
        $table->isactive = $table->isactive == 'Y' ? 'N' : 'Y';

        if($table->save()) return response()->json(['msg' => 'news show in homepage updated.', 'status' => 'success']);
        else return response()->json(['msg' => 'Something is wrong. Please try again.', 'status' => 'fail']);
    }
}
