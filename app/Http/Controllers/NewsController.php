<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>',
    ];

    public function index() {
        $news = News::orderBy('created_at', 'DESC')->get();
        $news_status = $this->_Status;

        return view('pages.news.index', ['news' => $news, 'status' => $news_status]);
    }

    public function create() {
        return view('pages.news.create');
    }

    public function edit(News $news) {
        return view('pages.news.edit',['news' => $news]);
    }



    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'body'=>'required|string'
        ]);

        $random = Str::random(6);
        $_news = News::where('title', $request->title)->first();
        if(isset($_news)) $_slug = Str::slug($request->title, '-').'-'.Str::lower($random);
        else $_slug = Str::slug($request->title, '-');

        $news = News::create([
            'title' => $request->title,
            'slug' => $_slug,
            'body' => $request->body,
            'isactive' => 'Y'
        ]);

        if($news){
            return redirect()->route('news-index')->withSuccess('News created...');
        }else{
            return redirect()->route('news-create')->withErrors('Failed');
        }
    }

    public function update(News $news){
        request()->validate([
            'title' => 'required|string',
            'body'=>'required|string'
        ]);

        $news->title = request()->get('title');
        $news->body = request()->get('body');
        $news->isactive = request()->get('isactive') != '' ? 'Y' : 'N';

        $news->save();

        return redirect()->route('news-index')->withSuccess('News is updated...');
    }

    public function destroy(string $id = null) {
        if(!is_null($id)){
            $news = News::find($id);
            $news->delete();
            return redirect()->route('news-index')->withSuccess('Deleted');
        }

        return redirect()->route('news-index');
    }

    public function updateStatus($id) {
        $news = News::find($id);
        if(isset($news)) {
            $news->isactive = $news->isactive == 'Y' ? 'N' : 'Y';
            if($news->save()) {
                return response()->json(['result' => true], 200);
            }
            return response()->json(['result' => false], 200);
        }
        return response()->json(['result' => false], 200);
    }
}
