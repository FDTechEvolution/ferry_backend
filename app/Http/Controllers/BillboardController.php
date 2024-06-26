<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Slide;

class BillboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function icon(){
        return [
            'icon/billbord/carlendar.png'=>'icon/billbord/carlendar-g2.png',
            'icon/billbord/news.png'=>'icon/billbord/news-g2.png',
            'icon/billbord/sound.png'=>'icon/billbord/sound-g2.png',
            'icon/billbord/sun.png'=>'icon/billbord/sun-g2.png',
            'icon/billbord/tigerline.png'=>'icon/billbord/tigerline-g2.png',
        ];
    }

    public function index() {
        $billboard = Slide::where('status', 'CO')->where('type', 'BOARD')->orderBy('sort', 'ASC')->get();
        $icons = $this->icon();

        return view('pages.billboard.index', ['billboard' => $billboard,'icons'=>$icons]);
    }

    public function create() {
        $icons = $this->icon();
        return view('pages.billboard.create',['icons'=>$icons]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string|nullable',
            'color' => 'required|string'
        ]);

        $board = Slide::create([
            'title' => $request->title,
            'sort' => 1,
            'description' => $request->description,
            'type' => 'BOARD',
            'color' => $request->color,
            'icon'=>$request->icon
        ]);

        if($board->save()) {
            $this->updateSortList($board->id);
            return redirect()->route('billboard-index')->withSuccess('Content created.');
        }
        return redirect()->route('billboard-index')->withFail('Something is wrong. Please try again.');
    }

    private function updateSortList($last_id) {
        $billboard = Slide::where('id', '!=', $last_id)->where('type', 'BOARD')->get();
        foreach($billboard as $item) {
            $item->sort = $item->sort+1;
            $item->save();
        }
    }

    public function updateStatus($id) {
        $billboard = Slide::find($id);
        $billboard->isactive = $billboard->isactive == 'Y' ? 'N' : 'Y';

        if($billboard->save()) return response()->json(['result' => true, 'msg' => 'Billboard status updated.']);
        else return response()->json(['result' => false, 'msg' => 'Something is wrong. Please try again.']);
    }

    public function edit(string $id = null) {
        $billboard = Slide::where('id', $id)->where('status', 'CO')->first();
        $max_sort = Slide::where('type', 'BOARD')->orderBy('sort', 'DESC')->first();
        $icons = $this->icon();

        // Log::debug($slide->toArray());

        if(isset($billboard)) return view('pages.billboard.edit', ['billboard' => $billboard, 'max_sort' => $max_sort->sort,'icons'=>$icons]);
        return redirect()->route('billboard-index')->withFail('No billboard.');
    }

    public function update(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string|nullable',
            'color' => 'required|string',
            'sort' => 'required|integer'
        ]);

        $billboard = Slide::find($request->billboard_id);
        $oldSort = $billboard->sort;

        $billboard->title = $request->title;
        $billboard->color = $request->color;
        $billboard->description = $request->description;
        $billboard->sort = $request->sort;
        $billboard->icon = $request->icon;

        if($billboard->save()) {
            if ($oldSort != $request->sort) {
                $this->setBillboardSort(($request->sort > $oldSort ? 'ASC' : 'DESC'));
            }
            return redirect()->route('billboard-index')->withSuccess('Billboard updated.');
        }
        else return redirect()->route('billboard-index')->withFail('Something is wrong. Please try again.');
    }

    private function setBillboardSort($sort = 'DESC')
    {
        $billboard = Slide::where('type', 'BOARD')->orderBy('sort', 'ASC')
                    ->orderBy('updated_at', $sort)
                    ->get();

        foreach ($billboard as $index => $item) {
            $item->sort = ($index + 1);
            $item->save();
        }
    }

    public function destroy(string $id = null) {
        $slide = Slide::find($id);

        if($slide->delete()) return redirect()->route('billboard-index')->withSuccess('Billboard deleted.');
        else return redirect()->route('billboard-index')->withFail('Something is wrong. Please try again.');
    }
}
